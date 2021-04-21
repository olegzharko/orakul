<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingRepresentativeProxiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_representative_proxies', function (Blueprint $table) {
            $table->id();
            $table->integer('building_id')->nullable();
            $table->integer('dev_representative_id')->nullable();
            $table->integer('proxy_id')->nullable();
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
        Schema::dropIfExists('building_representative_proxies');
    }
}
