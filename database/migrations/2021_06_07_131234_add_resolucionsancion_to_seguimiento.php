<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResolucionsancionToSeguimiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seguimiento', function (Blueprint $table) {
            $table->integer('resolucionsancion_id')->unsigned()->nullable();
            $table->foreign('resolucionsancion_id')->references('id')->on('resolucionsancion')->onUpdate('restrict')->onDelete('restrict')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seguimiento', function (Blueprint $table) {
            //
        });
    }
}
