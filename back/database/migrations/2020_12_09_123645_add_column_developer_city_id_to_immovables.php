<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDeveloperCityIdToImmovables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('immovables', function (Blueprint $table) {
            $table->dropColumn('work_address_id');
            $table->integer('developer_address_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('immovables', function (Blueprint $table) {
            //
        });
    }
}
