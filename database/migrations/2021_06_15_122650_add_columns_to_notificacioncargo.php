<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToNotificacioncargo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notificacioncargo', function (Blueprint $table) {
            $table->string('estado')->default('PENDIENTE')->nullable(); // PENDIENTE; CON DESCARGO, RESOLUCION; ARCHIVADO
            $table->text('descargo')->nullable();
            $table->string('nro_ordenanza')->nullable();
            $table->datetime('fecha_descargo')->nullable();
            $table->datetime('fecha_resolucion')->nullable();
            $table->datetime('fecha_archivado')->nullable();
            $table->double('total',8,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notificacioncargo', function (Blueprint $table) {
            $table->dropColumn('estado');
            $table->dropColumn('nro_ordenanza');
            $table->dropColumn('descargo');
            $table->dropColumn('fecha_descargo');
            $table->dropColumn('fecha_resolucion');
            $table->dropColumn('fecha_archivado');
            $table->dropColumn('total');
        });
    }
}
