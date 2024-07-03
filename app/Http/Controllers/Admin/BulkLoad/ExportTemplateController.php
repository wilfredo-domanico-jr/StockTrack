<?php

namespace App\Http\Controllers\Admin\BulkLoad;

use App\Exports\UserExport;
use App\Exports\ProductExport;
use App\Exports\LocationExport;
use App\Exports\SupplierExport;
use App\Exports\InventoryExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExportTemplateController extends Controller
{

    public function userTemplate()
    {
        return Excel::download(new UserExport, 'userTemplate.xlsx');
    }

    public function productTemplate()
    {
        return Excel::download(new ProductExport, 'productTemplate.xlsx');
    }

    public function inventoryTemplate()
    {
        return Excel::download(new InventoryExport, 'inventoryTemplate.xlsx');
    }

    public function supplierTemplate()
    {
        return Excel::download(new SupplierExport, 'supplierTemplate.xlsx');
    }

    public function locationTemplate()
    {
        return Excel::download(new LocationExport, 'locationTemplate.xlsx');
    }


}
