<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('surname')->nullable();
            $table->string('name')->nullable();
            $table->string('patronymic')->nullable();
            $table->integer('male')->nullable();
            $table->integer('married')->nullable();
            $table->string('maiden_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('tax_code')->nullable();
            $table->integer('passport_type_id')->nullable();
            $table->string('passport_code')->nullable();
            $table->dateTime('passport_date')->nullable();
            $table->string('passport_department')->nullable();
            $table->string('passport_demographic_code')->nullable();
            $table->integer('region_id')->nullable();
            $table->integer('city_type_id')->nullable();
            $table->string('city')->nullable();
            $table->integer('address_type_id')->nullable();
            $table->string('address')->nullable();
            $table->string('building')->nullable();
            $table->string('apartment')->nullable();
            $table->integer('sort_order')->nullable();
            $table->boolean('active')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
