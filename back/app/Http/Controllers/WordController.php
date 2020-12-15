<?php

namespace App\Http\Controllers;

use PhpOffice\PhpWord\TemplateProcessor;

class WordController extends RakulController
{
//    public $contract;

    public function __construct($contract = null)
    {
        parent::__construct();
        $this->contract = $contract;
    }

    public function read_contract_template()
    {
//        dd($this->contract);
        $filename = "Test_". time(). ".docx";
        $filename = "Test.docx";
        $file_path = $this->contract->template->document;
//        dd($this->contract);
        $word = new TemplateProcessor($file_path);

        // Тип договору
        $word->setValue('template-type', mb_strtolower($this->contract->template->type->title));

        // Дата підписання договору
        $word->setValue('date-day-r', $this->contract->str_day->title_r);
        $word->setValue('date-month-r', $this->contract->str_month->title_r);
        $word->setValue('date-year-r', $this->contract->str_year->title_r);

        // Забудовник
        $word->setValue('developer-surname', $this->contract->developer->surname);
        $word->setValue('developer-name', $this->contract->developer->name);
        $word->setValue('developer-patronymic', $this->contract->developer->patronymic);

        // Код забудовника
        $word->setValue('developer-tax-code', $this->contract->developer->tax_code);

        // Місце проживання забудовника
        $word->setValue('developer-full-address', $this->contract->developer->full_address);

        // Клієнт
        $word->setValue('client-surname', $this->contract->client->surname);
        $word->setValue('client-name', $this->contract->client->name);
        $word->setValue('client-patronymic', $this->contract->client->patronymic);

        // Код та паспорт клієнта
        $word->setValue('client-tax-code', $this->contract->client->tax_code);

//        $word->setValue('comma-client-passport-card-id', $this->full_string_with_passport_card_id($this->contract));

        $word->setValue('client-passport-type-des', $this->contract->client->passport_type->description);
        $word->setValue('client-passport-code', $this->contract->client->passport_demographic_code);

        // Місце проживання клієнта
        $word->setValue('client-full-address', $this->contract->client->full_address);

        // Об'єкт
        $word->setValue('imm-type-n', $this->contract->immovable->immovable_type->title_n);
        $word->setValue('imm-type-z', $this->contract->immovable->immovable_type->title_z);
        $word->setValue('imm-number', $this->contract->immovable->immovable_number);
        $word->setValue('imm-building-number', $this->contract->immovable->building_number);

        // адреса Об'єкта
        $word->setValue('imm-developer-add-type-r', $this->contract->immovable->developer_address->address_type->title_r);
        $word->setValue('imm-developer-address-title', $this->contract->immovable->developer_address->title);
        $word->setValue('imm-number', $this->contract->immovable->immovable_number);
        $word->setValue('imm-building-number', $this->contract->immovable->building_number);
        $word->setValue('imm-developer-address-title', $this->contract->immovable->developer_address->title);

        // Площа та тип нерухомості
        $word->setValue('imm-app-type-title', $this->contract->immovable->immovable_type->title);
        $word->setValue('imm-total-space', $this->contract->immovable->total_space);
        $word->setValue('imm-living-space', $this->contract->immovable->living_space);

        // Право власності на об'єкт
        $word->setValue('imm-own-gov-reg-num', $this->contract->immovable_ownership->gov_reg_number);
        $word->setValue('imm-own-gov-reg-date', $this->contract->immovable_ownership->gov_reg_date_format);
        $word->setValue('imm-own-dis-date', $this->contract->immovable_ownership->discharge_date_format);
        $word->setValue('imm-own-dis-num', $this->contract->immovable_ownership->discharge_number);
        $word->setValue('imm-reg-num', $this->contract->immovable->registration_number);

        // Оцінка
        $word->setValue('pvprice-date', $this->contract->pvprice->date_format);
        $word->setValue('pv-title', $this->contract->pvprice->property_valuation->title);
        $word->setValue('pv-certificate', $this->contract->pvprice->property_valuation->certificate);
        $word->setValue('pv-date', $this->contract->pvprice->property_valuation->date->format('d.m.Y'));
        $word->setValue('pvprice-grn', $this->contract->pvprice->grn);
        $word->setValue('pvprice-coin', $this->contract->pvprice->coin);

        // Ціна від забудовника
        $word->setValue('dev-price-grn', $this->contract->immovable->grn);
        $word->setValue('dev-price-coin', $this->contract->immovable->coin);


        $word->saveAs($filename);
    }

    public function convert_address($person)
    {

    }

//    public function full_string_with_passport_card_id($contract)
//    {
//        $desctiption = $this->contract->client->passport_type->description;
//        $passport_id = $this->contract->client->passport_demographic_code;
//
//        $result = ", $desctiption $passport_id";
//
//        return $result;
//    }
}
