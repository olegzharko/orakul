<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->integer('card_id')->nullable();
            $table->integer('room_id')->nullable();
            $table->dateTime('arrival_time')->nullable();
            $table->dateTime('waiting_time')->nullable();
            $table->dateTime('total_time')->nullable();
            $table->integer('number_of_people')->nullable();
            $table->integer('children')->nullable();
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
        Schema::dropIfExists('deals');
    }
}
