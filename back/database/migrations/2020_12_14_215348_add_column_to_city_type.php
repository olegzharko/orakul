<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCityType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('city_types', function (Blueprint $table) {
            $table->dropColumn('full');
            $table->string('title_n');
            $table->string('title_r');
            $table->string('title_z');
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
