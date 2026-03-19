<?php

namespace App\Http\Controllers;

use App\Enums\TipoCliente;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Provincia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Enum;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $provincias = Provincia::orderBy('name')->get();
        $productos = Producto::activos()->orderBy('name')->get();
        $vendedores = User::vendedores()->get();
        $order = $request->input('order', 'desc');

        if (auth()->user()->hasPermissionTo('VER_TODOS_CLIENTES') || auth()->user()->hasRole('admin'))
        {
            $clientes = Cliente::activos()->orderBy('created_at', $order)
                ->when($request->filled('tipo'), fn($q) => $q->where('tipo', $request->tipo))
                ->when($request->filled('provincia_id'), fn($q) => $q->where('provincia_id', $request->provincia_id))
                ->when($request->filled('producto_id'), fn($q) => $q->whereHas('productos', fn($q) => $q->where('productos.id', $request->producto_id)))
                ->when($request->filled('vendedor_id'), fn($q) => $q->where('vendedor_id', $request->vendedor_id))
                ->paginate(7)->withQueryString();

            return view('clientes.index', ['clientes' => $clientes, 'todos' => true, 'provincias' => $provincias, 'productos' => $productos, 'vendedores' => $vendedores]);
        }
        else
        {
            $clientes = auth()->user()->clientes()->where('activo', 1)
                ->orderBy('created_at', $order)
                ->when($request->filled('tipo'), fn($q) => $q->where('tipo', $request->tipo))
                ->when($request->filled('provincia_id'), fn($q) => $q->where('provincia_id', $request->provincia_id))
                ->when($request->filled('producto_id'), fn($q) => $q->whereHas('productos', fn($q) => $q->where('productos.id', $request->producto_id)))
                ->paginate(7)->withQueryString();

            return view('clientes.index', ['clientes' => $clientes, 'todos' => false, 'provincias' => $provincias, 'productos' => $productos]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::activos()->get();
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
        if (!Gate::allows('view', $cliente))
        {
            abort(404);
        }

        return view('clientes.show', ['cliente' => $cliente]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        $productos = Producto::activos()->get();
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

        if (auth()->user()->hasRole('comercial'))
        {
            $data['vendedor_id'] = auth()->id();
        }

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
        $cliente['activo'] = 0;

        $cliente->update();

        session()->flash('swal',[
            'icon' => 'warning',
            'title' => 'Eliminado',
            'text' => 'El cliente se ha eliminado de la BBDD',
        ]);

        return redirect()->route('clientes.index');
    }

    public function asignarVendedor(Request $request)
    {
        $request->validate([
            'clientes'    => 'required|array',
            'clientes.*'  => 'exists:clientes,id',
            'vendedor_id' => 'required|exists:users,id',
        ]);

        Cliente::whereIn('id', $request->clientes)
            ->update(['vendedor_id' => $request->vendedor_id]);

        return response()->json(['success' => true]);
    }
}
