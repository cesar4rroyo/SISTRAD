<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacioncargoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacioncargo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero');
            $table->datetime('fecha_inspeccion');
            $table->datetime('fecha_notificacion');
            
            $table->string('nombre')->nullable();
            $table->string('nro_documento')->nullable();
            //PERSONA QUE REALIZA LA NOTIFICACION
            $table->string('p_nombre')->nullable();
            $table->string('p_nro_documento')->nullable();
            //DIRECCION INFRACTOR
            $table->string('calle')->nullable();
            $table->string('nro')->nullable();
            $table->string('sector')->nullable();
            $table->string('manzana')->nullable();
            $table->string('lote')->nullable();
            $table->string('urbanizacion')->nullable();
            $table->string('distrito')->nullable();
            //DIRECCION INFRACCION
            $table->string('i_calle')->nullable();
            $table->string('i_nro')->nullable();
            $table->string('i_sector')->nullable();
            $table->string('i_manzana')->nullable();
            $table->string('i_lote')->nullable();
            $table->string('i_urbanizacion')->nullable();
            $table->string('i_distrito')->nullable();

            //DETALLES INFRACCION
            $table->text('descripcion')->nullable();
            $table->integer('plazo')->default(6)->nullable();
            $table->double('i_monto' , 8 , 2)->nullable();

            $table->integer('actafiscalizacion_id')->unsigned()->nullable();
            $table->foreign('actafiscalizacion_id')->references('id')->on('actafiscalizacion')->onUpdate('restrict')->onDelete('restrict');
            
            $table->integer('infraccion_id')->unsigned()->nullable();
            $table->foreign('infraccion_id')->references('id')->on('infraccion')->onUpdate('restrict')->onDelete('restrict');
            


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
        Schema::dropIfExists('notificacioncargo');
    }
}
