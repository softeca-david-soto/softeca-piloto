<?php

namespace App\Imports;

use App\Models\Cliente;
use App\Enums\TipoCliente;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rules\Enum;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ClientesImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $rows)
    {
        $user = auth()->user();

        foreach ($rows as $row) {
            $id = $row['id'] ?? null;
            $cliente = null;

            if ($id) {
                $query = Cliente::where('id', $id);
                // Si es comercial, solo puede editar los suyos
                if ($user->hasRole('comercial')) {
                    $query->where('vendedor_id', $user->id);
                }
                $cliente = $query->first();
            }

            // Si no existe o no se tiene permiso de edición, preparamos creación
            if (!$cliente) {
                $cliente = new Cliente();
                $cliente->vendedor_id = $user->hasRole('comercial') ? $user->id : $row['vendedor_id'];
            } else {
                // Si es actualización y el usuario es admin, permite cambiar vendedor
                if (!$user->hasRole('comercial') && isset($row['vendedor_id'])) {
                    $cliente->vendedor_id = $row['vendedor_id'];
                }
            }

            $cliente->fill([
                'name'         => $row['nombre'],
                'email'        => $row['email'],
                'phone'        => $row['telefono'],
                'zipcode'      => $row['zipcode'] ?? null,
                'provincia_id' => $row['provincia_id'],
                'tipo'         => $row['tipo'],
                'activo'       => 1,
            ]);

            $cliente->save();

            // Sincronizar productos usando tu método personalizado
            if (!empty($row['productos'])) {
                // Se espera en el Excel IDs separados por coma: "1,2,3"
                $productosIds = explode(',', $row['productos']);
                $cliente->syncProductosConPrecio($productosIds);
            }
        }
    }

    public function rules(): array
    {
        return [
            'id'           => 'nullable|exists:clientes,id',
            'nombre'       => 'required|string|max:255',
            'email'        => 'required|email',
            'telefono'     => 'required',
            'provincia_id' => 'required|exists:provincias,id',
            'tipo'         => ['required', new Enum(TipoCliente::class)],
            'vendedor_id'  => auth()->user()->hasRole('comercial') ? 'nullable' : 'required|exists:users,id',
            'productos'    => 'nullable',
        ];
    }

    public function customValidationAttributes()
    {
        return [
            'nombre' => 'Nombre',
            'email' => 'Correo Electrónico',
            'vendedor_id' => 'Comercial',
            'provincia_id' => 'Provincia',
        ];
    }
}
