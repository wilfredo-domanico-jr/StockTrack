<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;


class InventoryExport implements  WithHeadings, WithColumnWidths
{
    use Exportable;


    public function headings(): array
    {
        return [
            'Asset ID',
            'Asset Tag',
            'Serial No.',
            'Location ID',
            'Use Policy',
            'Service Level',
            'Barcode',
            'Purchase Order No.',
            'Purchase Date (YYYY/MM/DD)',
            'In Sevice Data (YYYY/MM/DD)',
            'Warranty Start Date (YYYY/MM/DD)'
        ];
    }

    public function columnWidths(): array
    {
        $width = 40;
        $columns = range('A', 'K'); // Get all column names

        $result = array_fill_keys($columns, $width);

        return $result;
    }
}
