<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevConsentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_consents', function (Blueprint $table) {
            $table->id();
            $table->integer('developer_id')->nullable();
            $table->integer('template_id')->nullable();
            $table->integer('contract_spouse_word_id')->nullable();
            $table->integer('notary_id')->nullable();
            $table->dateTime('reg_date')->nullable();
            $table->string('reg_num')->nullable();
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
        Schema::dropIfExists('dev_consents');
    }
}
