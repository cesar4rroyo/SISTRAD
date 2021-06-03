<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InfraccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('infraccion')->insert([
            'codigo' => '01.01.01', 
            'descripcion' => 'Abrir el establecimiento sin contar con la respectiva Licencia de Funcionamiento.', 
            'procedimiento' => 'Notificacion',      
            'tipo' => 'G',      
            'uit' => 0.50,      
            'medidacomplementaria' => 'Clausura temporal hasta que regularice la conducta infractora.',      
        ]);
        
        DB::table('infraccion')->insert([
            'codigo' => '01.01.02', 
            'descripcion' => 'Ampliar o modificar las
            características y/o condiciones
            señaladas en la Licencia de
            Funcionamiento. (Giro, áreas
            dentro y fuera del
            establecimiento, con material
            montable o desmontable, cambio
            de titular), o los parámetros
            descritos en la autorización.', 
            'procedimiento' => 'Notificacion',      
            'tipo' => 'M',      
            'uit' => 0.25,      
            'medidacomplementaria' => 'Clausura
            temporal hasta
            que regularice la
            conducta
            infractora /
            Clausura
            definitiva en caso
            a continuidad.
            ',      
        ]);
        
    }
}
