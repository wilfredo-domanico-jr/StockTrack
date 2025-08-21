<?php

namespace App\Http\Controllers\Inventory;

use Inertia\Inertia;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;

class InventoryController extends Controller
{



    public function index()
    {

        if (Gate::allows('AuthorizeAction', ['INVENTORY'])) {
            $inventories = Inventory::leftJoin('product_list', 'inventory.ASSET_ID', 'product_list.ASSET_ID')
                ->leftJoin('asset_category', 'product_list.ASSET_CATEGORY', 'asset_category.id')
                ->leftJoin('location', 'inventory.LOCATION_ID', 'location.LOCATION_ID')
                ->where('inventory.IS_DISPOSED', 0)
                ->select(
                    'inventory.INVENTORY_ID',
                    'inventory.ASSET_ID',
                    'asset_category.CATEGORY_NAME',
                    'product_list.PRODUCT_CATEGORY',
                    'product_list.ASSET_NAME',
                    'inventory.ASSET_TAG',
                    'location.LOCATION',
                    'inventory.SERIAL_NO',
                    DB::raw('DATE_FORMAT(inventory.created_at, "%Y-%m-%d") as DATE_CREATED')
                )
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('inventory.ASSET_ID', 'like', "%{$search}%")
                        ->orWhere('asset_category.CATEGORY_NAME', 'like', "%{$search}%")
                        ->orWhere('product_list.PRODUCT_CATEGORY', 'like', "%{$search}%")
                        ->orWhere('product_list.ASSET_NAME', 'like', "%{$search}%")
                        ->orWhere('inventory.ASSET_TAG', 'like', "%{$search}%")
                        ->orWhere('location.LOCATION', 'like', "%{$search}%")
                        ->orWhere('inventory.SERIAL_NO', 'like', "%{$search}%")
                        ->orWhere('inventory.created_at', 'like', "%{$search}%");
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


    public function show($inventoryID)
    {

        if (Gate::allows('AuthorizeAction', ['INVENTORY'])) {

            $inventoryData = Inventory::with('product.assetCategory')->findOrFail($inventoryID);

            return Inertia::render('Inventory/InventoryList/Show', ['inventoryData' => $inventoryData]);
        } else {
            return Redirect::route('noAccess');
        }
    }
}
