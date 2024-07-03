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
use App\Http\Controllers\Admin\BulkLoad\BulkLoadController;
use App\Http\Controllers\Inventory\AssetTransferController;
use App\Http\Controllers\Admin\LocationManagementController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\BulkLoad\ExportTemplateController;
use App\Http\Controllers\Admin\BulkLoad\ImportUserTemplateController;
use App\Http\Controllers\Admin\BulkLoad\ImportProductTemplateController;
use App\Http\Controllers\Admin\BulkLoad\ImportLocationTemplateController;
use App\Http\Controllers\Admin\BulkLoad\ImportSupplierTemplateController;
use App\Http\Controllers\Admin\BulkLoad\ImportInventoryTemplateController;

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
    Route::get('/productCatalog/product/edit/{assetId}', [ProductCatalogController::class, 'editProduct'])->name('editProduct');
    Route::post('/productCatalog/product/update/{assetId}', [ProductCatalogController::class, 'updateProduct'])->name('updateProduct');
    Route::get('/productCatalog/product/delete/{assetId}', [ProductCatalogController::class, 'deleteProduct'])->name('deleteProduct');
    Route::get('/productCatalog/assetCategorySetting', [ProductCatalogController::class, 'assetCategorySetting'])->name('assetCategorySetting');
    Route::get('/productCatalog/assetCategorySetting/create', [ProductCatalogController::class, 'createAssetCategory'])->name('createAssetCategory');
    Route::post('/productCatalog/assetCategorySetting/store', [ProductCatalogController::class, 'storeAssetCategory'])->name('storeAssetCategory');
    Route::get('/productCatalog/assetCategorySetting/edit/{categoryId}', [ProductCatalogController::class, 'editAssetCategory'])->name('editAssetCategory');
    Route::put('/productCatalog/assetCategorySetting/update/{categoryId}', [ProductCatalogController::class, 'updateAssetCategory'])->name('updateAssetCategory');
    Route::get('/productCatalog/assetCategorySetting/delete/{categoryId}', [ProductCatalogController::class, 'deleteAssetCategory'])->name('deleteAssetCategory');
});


Route::name('Inventory.')->middleware(['auth', 'verified'])->group(function () {

    Route::name('InventoryList.')->group(function () {
        Route::get('/inventory', [InventoryController::class, 'index'])->name('index');
        Route::get('/inventory/show/{inventoryID}', [InventoryController::class, 'show'])->name('show');

    });

    Route::name('Receive.')->group(function () {
        Route::get('/inventory/receive', [ReceiveController::class, 'index'])->name('index');
        Route::get('/inventory/receive/show/{assetTransNo}', [ReceiveController::class, 'show'])->name('show');
        Route::post('/inventory/receive/accept/{assetTransNo}', [ReceiveController::class, 'accept'])->name('accept');
        Route::post('/inventory/receive/reject/{assetTransNo}', [ReceiveController::class, 'reject'])->name('reject');
        Route::get('/inventory/receive/history', [ReceiveController::class, 'history'])->name('history');
        Route::get('/inventory/receive/history/show/{assetTransNo}', [ReceiveController::class, 'historyShow'])->name('historyShow');
       });

    Route::name('AssetTransfer.')->group(function () {
        Route::get('/inventory/asset-transfer', [AssetTransferController::class, 'index'])->name('index');
        Route::get('/inventory/asset-transfer/create', [AssetTransferController::class, 'create'])->name('create');
        Route::post('/inventory/asset-transfer/store', [AssetTransferController::class, 'store'])->name('store');
        Route::get('/inventory/asset-transfer/show/{assetTransNo}', [AssetTransferController::class, 'show'])->name('show');
        Route::get('/inventory/asset-transfer/history', [AssetTransferController::class, 'history'])->name('history');
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

    Route::name('BulkLoad.')->group(function () {
        Route::get('/admin/bulkload/index', [BulkLoadController::class, 'index'])->name('index');


        Route::name('ExportTemplate.')->group(function(){
            Route::get('/admin/bulkload/download/userTemplate',[ExportTemplateController::class, 'userTemplate'])->name('userTemplate');
            Route::get('/admin/bulkload/download/productTemplate',[ExportTemplateController::class, 'productTemplate'])->name('productTemplate');
            Route::get('/admin/bulkload/download/inventoryTemplate',[ExportTemplateController::class, 'inventoryTemplate'])->name('inventoryTemplate');
            Route::get('/admin/bulkload/download/supplierTemplate',[ExportTemplateController::class, 'supplierTemplate'])->name('supplierTemplate');
            Route::get('/admin/bulkload/download/locationTemplate',[ExportTemplateController::class, 'locationTemplate'])->name('locationTemplate');
        });


        Route::name('ImportTemplate.')->group(function(){
            Route::post('/admin/bulkload/upload/userImport',[ImportUserTemplateController::class, 'importUser'])->name('importUser');
            Route::post('/admin/bulkload/upload/productImport',[ImportProductTemplateController::class, 'importProduct'])->name('importProduct');
            Route::post('/admin/bulkload/upload/inventoryImport',[ImportInventoryTemplateController::class, 'importInventory'])->name('importInventory');
            Route::post('/admin/bulkload/upload/supplierImport',[ImportSupplierTemplateController::class, 'importSupplier'])->name('importSupplier');
            Route::post('/admin/bulkload/upload/locationImport',[ImportLocationTemplateController::class, 'importLocation'])->name('importLocation');
        });

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


require __DIR__.'/auth.php';


