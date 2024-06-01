<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFullSettlementApplicationTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('full_settlement_application_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('название шаблона');
            $table->unsignedBigInteger('dev_company_id')->nullable()->comment('ID компании-разработчика');
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);

            // Добавление внешнего ключа
            $table->foreign('dev_company_id')->references('id')->on('dev_companies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('full_settlement_application_templates');
    }
}
