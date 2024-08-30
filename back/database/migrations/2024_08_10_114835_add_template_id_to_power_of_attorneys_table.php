<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTemplateIdToPowerOfAttorneysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('power_of_attorneys', function (Blueprint $table) {
            // Добавляем поле template_id с default null
            $table->bigInteger('template_id')->unsigned()->nullable()->after('agent_id');

            // Создаем внешний ключ на таблицу power_of_attorney_templates
            $table->foreign('template_id')
                  ->references('id')
                  ->on('power_of_attorney_templates')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('power_of_attorneys', function (Blueprint $table) {
            // Удаляем внешний ключ и поле template_id
            $table->dropForeign(['template_id']);
            $table->dropColumn('template_id');
        });
    }
}
