<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('units',function(Blueprint $table){
            $table->integer('no_of_livingrooms');
            $table->integer('unit_description');
            $table->string('no_of_kitchens');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('units',function(Blueprint $table) {
            $table->dropColumn('no_of_livingrooms');
            $table->dropColumn('unit_description');
            $table->dropColumn('no_of_kitchens');
        });

    }
}
