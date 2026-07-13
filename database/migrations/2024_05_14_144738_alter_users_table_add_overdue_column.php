<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableAddOverdueColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('over_due_date')->after('due_date')->nullable();
            $table->string('logo')->after('over_due_date')->nullable();
            $table->string('company_name')->after('logo')->nullable();
            $table->string('company_address')->after('company_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('over_due_date');
            $table->dropColumn('logo');
            $table->dropColumn('company_name');
            $table->dropColumn('company_address');
        });
    }
}
