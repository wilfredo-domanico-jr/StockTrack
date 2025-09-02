<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AccountSettingController;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\Admin\RoleAccessController;
use App\Http\Controllers\Inventory\ReceiveController;
use App\Http\Controllers\Inventory\InventoryController;
use App\Http\Controllers\Admin\RoleManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Inventory\InventoryTransferController;
use App\Http\Controllers\Admin\LocationManagementController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', [AuthenticatedSessionController::class, 'create']);
Route::get('/noAccess', [PageController::class, 'noAccess'])->name('noAccess');

// Handle 404 error
Route::fallback([PageController::class, 'notfound']);


Route::name('Home.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('index');
});


Route::name('ProductCatalog.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/productCatalog', [ProductCatalogController::class, 'index'])->name('index');
    Route::get('/productCatalog/product/create', [ProductCatalogController::class, 'createProduct'])->name('createProduct');
    Route::post('/productCatalog/product/store', [ProductCatalogController::class, 'storeProduct'])->name('storeProduct');
    Route::get('/productCatalog/product/edit/{productId}', [ProductCatalogController::class, 'editProduct'])->name('editProduct');
    Route::post('/productCatalog/product/update/{productId}', [ProductCatalogController::class, 'updateProduct'])->name('updateProduct');
    Route::get('/productCatalog/product/delete/{productId}', [ProductCatalogController::class, 'deleteProduct'])->name('deleteProduct');
    Route::get('/productCatalog/productCategorySetting', [ProductCatalogController::class, 'productCategorySetting'])->name('productCategorySetting');
    Route::get('/productCatalog/productCategorySetting/create', [ProductCatalogController::class, 'createProductCategory'])->name('createProductCategory');
    Route::post('/productCatalog/productCategorySetting/store', [ProductCatalogController::class, 'storeProductCategory'])->name('storeProductCategory');
    Route::get('/productCatalog/productCategorySetting/edit/{categoryId}', [ProductCatalogController::class, 'editProductCategory'])->name('editProductCategory');
    Route::put('/productCatalog/productCategorySetting/update/{categoryId}', [ProductCatalogController::class, 'updateProductCategory'])->name('updateProductCategory');
    Route::get('/productCatalog/productCategorySetting/delete/{categoryId}', [ProductCatalogController::class, 'deleteProductCategory'])->name('deleteProductCategory');
});


Route::name('Inventory.')->middleware(['auth', 'verified'])->group(function () {

    Route::name('InventoryList.')->group(function () {
        Route::get('/inventory', [InventoryController::class, 'index'])->name('index');
        Route::get('/inventory/create', [InventoryController::class, 'create'])->name('create');
        Route::post('/inventory/store', [InventoryController::class, 'store'])->name('store');
    });

    Route::name('Receive.')->group(function () {
        Route::get('/inventory/receive', [ReceiveController::class, 'index'])->name('index');
        Route::get('/inventory/receive/show/{assetTransNo}', [ReceiveController::class, 'show'])->name('show');
        Route::post('/inventory/receive/accept/{assetTransNo}', [ReceiveController::class, 'accept'])->name('accept');
        Route::post('/inventory/receive/reject/{assetTransNo}', [ReceiveController::class, 'reject'])->name('reject');
        Route::get('/inventory/receive/history', [ReceiveController::class, 'history'])->name('history');
        Route::get('/inventory/receive/history/show/{assetTransNo}', [ReceiveController::class, 'historyShow'])->name('historyShow');
    });

    Route::name('InventoryTransfer.')->group(function () {
        Route::get('/inventory/inventory-transfer', [InventoryTransferController::class, 'index'])->name('index');
        Route::get('/inventory/inventory-transfer/create', [InventoryTransferController::class, 'create'])->name('create');
        Route::post('/inventory/inventory-transfer/store', [InventoryTransferController::class, 'store'])->name('store');
        Route::get('/inventory/inventory-transfer/show/{inventoryTransNo}', [InventoryTransferController::class, 'show'])->name('show');
        Route::get('/inventory/inventory-transfer/history', [InventoryTransferController::class, 'history'])->name('history');
    });
});


Route::name('Supplier.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/supplier', [SupplierController::class, 'index'])->name('index');
    Route::get('/supplier/create', [SupplierController::class, 'create'])->name('create');
    Route::post('/supplier/store', [SupplierController::class, 'store'])->name('store');
    Route::get('/supplier/show/{supplierID}', [SupplierController::class, 'show'])->name('show');
    Route::put('/supplier/update/{supplierID}', [SupplierController::class, 'update'])->name('update');
    Route::get('/supplier/destroy/{supplierID}', [SupplierController::class, 'destroy'])->name('destroy');
});

Route::name('AccountSetting.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/accountsetting/index', [AccountSettingController::class, 'index'])->name('index');
    Route::get('/accountsetting/show', [AccountSettingController::class, 'show'])->name('show');
    Route::post('/accountsetting/update', [AccountSettingController::class, 'update'])->name('update');
});



Route::name('Admin.')->middleware(['auth', 'verified'])->group(function () {

    Route::name('UserManagement.')->group(function () {
        Route::get('/admin/usermanagement/index', [UserManagementController::class, 'index'])->name('index');
        Route::get('/admin/usermanagement/create', [UserManagementController::class, 'create'])->name('create');
        Route::post('/admin/usermanagement/store', [UserManagementController::class, 'store'])->name('store');
        Route::get('/admin/usermanagement/show/{userID}', [UserManagementController::class, 'show'])->name('show');
        Route::get('/admin/usermanagement/destroy/{userID}', [UserManagementController::class, 'destroy'])->name('destroy');
    });


    Route::name('LocationManagement.')->group(function () {
        Route::get('/admin/locationmanagement/index', [LocationManagementController::class, 'index'])->name('index');
        Route::get('/admin/locationmanagement/create', [LocationManagementController::class, 'create'])->name('create');
        Route::post('/admin/locationmanagement/store', [LocationManagementController::class, 'store'])->name('store');
        Route::get('/admin/locationmanagement/show/{locationID}', [LocationManagementController::class, 'show'])->name('show');
        Route::put('/admin/locationmanagement/update/{locationID}', [LocationManagementController::class, 'update'])->name('update');
        Route::get('/admin/locationmanagement/destroy/{locationID}', [LocationManagementController::class, 'destroy'])->name('destroy');
    });

    Route::name('RoleManagement.')->group(function () {
        Route::get('/admin/rolemanagement/index', [RoleManagementController::class, 'index'])->name('index');
        Route::get('/admin/rolemanagement/create', [RoleManagementController::class, 'create'])->name('create');
        Route::post('/admin/rolemanagement/store', [RoleManagementController::class, 'store'])->name('store');
        Route::get('/admin/rolemanagement/show/{roleID}', [RoleManagementController::class, 'show'])->name('show');
        Route::put('/admin/rolemanagement/update/{roleID}', [RoleManagementController::class, 'update'])->name('update');
        Route::get('/admin/rolemanagement/destroy/{roleID}', [RoleManagementController::class, 'destroy'])->name('destroy');
    });

    Route::name('RoleAccess.')->group(function () {
        Route::get('/admin/roleaccess/index', [RoleAccessController::class, 'index'])->name('index');
        Route::get('/admin/roleaccess/update', [RoleAccessController::class, 'update'])->name('update');
        Route::get('/admin/roleaccess/show/{roleID}', [RoleAccessController::class, 'show'])->name('show');
        Route::put('/admin/roleaccess/update/{roleID}', [RoleAccessController::class, 'update'])->name('update');
    });
});


require __DIR__ . '/auth.php';
