<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class SupplierController extends Controller
{
    public function index()
    {

        if (Gate::allows('AuthorizeAction', ['SUPPLIER'])) {
            $suppliers = Supplier::where('DELETED', 0)->when(Request::input('search'), function ($query, $search) {
                $query->where('SUPPLIER_ID', 'like', "%{$search}%")
                    ->orWhere('SUPP_NAME', 'like', "%{$search}%")
                    ->orWhere('TYPE', 'like', "%{$search}%");
            })->paginate(10)->withQueryString();

            return Inertia::render('Supplier/Index', [
                'suppliers' => $suppliers,
                'filters' => Request::only(['search']),
            ]);
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function create()
    {

        if (Gate::allows('AuthorizeAction', ['SUPPLIER'])) {
            return Inertia::render('Supplier/Create', []);
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function store(HttpRequest $request)
    {


        // Prevent modification for demo purpose
        return redirect()->back()->with('error', 'For demo purposes, Add, Edit, and Delete functions of Suppliers are disabled.');


        if (Gate::allows('AuthorizeAction', ['SUPPLIER'])) {
            try {
                // Begin transaction
                DB::beginTransaction();

                $maxID = Supplier::max('UNIQUE_ID') + 1;
                $supplierID = 'VR-' . str_pad($maxID, 7, '0', STR_PAD_LEFT);
                Supplier::insert([
                    'SUPPLIER_ID' => $supplierID,
                    'SUPP_NAME' => $request->supplierName,
                    'TYPE' => $request->supplierType,
                    'CONTACT_NAME' => $request->contactName,
                    'EMAIL' => $request->email,
                    'CONTACT_NO' => $request->contactNumber,
                    'ADDRESS' => $request->address,
                    'UPDATED_BY' => Auth::user()->FIRST_NAME . ' ' . Auth::user()->LAST_NAME,
                ]);
                // Commit transaction
                DB::commit();

                return Redirect::route('Supplier.index')->with('success', 'Supplier Created Successfully.');
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

    public function show($supplierID)
    {

        // Prevent searching already delete
        $supplier = Supplier::find($supplierID);

        if (!$supplier || $supplier->DELETED == 1) {
            abort(404); // Return 404 Not Found
        }
        //

        //
        if (Gate::allows('AuthorizeAction', ['SUPPLIER'])) {

            $supplierData = Supplier::findOrFail($supplierID);

            return Inertia::render('Supplier/Show', ['supplierData' => $supplierData]);
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function update(HttpRequest $request, $supplierID)
    {

        // Prevent modification for demo purpose
        return Redirect::route('Supplier.index')->with('error', 'For demo purposes, Add, Edit, and Delete functions of Suppliers are disabled.');

        if (Gate::allows('AuthorizeAction', ['SUPPLIER'])) {


            Supplier::findOrFail($supplierID);


            try {
                // Begin transaction
                DB::beginTransaction();

                Supplier::where('SUPPLIER_ID', $supplierID)
                    ->update([
                        'SUPPLIER_ID' => $supplierID,
                        'SUPP_NAME' => $request->supplierName,
                        'TYPE' => $request->supplierType,
                        'CONTACT_NAME' => $request->contactName,
                        'EMAIL' => $request->email,
                        'CONTACT_NO' => $request->contactNumber,
                        'ADDRESS' => $request->address,
                        'UPDATED_BY' => Auth::user()->FIRST_NAME . ' ' . Auth::user()->LAST_NAME,
                    ]);


                // Commit transaction
                DB::commit();

                return Redirect::route('Supplier.index')->with('success', 'Supplier Updated Successfully.');
            } catch (\Exception $e) {
                // Rollback transaction if an exception occurred
                DB::rollBack();
                // Log the error
                Log::error('Error occurred during database transaction: ' . $e->getMessage());

                return Redirect::back()->with('error', 'An Error Occur.');
            }


            $supplierData = Supplier::findOrFail($supplierID);

            return Inertia::render('Supplier/Show', ['supplierData' => $supplierData]);
        } else {
            return Redirect::route('noAccess');
        }
    }


    public function destroy($supplierID)
    {


        // Prevent modification for demo purpose
        return Redirect::route('Supplier.index')->with('error', 'For demo purposes, Add, Edit, and Delete functions of Suppliers are disabled.');


        if (Gate::allows('AuthorizeAction', ['SUPPLIER'])) {

            $supplier = Supplier::findOrFail($supplierID);

            // Delete the supplier
            $supplier->update(['DELETED' => 1]);

            return Redirect::route('Supplier.index')->with('success', 'Supplier Deleted Successfully.');
        } else {
            return Redirect::route('noAccess');
        }
    }
}
