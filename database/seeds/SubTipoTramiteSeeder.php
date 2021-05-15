<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubTipoTramiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //id=1
        DB::table('subtipotramitenodoc')->insert([
            'descripcion' => 'LICENCIAS DE FUNCIONAMIENTO',  
            'tipotramitenodoc_id'=>1,          
        ]);
        //id=2
        DB::table('subtipotramitenodoc')->insert([
            'descripcion' => 'AUTORIZACION DE ANUNCIOS PUBLICITARIOS',   
            'tipotramitenodoc_id'=>1,          
        ]);
        //id=3
        DB::table('subtipotramitenodoc')->insert([
            'descripcion' => 'AUTORIZACION PARA BODEGAS',   
            'tipotramitenodoc_id'=>1,          
        ]);
    }
}
