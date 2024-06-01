<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundTaxesListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_taxes_lists', function (Blueprint $table) {
            $table->id();
            $table->string('alias')->nullable();
            $table->text('title')->nullable();
            $table->string('type')->nullable();
            $table->text('appointment_payment')->nullable();
            $table->text('code_and_edrpoy')->nullable();
            $table->text('mfo')->nullable();
            $table->text('bank_account')->nullable();
            $table->text('name_recipient')->nullable();
            $table->text('okpo')->nullable();
            $table->integer('percent')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fund_taxes_lists');
    }
}
