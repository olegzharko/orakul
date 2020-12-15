<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDeveloperCityIdToDeveloperCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('developer_address', function (Blueprint $table) {
            $table->dropColumn('work_city_id');
            $table->integer('developer_city_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('developer_address', function (Blueprint $table) {
            //
        });
    }
}
