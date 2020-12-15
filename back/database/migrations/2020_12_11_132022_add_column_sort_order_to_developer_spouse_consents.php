<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSortOrderToDeveloperSpouseConsents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('developer_spouse_consents', function (Blueprint $table) {
            $table->integer('sort_order')->nullable();
            $table->boolean('active')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('developer_spouse_consents', function (Blueprint $table) {
            //
        });
    }
}
