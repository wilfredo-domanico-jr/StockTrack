<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\AssetCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class ProductCatalogController extends Controller
{



    public function index()
    {

        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {
            $products = Product::leftJoin('asset_category', 'product_list.ASSET_CATEGORY', '=', 'asset_category.id')
                ->select(
                    'product_list.INDEX_ID',
                    'product_list.ASSET_ID',
                    'product_list.ASSET_NAME',
                    'product_list.ASSET_SUB_TYPE',
                    'product_list.PRODUCT_CATEGORY',
                    'product_list.STATUS',
                    'asset_category.CATEGORY_NAME'
                )->where('product_list.DELETED', 0)
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('product_list.ASSET_ID', 'like', "%{$search}%")
                        ->orWhere('product_list.ASSET_NAME', 'like', "%{$search}%")
                        ->orWhere('product_list.ASSET_SUB_TYPE', 'like', "%{$search}%")
                        ->orWhere('product_list.PRODUCT_CATEGORY', 'like', "%{$search}%")
                        ->orWhere('product_list.STATUS', 'like', "%{$search}%")
                        ->orWhere('asset_category.CATEGORY_NAME', 'like', "%{$search}%");
                })
                ->paginate(10)->withQueryString();

            return Inertia::render('ProductCatalog/Index', [
                'products' => $products,
                'filters' => Request::only(['search']),
            ]);
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function createProduct()
    {


        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {

            $categories = AssetCategory::all();
            $suppliers = (new Supplier())->getAll();

            return Inertia::render('ProductCatalog/CreateProduct', [
                'categories' => $categories,
                'suppliers' => $suppliers,
            ]);
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function storeProduct(HttpRequest $request)
    {


        // Prevent adding more than one for demo-purpose
        $totalProduct = Product::count();

        if ($totalProduct >= 5) {
            return redirect()->back()->with('error', 'For demo purpose: Adding more than 5 product is not allowed. You can delete an existing product to add a new one.');
        }
        //




        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {

            try {
                // Begin transaction
                DB::beginTransaction();

                $nextAssetId = Product::max('INDEX_ID') + 1;
                $assetId = 'AST-' . str_pad($nextAssetId, 5, '0', STR_PAD_LEFT);

                if ($request->hasFile('image')) {

                    $file = $request->file('image');

                    $extension = $file->getClientOriginalExtension();
                    $size = $file->getSize();
                    // Check Extension
                    if ($extension != 'png' && $extension != 'jpeg' && $extension != 'jpg') {
                        return Redirect::back()->with('error', 'Image must be in png, jpeg or jpg format only.');
                    }

                    // Check if the file size is more than 5MB
                    $maxSize = 5 * 1024 * 1024; // 5MB in bytes

                    if ($size > $maxSize) {
                        // Handle the case where the file is larger than 5MB
                        return Redirect::back()->with('error', 'The file size exceeds the maximum limit of 5MB.');
                    }

                    $fileName = $assetId . '.' . $extension;

                    $file->move(public_path('images/productListPhotos'), $fileName);

                    $items_logo = $fileName;
                } else {
                    $items_logo = '';
                }

                Product::insert([
                    'ASSET_ID' => $assetId,
                    'ASSET_NAME' => $request->assetName,
                    'ASSET_SUB_TYPE' => $request->assetSubType,
                    'PRODUCT_CATEGORY' => $request->productCategory,
                    'ASSET_CATEGORY' => $request->assetCategory,
                    'EQUIPMENT_MODEL' => $request->equipmentModel,
                    'MANUFACTURER' => $request->manufacturer,
                    'COLOR' => $request->color,
                    'WEIGHT' => $request->weight,
                    'DIMENSION' => $request->dimension,
                    'COST' => $request->cost,
                    'WARRANTY_TERMS' => $request->warrantyTerms,
                    'USEFUL_LIFE' => $request->usefulLife,
                    'ASSET_CONDITION' => $request->assetCondition,
                    'FROM_DATE' => date('Y-m-d'),
                    'STATUS' => $request->status,
                    'VENDOR_ID' => $request->vendor,
                    'ASSET_DESCRIPTION' => $request->description,
                    'LOGO' => $items_logo,
                ]);

                // Commit transaction
                DB::commit();

                return Redirect::route('ProductCatalog.index')->with('success', 'Asset Inserted Successfully.');
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

    public function editProduct($assetId)
    {

        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {

            Product::findOrFail($assetId);

            $productDetail = (new Product)->find($assetId);
            $categories = AssetCategory::all();
            $suppliers = (new Supplier())->getAll();


            return Inertia::render('ProductCatalog/EditProduct', [
                'productDetail' => $productDetail,
                'categories' => $categories,
                'suppliers' => $suppliers,
            ]);
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function updateProduct(HttpRequest $request, $assetId)
    {


        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {

            Product::findOrFail($assetId);


            try {
                // Begin transaction
                DB::beginTransaction();


                if ($request->hasFile('image')) {

                    $file = $request->file('image');

                    $extension = $file->getClientOriginalExtension();
                    $size = $file->getSize();
                    // Check Extension

                    if ($extension != 'png' && $extension != 'jpeg' && $extension != 'jpg') {
                        return Redirect::back()->with('error', 'Image must be in png, jpeg or jpg format only.');
                    }

                    // Check if the file size is more than 5MB
                    $maxSize = 5 * 1024 * 1024; // 5MB in bytes

                    if ($size > $maxSize) {
                        // Handle the case where the file is larger than 5MB
                        return Redirect::back()->with('error', 'The file size exceeds the maximum limit of 5MB.');
                    }

                    $fileName = $assetId . date('YmdHis') . '.' . $extension;

                    $file->move(public_path('images/productListPhotos'), $fileName);

                    $image = $fileName;


                    // Then Delete the old photo

                    $oldFileName = public_path('images/productListPhotos') . '/' . $request->old_image;

                    if (file_exists($oldFileName)) {
                        unlink($oldFileName);
                    }
                } else {
                    //Get Database product
                    $image = $request->old_image;
                }


                Product::where('ASSET_ID', $assetId)
                    ->update([
                        'ASSET_NAME' => $request->assetName,
                        'ASSET_SUB_TYPE' => $request->assetSubType,
                        'PRODUCT_CATEGORY' => $request->productCategory,
                        'ASSET_CATEGORY' => $request->assetCategory,
                        'EQUIPMENT_MODEL' => $request->equipmentModel,
                        'MANUFACTURER' => $request->manufacturer,
                        'COLOR' => $request->color,
                        'WEIGHT' => $request->weight,
                        'DIMENSION' => $request->dimension,
                        'COST' => $request->cost,
                        'WARRANTY_TERMS' => $request->warrantyTerms,
                        'USEFUL_LIFE' => $request->usefulLife,
                        'ASSET_CONDITION' => $request->assetCondition,
                        'STATUS' => $request->status,
                        'VENDOR_ID' => $request->vendor,
                        'ASSET_DESCRIPTION' => $request->description,
                        'LOGO' => $image,
                    ]);


                // Commit transaction
                DB::commit();

                return Redirect::route('ProductCatalog.index')->with('success', 'Asset Updated Successfully.');
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


    public function deleteProduct($assetId)
    {

        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {

            // Retrieve the product by ASSET_ID or fail
            $product = Product::findOrFail($assetId);

            // Delete the product
            $product->update(['DELETED' => 1]);

            return Redirect::route('ProductCatalog.index')->with('success', 'Asset Deleted Successfully.');
        } else {
            return Redirect::route('noAccess');
        }
    }


    public function assetCategorySetting()
    {


        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {

            $categories = AssetCategory::when(Request::input('search'), function ($query, $search) {
                $query->where('CATEGORY_NAME', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            })
                ->paginate(10)->withQueryString();

            return Inertia::render('ProductCatalog/AssetCategorySetting', [
                'categories' => $categories,
                'filters' => Request::only(['search']),
            ]);
        } else {
            return Redirect::route('noAccess');
        }
    }


    public function createAssetCategory()
    {


        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {
            return Inertia::render('ProductCatalog/CreateAssetCategory', []);
        } else {
            return Redirect::route('noAccess');
        }
    }


    public function storeAssetCategory()
    {

        // Prevent adding more than five for demo-purpose
        $totalAssetCategory = AssetCategory::count();

        if ($totalAssetCategory >= 5) {
            return redirect()->back()->with('error', 'For demo purpose: Adding more than 5 asset category is not allowed. You can delete an existing asset category to add a new one.');
        }
        //


        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {

            AssetCategory::insert(['CATEGORY_NAME' => Request::input('category')]);

            return Redirect::route('ProductCatalog.assetCategorySetting')->with('success', 'Asset Category Created.');
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function editAssetCategory($categoryId)
    {


        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {

            $category = AssetCategory::findOrFail($categoryId);

            return Inertia::render('ProductCatalog/EditAssetCategory', ['category' => $category]);
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function updateAssetCategory($categoryId)
    {

        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {

            AssetCategory::where('id', $categoryId)->update(['CATEGORY_NAME' => Request::input('category')]);

            return Redirect::route('ProductCatalog.assetCategorySetting')->with('success', 'Asset Category Updated Successfully.');
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function deleteAssetCategory($categoryId)
    {

        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {

            AssetCategory::where('id', $categoryId)->delete();

            return Redirect::route('ProductCatalog.assetCategorySetting')->with('success', 'Asset Category Deleted Successfully.');
        } else {
            return Redirect::route('noAccess');
        }
    }
}
