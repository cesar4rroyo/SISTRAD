<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfraccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infraccion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('procedimiento')->nullable();
            $table->string('tipo')->nullable();
            $table->text('medidacomplementaria')->nullable();
            $table->double('uit' , 8 ,2)->nullable();
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
        Schema::dropIfExists('infraccion');
    }
}
