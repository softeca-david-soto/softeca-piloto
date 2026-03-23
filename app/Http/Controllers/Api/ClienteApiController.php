<?php

namespace App\Http\Controllers\Api;

use App\Enums\TipoCliente;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClienteResource;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class ClienteApiController extends Controller
{
    public function index()
    {
        return ClienteResource::collection(Cliente::activos()->get());
    }

    public function show(int $cliente_id)
    {
        $cliente = Cliente::activos()->find($cliente_id);
        return new ClienteResource($cliente);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email',
            'phone' => 'required',
            'zipcode' => 'nullable',
            'provincia_id' => 'required|exists:provincias,id',
            'vendedor_id' => 'required|exists:users,id',
            'tipo' => [new Enum(TipoCliente::class)],
            'productos' => 'nullable|array',
            'productos.*' => 'exists:productos,id',
        ]);

        $cliente = Cliente::create($data);

        $cliente->syncProductosConPrecio($data['productos'] ?? []);

        return new ClienteResource($cliente);
    }

    public function update(Request $request, int $cliente_id)
    {
        $cliente = Cliente::activos()->find($cliente_id);

         $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email,'.$cliente_id,
            'phone' => 'required',
            'zipcode' => 'nullable',
            'provincia_id' => 'required|exists:provincias,id',
            'vendedor_id' => 'required|exists:users,id',
            'tipo' => [new Enum(TipoCliente::class)],
            'productos' => 'nullable|array',
            'productos.*' => 'exists:productos,id',
        ]);

        $cliente->update($data);
        $cliente->syncProductosConPrecio($data['productos'] ?? []);

        return new ClienteResource($cliente);
    }

    public function destroy(int $cliente_id)
    {
        $cliente = Cliente::activos()->find($cliente_id);

        $cliente['activo'] = 0;

        $cliente->update();

        return response()->noContent();
    }

}
