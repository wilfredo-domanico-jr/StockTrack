<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Location;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Roles;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\Request as HttpRequest;

class UserManagementController extends Controller
{
    public function index()
    {

        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {

            $users = User::where('DELETED', 0)->when(Request::input('search'), function ($query, $search) {
                $query->where('USER_ID', 'like', "%{$search}%")
                    ->orWhere('FIRST_NAME', 'like', "%{$search}%")
                    ->orWhere('LAST_NAME', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('ACC_STATUS', 'like', "%{$search}%");
            })->paginate(10)->withQueryString();
            return Inertia::render('Admin/UserManagement/Index', [
                'users' => $users,
                'filters' => Request::only(['search']),
            ]);
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function create()
    {

        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {
            $locations = Location::where('DELETED', 0)->where('LOCATION_ID', '!=', '000000')->get();



            $roles = Roles::where('DELETED', 0)
                ->where('id', '!=', 1)
                ->get();

            return Inertia::render('Admin/UserManagement/Create', ['locations' => $locations, 'roles' => $roles]);
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function store(HttpRequest $request)
    {



        return redirect()->back()->with(
            'error',
            'For demo purpose: Adding more users is disabled. Only an admin account and the 2 default user provided are permitted.'
        );

        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {


            try {

                // Check if password matches
                if ($request->initialPassword != $request->confirmInitialPassword) {
                    return Redirect::back()->with('error', 'Password confirmation mismatch.');
                }
                // Begin transaction
                DB::beginTransaction();


                $nextUserId = User::max('id') + 1;
                $userId = str_pad($nextUserId, 7, '0', STR_PAD_LEFT);

                User::insert([
                    'USER_ID' => $userId,
                    'FIRST_NAME' => $request->firstName,
                    'LAST_NAME' => $request->lastName,
                    'email' => $request->email,
                    'password' => Hash::make($request->initialPassword),
                    'LOCATION_ID' => $request->location,
                    'ROLE_ID' => $request->role,
                    'ACC_STATUS' => "INACTIVE"
                ]);




                // Commit transaction
                DB::commit();

                return Redirect::route('Admin.UserManagement.index')->with('success', 'User Inserted Successfully.');
            } catch (\Exception $e) {
                // Rollback transaction if an exception occurred
                DB::rollBack();
                // Log the error
                Log::error('Error occurred during database transaction: ' . $e->getMessage());

                return Redirect::back()->with('error', 'An Error Occur.');
            }
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function show($userID)
    {


        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {


            $userData = User::with(['location', 'role'])->where('USER_ID', $userID)->first();

            if (!$userData) {
                abort(404, 'User Not Found');
            }

            return Inertia::render('Admin/UserManagement/Show', [
                'userData' => $userData,
            ]);
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function destroy($userID)
    {
        if (
            $userID == "0000000" ||
            $userID == "0000001" ||
            $userID == "0000002"
        ) {
            return redirect()->back()->with(
                'error',
                'For demo purpose: Deleting the admin account or the default user account is not permitted.'
            );
        }


        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {
            User::where('USER_ID', $userID)->update(['DELETED' => 1]);


            return Redirect::route('Admin.UserManagement.index')->with('success', 'User Deleted Successfully.');
        } else {
            return Redirect::route('noAccess');
        }
    }
}
