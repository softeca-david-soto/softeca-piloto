<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VendedorController extends Controller
{
    public function index()
    {

        $vendedores = User::vendedores()->orderBy('id', 'desc')->get();

        return view('vendedores.index', ['vendedores' => $vendedores]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:vendedores',
            'password' => 'required',
        ]);

        User::create($data);

        session()->flash('swal',[
            'icon' => 'success',
            'title' => 'Bien hecho!',
            'text' => 'El vendedor se ha creado correctamente',
        ]);
        return redirect()->route('vendedores.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $vendedor)
    {
        return view('vendedores.show', ['vendedor' => $vendedor]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $vendedor)
    {
        return view('vendedores.edit', ['vendedor' => $vendedor]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $vendedor)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:vendedores,email,'.$vendedor->id,
            'password' => 'required',
        ]);


        $vendedor->update($data);

        session()->flash('swal',[
            'icon' => 'info',
            'title' => 'Edición Realizada',
            'text' => 'El vendedor se ha actualizado correctamente',
        ]);
        return redirect()->route('vendedores.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $vendedor)
    {
        $vendedor->delete();

        session()->flash('swal',[
            'icon' => 'warning',
            'title' => 'Eliminado',
            'text' => 'El vendedor se ha eliminado de la BBDD',
        ]);

        return redirect()->route('vendedores.index');
    }
}
