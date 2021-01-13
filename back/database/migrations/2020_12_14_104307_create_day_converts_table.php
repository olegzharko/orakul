<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDayConvertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_converts', function (Blueprint $table) {
            $table->id();
            $table->string('original')->nullable();
            $table->string('title_n')->nullable();
            $table->string('title_r')->nullable();
            $table->string('title_z')->nullable();
            $table->string('title_m')->nullable();
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
        Schema::dropIfExists('day_converts');
    }
}
