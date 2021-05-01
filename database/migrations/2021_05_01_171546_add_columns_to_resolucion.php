<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToResolucion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resolucion', function (Blueprint $table) {
            $table->string('proyecto')->nullable();
            $table->string('uso')->nullable();
            $table->string('altura')->nullable();
            $table->string('responsableobra')->nullable();
            $table->double('area' , 8 , 2)->nullable();
            $table->double('valor' , 8 , 2)->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resolucion', function (Blueprint $table) {
            $table->dropColumn('proyecto');
            $table->dropColumn('uso');
            $table->dropColumn('altura');
            $table->dropColumn('responsableobra');
            $table->dropColumn('valor');
            $table->dropColumn('area');
        });
    }
}
