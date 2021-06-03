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
            $table->string('estado');
            $table->string('ordenanza');
            $table->string('medidacorrectiva');
            $table->string('periodo');
            $table->string('descargo', 4000);
            $table->string('conclusion', 4000);
            $table->decimal('monto', 10,2);
            $table->integer('actafiscalizacion_id')->unsigned()->nullable();
            $table->foreign('actafiscalizacion_id')->references('id')->on('actafiscalizacion')->onUpdate('restrict')->onDelete('restrict');
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
