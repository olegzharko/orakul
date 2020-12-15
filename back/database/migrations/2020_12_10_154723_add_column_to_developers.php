<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToDevelopers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('developers', function (Blueprint $table) {
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('developers', function (Blueprint $table) {
            //
        });
    }
}
