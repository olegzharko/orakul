<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePowerOfAttorneyGeneralCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('power_of_attorney_general_cars', function (Blueprint $table) {
            $table->id(); // Первичный ключ
            $table->bigInteger('power_of_attorney_id')->unsigned(); // Внешний ключ на таблицу доверенностей
            $table->text('car_make')->nullable(); // Автомобильная марка
            $table->text('commercial_description')->nullable(); // Коммерческий опис
            $table->text('type')->nullable(); // Тип
            $table->text('special_notes')->nullable(); // Особые отметки
            $table->year('year_of_manufacture')->nullable(); // Год выпуска
            $table->text('vin_code')->nullable(); // VIN-код
            $table->text('registration_number')->nullable(); // Регистрационный номер
            $table->text('registered')->nullable(); // Зарегистрирован
            $table->date('registration_date')->nullable(); // Дата регистрации
            $table->text('registration_certificate')->nullable(); // Свидетельство о регистрации
            $table->timestamps(); // created_at и updated_at

            // Внешний ключ
            $table->foreign('power_of_attorney_id')
                  ->references('id')
                  ->on('power_of_attorneys')
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
        Schema::dropIfExists('power_of_attorney_general_cars');
    }
}
