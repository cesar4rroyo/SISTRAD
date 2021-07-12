<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallenotificacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallenotificacion', function (Blueprint $table) {
            $table->increments('id');
            $table->double('uit' , 8 ,2)->nullable();
            $table->double('porcentaje' , 8 ,2)->nullable();
            $table->integer('notificacion_id')->unsigned()->nullable();
            $table->foreign('notificacion_id')->references('id')->on('notificacioncargo')->onDelete('restrict')->onUpdate('restrict');
            $table->integer('infraccion_id')->unsigned()->nullable();
            $table->foreign('infraccion_id')->references('id')->on('infraccion')->onDelete('restrict')->onUpdate('restrict');
            
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
        Schema::dropIfExists('detallenotificacion');
    }
}
