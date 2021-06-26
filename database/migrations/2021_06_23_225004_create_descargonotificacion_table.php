<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescargonotificacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descargonotificacion', function (Blueprint $table) {
            $table->increments('id');
            $table->text('descripcion')->nullable();
            $table->string('archivo')->nullable();
            $table->integer('notificacion_id')->unsigned()->nullable();
            $table->foreign('notificacion_id')->references('id')->on('notificacioncargo')->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('descargonotificacion');
    }
}
