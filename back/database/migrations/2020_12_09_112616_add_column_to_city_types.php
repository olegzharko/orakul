<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCityTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('city_types', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->string('short')->nullable();
            $table->string('full')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('city_types', function (Blueprint $table) {
            //
        });
    }
}
