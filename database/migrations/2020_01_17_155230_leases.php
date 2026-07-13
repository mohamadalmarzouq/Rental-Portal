<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Leases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lease_name', 255)->nullable();
            $table->integer('property_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->integer('lease_status_id')->unsigned();
            $table->string('payer_name', 255)->nullable();
            $table->string('frequency', 255)->nullable();
            $table->double('amount_payable')->nullable();
            $table->integer('payment_method_id')->unsigned();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('description',255)->nullable();
            $table->double('amount')->nullable();
            $table->integer('enable_email')->nullable();
            $table->integer('enable_sms')->nullable();
            $table->string('rental',255)->nullable();
            $table->integer('tenant_id')->unsigned();
            $table->integer('unit_id')->unsigned();
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
        Schema::dropIfExists('leases');
    }
}
