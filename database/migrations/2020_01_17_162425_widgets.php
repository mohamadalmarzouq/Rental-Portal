<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Widgets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widgets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 255)->nullable();
            $table->string('icon', 255)->nullable();
            $table->string('query', 500)->nullable();
            $table->integer('status_id')->unsigned();
            $table->string('sorting', 255)->nullable();
            $table->string('column', 255)->nullable();
            $table->string('module', 255)->nullable();
            $table->string('method', 255)->nullable();
            $table->integer('type_id')->unsigned();
            $table->string('class', 255)->nullable();
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
        Schema::dropIfExists('widgets');
    }
}
