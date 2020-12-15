<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsFromImmovables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('immovables', function (Blueprint $table) {
            $table->dropColumn('gov_reg_imm_number');
            $table->dropColumn('gov_reg_imm_date');
            $table->dropColumn('discharge_imm_number');
            $table->dropColumn('discharge_imm_date');
            $table->dropColumn('discharge_responsible');
            $table->dropColumn('registration_number');
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
