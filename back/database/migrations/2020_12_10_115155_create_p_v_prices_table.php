<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePVPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_v_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('immovable_id')->nullable();
            $table->integer('pv_id')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('price')->nullable();
            $table->text('price_grn_str')->nullable();
            $table->text('price_coin_str')->nullable();
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
        Schema::dropIfExists('p_v_prices');
    }
}
