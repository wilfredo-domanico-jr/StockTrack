<?php

namespace App\Http\Controllers\Admin\BulkLoad;

use DateTime;
use App\Models\Product;
use App\Models\Location;
use App\Models\Inventory;
use App\Jobs\InventoryImportJob;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request as HttpRequest;

class ImportInventoryTemplateController extends Controller
{

    public function importInventory(HttpRequest $request)
    {
        // Check dito kung yung file is hindi empty

        ini_set('max_execution_time', 300);


        //Check if there's a file submitted
        if (!$request->hasFile('submittedFile')) {
            return Redirect::back()->with('error', 'Inventory Bulkload - No file submitted.');
        }


        // Validate the uploaded file
        $validator = Validator::make($request->all(), [
            'submittedFile' => 'mimes:xls,xlsx',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->with('error', 'Bulk load only accept xls,xlsx file.');
        }


        $dataArray = Excel::toArray([], $request->file('submittedFile'))[0];

        //=== KEEP ONLY 16 COLUMN TO PREVENT ERROR WHEN THERES TOO MANY COLUMN


        foreach ($dataArray as &$subArray) {
            // Check the number of elements in the sub-array
            $numElements = count($subArray);



            // Slice the sub-array to keep only the first 11 elements if more than six exist
            if ($numElements > 11) {
                $subArray = array_slice($subArray, 0, 11); // Keep elements from index 0 to 11
            }
        }

        unset($subArray);

        // Remove heading
        array_shift($dataArray);

        // Validate the user data
        $validationError = $this->validations($dataArray);

        if (!empty($validationError)) {
            return Redirect::back()->with('error', $validationError);
        }

        $this->storeInventory($dataArray);
    }



    public function doesAssetIDExist($assetID)
    {

        $check = Product::where('ASSET_ID',$assetID)->first();

        if ($check) {
            return true;
        } else {
            return false;
        }
    }


    public function doesSerialNoExist($serialNo)
    {

        $check = Inventory::where('SERIAL_NO',$serialNo)->first();

        if ($check) {
            return true;
        } else {
            return false;
        }
    }



    public function doesLocationIDExist($locationID)
    {

        $check = Location::where('LOCATION_ID',$locationID)->first();

        if ($check) {
            return true;
        } else {
            return false;
        }
    }


    public function isDateFormat($date)
    {

        $dateTime = DateTime::createFromFormat('Y/m/d', $date);

        if ($dateTime === false || $dateTime->format('Y/m/d') !== $date) {
            return false;
        }else{
            return true;
        }

    }

    public function dateFormatConverter($date)
    {

        $rawDate =  DateTime::createFromFormat('Y/m/d', $date);
        $convertedDate = $rawDate->format('Y-m-d');

        return $convertedDate;

    }

    public function validations($dataArray)
    {

        $assetIDColumnIndex = 0;
        $assetIDColumn = array_column($dataArray, $assetIDColumnIndex);


        foreach ($assetIDColumn as $assetID) {

            if (!$this-> doesAssetIDExist($assetID)) {
                return "Asset ID '$assetID' does not exist.";
            }
        }


        $serialNoColumnIndex = 2;
        $serialNoColumn = array_column($dataArray, $serialNoColumnIndex);


        foreach ($serialNoColumn as $serialNo) {

            if ($this->doesSerialNoExist($serialNo)) {
                return "Serial No. '$serialNo' already exist.";
            }
        }


        $locationIDColumnIndex = 3;
        $locationIDColumn = array_column($dataArray, $locationIDColumnIndex);

        foreach ($locationIDColumn as $locationID) {

            if (!$this->doesLocationIDExist($locationID)) {
                return "Location ID: '$locationID' does not exist.";
            }
        }


        $purchaseDateColumnIndex = 8;
        $purchaseDateColumn = array_column($dataArray, $purchaseDateColumnIndex);

        foreach ($purchaseDateColumn as $row => $purchaseDate) {

            if (!$this->isDateFormat($purchaseDate)) {
                $rowNum = $row + 2;
                $date = date('Y/m/d');
                return "Purchase Date in row number '$rowNum' invalid. Must be in ( YYYY-MM-DD ) format Ex. '$date'";
            }
        }


        $inServiceDateColumnIndex = 9;
        $inServiceDateColumn = array_column($dataArray, $inServiceDateColumnIndex);

        foreach ($inServiceDateColumn as $row => $inService) {

            if (!$this->isDateFormat($inService)) {
                $rowNum = $row + 2;
                $date = date('Y/m/d');
                return "In Service Date in row number '$rowNum' invalid. Must be in ( YYYY-MM-DD ) format Ex. '$date'";
            }
        }


        $warrantyStartDateColumnIndex = 10;
        $warrantyStartDateColumn = array_column($dataArray, $warrantyStartDateColumnIndex);

        foreach ($warrantyStartDateColumn as $row => $warrantyStartDate) {

            if (!$this->isDateFormat($warrantyStartDate)) {
                $rowNum = $row + 2;
                $date = date('Y/m/d');
                return "Warranty Start Date in row number '$rowNum' invalid. Must be in ( YYYY-MM-DD ) format Ex. '$date'";
            }
        }


    }

    public function storeInventory($dataArray)
    {


        $nextInventoryId = Inventory::max('id') + 1;

        $required_headers = [
            'ASSET_ID',
            'ASSET_TAG',
            'SERIAL_NO',
            'LOCATION_ID',
            'USE_POLICY',
            'SERVICE_LEVEL',
            'BARCODE',
            'PURCHASE_ORDER_NO',
            'PURCHASE_DATE',
            'IN_SERVICE_DATE',
            'WARRANTY_START_DATE'
        ];

        $results[0] = $required_headers;

        $header = $results[0];

        $results = array_map(function ($val) use ($header) {
            return array_combine($header, $val);
        }, $dataArray);


        $arrayToInsert = [];

        foreach ($results as $i => $value) :




                $usefullLife = Product::where('ASSET_ID',$value["ASSET_ID"])->pluck('USEFUL_LIFE')->first();
                $formatEndDate = new DateTime($value["WARRANTY_START_DATE"]);
                $formatEndDate->modify("+$usefullLife months");
                $warrantyEndDate = $formatEndDate->format('Y-m-d');

            $inventoryData = [
                'INVENTORY_ID' => 'INV-'.str_pad($nextInventoryId + $i, 10, '0', STR_PAD_LEFT),
                'ASSET_ID' => $value["ASSET_ID"],
                'ASSET_TAG' => $value["ASSET_TAG"],
                'SERIAL_NO' => $value["SERIAL_NO"],
                'LOCATION_ID' => $value["LOCATION_ID"],
                'USE_POLICY' => $value["USE_POLICY"],
                'SERVICE_LEVEL' => $value["SERVICE_LEVEL"],
                'BARCODE' => $value["BARCODE"],
                'PURCHASE_ORDER_NO' => $value["PURCHASE_ORDER_NO"],
                'PURCHASE_DATE' =>  $this->dateFormatConverter($value["PURCHASE_DATE"]),
                'IN_SERVICE_DATE' => $this->dateFormatConverter($value["IN_SERVICE_DATE"]),
                'WARRANTY_START_DATE' => $this->dateFormatConverter($value["WARRANTY_START_DATE"]),
                'WARRANTY_EXPIRY' => $warrantyEndDate,
                'created_at' => NOW(),
                'updated_at' => NOW()

            ];


            $arrayToInsert[] = $inventoryData;


            if (count($arrayToInsert)) {
                InventoryImportJob::dispatch($arrayToInsert);
                $arrayToInsert = [];
            }


        endforeach;

        if (!empty($arrayToInsert)) {

            InventoryImportJob::dispatch($arrayToInsert);
        }

        return Redirect::route('Admin.BulkLoad.ImportTemplate.importInventory')
        ->with('success', "Inventory Bulkload Successfull.");
    }
}
