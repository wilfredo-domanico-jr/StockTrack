<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Roles;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class RoleManagementController extends Controller
{
    public function index()
    {

        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {

            $roles = Roles::when(Request::input('search'), function ($query, $search) {
                $query->where('ROLE', 'like', "%{$search}%")
                    ->orWhere('CREATED_BY', 'like', "%{$search}%")
                    ->orWhere('UPDATED_BY', 'like', "%{$search}%");
            })->paginate(10)->withQueryString();

            return Inertia::render('Admin/RoleManagement/Index', [
                'roles' => $roles,
                'filters' => Request::only(['search']),
            ]);
        } else {
            return Redirect::route('noAccess');
        }
    }


    public function create()
    {






        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {

            return Inertia::render('Admin/RoleManagement/Create');
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function store(HttpRequest $request)
    {



        return redirect()->back()->with(
            'error',
            'For demo purpose: Adding new role is not allowed. Only the default Admin and User roles are permitted.'
        );

        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {

            // Insert the role
            Roles::insert([
                'ROLE' => $request->roleName,
                'CREATED_BY' => Auth::user()->FIRST_NAME . ' ' . Auth::user()->LAST_NAME,
                'UPDATED_BY' => Auth::user()->FIRST_NAME . ' ' . Auth::user()->LAST_NAME,
            ]);

            return Redirect::route('Admin.RoleManagement.index')->with('success', 'Role Inserted Successfully.');
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function show($roleID)
    {

        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {
            $roleData = Roles::findOrFail($roleID);

            return Inertia::render('Admin/RoleManagement/Show', ['roleData' => $roleData]);
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function update(HttpRequest $request, $roleID)
    {


        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {
            // Insert the location

            return redirect()->back()->with(
                'error',
                "For demo purpose: Updating the default role is not allowed"
            );


            Roles::where('id', $roleID)->update([
                'ROLE' => $request->roleName,
                'UPDATED_BY' => Auth::user()->FIRST_NAME . ' ' . Auth::user()->LAST_NAME,
            ]);


            return Redirect::route('Admin.RoleManagement.index')->with('success', 'Role Updated Successfully.');
        } else {
            return Redirect::route('noAccess');
        }
    }



    public function destroy($roleID)
    {




        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {

            $roleData = Roles::findOrFail($roleID);

            return redirect()->back()->with(
                'error',
                "For demo purpose: Deleting default role `{$roleData->ROLE}` is not allowed"
            );

            $roleData->delete();

            return Redirect::route('Admin.RoleManagement.index')->with('success', 'Role Deleted Successfully.');
        } else {
            return Redirect::route('noAccess');
        }
    }
}
