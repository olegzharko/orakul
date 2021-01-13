<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevFencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_fences', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('developer_id')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('number')->nullable();
            $table->boolean('pass')->nullable();
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
        Schema::dropIfExists('dev_fences');
    }
}
