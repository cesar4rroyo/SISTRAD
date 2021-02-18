<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('personal')->insert([
            'nombres' => 'Santiago Ronald',
            'apellidopaterno' => 'Rodas',
            'apellidomaterno' => 'Ipanaque',
            'dni' => '45841576',
            'telefono' => '974866028',
        ]);
        DB::table('personal')->insert([
            'nombres' => 'Richard',
            'apellidopaterno' => 'Serrano',
            'apellidomaterno' => 'Bautista',
            'dni' => '75020436',
            'telefono' => '986783159',
        ]);
        DB::table('personal')->insert([
            'nombres' => 'Juan Eduardo',
            'apellidopaterno' => 'Bazan',
            'apellidomaterno' => 'Guerrero',
            'dni' => '45841576',
            'telefono' => '932827302',
        ]);
    }
}
