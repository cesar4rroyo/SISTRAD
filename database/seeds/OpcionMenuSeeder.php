<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpcionMenuSeeder extends Seeder
{
    
    public function run()
    {
        //start Grupo Personal
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Personal',
            'icono' => 'fas fa-user-alt',
            'link' => 'admin/persona',
            'orden' => 1,
            'grupomenu_id' => 2
        ]);
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Cargos',
            'icono' => 'fas fa-address-card',
            'link' => 'admin/cargo',
            'orden' => 3,
            'grupomenu_id' => 2
        ]);
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Area',
            'icono' => 'fas fa-warehouse',
            'link' => 'area',
            'orden' => 2,
            'grupomenu_id' => 2
        ]);
        //end Grupo Persona
        //start Grupo Usuarios
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Usuario',
            'link' => 'admin/usuario',
            'icono' => 'fas fa-user',
            'orden' => 1,
            'grupomenu_id' => 3
        ]);
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Roles',
            'link' => 'admin/rol',
            'icono' => 'fas fa-users-cog',
            'orden' => 2,
            'grupomenu_id' => 3
        ]);
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Rol Persona',
            'icono' => 'fas fa-user-plus',
            'link' => 'admin/rolpersona',
            'orden' => 3,
            'grupomenu_id' => 3
        ]);
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Tipos Usuario',
            'icono' => 'fas fa-users-slash',
            'link' => 'admin/tipousuario',
            'orden' => 4,
            'grupomenu_id' => 3
        ]);
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Accesos',
            'link' => 'admin/acceso',
            'icono' => 'fas fa-people-arrows',
            'orden' => 3,
            'grupomenu_id' => 3
        ]);
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Opciones de Menú',
            'icono' => 'fas fa-stream',
            'link' => 'admin/opcionmenu',
            'orden' => 6,
            'grupomenu_id' => 3
        ]);
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Grupos de Menú',
            'icono' => 'fas fa-list-ol',
            'link' => 'admin/grupomenu',
            'orden' => 7,
            'grupomenu_id' => 3
        ]);
        //end Grupo Usuarios

        //start Control        
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Trámite',
            'icono' => 'far fa-file-alt',
            'link' => 'tramite',
            'orden' => 2,
            'grupomenu_id' => 1
        ]);
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Motivo Rechazo',
            'icono' => 'fas fa-book-open',
            'link' => 'motivorechazo',
            'orden' => 3,
            'grupomenu_id' => 1
        ]);
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Motivo Courier',
            'icono' => 'fas fa-book-open',
            'link' => 'motivocourier',
            'orden' => 4,
            'grupomenu_id' => 1
        ]);     
        
        //end Control




    }
}
