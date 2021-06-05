<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResolucionsancionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resolucionsancion', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fechaemision');
            $table->string('numero');
            $table->string('nroinstruccion')->nullable();
            $table->date('fechainstruccion')->nullable();
            $table->string('fojas')->nullable();
            $table->string('estado')->nullable();
            $table->string('ordenanza')->nullable();
            $table->string('medidacorrectiva')->nullable();
            $table->string('periodo')->nullable();
            $table->string('descargo', 4000)->nullable();
            $table->string('conclusion', 4000)->nullable();
            $table->string('domicilioprocesal', 4000)->nullable();
            $table->decimal('monto', 10,2)->nullable();
            $table->integer('actafiscalizacion_id')->unsigned()->nullable();
            $table->foreign('actafiscalizacion_id')->references('id')->on('actafiscalizacion')->onUpdate('restrict')->onDelete('restrict');
            $table->integer('notificacioncargo_id')->unsigned()->nullable();
            $table->foreign('notificacioncargo_id')->references('id')->on('notificacioncargo')->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('resolucionsancion');
    }
}
