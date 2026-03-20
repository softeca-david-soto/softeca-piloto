<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PlantillaClientesExport implements FromArray, WithStyles, ShouldAutoSize, WithHeadings
{
    public function headings(): array
    {
        return [
            'id',
            'nombre',
            'email',
            'telefono',
            'zipcode',
            'provincia_id',
            'tipo (tradicional,supermercado,cadena,distribuidor)',
            'vendedor_id',
            'productos'
        ];
    }

    public function array(): array
    {
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => '000000'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'CEF571'],
                ],
            ],
        ];
    }
}
