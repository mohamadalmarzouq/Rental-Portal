<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Notifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identifier', 255)->nullable();
            $table->string('module', 255)->nullable();
            $table->integer('ref_id')->unsigned();
            $table->integer('receiver')->unsigned();
            $table->integer('sender')->unsigned();
            $table->string('replacers', 255)->nullable();
            $table->integer('read')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
