<?php

namespace Database\Seeders;

use App\Models\Provincia;
use Illuminate\Database\Seeder;

class ProvinciasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provincias = ['Asturias', 'Cantabria', 'Burgos', 'Bizkaia', 'León', 'La Rioja',];

        foreach ($provincias as $provincia) {

            Provincia::updateOrCreate([
                'name' => $provincia,
            ]);

        }
    }
}
