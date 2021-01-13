<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeveloperStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('developer_statements', function (Blueprint $table) {
            $table->id();
            $table->integer('notary_id')->nullable();
            $table->integer('developer_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->dateTime('date')->nullable();
            $table->unsignedInteger('statement_template_id')->nullable();
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
        Schema::dropIfExists('developer_statements');
    }
}
