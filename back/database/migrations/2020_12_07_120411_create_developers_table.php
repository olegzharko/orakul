<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevelopersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('developers', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();

            $table->string('surname_n')->nullable();
            $table->string('name_n')->nullable();
            $table->string('patronymic_n')->nullable();

            $table->string('surname_r')->nullable();
            $table->string('name-r')->nullable();
            $table->string('patronymic_r')->nullable();

            $table->string('surname_d')->nullable();
            $table->string('name-d')->nullable();
            $table->string('patronymic_d')->nullable();

            $table->boolean('developer_spouses_id')->nullable();
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
        Schema::dropIfExists('developers');
    }
}
