<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\ProductCategory;
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
            $products = Product::leftJoin('product_category', 'product_list.PRODUCT_CATEGORY', '=', 'product_category.id')
                ->leftJoin('supplier', 'product_list.VENDOR_ID', '=', 'supplier.SUPPLIER_ID')
                ->select(
                    'product_list.INDEX_ID',
                    'product_list.PRODUCT_ID',
                    'product_list.PRODUCT_NAME',
                    'product_list.STATUS',
                    'product_category.CATEGORY_NAME',
                    'supplier.SUPP_NAME'
                )->where('product_list.DELETED', 0)
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('product_list.PRODUCT_ID', 'like', "%{$search}%")
                        ->orWhere('product_list.PRODUCT_NAME', 'like', "%{$search}%")
                        ->orWhere('product_list.STATUS', 'like', "%{$search}%")
                        ->orWhere('product_category.CATEGORY_NAME', 'like', "%{$search}%")
                        ->orWhere('supplier.SUPP_NAME', 'like', "%{$search}%");
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

            $categories = ProductCategory::all();
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
        return redirect()->back()->with('error', 'For demo purposes, Add, Edit, and Delete functions of Products are disabled.');


        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {

            try {
                // Begin transaction
                DB::beginTransaction();

                $nextProductId = Product::max('INDEX_ID') + 1;
                $productId = 'PROD-' . str_pad($nextProductId, 5, '0', STR_PAD_LEFT);

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

                    $fileName = $productId . '.' . $extension;

                    $file->move(public_path('images/productListPhotos'), $fileName);

                    $items_logo = $fileName;
                } else {
                    $items_logo = '';
                }

                Product::insert([
                    'PRODUCT_ID' => $productId,
                    'PRODUCT_NAME' => $request->productName,
                    'PRODUCT_CATEGORY' => $request->productCategory,
                    'EQUIPMENT_MODEL' => $request->equipmentModel,
                    'MANUFACTURER' => $request->manufacturer,
                    'COLOR' => $request->color,
                    'WEIGHT' => $request->weight,
                    'DIMENSION' => $request->dimension,
                    'USEFUL_LIFE' => $request->usefulLife,
                    'PRODUCT_CONDITION' => $request->condition,
                    'FROM_DATE' => date('Y-m-d'),
                    'STATUS' => $request->status,
                    'VENDOR_ID' => $request->vendor,
                    'PRODUCT_DESCRIPTION' => $request->description,
                    'LOGO' => $items_logo,
                ]);

                // Commit transaction
                DB::commit();

                return Redirect::route('ProductCatalog.index')->with('success', 'Product Inserted Successfully.');
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

    public function editProduct($productId)
    {

        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {

            Product::findOrFail($productId);

            $productDetail = (new Product)->find($productId);
            $categories = ProductCategory::all();
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

    public function updateProduct(HttpRequest $request, $productId)
    {

        return Redirect::route('ProductCatalog.index')->with('error', 'For demo purposes, Add, Edit, and Delete functions of Products are disabled.');
        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {

            Product::findOrFail($productId);


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

                    $fileName = $productId . date('YmdHis') . '.' . $extension;

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

                Product::where('PRODUCT_ID', $productId)
                    ->update([
                        'PRODUCT_NAME' => $request->productName,
                        'PRODUCT_CATEGORY' => $request->productCategory,
                        'EQUIPMENT_MODEL' => $request->equipmentModel,
                        'MANUFACTURER' => $request->manufacturer,
                        'COLOR' => $request->color,
                        'WEIGHT' => $request->weight,
                        'DIMENSION' => $request->dimension,
                        'USEFUL_LIFE' => $request->usefulLife,
                        'PRODUCT_CONDITION' => $request->condition,
                        'STATUS' => $request->status,
                        'VENDOR_ID' => $request->vendor,
                        'PRODUCT_DESCRIPTION' => $request->description,
                        'LOGO' => $image,
                    ]);


                // Commit transaction
                DB::commit();

                return Redirect::route('ProductCatalog.index')->with('success', 'Product Updated Successfully.');
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


    public function deleteProduct($productId)
    {

        return Redirect::route('ProductCatalog.index')->with('error', 'For demo purposes, Add, Edit, and Delete functions of Products are disabled.');
        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {

            // Retrieve the product by PRODUCT_ID or fail
            $product = Product::findOrFail($productId);

            // Delete the product
            $product->update(['DELETED' => 1]);

            return Redirect::route('ProductCatalog.index')->with('success', 'Product Deleted Successfully.');
        } else {
            return Redirect::route('noAccess');
        }
    }


    public function productCategorySetting()
    {


        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {

            $categories = ProductCategory::when(Request::input('search'), function ($query, $search) {
                $query->where('CATEGORY_NAME', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            })
                ->paginate(10)->withQueryString();

            return Inertia::render('ProductCatalog/ProductCategorySetting', [
                'categories' => $categories,
                'filters' => Request::only(['search']),
            ]);
        } else {
            return Redirect::route('noAccess');
        }
    }


    public function createProductCategory()
    {


        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {
            return Inertia::render('ProductCatalog/CreateProductCategory', []);
        } else {
            return Redirect::route('noAccess');
        }
    }


    public function storeProductCategory()
    {

        // Prevention For Demo Purposes
        return redirect()->back()->with('error', 'For demo purposes, Add, Edit, and Delete functions of Product Categories are disabled.');


        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {

            ProductCategory::insert(['CATEGORY_NAME' => Request::input('category')]);

            return Redirect::route('ProductCatalog.productCategorySetting')->with('success', 'Product Category Created.');
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function editProductCategory($categoryId)
    {


        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {

            $category = ProductCategory::findOrFail($categoryId);

            return Inertia::render('ProductCatalog/EditProductCategory', ['category' => $category]);
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function updateProductCategory($categoryId)
    {

        return Redirect::route('ProductCatalog.productCategorySetting')->with('error', 'For demo purposes, Add, Edit, and Delete functions of Product Categories are disabled.');

        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {

            ProductCategory::where('id', $categoryId)->update(['CATEGORY_NAME' => Request::input('category')]);

            return Redirect::route('ProductCatalog.productCategorySetting')->with('success', 'Product Category Updated Successfully.');
        } else {
            return Redirect::route('noAccess');
        }
    }

    public function deleteProductCategory($categoryId)
    {

        return Redirect::route('ProductCatalog.productCategorySetting')->with('error', 'For demo purposes, Add, Edit, and Delete functions of Product Categories are disabled.');

        if (Gate::allows('AuthorizeAction', ['PRODUCT_CATALOG'])) {

            ProductCategory::where('id', $categoryId)->delete();

            return Redirect::route('ProductCatalog.productCategorySetting')->with('success', 'Product Category Deleted Successfully.');
        } else {
            return Redirect::route('noAccess');
        }
    }
}
