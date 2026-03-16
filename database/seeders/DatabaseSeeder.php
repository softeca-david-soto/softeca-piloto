<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermisosSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(ProvinciasSeeder::class);
        $this->call(VendedoresSeeder::class);
        $this->call(ProductosSeeder::class);
        $this->call(ClientesSeeder::class);

        $admin = User::updateOrCreate([
            'name' => 'Administrador',
            'email' => 'admin@softeca.es',
            'password' => bcrypt('david'),
        ]);

        $admin->assignRole('admin');
    }
}
