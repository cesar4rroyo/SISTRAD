<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActafiscalizacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actafiscalizacion', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha');
            $table->string('numero');
            $table->dateTime('fechafin')->nullable();
            $table->string('ordenanza')->nullable();
            $table->string('subgerencia')->nullable();
            $table->string('fiscalizador')->nullable();
            $table->string('dnifiscalizador')->nullable();
            $table->string('participante')->nullable();
            $table->string('condicionparticipante')->nullable();
            $table->string('direccion')->nullable();
            $table->string('razonsocial')->nullable();
            $table->string('girocomercial')->nullable();
            $table->string('ruc')->nullable();
            $table->string('representante')->nullable();
            $table->string('dnirepresentante')->nullable();
            $table->string('calidadrepresentante')->nullable();
            $table->string('ocurrencia', 4000)->nullable();
            $table->string('observaciones', 4000)->nullable();
            $table->string('conclusiones', 400)->nullable();
            $table->string('imagen', 400)->nullable();
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
        Schema::dropIfExists('actafiscalizacion');
    }
}
