<?php

namespace App\Http\Controllers\Word;

use App\Http\Controllers\Controller;
use App\Models\CityType;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class WordConsentController extends Controller
{
//    public $consent;
//    public $contract;
//
//    public function __construct()
//    {
//        $this->consent = null;
//        $this->contract = null;
//    }
//
//    public function consent_template_set_data($consent, $contract)
//    {
//        $this->consent = $consent;
//        $this->contract = $contract;
//
//        $this->consent->consents_template->getMedia('path')->first();
//        $filename = "Згода.docx";
//        $file_path = $this->get_consent_path();
//
//        $word = new TemplateProcessor($file_path);
//
////        dd($this->consent->client_spouse->address_type->short);
////        dd($this->consent->client_spouse->client->surname_o);
//
//        // Нотариус
//        $word->setValue('ntr-actvt-n', $this->consent->notary->activity_n);
//        $word->setValue('ntr-actvt-d', $this->mb_ucfirst($this->consent->notary->activity_d));
//        $word->setValue('ntr-surname-n', $this->consent->notary->surname_n);
//        $word->setValue('ntr-surname-d', $this->consent->notary->surname_d);
//        $word->setValue('ntr-sh-name', $this->consent->notary->short_name);
//        $word->setValue('ntr-sh-patr', $this->consent->notary->short_patronymic);
//
//        $word->setValue('cs-surname-r', $this->consent->client_spouse->surname_r);
//        $word->setValue('cs-name-r', $this->consent->client_spouse->name_r);
//        $word->setValue('cs-patr-r', $this->consent->client_spouse->patronymic_r);
//
//        $word->setValue('cs-birthday', $this->consent->client_spouse->birthday->format('d.m.Y'));
//        $word->setValue('cs-pssprt-code', $this->consent->client_spouse->passport_code);
//        $word->setValue('cs-pssprt-date', $this->consent->client_spouse->passport_date->format('d.m.Y'));
//        $word->setValue('cs-pssprt-dep', $this->consent->client_spouse->passport_department);
//
//        $word->setValue('cs-region', $this->consent->client_spouse->region->title_n);
//        // $word->setValue('sp-district', $this->consent->client_spouse->passport_department);
//        $word->setValue('cs-city-type-s', $this->consent->client_spouse->city_type->short);
//        $word->setValue('cs-city', $this->consent->client_spouse->city->title_n);
//        $word->setValue('cs-district', $this->consent->client_spouse->city->district->title_n);
//        $word->setValue('cs-addr-type', $this->consent->client_spouse->address_type->short);
//        $word->setValue('cs-addr', $this->consent->client_spouse->address);
//        $word->setValue('cs-build-type', $this->consent->client_spouse->building_type->short);
//        $word->setValue('cs-build-num', $this->consent->client_spouse->building);
//
//        $word->setValue('cs-tax-code', $this->consent->client_spouse->tax_code);
//
//        $word->setValue('cs-surname-n', $this->consent->client_spouse->surname_n);
//        $word->setValue('cs-name-n', $this->consent->client_spouse->name_n);
//        $word->setValue('cs-patr-n', $this->consent->client_spouse->patronymic_n);
//
//        // client
//        $word->setValue('cl-surname-o', $this->consent->client_spouse->client->surname_o);
//        $word->setValue('cl-name-o', $this->consent->client_spouse->client->name_o);
//        $word->setValue('cl-patr-o', $this->consent->client_spouse->client->patronymic_o);
//        $word->setValue('cl-tax-code', $this->consent->client_spouse->client->tax_code);
//
//        $word->setValue('imm-num', $this->contract->immovable->immovable_number);
//        $word->setValue('imm-num-str', $this->contract->immovable->immovable_number_string);
//        $word->setValue('imm-dev-reg-title-n', $this->contract->immovable->developer_address->developer_city->region->title_n);
//        $word->setValue('imm-dev-dis-title-n', $this->contract->immovable->developer_address->developer_city->district->title_n);
//        $word->setValue('alias-dis-sh', CityType::where('alias', 'district')->value('short'));
//        $word->setValue('alias-dis-n', CityType::where('alias', 'district')->value('title_n'));
//        $word->setValue('imm-dev-city-type-n', $this->contract->immovable->developer_address->developer_city->city_type->title_n);
//        $word->setValue('imm-dev-city-title-n', $this->contract->immovable->developer_address->developer_city->title_n);
//        $word->setValue('imm-dev-addr-type-r', $this->contract->immovable->developer_address->address_type->title_r);
//        $word->setValue('imm-dev-addr-title', $this->contract->immovable->developer_address->title);
//        $word->setValue('imm-build-num', $this->contract->immovable->building_number);
//        $word->setValue('imm-build-num-str', $this->contract->immovable->building_number_string);
//
//        $word->setValue('date-d-r', $this->contract->str_day->title_r);
//        $word->setValue('date-m-r', $this->contract->str_month->title_r);
//        $word->setValue('date-y-r', $this->contract->str_year->title_r);
//
//        $word->setValue('con-city-type-n', $this->mb_ucfirst($this->contract->event_city->city_type->title_n));
//        $word->setValue('con-city-title-n', $this->contract->event_city->title_n);
//        $word->setValue('con-dis-title-n', $this->contract->event_city->district->title_n);
//        $word->setValue('con-reg-title-n', $this->contract->event_city->region->title_n);
//        $word->setValue('ntr-surname-n', $this->contract->str_year->title_r);
//        $word->setValue('ntr-actvt-n', $this->contract->str_year->title_r);
//
//        $word->saveAs($filename);
//    }
//
//    private function get_consent_path()
//    {
//        if ($file = $this->consent->consents_template->getMedia('path')->first()) {
//            return $file->getUrl();
//        } else {
//            dd('File not exist');
//        }
//    }
//
//    private function mb_ucfirst($string)
//    {
//        if ($string) {
//            $string = explode(" ", $string);
//            $string[0] = mb_convert_case($string[0], MB_CASE_TITLE, 'UTF-8');
//            $string = implode(" ", $string);
//        }
//
//        return $string;
//    }
}
