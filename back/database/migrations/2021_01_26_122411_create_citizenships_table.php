<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitizenshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citizenships', function (Blueprint $table) {
            $table->id();
            $table->text('title_n')->nullable();
            $table->text('title_r')->nullable();
            $table->text('title_d')->nullable();
            $table->text('title_z')->nullable();
            $table->text('title_o')->nullable();
            $table->text('title_m')->nullable();
            $table->text('title_k')->nullable();
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
        Schema::dropIfExists('citizenships');
    }
}
