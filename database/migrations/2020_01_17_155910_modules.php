<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Modules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->string('route_name', 255)->nullable();
            $table->string('icon', 255)->nullable();
            $table->integer('parent')->nullable();
            $table->integer('permissions_enabled')->nullable();
            $table->string('permissions_table', 255)->nullable();
            $table->integer('sort')->nullable();
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
        Schema::dropIfExists('modules');
    }
}
