<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Location;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request as HttpRequest;

class LocationManagementController extends Controller
{
    public function index()
    {

        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {

            $locations = Location::where('DELETED', 0)->when(Request::input('search'), function ($query, $search) {
                $query->where('LOCATION_ID', 'like', "%{$search}%")
                    ->orWhere('LOCATION', 'like', "%{$search}%")
                    ->orWhere('UPDATED_BY', 'like', "%{$search}%");
            })->paginate(10)->withQueryString();

            return Inertia::render('Admin/LocationManagement/Index', [
                'locations' => $locations,
                'filters' => Request::only(['search']),
            ]);
        } else {
            return Redirect::route('noAccess');
        }
    }


    public function create()
    {

        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {

            return Inertia::render('Admin/LocationManagement/Create');
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function store(HttpRequest $request)
    {

        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {

            //Check if location ID already exist

            $isLocationIDExisting = Location::where('LOCATION_ID', $request->locationID)->first();
            if ($isLocationIDExisting) {
                return Redirect::back()->with('error', "Location ID $request->locationID already exist.");
            }

            // Insert the location

            Location::insert([
                'LOCATION_ID' => $request->locationID,
                'LOCATION' => $request->location,
                'UPDATED_BY' => Auth::user()->FIRST_NAME . ' ' . Auth::user()->LAST_NAME,
            ]);

            //location
            return Redirect::route('Admin.LocationManagement.index')->with('success', 'Location Inserted Successfully.');
        } else {
            return Redirect::route('noAccess');
        }
    }


    public function show($locationID)
    {

        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {

            $locationData = Location::findOrFail($locationID);

            return Inertia::render('Admin/LocationManagement/Show', ['locationData' => $locationData]);
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function update(HttpRequest $request, $locationID)
    {


        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {

            if ($request->locationID != $locationID) {

                //Check if location ID already exist

                $isLocationIDExisting = Location::where('LOCATION_ID', $request->locationID)->first();
                if ($isLocationIDExisting) {
                    return Redirect::back()->with('error', "Location ID $request->locationID already exist.");
                }

                $locationIDUpdate = $request->locationID;
            } else {
                $locationIDUpdate = $locationID;
            }


            // Insert the location

            Location::where('LOCATION_ID', $locationID)->update([
                'LOCATION_ID' => $locationIDUpdate,
                'LOCATION' => $request->location,
                'UPDATED_BY' => Auth::user()->FIRST_NAME . ' ' . Auth::user()->LAST_NAME,
            ]);


            return Redirect::route('Admin.LocationManagement.index')->with('success', 'Location Updated Successfully.');
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function destroy($locationID)
    {


        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {

            $locationData = Location::findOrFail($locationID);

            $locationData->update(['DELETED' => 1]);
            return Redirect::route('Admin.LocationManagement.index')->with('success', 'Location Deleted Successfully.');
        } else {
            return Redirect::route('noAccess');
        }
    }
}
