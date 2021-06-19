<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePadronfiscalizacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('padronfiscalizacion', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->string('vigencia1');
            $table->string('vigencia2');
            $table->string('vigencia3');
            $table->string('vigencia4');
            $table->string('vigencia5');
            $table->string('fiscalizador')->nullable();
            $table->string('numero')->nullable();
            $table->string('razonsocial')->nullable();
            $table->string('rubro')->nullable();
            $table->string('representantelegal')->nullable();
            $table->string('ruc')->nullable();
            $table->string('tipopersona')->nullable();
            $table->string('direccion')->nullable();
            $table->string('urbanizacion')->nullable();
            $table->string('sector')->nullable();
            $table->string('archivo')->nullable();
            $table->string('manzana')->nullable();
            $table->string('lote')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->string('tamano')->nullable();
            $table->string('condicion')->nullable();
            $table->string('formalizacion')->nullable();
            $table->string('vigencia')->nullable();
            $table->string('tamanoanuncio')->nullable();
            $table->string('tipoanuncio')->nullable();
            $table->string('alpropietario')->nullable();
            $table->text('observaciones', 4000)->nullable();
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
        Schema::dropIfExists('padronfiscalizacion');
    }
}
