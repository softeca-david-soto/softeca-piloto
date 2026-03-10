<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nombres = ['Jose Luis', 'Pablo Cuesta', 'Alfredo Ortuñez',];

        $search = explode(",","á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ");
        $replace = explode(",","a,e,i,o,u,n,A,E,I,O,U,N");
        foreach ($nombres as $nombre) {

            $email = str_replace($search, $replace, strtolower(str_replace(' ', '', $nombre)));

            //He usado el Facade DB porque con modelos de Eloquent dice que el plural es "vendedors"
            DB::table('vendedores')->insert([
                'name' => $nombre,
                'email' => $email.'@embutidossoto.es',
                'password' => bcrypt('admin1'),
            ]);
        }
    }
}
