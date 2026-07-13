<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Units extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number', 255)->nullable();
            $table->string('size', 255)->nullable();
            $table->string('type', 255)->nullable();
            $table->integer('property_id')->unsigned();
            $table->integer('no_of_bedrooms')->nullable();
            $table->integer('no_of_bathrooms')->nullable();
            $table->integer('unit_status_id')->nullable();
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
        Schema::dropIfExists('units');
    }
}
