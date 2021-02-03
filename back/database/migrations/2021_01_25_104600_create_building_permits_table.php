<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingPermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_permits', function (Blueprint $table) {
            $table->id();
            $table->integer('immovable_id')->nullable();
            $table->string('resolution')->nullable();
            $table->dateTime('sign_date')->nullable();
            $table->text('organization')->nullable();
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
        Schema::dropIfExists('building_permits');
    }
}
