<?php

namespace App\Http\Controllers\Admin\BulkLoad;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\AssetCategory;
use App\Jobs\ProductImportJob;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request as HttpRequest;

class ImportProductTemplateController extends Controller
{

    public function importProduct(HttpRequest $request)
    {
        // Check dito kung yung file is hindi empty

        ini_set('max_execution_time', 300);


        //Check if there's a file submitted
        if (!$request->hasFile('submittedFile')) {
            return Redirect::back()->with('error', 'Product Bulkload - No file submitted.');
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

            // Slice the sub-array to keep only the first 15 elements if more than six exist
            if ($numElements > 16) {
                $subArray = array_slice($subArray, 0, 15); // Keep elements from index 0 to 6
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

        $this->storeProduct($dataArray);
    }



    public function doesAssetCategoryExist($assetCategory)
    {

        $check = AssetCategory::where('id',$assetCategory)->first();

        if ($check) {
            return true;
        } else {
            return false;
        }
    }

    public function doesAssetSubtypeExist($assetSubtype)
    {

        $validSubtypes = [
            "Computer Desktop PC",
            "Laptop",
            "POS Terminal",
            "Server",
            "Handy Terminal",
            "Equipment Parts"
        ];


        if (!in_array($assetSubtype, $validSubtypes)) {
            return false;
        }

        return true;

    }


    public function doesProductCategoryExist($productCategory)
    {

        $validCategories = [
            "Hardware",
            "Software",
            "Consumables",
            "Bundle"
        ];


        if (!in_array($productCategory, $validCategories)) {
            return false;
        }

        return true;

    }



    public function doesVendorIDExist($vendorId)
    {


        $check = Supplier::where('SUPPLIER_ID',$vendorId)->first();

        if ($check) {
            return true;
        } else {
            return false;
        }

    }

    public function checkAssetStatus($assetStatus){


        $validStatus = [
            "In-Stock",
            "Out of Stock",
            "Allocated",
            "In-Use",
            "Disposed",
            "Obsolete"
        ];


        if (!in_array($assetStatus, $validStatus)) {
            return false;
        }

        return true;



    }

    public function validations($dataArray)
    {

        $assetCategoryColumnIndex = 1;
        $assetCategoryColumn = array_column($dataArray, $assetCategoryColumnIndex);


        foreach ($assetCategoryColumn as $assetCategory) {

            if (!$this->doesAssetCategoryExist($assetCategory)) {
                return "Asset Category ID $assetCategory does not exist.";
            }
        }


        $assetSubtypeColumnIndex = 2;
        $assetSubtypeColumn = array_column($dataArray, $assetSubtypeColumnIndex);


        foreach ($assetSubtypeColumn as $assetSubtype) {

            if (!$this->doesAssetSubtypeExist($assetSubtype)) {
                return "Invalid Subtype '$assetSubtype'.
                Please Check your data, spelling or refer to following choices:
                Computer Desktop PC, Laptop, POS Terminal, Server, Handy Terminal and Equipment Parts";
            }
        }


        $productCategoryColumnIndex = 7;
        $productCategoryColumn = array_column($dataArray, $productCategoryColumnIndex);

        foreach ($productCategoryColumn as $productCategory) {

            if (!$this->doesProductCategoryExist($productCategory)) {
                return "Invalid Product Category '$productCategory'.
                Please Check your data, spelling or refer to following choices:\n
                    Hardware, Software, Consumables and Bundle.";
            }
        }


        $vendorIdColumnIndex = 9;
        $vendorIdColumn = array_column($dataArray, $vendorIdColumnIndex);

        foreach ($vendorIdColumn as $vendorId) {

            if (!$this->doesVendorIDExist($vendorId)) {
                return "Vendor ID '$vendorId'. Does not exist.";
            }
        }


        $usefulLifeColumnIndex = 12;
        $usefulLifeColumn = array_column($dataArray, $usefulLifeColumnIndex);

        foreach ($usefulLifeColumn as $usefulLife) {

            if (!is_numeric($usefulLife)) {
                return "Useful Life: $usefulLife Invalid. Must be numeric";
            }
        }


        $assetStatusColumnIndex = 13;
        $assetStatusColumn = array_column($dataArray, $assetStatusColumnIndex);

        foreach ($assetStatusColumn as $assetStatus) {

            if (!$this->checkAssetStatus($assetStatus)) {
                return "Invalid Asset Status '$assetStatus'.
                Please Check your data, spelling or refer to following choices:\n
                    In-Stock, Out of Stock, Allocated, In-Use, Disposed and Obsolete";
            }
        }



    }

    public function storeProduct($dataArray)
    {


        $nextProductId = Product::max('INDEX_ID') + 1; //get max id

        $required_headers = [
            'ASSET_NAME',
            'ASSET_CATEGORY_ID',
            'ASSET_SUB_TYPE',
            'ASSET_DESCRIPTION',
            'COLOR',
            'WEIGHT',
            'DIMENSION',
            'PRODUCT_CATEGORY',
            'MANUFACTURER',
            'VENDOR_ID',
            'COST',
            'WARRANTY_TERMS',
            'USEFUL_LIFE',
            'STATUS',
            'EQUIPMENT_MODEL',
            'ASSET_CONDITION',
        ];

        $results[0] = $required_headers;

        $header = $results[0];

        $results = array_map(function ($val) use ($header) {
            return array_combine($header, $val);
        }, $dataArray);

        $arrayToInsert = [];

        foreach ($results as $i => $value) :


            $productData = [
                'ASSET_ID' => 'AST-'.str_pad($nextProductId + $i, 5, '0', STR_PAD_LEFT),
                'ASSET_CATEGORY' => $value["ASSET_CATEGORY_ID"],
                'ASSET_NAME' => $value["ASSET_NAME"],
                'ASSET_SUB_TYPE' => $value["ASSET_SUB_TYPE"],
                'EQUIPMENT_MODEL' => $value["EQUIPMENT_MODEL"],
                'ASSET_DESCRIPTION' => $value["ASSET_DESCRIPTION"],
                'COLOR' => $value["COLOR"],
                'WEIGHT' => $value["WEIGHT"],
                'DIMENSION' => $value["DIMENSION"],
                'PRODUCT_CATEGORY' => $value["PRODUCT_CATEGORY"],
                'MANUFACTURER' => $value["MANUFACTURER"],
                'VENDOR_ID' => $value["VENDOR_ID"],
                'COST' => $value["COST"],
                'WARRANTY_TERMS' => $value["WARRANTY_TERMS"],
                'USEFUL_LIFE' => $value["USEFUL_LIFE"],
                'STATUS' => $value["STATUS"],
                'FROM_DATE' => date('Y-m-d'),
                'ASSET_CONDITION' => $value["ASSET_CONDITION"]
            ];

            $arrayToInsert[] = $productData;


            if (count($arrayToInsert)) {
                ProductImportJob::dispatch($arrayToInsert);
                $arrayToInsert = [];
            }


        endforeach;

        if (!empty($arrayToInsert)) {

            ProductImportJob::dispatch($arrayToInsert);
        }

        return Redirect::route('Admin.BulkLoad.ImportTemplate.importProduct')
        ->with('success', "Product Bulkload Successfull.");
    }
}
