<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Roles;
use App\Http\Controllers\Controller;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request as HttpRequest;

class RoleAccessController extends Controller
{
    public function index()
    {

        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {


            return Inertia::render('Admin/RoleAccess/Index', [
                'roles' => Roles::all(),
                'roleSelected' => Request::only(['roleID']),
            ]);
        } else {
            return Redirect::route('noAccess');
        }
    }


    public function show($roleID)
    {


        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {


            //Check first if already have role permission. If not create
            $doesHavePermission = RolePermission::where('ROLE_ID', $roleID)->first();

            if (!$doesHavePermission) {
                RolePermission::insert([
                    'ROLE_ID' => $roleID,
                ]);
            }

            return Inertia::render('Admin/RoleAccess/Show', [
                'roleDetail' => Roles::findOrFail($roleID),
                'listOfRoles' => Roles::all(),
                'roleSelected' => $roleID,
                'roleAccess' => RolePermission::where('ROLE_ID', $roleID)->first(),
            ]);
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function update(HttpRequest $request, $roleID)
    {



        return redirect()->back()->with(
            'error',
            'For demo purpose: Modifying role access settings is disabled.'
        );


        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {

            RolePermission::where('ROLE_ID', $roleID)->update([
                'PRODUCT_CATALOG' => $request->productCatalog,
                'ADD_PRODUCT' => $request->addProduct,
                'EDIT_PRODUCT' => $request->editProduct,
                'DELETE_PRODUCT' => $request->deleteProduct,
                'ADD_ASSET_CATEGORY' => $request->addAssetCategory,
                'EDIT_ASSET_CATEGORY' => $request->editAssetCategory,
                'DELETE_ASSET_CATEGORY' => $request->deleteAssetCategory,
                'INVENTORY' => $request->inventory,
                'CREATE_ASSET_TRANSFER' => $request->createAssetTransfer,
                'RECEIVE_ASSET_TRANSFER' => $request->receiveAssetTransfer,
                'SUPPLIER' => $request->supplier,
                'ADD_SUPPLIER' => $request->addSupplier,
                'EDIT_SUPPLIER' => $request->editSupplier,
                'DELETE_SUPPLIER' => $request->deleteSupplier,
                'ADMIN' => $request->admin,
                'ADD_USER' => $request->addUser,
                'DELETE_USER' => $request->deleteUser,
                'ADD_LOCATION' => $request->addLocation,
                'EDIT_LOCATION' => $request->editLocation,
                'DELETE_LOCATION' => $request->deleteLocation,
                'ADD_ROLE' => $request->addRole,
                'EDIT_ROLE' => $request->editRole,
                'DELETE_ROLE' => $request->deleteRole,
                'MANAGE_ROLE_ACCESS' => $request->manageRoleAccess,
            ]);


            return Redirect::route('Admin.RoleAccess.index')->with('success', "Role Access Updated Successfully.");
        } else {
            return Redirect::route('noAccess');
        }
    }
}
