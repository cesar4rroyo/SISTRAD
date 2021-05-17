<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //no borrar este cargo id=1 Inpesectos
        DB::table('cargo')->insert([
            'descripcion' => 'Inspector',            
        ]);
        DB::table('cargo')->insert([
            'descripcion' => 'Cargo 2',            
        ]);
        DB::table('cargo')->insert([
            'descripcion' => 'Cargo 3',
        ]);

    }
}
