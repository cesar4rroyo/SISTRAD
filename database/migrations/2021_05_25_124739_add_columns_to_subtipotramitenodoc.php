<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSubtipotramitenodoc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subtipotramitenodoc', function (Blueprint $table) {
            $table->string('codigo')->nullable();
            $table->double('monto',8,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subtipotramitenodoc', function (Blueprint $table) {
            $table->dropColumn('codigo');
            $table->dropColumn('monto');
        });
    }
}
