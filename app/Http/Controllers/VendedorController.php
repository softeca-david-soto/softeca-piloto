<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VendedorController extends Controller
{
    public function index()
    {
        $vendedores = User::vendedores()->get();

        return view('vendedores.index', ['vendedores' => $vendedores,]);
    }

    public function create()
    {
        return view('vendedores.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $user->assignRole('comercial');

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => 'Bien hecho!',
            'text'  => 'El vendedor se ha creado correctamente',
        ]);

        return redirect()->route('vendedores.index');
    }

    public function show(User $vendedor)
    {
        $vendedor->load('clientes.provincia');
        return view('vendedores.show', ['vendedor' => $vendedor]);
    }

    public function edit(User $vendedor)
    {
        return view('vendedores.edit', ['vendedor' => $vendedor]);
    }

    public function update(Request $request, User $vendedor)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,'.$vendedor->id,
            'password' => 'nullable|string|min:6',
        ]);

        $vendedor->update([
            'name'  => $data['name'],
            'email' => $data['email'],
            ...($data['password'] ? ['password' => bcrypt($data['password'])] : []),
        ]);

        session()->flash('swal', [
            'icon'  => 'info',
            'title' => 'Edición Realizada',
            'text'  => 'El vendedor se ha actualizado correctamente',
        ]);

        return redirect()->route('vendedores.index');
    }

    public function destroy(User $vendedor)
    {
        $vendedor->delete();

        session()->flash('swal', [
            'icon'  => 'warning',
            'title' => 'Eliminado',
            'text'  => 'El vendedor se ha eliminado de la BBDD',
        ]);

        return redirect()->route('vendedores.index');
    }
}
