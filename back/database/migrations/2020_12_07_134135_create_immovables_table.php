<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImmovablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('immovables', function (Blueprint $table) {
            $table->id();
            $table->integer('immovable_type_id')->nullable();
            $table->integer('work_address_id')->nullable();
            $table->integer('building_number')->nullable();
            $table->integer('immovable_number')->nullable();
            $table->integer('developer_price')->nullable();
            $table->integer('pv_price')->nullable();
            $table->integer('gov_reg_imm_date')->nullable();
            $table->integer('gov_reg_imm_num')->nullable();
            $table->integer('discharge_imm_date')->nullable();
            $table->integer('discharge_imm_number')->nullable();
            $table->integer('discharge_responsible')->nullable();
            $table->integer('registration_number')->nullable();
            $table->integer('drrp_number')->nullable();
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
        Schema::dropIfExists('immovables');
    }
}
