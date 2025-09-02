<?php

namespace App\Http\Controllers\Inventory;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request as HttpRequest;

class InventoryController extends Controller
{



    public function index()
    {

        if (Gate::allows('AuthorizeAction', ['INVENTORY'])) {
            $inventories = Inventory::leftJoin('product_list', 'inventory.PRODUCT_ID', 'product_list.PRODUCT_ID')
                ->leftJoin('product_category', 'product_list.PRODUCT_CATEGORY', 'product_category.id')
                ->leftJoin('location', 'inventory.LOCATION_ID', 'location.LOCATION_ID')
                ->select(
                    'inventory.id',
                    'inventory.PRODUCT_ID',
                    'product_category.CATEGORY_NAME',
                    'product_list.PRODUCT_NAME',
                    'inventory.SERIAL_NO',
                    'inventory.PURCHASE_DATE',
                    DB::raw('DATE_FORMAT(inventory.created_at, "%Y-%m-%d") as DATE_CREATED')
                )
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('product_category.CATEGORY_NAME', 'like', "%{$search}%")
                        ->orWhere('product_list.PRODUCT_NAME', 'like', "%{$search}%")
                        ->orWhere('inventory.PURCHASE_DATE', 'like', "%{$search}%")
                        ->orWhere('inventory.SERIAL_NO', 'like', "%{$search}%");
                });


            $inventories = $inventories->paginate(10)->withQueryString();


            return Inertia::render('Inventory/InventoryList/Index', [
                'inventories' => $inventories,
                'filters' => Request::only(['search']),

            ]);
        } else {
            return Redirect::route('noAccess');
        }
    }


    public function create()
    {


        if (Gate::allows('AuthorizeAction', ['INVENTORY'])) {

            $products = Product::all();
            return Inertia::render('Inventory/InventoryList/Create', [
                'products' => $products

            ]);
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function store(HttpRequest $request)
    {



        if (Gate::allows('AuthorizeAction', ['INVENTORY'])) {


            // Validate if Serial No for selected product is already existing.

            $isSerialExisting = Inventory::where([
                'SERIAL_NO' => $request->serialNo
            ])->exists();


            if ($isSerialExisting) {
                return Redirect::back()->with('error', "Product with serial number '{$request->serialNo}' already exist in the system.");
            }

            try {
                // Begin transaction
                DB::beginTransaction();

                Inventory::insert([
                    'PRODUCT_ID' => $request->productId,
                    'SERIAL_NO' => $request->serialNo,
                    'PURCHASE_DATE' => $request->purchaseDate,
                    'LOCATION_ID' => getUserLocation()
                ]);

                // Commit transaction
                DB::commit();

                return Redirect::route('Inventory.InventoryList.index')->with('success', 'Inventory Inserted Successfully.');
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
}
