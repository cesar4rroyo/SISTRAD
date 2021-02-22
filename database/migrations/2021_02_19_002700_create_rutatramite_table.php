<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRutatramiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rutatramite', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plazo');
            $table->integer('tramite_id')->unsigned();
            $table->integer('areainicial_id')->unsigned();
            $table->integer('areafinal_id')->unsigned();
            $table->foreign('tramite_id')->references('id')->on('tramite')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('areainicial_id')->references('id')->on('area')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('areafinal_id')->references('id')->on('area')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('rutatramite');
    }
}
