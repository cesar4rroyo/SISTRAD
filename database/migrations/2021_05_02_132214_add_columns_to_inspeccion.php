<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToInspeccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inspeccion', function (Blueprint $table) {
            $table->string('localidad')->nullable();
            $table->double('area' , 8 , 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inspeccion', function (Blueprint $table) {
            $table->dropColumn('localidad');
            $table->dropColumn('area');
        });
    }
}
