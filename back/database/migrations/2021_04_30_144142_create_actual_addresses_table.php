<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActualAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actual_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->string('city_id')->nullable();
            $table->integer('address_type_id')->nullable();
            $table->string('address')->nullable();
            $table->string('building_type_id')->nullable();
            $table->string('building')->nullable();
            $table->string('apartment_type_id')->nullable();
            $table->string('apartment_num')->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actual_addresses');
    }
}
