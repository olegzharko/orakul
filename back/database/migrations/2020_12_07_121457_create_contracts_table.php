<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->integer('template_id')->nullable();
            $table->integer('immovable_id')->nullable();
            $table->dateTime('event_datetime')->nullable();
            $table->integer('developer_id')->nullable();
            $table->integer('assistant_id')->nullable();
            $table->integer('manager_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('notary_id')->nullable();
            $table->integer('reader_id')->nullable();
            $table->integer('delivery_id')->nullable();
            $table->integer('pvprice_id')->nullable();
            $table->dateTime('sign_date')->nullable();
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
        Schema::dropIfExists('contracts');
    }
}
