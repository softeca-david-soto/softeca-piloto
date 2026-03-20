<?php

namespace App\Exports;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomChunkSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClientesExport implements FromQuery, ShouldAutoSize, WithCustomChunkSize, WithHeadings, WithMapping, WithStyles
{
    public function __construct(
        protected Request $request
    ) {}

    public function query()
    {
        $user = auth()->user();

        if ($user->hasPermissionTo('VER_TODOS_CLIENTES') || $user->hasRole('admin')) {
            $query = Cliente::activos();
        } else {
            $query = $user->clientes()->activos();
        }

        return $query->orderBy('created_at', $this->request->input('order', 'desc'))
            ->when($this->request->filled('tipo'), fn ($q) => $q->where('tipo', $this->request->tipo))
            ->when($this->request->filled('provincia_id'), fn ($q) => $q->where('provincia_id', $this->request->provincia_id))
            ->when($this->request->filled('producto_id'), fn ($q) => $q->whereHas('productos', fn ($q2) => $q2->where('productos.id', $this->request->producto_id)))
            ->when($this->request->filled('vendedor_id'), fn ($q) => $q->where('vendedor_id', $this->request->vendedor_id));
    }

    public function headings(): array
    {
        return ['FECHA', 'CLIENTE', 'EMAIL', 'TELEFONO', 'TIPO', 'PROVINCIA', 'PRODUCTOS', 'COMERCIAL'];
    }

    public function map($cliente): array
    {
        return [
            $cliente->created_at->format('d/m/Y'),
            $cliente->name,
            $cliente->email,
            $cliente->phone,
            $cliente->tipo->label(),
            $cliente->provincia?->name ?? 'N/A',
            $cliente->productos->pluck('name')->implode(', '),
            $cliente->vendedor?->name ?? 'Sin asignar',
        ];
    }

    public function chunkSize(): int
    {
        return 2000;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true,],
                'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'CEF571']]
            ]
        ];
    }
}
