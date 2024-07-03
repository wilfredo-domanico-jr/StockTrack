<?php

namespace App\Http\Controllers\Admin\BulkLoad;

use App\Models\User;
use App\Models\Roles;
use App\Models\Location;
use App\Jobs\UserImportJob;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request as HttpRequest;

class ImportUserTemplateController extends Controller
{

    public function importUser(HttpRequest $request)
    {
        // Check dito kung yung file is hindi empty

        ini_set('max_execution_time', 300);


        //Check if there's a file submitted
        if (!$request->hasFile('submittedFile')) {
            return Redirect::back()->with('error', 'User Bulkload - No file submitted.');
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

            // Slice the sub-array to keep only the first six elements if more than six exist
            if ($numElements > 6) {
                $subArray = array_slice($subArray, 0, 6); // Keep elements from index 0 to 6
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

        $this->storeUser($dataArray);
    }

    public function isEmailValid($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function doesRoleIDExist($roleID)
    {

        $check = Roles::where([
            'DELETED' => 0,
            'id' => $roleID,
        ])->first();

        if ($check) {
            return true;
        } else {
            return false;
        }
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

    public function doesEmailExist($email)
    {

        $check = User::where([
            'DELETED' => 0,
            'email' => $email,
        ])->first();

        if ($check) {
            return true;
        } else {
            return false;
        }
    }

    public function validations($dataArray)
    {

        $emailColumnIndex = 3;
        $emailColumn = array_column($dataArray, $emailColumnIndex);


        foreach ($emailColumn as $email) {

            if (!$this->isEmailValid($email)) {
                return "Email $email is in invalid format.";
            }

            if ($this->doesEmailExist($email)) {
                return "Email $email already exist.";
            }
        }


        // Check if location id exist

        $locationColumnIndex = 4;
        $locationIDColumn = array_column($dataArray, $locationColumnIndex);



        foreach ($locationIDColumn as $locationID) {

            if (!$this->doesLocationIDExist($locationID)) {
                return "Location ID $locationID does not exist.";
            }
        }


        //Check if ROLE ID EXIST

        $roleColumnIndex = 5;
        $roleIDColumn = array_column($dataArray, $roleColumnIndex);

        foreach ($roleIDColumn as $roleID) {

            if (!$this->doesRoleIDExist($roleID)) {
                return "Role ID $roleID does not exist.";
            }
        }
    }

    public function storeUser($dataArray)
    {


        $nextUserId = User::max('id') + 1; //get max id

        $required_headers = [
            'FIRST_NAME',
            'LAST_NAME',
            'INITIAL_PASSWORD',
            'EMAIL',
            'LOCATION_ID',
            'ROLE_ID'
        ];

        $results[0] = $required_headers;

        $header = $results[0];

        $results = array_map(function ($val) use ($header) {
            return array_combine($header, $val);
        }, $dataArray);

        $arrayToInsert = [];

        foreach ($results as $i => $value) :


            $userData = [
                'USER_ID' => str_pad($nextUserId + $i, 7, '0', STR_PAD_LEFT),
                'FIRST_NAME' => $value["FIRST_NAME"],
                'LAST_NAME' => $value["LAST_NAME"],
                'password' => Hash::make($value["INITIAL_PASSWORD"]),
                'email' => $value["EMAIL"],
                'LOCATION_ID' => $value["LOCATION_ID"],
                'ROLE_ID' => $value["ROLE_ID"],
                'ACC_STATUS' => 'UNVERIFIED',
            ];

            $arrayToInsert[] = $userData;


            if (count($arrayToInsert)) {
                UserImportJob::dispatch($arrayToInsert);
                $arrayToInsert = [];
            }


        endforeach;

        if (!empty($arrayToInsert)) {

            UserImportJob::dispatch($arrayToInsert);
        }

        return Redirect::route('Admin.BulkLoad.ImportTemplate.importUser')
        ->with('success', "User Bulkload Successfull.");
    }
}
