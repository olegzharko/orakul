<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumericConvertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('numeric_converts', function (Blueprint $table) {
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
        Schema::dropIfExists('numeric_converts');
    }
}
