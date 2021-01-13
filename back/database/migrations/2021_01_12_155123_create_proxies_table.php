<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProxiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proxies', function (Blueprint $table) {
            $table->id();
            $table->integer('dev_company_id')->nullable();
            $table->string('title')->nullable();
            $table->string('number')->nullable();
            $table->dateTime('date')->nullable();
            $table->integer('notary_id')->nullable();
            $table->dateTime('reg_date')->nullable();
            $table->string('reg_num')->nullable();
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
        Schema::dropIfExists('proxies');
    }
}
