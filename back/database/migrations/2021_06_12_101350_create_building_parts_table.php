<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_parts', function (Blueprint $table) {
            $table->id();
            $table->string('short')->nullable();
            $table->string('title_n')->nullable();
            $table->string('title_r')->nullable();
            $table->string('title_z')->nullable();
            $table->string('title_m')->nullable();
            $table->integer('sort_order')->nullable();
            $table->string('active')->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('building_parts');
    }
}
