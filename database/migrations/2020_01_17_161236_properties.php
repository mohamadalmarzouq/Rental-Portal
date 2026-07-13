<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Properties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->nullable();
            $table->string('location', 255)->nullable();
            $table->string('contact', 255)->nullable();
            $table->string('region', 255)->nullable();
            $table->string('bank', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->double('paid_amount')->nullable();
            $table->integer('payment_method_id')->unsigned();
            $table->integer('property_status_id')->unsigned();
            $table->integer('paci_id')->nullable();
            $table->integer('type_id')->unsigned();
            $table->integer('land_lord_id')->unsigned();
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
        Schema::dropIfExists('properties');
    }
}
