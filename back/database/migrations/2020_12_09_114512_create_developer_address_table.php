<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeveloperAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('developer_address', function (Blueprint $table) {
            $table->id();
            $table->integer('work_city_id')->nullable();
            $table->string('title')->nullable();
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
        Schema::dropIfExists('developer_address');
    }
}
