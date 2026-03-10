<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ProvinciasSeeder::class);
        $this->call(VendedoresSeeder::class);
        $this->call(ProductosSeeder::class);
        $this->call(ClientesSeeder::class);
    }
}
