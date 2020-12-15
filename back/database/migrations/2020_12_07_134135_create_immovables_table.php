<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImmovablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('immovables', function (Blueprint $table) {
            $table->id();
            $table->integer('immovable_type_id')->nullable();
            $table->integer('work_address_id')->nullable();
            $table->integer('building_number')->nullable();
            $table->integer('immovable_number')->nullable();
            $table->float('developer_price')->nullable();
            $table->float('pv_price')->nullable();
            $table->integer('drrp_number')->nullable();
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
        Schema::dropIfExists('immovables');
    }
}
