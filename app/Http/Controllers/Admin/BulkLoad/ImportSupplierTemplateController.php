<?php

namespace App\Http\Controllers\Admin\BulkLoad;

use App\Models\Supplier;
use App\Jobs\SupplierImportJob;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request as HttpRequest;

class ImportSupplierTemplateController extends Controller
{

    public function importSupplier(HttpRequest $request)
    {
        // Check dito kung yung file is hindi empty

        ini_set('max_execution_time', 300);


        //Check if there's a file submitted
        if (!$request->hasFile('submittedFile')) {
            return Redirect::back()->with('error', 'Supplier Bulkload - No file submitted.');
        }


        // Validate the uploaded file
        $validator = Validator::make($request->all(), [
            'submittedFile' => 'mimes:xls,xlsx',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->with('error', 'Bulk load only accept xls,xlsx file.');
        }


        $dataArray = Excel::toArray([], $request->file('submittedFile'))[0];

        //=== KEEP ONLY 6 COLUMN TO PREVENT ERROR WHEN THERES TOO MANY COLUMN


        foreach ($dataArray as &$subArray) {
            // Check the number of elements in the sub-array
            $numElements = count($subArray);

            if ($numElements > 6) {
                $subArray = array_slice($subArray, 0, 6); // Keep elements from index 0 to 6
            }
        }

        unset($subArray);

        // Remove heading
        array_shift($dataArray);


        // Validate the supplier data
        $validationError = $this->validations($dataArray);

        if (!empty($validationError)) {
            return Redirect::back()->with('error', $validationError);
        }

        $this->storeSupplier($dataArray);
    }


    public function isEmailValid($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }


    public function validations($dataArray)
    {

        $emailColumnIndex = 3;
        $emailColumn = array_column($dataArray, $emailColumnIndex);


        foreach ($emailColumn as $email) {

            if (!$this->isEmailValid($email)) {
                return "Email $email is in invalid format.";
            }
        }
    }

    public function storeSupplier($dataArray)
    {

        $nextSupplierId = Supplier::max('UNIQUE_ID') + 1; //get max id

        $required_headers = [
            'SUPPLIER_NAME',
            'SUPPLIER_TYPE',
            'CONTACT_NAME',
            'EMAIL',
            'CONTACT_NUMBER',
            'ADDRESS'
        ];

        $results[0] = $required_headers;

        $header = $results[0];

        $results = array_map(function ($val) use ($header) {
            return array_combine($header, $val);
        }, $dataArray);


        $arrayToInsert = [];

        foreach ($results as $i => $value) :
            $supplierData = [
                'SUPPLIER_ID' => 'VR-'.str_pad($nextSupplierId + $i, 7, '0', STR_PAD_LEFT),
                'SUPP_NAME' => $value["SUPPLIER_NAME"],
                'TYPE' => $value["SUPPLIER_TYPE"],
                'CONTACT_NAME' => $value["CONTACT_NAME"],
                'EMAIL' => $value["EMAIL"],
                'CONTACT_NO' => $value["CONTACT_NUMBER"],
                'ADDRESS' => $value["ADDRESS"],
                'UPDATED_BY' => Auth::user()->FIRST_NAME.' '.Auth::user()->LAST_NAME,
            ];


            $arrayToInsert[] = $supplierData;


            if (count($arrayToInsert)) {
                SupplierImportJob::dispatch($supplierData);
                $arrayToInsert = [];
            }


        endforeach;

        if (!empty($arrayToInsert)) {

            SupplierImportJob::dispatch($arrayToInsert);
        }

        return Redirect::route('Admin.BulkLoad.ImportTemplate.importSupplier')
        ->with('success', "Supplier Bulkload Successfull.");
    }
}
