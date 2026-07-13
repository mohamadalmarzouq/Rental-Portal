<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterInvoiceExtrasTableAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_extras', function (Blueprint $table) {
            $table->bigInteger('property_id')->after('id')->nullable();
            $table->bigInteger('unit_id')->after('id')->nullable();
            $table->bigInteger('lease_id')->after('id')->nullable();
            $table->bigInteger('tenant_id')->after('id')->nullable();
            $table->double('waive_amount')->after('amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_extras', function (Blueprint $table) {
            //
        });
    }
}
