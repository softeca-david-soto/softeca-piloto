<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

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
        $id = 0;
        foreach ($nombres as $nombre) {

            $email = str_replace($search, $replace, strtolower(str_replace(' ', '', $nombre)));

            $v = User::updateOrCreate([
                'name' => $nombre,
                'email' => $email.'@embutidossoto.es',
                'password' => bcrypt('admin1'),
            ]);

            $v->assignRole('vendedor');
            $id++;
        }
    }
}
