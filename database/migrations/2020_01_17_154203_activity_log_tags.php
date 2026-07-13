<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivityLogTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_log_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identifier', 255)->nullable();
            $table->string('body', 255)->nullable();
            $table->string('title', 100)->nullable();
            $table->string('wildcards', 255)->nullable();
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
        Schema::dropIfExists('activity_log_tags');
    }
}
