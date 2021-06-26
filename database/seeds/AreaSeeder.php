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
            'descripcion' => 'Mesa de Partes', 
            'mesadepartes' => true         
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Alcaldía',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Asesoría Jurídica',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'SUB GERENCIA DE PLANIFICACION URBANA Y CATASTRO',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Sub Gerencia de Contabilidad',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Gerencia de Desarrollo Económico y Social',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Sub Gerencía de Fiscalización',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Gerencía Municipal',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Gerencía de Infraestructura y Desarrollo Urbano',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Imágen Institucional y Acceso a la Información Pública',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Cuenta integrada para el acceso como invitado al equipo o dominio',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Oficina de Licencias y Autorizaciones',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Oficina de Multas y Sanciones',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Sub Gerencía de obras Públicas',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Oficina de Control Institucional',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Oficina OMAPED',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Secretaria Técnica de Procedimiento Administrativo Disciplinario - STPAD',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Oficina de Participación Vecinal perteneciente a la Sub Gerencía de Programas Sociales y  Particpación Vecinal',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Unidad de Control Patrimonial',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Oficina de Planificación perteneciente a la Gerencía de Planificación y Presupuesto',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Gerencia de Planificación y Presupuesto',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Procuraduría Municipal',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Sub Gerencía de Programas Sociales',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Sub Gerencía de Recaudación y Control de Deuda',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Gerencía de Gestión de Recursos Humanos',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Oficina de Salubridad',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Oficina de Secretaría General',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Gerencía de Seguridad Ciudadana',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Sub Gerencía de Residuos Solidos',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Sub Gerencia de Tránsito, Transporte y Viabilidad',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Unidad Local de Empadronamiento - ULE',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Almacén General',
        ]);
        DB::table('area')->insert([
            'descripcion' => 'Centro de Defensa Cívil y Gestión de Riesgo',
        ]);
    }
}
