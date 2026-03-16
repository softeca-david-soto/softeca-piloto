<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permisos = [
            'VER_VENDEDORES',
            'CREAR_VENDEDORES',
            'EDITAR_VENDEDORES',
            'BORRAR_VENDEDORES',
            'VER_TODOS_CLIENTES',
            'VER_CLIENTES',
            'CREAR_CLIENTES',
            'EDITAR_CLIENTES',
            'BORRAR_CLIENTES',
            'CREAR_PRODUCTOS',
            'VER_PRODUCTOS',
            'FIJAR_PRECIOS',
            'EDITAR_PRODUCTOS',
            'BORRAR_PRODUCTOS',
        ];

        foreach ($permisos as $perm) {
            Permission::create([
                'name' => $perm,
            ]);
        }
    }
}
