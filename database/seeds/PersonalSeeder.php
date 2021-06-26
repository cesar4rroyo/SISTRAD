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
        // DB::table('personal')->insert([
        //     'nombres' => 'Santiago Ronald',
        //     'apellidopaterno' => 'Rodas',
        //     'apellidomaterno' => 'Ipanaque',
        //     'dni' => '45841576',
        //     'telefono' => '974866028',
        //     'area_id'=>4,
        //     'cargo_id'=>1
        // ]);
        // DB::table('personal')->insert([
        //     'nombres' => 'Richard',
        //     'apellidopaterno' => 'Serrano',
        //     'apellidomaterno' => 'Bautista',
        //     'dni' => '75020436',
        //     'telefono' => '986783159',
        //     'area_id'=>3,
        //     'cargo_id'=>1

        // ]);
        // DB::table('personal')->insert([
        //     'nombres' => 'Juan Eduardo',
        //     'apellidopaterno' => 'Bazan',
        //     'apellidomaterno' => 'Guerrero',
        //     'dni' => '45841576',
        //     'telefono' => '932827302',
        //     'area_id'=>2,
        //     'cargo_id'=>1
        // ]);
        // DB::table('personal')->insert([
        //     'nombres' => 'César',
        //     'apellidopaterno' => 'Arroyo',
        //     'apellidomaterno' => 'Torres',
        //     'dni' => '71482136',
        //     'telefono' => '924734626',
        //     'area_id'=>1,
        //     'cargo_id'=>1
        // ]);

        
        DB::table('personal')->insert([
            'nombres' => 'Admin',
            'apellidopaterno' => 'Admin',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>1,
            'cargo_id'=>1
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pMesaPartes',
            'apellidopaterno' => 'pMesaPartes',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>1,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pAlcaldia',
            'apellidopaterno' => 'pAlcaldia',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>2,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pAsesoria',
            'apellidopaterno' => 'pAsesoria',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>3,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pPlanificacion',
            'apellidopaterno' => 'pPlanificacion',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>4,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pContabilidad',
            'apellidopaterno' => 'pContabilidad',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>5,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pDesarrollo',
            'apellidopaterno' => 'pDesarrollo',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>6,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pFiscalizacion',
            'apellidopaterno' => 'pFiscalizacion',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>7,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pGMunicipal',
            'apellidopaterno' => 'pGMunicipal',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>8,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pGInfraestructura',
            'apellidopaterno' => 'pGInfraestructura',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>9,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pImagen',
            'apellidopaterno' => 'pImagen',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>10,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pCuenta',
            'apellidopaterno' => 'pCuenta',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>11,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pLicencias',
            'apellidopaterno' => 'pLicencias',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>12,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pMultas',
            'apellidopaterno' => 'pMultas',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>13,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pObras',
            'apellidopaterno' => 'pObras',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>14,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pControl',
            'apellidopaterno' => 'pControl',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>15,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pOMAPED',
            'apellidopaterno' => 'pOMAPED',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>16,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pSecretaria',
            'apellidopaterno' => 'pSecretaria',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>17,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pParticipacion',
            'apellidopaterno' => 'pParticipacion',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>18,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pUnidad',
            'apellidopaterno' => 'pUnidad',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>19,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pOPlanificacion',
            'apellidopaterno' => 'pOPlanificacion',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>20,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pGPlanificacionPresupuesto',
            'apellidopaterno' => 'pGPlanificacionPresupuesto',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>21,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pProcuraduria',
            'apellidopaterno' => 'pProcuraduria',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>22,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pSGProgamas',
            'apellidopaterno' => 'pSGProgamas',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>23,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pSGRecaudacion',
            'apellidopaterno' => 'pSGRecaudacion',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>24,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pGRRHH',
            'apellidopaterno' => 'pGRRHH',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>25,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pSalubridad',
            'apellidopaterno' => 'pSalubridad',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>26,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pSecretariaGeneral',
            'apellidopaterno' => 'pSecretariaGeneral',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>27,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pGSeguridad',
            'apellidopaterno' => 'pGSeguridad',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>28,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pSGResiduos',
            'apellidopaterno' => 'pSGResiduos',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>29,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pSGTransito',
            'apellidopaterno' => 'pSGTransito',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>30,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pUEmpradronamiento',
            'apellidopaterno' => 'pUEmpradronamiento',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>31,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pAlmacen',
            'apellidopaterno' => 'pAlmacen',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>32,
            'cargo_id'=>2
        ]);
        DB::table('personal')->insert([
            'nombres' => 'pDefensaCivil',
            'apellidopaterno' => 'pDefensaCivil',
            'apellidomaterno' => '',
            'dni' => '11111111',
            'telefono' => '999999999',
            'area_id'=>33,
            'cargo_id'=>2
        ]);
        
        
    }
}
