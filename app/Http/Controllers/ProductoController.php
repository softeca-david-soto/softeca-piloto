<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('id', 'desc')->get();

        return view('productos.index', ['productos' => $productos]);
    }

    public function create()
    {
        return view('productos.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'reference' => 'required|size:4',
            'stock' => 'numeric|min:0',
        ]);

        Producto::create($data);

        session()->flash('swal',[
            'icon' => 'success',
			'title' => 'Bien hecho!',
			'text' => 'El producto se ha creado correctamente',
        ]);

        return redirect()->route('productos.index');
    }

    public function show(Producto $producto)
    {
        return view('productos.show', ['producto' => $producto]);
    }

    public function setprices(Producto $producto)
    {
        $tiposcliente = Cliente::pluck('tipo')->unique()->toArray();

        return view('productos.prices', ['tiposcliente' => $tiposcliente, 'producto' => $producto]);
    }
}
