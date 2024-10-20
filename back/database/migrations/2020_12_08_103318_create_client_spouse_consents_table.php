<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientSpouseConsentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_spouse_consents', function (Blueprint $table) {
            $table->id();
            $table->integer('notary_id')->nullable();
            $table->integer('client_spouse_id')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('reg_num')->nullable();
            $table->unsignedInteger('consents_template_id')->nullable();
            $table->boolean('acitve')->nullable();
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
        Schema::dropIfExists('client_spouse_consents');
    }
}
