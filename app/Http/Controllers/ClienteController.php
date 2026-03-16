<?php

namespace App\Http\Controllers;

use App\Enums\TipoCliente;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Provincia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class ClienteController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasPermissionTo('VER_TODOS_CLIENTES') || auth()->user()->hasRole('admin'))
        {
            $clientes = Cliente::orderBy('vendedor_id', 'desc')->paginate(7);

            return view('clientes.index', ['clientes' => $clientes, 'todos' => true]);
        }
        else
        {
            $clientes = auth()->user()->clientes()->paginate(7);

            return view('clientes.index', ['clientes' => $clientes, 'todos' => false]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::all();
        $vendedores = User::vendedores()->get();
        $provincias = Provincia::orderBy('name')->get();

        return view('clientes.create', compact('productos', 'vendedores', 'provincias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email',
            'phone' => 'required',
            'zipcode' => 'nullable',
            'provincia_id' => 'required|exists:provincias,id',
            'vendedor_id' => auth()->user()->hasRole('comercial') ? 'nullable' : 'required|exists:users,id',
            'tipo' => [new Enum(TipoCliente::class)],
            'productos' => 'nullable|array',
            'productos.*' => 'exists:productos,id',
        ]);

        if (auth()->user()->hasRole('comercial'))
        {
            $data['vendedor_id'] = auth()->id();
        }


        $cliente = Cliente::create($data);

        $cliente->syncProductosConPrecio($data['productos'] ?? []);

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
        $productos = Producto::all();
        $vendedores = User::vendedores()->get();
        $provincias = Provincia ::orderBy('name')->get();

        return view('clientes.edit', ['cliente' => $cliente, 'productos' => $productos, 'vendedores' => $vendedores, 'provincias' => $provincias,]);
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
            'vendedor_id' => auth()->user()->hasRole('comercial') ? 'nullable' : 'required|exists:users,id',
            'tipo' => [new Enum(TipoCliente::class)],
            'productos' => 'nullable|array',
            'productos.*' => 'exists:productos,id',
        ]);


        $cliente->update($data);

        $cliente->syncProductosConPrecio($data['productos'] ?? []);


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
