<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuario')->insert([
            'login' => 'admin',
            'password' => bcrypt('123456'),
            'tipousuario_id' => 1,
            'personal_id'=>1,
        ]);
        DB::table('usuario')->insert([
            'login' => 'mesapartes',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>1,
            'personal_id'=>2
        ]);
        DB::table('usuario')->insert([
            'login' => 'area1',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>3
        ]);
        DB::table('usuario')->insert([
            'login' => 'area2',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>4
        ]);
        DB::table('usuario')->insert([
            'login' => 'area3',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>5
        ]);
        DB::table('usuario')->insert([
            'login' => 'area4',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>6
        ]);
        DB::table('usuario')->insert([
            'login' => 'area5',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>7
        ]);
        DB::table('usuario')->insert([
            'login' => 'area6',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>8
        ]);
        DB::table('usuario')->insert([
            'login' => 'uGMunicipal',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>9
        ]);
        DB::table('usuario')->insert([
            'login' => 'uGInfraestructura',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>10
        ]);
        DB::table('usuario')->insert([
            'login' => 'uImagen',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>11
        ]);
        DB::table('usuario')->insert([
            'login' => 'uCuenta',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>12
        ]);
        DB::table('usuario')->insert([
            'login' => 'uLicencias',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>13
        ]);
        DB::table('usuario')->insert([
            'login' => 'uMultas',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>14
        ]);
        DB::table('usuario')->insert([
            'login' => 'uObras',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>15
        ]);
        DB::table('usuario')->insert([
            'login' => 'uControl',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>16
        ]);
        DB::table('usuario')->insert([
            'login' => 'uOMAPED',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>17
        ]);
        DB::table('usuario')->insert([
            'login' => 'uSecretaria',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>18
        ]);
        DB::table('usuario')->insert([
            'login' => 'uParticipacion',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>19
        ]);
        DB::table('usuario')->insert([
            'login' => 'uUnidad',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>20
        ]);
        DB::table('usuario')->insert([
            'login' => 'uOPlanificacion',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>21
        ]);
        DB::table('usuario')->insert([
            'login' => 'uGPlanificacionPresupuesto',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>22
        ]);
        DB::table('usuario')->insert([
            'login' => 'uProcuraduria',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>23
        ]);
        DB::table('usuario')->insert([
            'login' => 'uSGProgamas',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>24
        ]);
        DB::table('usuario')->insert([
            'login' => 'uSGRecaudacion',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>25
        ]);
        DB::table('usuario')->insert([
            'login' => 'uGRRHH',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>26
        ]);
        DB::table('usuario')->insert([
            'login' => 'uSalubridad',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>27
        ]);
        DB::table('usuario')->insert([
            'login' => 'uSecretariaGeneral',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>28
        ]);
        DB::table('usuario')->insert([
            'login' => 'uGSeguridad',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>29
        ]);
        DB::table('usuario')->insert([
            'login' => 'uSGResiduos',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>30
        ]);
        DB::table('usuario')->insert([
            'login' => 'uSGTransito',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>31
        ]);
        DB::table('usuario')->insert([
            'login' => 'uUEmpradronamiento',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>32
        ]);
        DB::table('usuario')->insert([
            'login' => 'uAlmacen',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>33
        ]);
        DB::table('usuario')->insert([
            'login' => 'uDefensaCivil',
            'password' => bcrypt('123456'),
            'tipousuario_id'=>3,
            'personal_id'=>34
        ]);
    }
}
