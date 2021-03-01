<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_time')->nullable();
            $table->integer('room_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('notary_id')->nullable();
            $table->integer('dev_company_id')->nullable();
            $table->integer('dev_representative_id')->nullable();
            $table->integer('dev_manager_id')->nullable();
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
        Schema::dropIfExists('calendars');
    }
}
