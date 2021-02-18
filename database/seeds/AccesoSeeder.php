<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 9; $i++) {
            DB::table('acceso')->insert([
                'tipousuario_id' => 1,
                'opcionmenu_id' => $i,
            ]);
        }
    }
}
