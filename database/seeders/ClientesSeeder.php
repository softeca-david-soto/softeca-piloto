<?php

namespace Database\Seeders;

use App\Enums\TipoCliente;
use App\Models\Cliente;
use App\Models\Provincia;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = ['Adrián García', 'Carlos Fernández', 'Sofía González', 'Lucía Sánchez', 'Hugo Rodríguez', 'Gonzalo López', 'Héctor Martínez', 'Martina Pérez', 'María Gómez', 'Alba Díaz',];
        $provinciaIds = Provincia::pluck('id');
        $vendedorIds =  User::role('comercial')->pluck('id');
        $faker = Faker::create('es_ES');

        $search = explode(",","á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ");
        $replace = explode(",","a,e,i,o,u,n,A,E,I,O,U,N");
        foreach ($clientes as $cliente) {

            $email = str_replace($search, $replace, strtolower(str_replace(' ', '', $cliente)));

            Cliente::updateOrCreate([
                'name' => $cliente,
                'email' => $email.'@hotmail.com',
                'phone' => $faker->phoneNumber(),
                'zipcode' => $faker->postcode,
                'provincia_id' => $provinciaIds->random(),
                'vendedor_id' => $vendedorIds->random(),
                'tipo' => $faker->randomElement(TipoCliente::cases())->value,
            ]);
        }
    }
}
