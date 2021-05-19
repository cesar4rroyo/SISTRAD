<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResolucionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resolucion', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fechaexpedicion');
            $table->dateTime('fechavencimiento')->nullable();
            $table->dateTime('fechaentrega')->nullable();
            $table->string('numero' , 30)->nullable();
            $table->string('contribuyente' , 200)->nullable();
            $table->string('direccion' , 100)->nullable();
            $table->string('localidad' , 100)->nullable();
            $table->string('zona' , 100)->nullable();
            $table->string('categoria' , 100)->nullable();
            $table->string('girocomercial' , 100)->nullable();
            $table->string('razonsocial' , 200)->nullable();
            $table->string('dni' , 20)->nullable();
            $table->string('ruc' , 20)->nullable();
            $table->string('observaciones' , 300)->nullable();
            $table->string('claseanuncio' , 300)->nullable();
            $table->string('ubicacionanuncio' , 300)->nullable();
            $table->string('estado' , 300)->nullable();
            $table->string('tipopersona' , 300)->nullable();
            $table->string('vigencia' , 300)->nullable();
            $table->string('leyenda' , 300)->nullable();
            $table->integer('inspeccion_id')->unsigned()->nullable();
            $table->integer('ordenpago_id')->unsigned()->nullable();
            $table->foreign('inspeccion_id')->references('id')->on('inspeccion')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('ordenpago_id')->references('id')->on('ordenpago')->onDelete('restrict')->onUpdate('restrict');
            $table->integer('tipo_id')->unsigned()->nullable();
            $table->foreign('tipo_id')->references('id')->on('tipotramitenodoc')->onUpdate('restrict')->onDelete('restrict');
            $table->integer('subtipo_id')->unsigned()->nullable();
            $table->foreign('subtipo_id')->references('id')->on('subtipotramitenodoc')->onUpdate('restrict')->onDelete('restrict');
            $table->integer('tramiteref_id')->unsigned()->nullable();
            $table->foreign('tramiteref_id')->references('id')->on('tramite')->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('resolucion');
    }
}
