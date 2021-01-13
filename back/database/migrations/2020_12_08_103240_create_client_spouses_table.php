<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientSpousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_spouses', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->string('surname_n')->nullable();
            $table->string('name_n')->nullable();
            $table->string('patronymic_n')->nullable();
            $table->string('surname_r')->nullable();
            $table->string('name_r')->nullable();
            $table->string('patronymic_r')->nullable();
            $table->string('surname_o')->nullable();
            $table->string('name_o')->nullable();
            $table->string('patronymic_o')->nullable();
            $table->dateTime('birthday')->nullable();
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
            $table->integer('marriage_type_id')->nullable();
            $table->string('mar_series')->nullable();
            $table->string('mar_series_num')->nullable();
            $table->dateTime('mar_date')->nullable();
            $table->text('mar_depart')->nullable();
            $table->string('mar_reg_num')->nullable();


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
        Schema::dropIfExists('client_spouses');
    }
}
