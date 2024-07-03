<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements WithHeadings, WithColumnWidths
{

    use Exportable;


    public function headings(): array
    {
        return [
            'Asset Name',
            'Asset Category ID',
            'Asset Subtype',
            'Asset Description',
            'Color',
            'Weight',
            'Dimension',
            'Product Category',
            'Manufacturer',
            'Vendor ID',
            'Cost',
            'Warranty Terms',
            'Useful Life',
            'Status',
            'Equipment Model',
            'Asset Condition',
        ];
    }


    public function columnWidths(): array
    {
        $width = 20;
        $columns = range('A', 'P'); // Get all column names

        $widths = array_fill_keys($columns, $width); // Fill each column width with the same value

        return $widths;
    }


}
