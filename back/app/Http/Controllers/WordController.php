<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\CityType;
use App\Models\GlobalText;
use App\Models\NumericConvert;
use App\Models\KeyWord;
use App\Models\SpouseWord;
use PhpOffice\PhpWord\TemplateProcessor;
use URL;

class WordController extends GeneratorController
{
    public $contract;
    public $consent;
    public $file_type;

    public function __construct()
    {
        parent::__construct();

        $this->contract = null;
        $this->consent = null;
        $this->file_type = ".docx";
    }

    public function contract_template_set_data($contract)
    {
        $filename = "Договір" . $this->file_type;

        $this->contract = $contract;

        $file_path = $this->set_contract_template_part($filename);

        $word = new TemplateProcessor($file_path);
        $word = $this->set_data_word($word);
        $word->saveAs($filename);

        unset($word);
    }

    public function consent_template_set_data($contract)
    {
        $filename = "Згода_подружжя" . $this->file_type;

        $this->contract = $contract;

        $file_path = $this->set_consent_template_part($filename);

        $word = new TemplateProcessor($file_path);
        $word = $this->set_data_word($word);
        $word->saveAs($filename);

        unset($word);
    }

    public function developer_statement_template_set_data($contract)
    {
        $filename = "Запит" . $this->file_type;

        $this->contract = $contract;

        $file_path = $this->set_statement_template_part($filename);

        $word = new TemplateProcessor($file_path);
        $word = $this->set_data_word($word);
        $word->saveAs($filename);

        unset($word);
    }

    public function questionnaire_template_set_data($contract)
    {
        $filename = "Анкета" . $this->file_type;

        $this->contract = $contract;

        $this->set_template_part($filename);

        $file_path = URL::to('/') . "/" . $filename;
        $word = new TemplateProcessor($file_path);
        $word = $this->set_data_word($word);
        $word->saveAs($filename);

        unset($word);
    }

    public function get_file_path($model)
    {
        if ($file = $model->getMedia('path')->first()) {
//            $template->document = str_replace(URL::to('/'), '', $file->getUrl());
            $model->document_path = $file->getUrl();
        } else {
            $model->document_path = null;
        }

        return $model->document_path;
    }

    private function mb_ucfirst($string)
    {
        if ($string) {
            $string = explode(" ", $string);
            $string[0] = mb_convert_case($string[0], MB_CASE_TITLE, 'UTF-8');
            $string = implode(" ", $string);
        }

        return $string;
    }

    public function set_data_word($word)
    {
        // Договір - тип
        $word->setValue('template-type', mb_strtolower($this->contract->template->template_type->title));

        $word->setValue('con-city-type-n', $this->contract->event_city->city_type->title_n);
        $word->setValue('con-city-type-r', $this->contract->event_city->city_type->title_r);
        $word->setValue('con-city-title-n', $this->contract->event_city->title_n);
        $word->setValue('con-dis-title-n', $this->contract->event_city->district->title_n);
        $word->setValue('con-dis-title-r', $this->contract->event_city->district->title_r);
        $word->setValue('con-reg-title-n', $this->contract->event_city->region->title_n);
        $word->setValue('con-reg-title-r', $this->contract->event_city->region->title_r);

        // Договір - дата підписання договору словами
        $word->setValue('con-d-r', $this->contract->str_day->title_r);
        $word->setValue('con-m-r', $this->contract->str_month->title_r);
        $word->setValue('con-y-r', $this->contract->str_year->title_r);

        // Забудовник
        $word->setValue('dev-surname-n', $this->contract->dev_company->owner->surname_n);
        $word->setValue('dev-name-n', $this->contract->dev_company->owner->name_n);
        $word->setValue('dev-patr-n', $this->contract->dev_company->owner->patronymic_n);
        $word->setValue('dev-surname-r', $this->contract->dev_company->owner->surname_r);
        $word->setValue('dev-name-r', $this->contract->dev_company->owner->name_r);
        $word->setValue('dev-patr-r', $this->contract->dev_company->owner->patronymic_r);
        $word->setValue('dev-birthday', $this->contract->dev_company->owner->birthday->format('d.m.y'));

        // Забудовник - код
        $word->setValue('dev-tax-code', $this->contract->dev_company->owner->tax_code);
        $word->setValue('dev-psssprt-code', $this->contract->dev_company->owner->passport_code);

        // Забудовник - місце проживання
        $word->setValue('dev-f-addr', $this->contract->dev_company->owner->full_address);

        // Клієнт
        $word->setValue('cl-surname-n', $this->contract->client->surname_n);
        $word->setValue('cl-name-n', $this->contract->client->name_n);
        $word->setValue('cl-patr-n', $this->contract->client->patronymic_n);
        $word->setValue('cl-surname-r', $this->contract->client->surname_r);
        $word->setValue('cl-name-r', $this->contract->client->name_r);
        $word->setValue('cl-patr-r', $this->contract->client->patronymic_r);
        $word->setValue('cl-birthday', $this->contract->client->birthday->format('d.m.y'));

        // Клієнт - код
        $word->setValue('cl-tax-code', $this->contract->client->tax_code);

        // Клієнт - паспорт
        $word->setValue('cl-pssprt-type-des', $this->contract->client->passport_type->short_info);
        $word->setValue('cl-pssprt-code', $this->contract->client->passport_demographic_code);

        //  Клієнт - місце проживання
        $word->setValue('cl-f-addr', $this->contract->client->full_address);

        // Об'єкт
        $word->setValue('imm-type-n', $this->contract->immovable->immovable_type->title_n);
        $word->setValue('imm-type-z', $this->contract->immovable->immovable_type->title_z);
        $word->setValue('imm-type-r', $this->contract->immovable->immovable_type->title_r);

        // Об'єкт - адреса
        $word->setValue('imm-num', $this->contract->immovable->immovable_number);
        $word->setValue('imm-num-str', $this->contract->immovable->immovable_number_string);
        $word->setValue('imm-build-num', $this->contract->immovable->building_number);
        $word->setValue('imm-build-num-str', $this->contract->immovable->building_number_string);
        $word->setValue('imm-dev-addr-type-n', $this->contract->immovable->developer_address->address_type->title_n);
        $word->setValue('imm-dev-addr-type-r', $this->contract->immovable->developer_address->address_type->title_r);
        $word->setValue('imm-dev-addr-title', $this->contract->immovable->developer_address->title);
        $word->setValue('imm-dev-city-type-n', $this->contract->immovable->developer_address->developer_city->city_type->title_n);
        $word->setValue('imm-dev-city-type-r', $this->contract->immovable->developer_address->developer_city->city_type->title_r);
        $word->setValue('imm-dev-city-title-n', $this->contract->immovable->developer_address->developer_city->title_n);
        $word->setValue('imm-dev-dis-title-n', $this->contract->immovable->developer_address->developer_city->district->title_n);
        $word->setValue('imm-dev-dis-title-r', $this->contract->immovable->developer_address->developer_city->district->title_r);
        $word->setValue('imm-dev-reg-title-n', $this->contract->immovable->developer_address->developer_city->region->title_n);
        $word->setValue('imm-dev-reg-title-r', $this->contract->immovable->developer_address->developer_city->region->title_r);

        // Об'єкт - Площа та тип нерухомості
        $word->setValue('imm-app-type-title', $this->contract->immovable->immovable_type->title);
        $word->setValue('imm-total-space', $this->contract->immovable->total_space);
        $word->setValue('imm-living-space', $this->contract->immovable->living_space);

        // Об'єкт -право власності
        $word->setValue('imm-own-gov-reg-num', $this->contract->immovable_ownership->gov_reg_number);
        $word->setValue('imm-own-gov-reg-date', $this->contract->immovable_ownership->gov_reg_date_format);
        $word->setValue('imm-own-dis-date', $this->contract->immovable_ownership->discharge_date_format);
        $word->setValue('imm-own-dis-num', $this->contract->immovable_ownership->discharge_number);
        $word->setValue('imm-own-res-surname-o', $this->contract->immovable_ownership->discharge_resp->surname_o);
        $word->setValue('imm-own-res-sh-name', $this->contract->immovable_ownership->discharge_resp->short_name);
        $word->setValue('imm-own-res-sh-patr', $this->contract->immovable_ownership->discharge_resp->short_patronymic);
        $word->setValue('imm-own-res-actvt-o', $this->contract->immovable_ownership->discharge_resp->activity_o);
        $word->setValue('imm-reg-num', $this->contract->immovable->registration_number);

        // Об'єкт - оцінка
        $word->setValue('pvprice-date', $this->contract->pvprice->date_format);
        $word->setValue('pv-title', $this->contract->pvprice->property_valuation->title);
        $word->setValue('pv-certificate', $this->contract->pvprice->property_valuation->certificate);
        $word->setValue('pv-date', $this->contract->pvprice->property_valuation->date->format('d.m.Y'));
        $word->setValue('pvprice-grn', number_format(intval($this->contract->pvprice->price / 100), 0, ".",  " " ));
        $word->setValue('pvprice-grn-str', $this->contract->pvprice->price_grn_str);
        $word->setValue('pvprice-coin', sprintf("%02d", number_format($this->contract->pvprice->price % 100)));
        $word->setValue('pvprice-coin-str', $this->contract->pvprice->price_coin_str);

        // Об'єкт - ціна від забудовника
        $word->setValue('dev-price-grn', $this->contract->immovable->grn);
        $word->setValue('dev-price-grn-str', $this->contract->immovable->developer_grn_str);
        $word->setValue('dev-price-coin', $this->contract->immovable->coin);
        $word->setValue('dev-price-coin-str', $this->contract->immovable->developer_coin_str);

        // Об'єкт - нотариус по контракту
        $word->setValue('cont-ntr-surname-o', $this->contract->notary->surname_o);
        $word->setValue('cont-ntr-sh-name', $this->contract->notary->short_name);
        $word->setValue('cont-ntr-sh-patr', $this->contract->notary->short_patronymic);
        $word->setValue('cont-ntr-actvt-o', $this->contract->notary->activity_o);

        // Об'єкт - пераевірка заборон на майно та продавця
        $word->setValue('imm-fence-date', $this->contract->immovable->fence->date->format('d.m.Y'));
        $word->setValue('imm-fence-num', $this->contract->immovable->fence->number);
        $word->setValue('dev-fence-date', $this->contract->dev_company->owner->fence->date->format('d.m.Y'));
        $word->setValue('dev-fence-num', $this->contract->dev_company->owner->fence->number);

        $word->setValue('dev-surname-d', $this->contract->dev_company->owner->surname_d);
        $word->setValue('dev-name-d', $this->contract->dev_company->owner->name_d);
        $word->setValue('dev-patr-d', $this->contract->dev_company->owner->patronymic_d);

        // Нотариус
        $word->setValue('ntr-actvt-n', $this->contract->client_spouse_consent->notary->activity_n);
        $word->setValue('ntr-actvt-o', $this->contract->client_spouse_consent->notary->activity_o);
        $word->setValue('ntr-actvt-d', $this->mb_ucfirst($this->contract->client_spouse_consent->notary->activity_d));
        $word->setValue('ntr-surname-n', $this->contract->client_spouse_consent->notary->surname_n);
        $word->setValue('ntr-surname-o', $this->contract->client_spouse_consent->notary->surname_o);
        $word->setValue('ntr-surname-d', $this->contract->client_spouse_consent->notary->surname_d);
        $word->setValue('ntr-sh-name', $this->contract->client_spouse_consent->notary->short_name);
        $word->setValue('ntr-sh-patr', $this->contract->client_spouse_consent->notary->short_patronymic);

        $word->setValue('cs-surname-n', $this->contract->client_spouse_consent->client_spouse->surname_n);
        $word->setValue('cs-name-n', $this->contract->client_spouse_consent->client_spouse->name_n);
        $word->setValue('cs-patr-n', $this->contract->client_spouse_consent->client_spouse->patronymic_n);

        $word->setValue('cs-surname-r', $this->contract->client_spouse_consent->client_spouse->surname_r);
        $word->setValue('cs-name-r', $this->contract->client_spouse_consent->client_spouse->name_r);
        $word->setValue('cs-patr-r', $this->contract->client_spouse_consent->client_spouse->patronymic_r);

        $word->setValue('cs-surname-o', $this->contract->client_spouse_consent->client_spouse->surname_o);
        $word->setValue('cs-name-o', $this->contract->client_spouse_consent->client_spouse->name_o);
        $word->setValue('cs-patr-o', $this->contract->client_spouse_consent->client_spouse->patronymic_o);

        $word->setValue('cs-birthday', $this->contract->client_spouse_consent->client_spouse->birthday->format('d.m.Y'));
        $word->setValue('cs-pssprt-code', $this->contract->client_spouse_consent->client_spouse->passport_code);
        $word->setValue('cs-pssprt-date', $this->contract->client_spouse_consent->client_spouse->passport_date->format('d.m.Y'));
        $word->setValue('cs-pssprt-dep', $this->contract->client_spouse_consent->client_spouse->passport_department);

        $word->setValue('cs-region', $this->contract->client_spouse_consent->client_spouse->region->title_n);
        // $word->setValue('sp-district', $this->consent->client_spouse->passport_department);
        $word->setValue('cs-city-type-s', $this->contract->client_spouse_consent->client_spouse->city_type->short);
        $word->setValue('cs-city', $this->contract->client_spouse_consent->client_spouse->city->title_n);
        $word->setValue('cs-district', $this->contract->client_spouse_consent->client_spouse->city->district->title_n);
        $word->setValue('cs-addr-type', $this->contract->client_spouse_consent->client_spouse->address_type->short);
        $word->setValue('cs-addr', $this->contract->client_spouse_consent->client_spouse->address);
        $word->setValue('cs-build-type', $this->contract->client_spouse_consent->client_spouse->building_type->short);
        $word->setValue('cs-build-num', $this->contract->client_spouse_consent->client_spouse->building);

        $word->setValue('cs-tax-code', $this->contract->client_spouse_consent->client_spouse->tax_code);

        // client
        $word->setValue('cl-surname-o', $this->contract->client_spouse_consent->client_spouse->client->surname_o);
        $word->setValue('cl-name-o', $this->contract->client_spouse_consent->client_spouse->client->name_o);
        $word->setValue('cl-patr-o', $this->contract->client_spouse_consent->client_spouse->client->patronymic_o);
        $word->setValue('cl-tax-code', $this->contract->client_spouse_consent->client_spouse->client->tax_code);

        // client spouse consent part
        $word->setValue('cs-gender-o', KeyWord::where('key', $this->contract->client_spouse_consent->client_spouse->gender)->value('title_o'));
        $word->setValue('cs-gender-o-up', $this->mb_ucfirst(KeyWord::where('key', $this->contract->client_spouse_consent->client_spouse->gender)->value('title_o')));

        // Анкета
        $word->setValue('question-date', $this->contract->questionnaire->date->format('d.m.Y'));

        // Згода шлюб
        $word->setValue('mar-series', $this->contract->client_spouse_consent->mar_series);
        $word->setValue('mar-series-num', $this->contract->client_spouse_consent->mar_series_num);
        $word->setValue('mar-date', $this->contract->client_spouse_consent->mar_date->format('d.m.y'));
        $word->setValue('mar-depart', $this->contract->client_spouse_consent->mar_depart);
        $word->setValue('mar-reg-num', $this->contract->client_spouse_consent->mar_reg_num);

        $word->setValue('alias-dis-sh', CityType::where('alias', 'district')->value('short'));
        $word->setValue('alias-dis-n', CityType::where('alias', 'district')->value('title_n'));

        $word->setValue('sp-date-d-r', $this->contract->client_spouse_consent->str_day->title_r);
        $word->setValue('sp-date-m-r', $this->contract->client_spouse_consent->str_month->title_r);
        $word->setValue('sp-date-y-r', $this->contract->client_spouse_consent->str_year->title_r);

        $word->setValue('st-d-r', $this->contract->developer_statement->str_day->title_r);
        $word->setValue('st-m-r', $this->contract->developer_statement->str_month->title_r);
        $word->setValue('st-y-r', $this->contract->developer_statement->str_year->title_r);

        $word->setValue('contract-sign-date', $this->contract->sign_date->format('d.m.y'));

        $word->setValue('cs-consent-sign-date', $this->contract->client_spouse_consent->date->format('d.m.y'));
        $word->setValue('cs-consent-reg-num', $this->contract->client_spouse_consent->reg_num);

        $word->setValue('dev-consent-sign-date', $this->contract->developer_spouse_consent->date->format('d.m.y'));
        $word->setValue('dev-consent-reg-num', $this->contract->developer_spouse_consent->reg_num);

        return $word;
    }

    public function set_contract_template_part($filename)
    {
        $file_path = $this->get_file_path($this->contract->template);

        // client spouse
        $word = new TemplateProcessor($file_path);
        $word->setValue('cl-sp-word', $this->contract->client_spouse_word->text);
        $word->setValue('dev-sp-word', $this->contract->developer_spouse_word->text);
        $word->saveAs($filename);

        $file_path = URL::to('/') . "/" . $filename;

        return $file_path;
    }

    public function set_template_part($filename)
    {
        $file_path = $this->get_file_path($this->contract->questionnaire->questionnaire_template);

        $word = new TemplateProcessor($file_path);
        $word->setValue('q-dev-pssprt-full-n', $this->contract->dev_company->owner->passport_type->description_n);
        $word->saveAs($filename);

        $file_path = URL::to('/') . "/" . $filename;

        $word = new TemplateProcessor($file_path);
        $word->setValue('pssprt-code', $this->contract->dev_company->owner->passport_code);
        $word->setValue('pssprt-date', $this->contract->dev_company->owner->passport_date->format('d.m.y'));
        $word->setValue('pssprt-depart', $this->contract->dev_company->owner->passport_department);
        $word->setValue('pssprt-demogr', $this->contract->dev_company->owner->passport_demographic_code);
        $word->saveAs($filename);


        $word = new TemplateProcessor($file_path);
        $word->setValue('q-cl-pssprt-full-n', $this->contract->client->passport_type->description_n);
        $word->saveAs($filename);

        $word = new TemplateProcessor($file_path);
        $word->setValue('pssprt-code', $this->contract->client->passport_code);
        $word->setValue('pssprt-date', $this->contract->client->passport_date->format('d.m.y'));
        $word->setValue('pssprt-depart', $this->contract->client->passport_department);
        $word->setValue('pssprt-demogr', $this->contract->client->passport_demographic_code);
        $word->saveAs($filename);
    }

    public function set_consent_template_part($filename)
    {
        $file_path = $this->get_file_path($this->contract->client_spouse_consent->consents_template);

        $word = new TemplateProcessor($file_path);
        // Шлюб згода
        $word->setValue('consent-married-part', $this->contract->client_spouse_consent->marriage_type->description);
        $word->saveAs($filename);

        $file_path = URL::to('/') . "/" . $filename;

        return $file_path;
    }

    public function set_statement_template_part($filename)
    {
        $file_path = $this->get_file_path($this->contract->developer_statement->statement_template);

        $word = new TemplateProcessor($file_path);
        $word->setValue('s-dev-pssprt-full-o', $this->contract->dev_company->owner->passport_type->description_o);
        $word->saveAs($filename);

        $file_path = URL::to('/') . "/" . $filename;

        $word = new TemplateProcessor($file_path);
        $word->setValue('pssprt-code', $this->contract->dev_company->owner->passport_code);
        $word->setValue('pssprt-date', $this->contract->dev_company->owner->passport_date->format('d.m.y'));
        $word->setValue('pssprt-depart', $this->contract->dev_company->owner->passport_department);
        $word->setValue('pssprt-demogr', $this->contract->dev_company->owner->passport_demographic_code);
        $word->saveAs($filename);

        $word = new TemplateProcessor($file_path);
        $word->setValue('s-cl-pssprt-full-o', $this->contract->client->passport_type->description_o);
        $word->saveAs($filename);

        $word = new TemplateProcessor($file_path);
        $word->setValue('pssprt-code', $this->contract->client->passport_code);
        $word->setValue('pssprt-date', $this->contract->client->passport_date->format('d.m.y'));
        $word->setValue('pssprt-depart', $this->contract->client->passport_department);
        $word->setValue('pssprt-demogr', $this->contract->client->passport_demographic_code);
        $word->saveAs($filename);

        $word->setValue('s-cl-pssprt-full-o', $this->contract->client->passport_type->description_o);

        return $file_path;
    }

    public function set_proxy_data($word)
    {
        $word->setValue('pr-title', $this->contract->developer_spouse_consent->reg_num);
        $word->setValue('pr-num', $this->contract->developer_spouse_consent->reg_num);
        $word->setValue('pr-date', $this->contract->developer_spouse_consent->reg_num);
        $word->setValue('pr-ntr-surname-o', $this->contract->developer_spouse_consent->reg_num);
        $word->setValue('pr-ntr-sh-name', $this->contract->developer_spouse_consent->reg_num);
        $word->setValue('pr-ntr-sh-patr', $this->contract->developer_spouse_consent->reg_num);
        $word->setValue('pr-ntr-actvt-o', $this->contract->developer_spouse_consent->reg_num);
        $word->setValue('pr-reg-date', $this->contract->developer_spouse_consent->reg_num);
        $word->setValue('pr-reg-num', $this->contract->developer_spouse_consent->reg_num);

        return $word;
    }
}
