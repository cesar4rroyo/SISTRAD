<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspeccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspeccion', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha');
            $table->string('tipo')->nullable();
            $table->string('numero')->nullable();
            $table->string('observacion')->nullable();
            $table->string('situacion')->nullable();
            $table->string('archivo')->nullable();

            $table->integer('ordenpago_id')->unsigned()->nullable();
            $table->foreign('ordenpago_id')->references('id')->on('ordenpago')->onDelete('restrict')->onUpdate('restrict')->nullable();
            
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
        Schema::dropIfExists('inspeccion');
    }
}
