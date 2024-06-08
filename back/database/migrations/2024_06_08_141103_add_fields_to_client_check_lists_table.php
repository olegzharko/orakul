<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToClientCheckListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_check_lists', function (Blueprint $table) {
            $table->integer('self_employed_person')->nullable()->after('unified_register_of_debtors');
            $table->integer('non_market_value')->nullable()->after('self_employed_person');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_check_lists', function (Blueprint $table) {
            //
        });
    }
}
