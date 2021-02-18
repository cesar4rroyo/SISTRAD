<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('area')->insert([
            'descripcion' => 'Area 1',            
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Area 2',
        ]);
    }
}
