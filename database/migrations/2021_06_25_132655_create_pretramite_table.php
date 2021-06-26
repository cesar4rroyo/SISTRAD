<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePretramiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pretramite', function (Blueprint $table) {
            $table->increments('id');
            $table->text('numero')->nullable();
            $table->text('asunto')->nullable();
            $table->string('dni')->nullable();
            $table->string('remitente')->nullable();
            $table->string('correo')->nullable();
            $table->string('telefono')->nullable();
            $table->text('comentario')->nullable();
            $table->text('motivo_rechazo')->nullable();
            $table->text('motivo_aceptado')->nullable();
            $table->string('estado')->nullable()->default('PENDIENTE'); //PENDIENTE , ACEPTADO , RECHAZADO , CREADO
            $table->datetime('fecha_aceptado')->nullable();
            $table->datetime('fecha_rechazado')->nullable();
            $table->datetime('fecha_creado')->nullable();
            $table->integer('tramite_id')->unsigned()->nullable();
            $table->foreign('tramite_id')->references('id')->on('tramite')->onUpdate('restrict')->onDelete('restrict');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pretramite');
    }
}
