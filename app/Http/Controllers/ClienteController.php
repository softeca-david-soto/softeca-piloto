<?php

namespace App\Http\Controllers;

use App\Enums\TipoCliente;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class ClienteController extends Controller
{
    public function index()
    {

        $clientes = Cliente::orderBy('id', 'desc')->get();

        return view('clientes.index', ['clientes' => $clientes]);
    }

    public function index2()
    {

        $clientes = auth()->user()->clientes;

        return view('clientes.index', ['clientes' => $clientes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes',
            'phone' => 'required',
            'zipcode' => 'nullable',
            'provincia_id' => 'required|exists:provincias,id',
            'vendedor_id' => 'required|exists:vendedores,id',
            'tipo' => [new Enum(TipoCliente::class)],
        ]);

        Cliente::create($data);

        session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Bien hecho!',
            'text' => 'El cliente se ha creado correctamente',
        ]);
        return redirect()->route('clientes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        return view('clientes.show', ['cliente' => $cliente]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', ['cliente' => $cliente]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email,'.$cliente->id,
            'phone' => 'required',
            'zipcode' => 'nullable',
            'provincia_id' => 'required|exists:provincias,id',
            'vendedor_id' => 'required|exists:vendedores,id',
            'tipo' => [new Enum(TipoCliente::class)],
        ]);


        $cliente->update($data);

        session()->flash('swal',[
            'icon' => 'info',
            'title' => 'Edición Realizada',
            'text' => 'El cliente se ha actualizado correctamente',
        ]);
        return redirect()->route('clientes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        session()->flash('swal',[
            'icon' => 'warning',
            'title' => 'Eliminado',
            'text' => 'El cliente se ha eliminado de la BBDD',
        ]);

        return redirect()->route('clientes.index');
    }
}
