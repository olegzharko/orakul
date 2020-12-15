<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImmovableOwnershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('immovable_ownerships', function (Blueprint $table) {
            $table->id();
            $table->string('gov_reg_number')->nullable();
            $table->dateTime('gov_reg_date')->nullable();
            $table->string('discharge_number')->nullable();
            $table->dateTime('discharge_date')->nullable();
            $table->integer('discharge_responsible')->nullable();
            $table->string('registration_number')->nullable();
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
        Schema::dropIfExists('immovable_ownerships');
    }
}
