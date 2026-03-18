<?php

namespace App\Http\Controllers;

use App\Enums\TipoCliente;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::activos()->orderBy('id', 'desc')->paginate(7);

        return view('productos.index', ['productos' => $productos]);
    }

    public function create()
    {
        $tipos = TipoCliente::cases();

        return view('productos.create', ['tipos' => $tipos,]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'reference' => 'required|size:4|unique:productos,reference',
            'stock' => 'integer|min:0',
            'precio_tradicional'    => 'required|numeric|min:0',
            'precio_supermercado'   => 'required|numeric|min:0',
            'precio_cadena'         => 'required|numeric|min:0',
            'precio_distribuidor'   => 'required|numeric|min:0',
        ]);

        $producto = Producto::create($data);

        foreach ($producto->clientes as $cliente) {
            $campo = 'precio_' . $cliente->tipo->value;
            $producto->clientes()->updateExistingPivot($cliente->id, [
                'precio' => $data[$campo],
            ]);
        }

        session()->flash('swal',[
            'icon' => 'success',
			'title' => 'Bien hecho!',
			'text' => 'El producto se ha creado correctamente',
        ]);

        return redirect()->route('productos.index');
    }

    public function show(Producto $producto)
    {
        $clientes = $producto->clientes->where('vendedor_id', auth()->id())->where('activo', 1);

        if (auth()->user()->hasRole('admin')) {
            $clientes = $producto->clientes()->where('activo', 1)->get();
        }
        $tipos = TipoCliente::cases();

        return view('productos.show', ['producto' => $producto, 'clientes' => $clientes, 'tipos' => $tipos]);
    }

    public function edit(Producto $producto)
    {
        $tipos = TipoCliente::cases();
        return view('productos.edit', compact('producto', 'tipos'));
    }

    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'reference'             => 'required|string|unique:productos,reference,'.$producto->id,
            'stock'                 => 'required|integer|min:0',
            'precio_tradicional'    => 'required|numeric|min:0',
            'precio_supermercado'   => 'required|numeric|min:0',
            'precio_cadena'         => 'required|numeric|min:0',
            'precio_distribuidor'   => 'required|numeric|min:0',
        ]);

        $producto->update($data);

        // Actualizar precios en la tabla pivot según tipo de cliente
        foreach ($producto->clientes as $cliente) {
            $campo = 'precio_' . $cliente->tipo->value;
            $producto->clientes()->updateExistingPivot($cliente->id, [
                'precio' => $data[$campo],
            ]);
        }

        session()->flash('swal', [
            'icon'  => 'info',
            'title' => 'Edición Realizada',
            'text'  => 'El producto se ha actualizado correctamente',
        ]);

        return redirect()->route('productos.index');
    }

     public function destroy(Producto $producto)
    {
        $producto['activo'] = 0;

        $producto->update();

        session()->flash('swal', [
            'icon'  => 'warning',
            'title' => 'Eliminado',
            'text'  => 'El producto se ha eliminado de la BBDD',
        ]);

        return redirect()->route('productos.index');
    }

}
