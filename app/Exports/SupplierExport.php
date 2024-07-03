<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;


class SupplierExport implements WithHeadings, WithColumnWidths
{
    use Exportable;


    public function headings(): array
        {

            return[
                'Supplier Name',
                'Supplier Type',
                'Contact Name',
                'Email',
                'Contact Number',
                'Address'
            ];

        }

    public function columnWidths(): array
        {
            $width = 20;
            $columns = range('A', 'F'); // Get all column names

            $widths = array_fill_keys($columns, $width); // Fill each column width with the same value

            return $widths;
        }

}
