<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->integer('spouse_consent')->nullable();
            $table->integer('current_place_of_residence')->nullable();
            $table->integer('photo_in_the_passport')->nullable();
            $table->integer('immigrant_help')->nullable();
            $table->integer('passport')->nullable();
            $table->integer('tax_code')->nullable();
            $table->integer('evaluation_in_the_fund')->nullable();
            $table->integer('check_fop')->nullable();
            $table->integer('document_scans')->nullable();
            $table->integer('unified_register_of_court_decisions')->nullable();
            $table->integer('sanctions')->nullable();
            $table->integer('financial_monitoring')->nullable();
            $table->integer('unified_register_of_debtors')->nullable();
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
        Schema::dropIfExists('check_lists');
    }
}
