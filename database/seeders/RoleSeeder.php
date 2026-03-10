<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = ['admin', 'vendedor'];

        foreach ($roles as $role) {
            $createdRole = Role::create([
                'name' => $role,
            ]);

            if ($createdRole->name == 'vendedor')
            {
                $createdRole->givePermissionTo('VER_CLIENTES');
                $createdRole->givePermissionTo('CREAR_CLIENTES');
                $createdRole->givePermissionTo('EDITAR_CLIENTES');
                $createdRole->givePermissionTo('BORRAR_CLIENTES');
                $createdRole->givePermissionTo('VER_PRODUCTOS');
            }

        }
    }
}
