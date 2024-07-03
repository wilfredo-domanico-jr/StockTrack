<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LocationExport implements WithHeadings, WithColumnWidths
{


    public function headings(): array
    {
        return [
            'Location ID',
            'Location'
        ];
    }


    public function columnWidths(): array
    {
        $width = 20;
        $columns = range('A', 'B'); // Get all column names

        $widths = array_fill_keys($columns, $width); // Fill each column width with the same value

        return $widths;
    }
}
