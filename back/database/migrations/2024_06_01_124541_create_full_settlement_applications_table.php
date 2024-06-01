<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFullSettlementApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('full_settlement_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contract_id')->nullable()->comment('ID договора');
            $table->unsignedBigInteger('template_id')->nullable()->comment('ID шаблона');
            $table->unsignedBigInteger('notary_id')->nullable()->comment('ID нотариуса');
            $table->date('full_settlement_date')->comment('Дата до которой надо рассчитаться');
            $table->date('reg_date')->nullable()->comment('Дата подписания заявы');
            $table->integer('reg_number')->nullable()->comment('Регистрационный номер договора у нотариуса');
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);

            // Добавление внешних ключей
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('set null');
            $table->foreign('template_id')->references('id')->on('full_settlement_application_templates')->onDelete('set null');
            $table->foreign('notary_id')->references('id')->on('notaries')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('full_settlement_applications');
    }
}
