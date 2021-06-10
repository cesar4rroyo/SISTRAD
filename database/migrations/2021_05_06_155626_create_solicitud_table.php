<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('fecha')->nullable();
            $table->decimal('area', 8,2)->nullable();
            $table->string('numero')->nullable();
            $table->string('tiposolicitud')->nullable();            
            $table->string('tipotramitesolicitud', 4000)->nullable();
            $table->string('nombresolicitante')->nullable();
            $table->string('dni')->nullable();
            $table->string('ruc')->nullable(); //renovacion o apertura
            $table->string('razonsocial')->nullable(); //definitivo o temporal
            $table->string('direccion')->nullable();
            $table->string('girocomercial')->nullable();
            $table->string('numerocasa')->nullable();
            $table->string('manzanacasa')->nullable();
            $table->string('lotecasa')->nullable();
            $table->string('urbanizacion')->nullable();
            $table->string('representantelegal')->nullable();
            $table->string('dnirepresentante')->nullable();
            $table->string('rucrepresentante')->nullable();
            $table->string('telefonorepresentante')->nullable();
            $table->string('telefonosolicitante')->nullable();
            $table->string('nombrenegocio')->nullable();
            $table->string('requisitos')->nullable();
            $table->string('publicidadexterior')->nullable();
            $table->string('colores')->nullable();
            $table->string('tipoanuncio')->nullable();
            $table->string('medidas')->nullable();
            $table->string('leyendas')->nullable();
            $table->string('materiales')->nullable();
            $table->integer('cantidadanuncios')->nullable();
            $table->string('nroexpediente')->nullable();
            $table->string('nrocertificado')->nullable();
            $table->string('nroresolucion')->nullable();
            $table->integer('tipo_id')->unsigned()->nullable();
            $table->foreign('tipo_id')->references('id')->on('tipotramitenodoc')->onUpdate('restrict')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitud');
    }
}
