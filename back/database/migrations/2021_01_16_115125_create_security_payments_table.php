<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecurityPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('security_payments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('sign_date')->nullable();
            $table->string('reg_num')->nullable();
            $table->integer('grn_dig')->nullable();
            $table->string('grn_str')->nullable();
            $table->string('grn_cent-str')->nullable();
            $table->integer('dollar_dig')->nullable();
            $table->string('dollar_str')->nullable();
            $table->string('dollar_cent-str')->nullable();
            $table->dateTime('final_date')->nullable();
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
        Schema::dropIfExists('security_payments');
    }
}
