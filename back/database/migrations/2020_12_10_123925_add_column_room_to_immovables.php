<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnRoomToImmovables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('immovables', function (Blueprint $table) {
            $table->integer('appartment_type_id')->nullable();
            $table->string('total_space')->nullable();
            $table->string('living_spave')->nullable();
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
