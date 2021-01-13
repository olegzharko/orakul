<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notaries', function (Blueprint $table) {
            $table->id();
            $table->string('surname_n')->nullable();
            $table->string('name_n')->nullable();
            $table->string('short_name')->nullable();
            $table->string('patronymic_n')->nullable();
            $table->string('short_patronymic')->nullable();
            $table->string('surname_d')->nullable();
            $table->string('name_d')->nullable();
            $table->string('patronymic_d')->nullable();
            $table->string('surname_o')->nullable();
            $table->string('name_o')->nullable();
            $table->string('patronymic_o')->nullable();
            $table->text('activity_n')->nullable();
            $table->text('activity_d')->nullable();
            $table->text('activity_o')->nullable();
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
        Schema::dropIfExists('notaries');
    }
}
