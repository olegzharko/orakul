<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communals', function (Blueprint $table) {
            $table->id();
            $table->integer('contract_id')->nullable();
            $table->integer('template_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('notary_id')->nullable();
            $table->dateTime('sign_date')->nullable();
            $table->string('reg_num')->nullable();
            $table->integer('active')->nullable();
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
        Schema::dropIfExists('communals');
    }
}
