<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = [
            'lomo' => '01LM',
            'chorizo' => '01CR',
            'empanada' => '02MP',
            'fuet' => '01FT',
            'jamon' => '01JM',
            'salami' => '01SL',
            'mortadela' => '01MT',
            'tortilla' => '02TR',
        ];

        foreach ($productos as $producto => $ref) {

            Producto::updateOrCreate([
                'name' => $producto,
                'reference' => $ref,
                'stock' => random_int(0, 500),
            ]);
        }
    }
}
