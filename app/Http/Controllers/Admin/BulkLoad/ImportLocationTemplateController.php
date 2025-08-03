<?php

namespace App\Http\Controllers\Admin\BulkLoad;

use App\Models\Location;
use App\Jobs\LocationImportJob;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request as HttpRequest;

class ImportLocationTemplateController extends Controller
{

    public function importLocation(HttpRequest $request)
    {



        // Check dito kung yung file is hindi empty

        ini_set('max_execution_time', 300);


        //Check if there's a file submitted
        if (!$request->hasFile('submittedFile')) {
            return Redirect::back()->with('error', 'Location Bulkload - No file submitted.');
        }


        // Validate the uploaded file
        $validator = Validator::make($request->all(), [
            'submittedFile' => 'mimes:xls,xlsx',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->with('error', 'Bulk load only accept xls,xlsx file.');
        }


        $dataArray = Excel::toArray([], $request->file('submittedFile'))[0];

        //=== KEEP ONLY 2 COLUMN TO PREVENT ERROR WHEN THERES TOO MANY COLUMN



        foreach ($dataArray as &$subArray) {
            // Check the number of elements in the sub-array
            $numElements = count($subArray);

            if ($numElements > 2) {
                $subArray = array_slice($subArray, 0, 1); // Keep elements from index 0 to 1
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

        // Count total location. If hindi pa nag reach ng 5 compute the remaining.

        $totalLocation = Location::where('DELETED', 0)->count();

        if ($totalLocation >= 5) {
            redirect()->back()->with('error', 'For demo purpose: Adding more than 5 location is not allowed. You can delete an existing location to add a new one.');
        }

        // dd($dataArray);
        // return redirect()->back()->with(
        //     'error',
        //     'For demo purpose: Importing account is not permitted.'
        // );

        $this->storeLocation($dataArray);
    }


    public function doesLocationIDExist($locationID)
    {

        $check = Location::where([
            'DELETED' => 0,
            'LOCATION_ID' => $locationID,
        ])->first();

        if ($check) {
            return true;
        } else {
            return false;
        }
    }


    public function validations($dataArray)
    {

        $locationIDColumnIndex = 0;
        $locationIDColumn = array_column($dataArray, $locationIDColumnIndex);

        foreach ($locationIDColumn as $locationID) {

            if ($this->doesLocationIDExist($locationID)) {
                return "Location ID $locationID already exist.";
            }
        }
    }

    public function storeLocation($dataArray)
    {



        $required_headers = [
            'LOCATION_ID',
            'LOCATION'
        ];

        $results[0] = $required_headers;

        $header = $results[0];

        $results = array_map(function ($val) use ($header) {
            return array_combine($header, $val);
        }, $dataArray);


        $arrayToInsert = [];

        foreach ($results as $i => $value) :


            $locationData = [
                'LOCATION_ID' => $value["LOCATION_ID"],
                'LOCATION' => $value["LOCATION"],
                'UPDATED_BY' => Auth::user()->FIRST_NAME . ' ' . Auth::user()->LAST_NAME,
            ];


            $arrayToInsert[] = $locationData;


            if (count($arrayToInsert)) {
                LocationImportJob::dispatch($locationData);
                $arrayToInsert = [];
            }


        endforeach;

        if (!empty($arrayToInsert)) {

            LocationImportJob::dispatch($arrayToInsert);
        }

        return Redirect::route('Admin.BulkLoad.ImportTemplate.importLocation')
            ->with('success', "Location Bulkload Successfull.");
    }
}
