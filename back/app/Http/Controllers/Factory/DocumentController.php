<?php

namespace App\Http\Controllers\Factory;

use App\Models\CityType;
use App\Models\GenderWord;
use App\Models\KeyWord;
use App\Models\MainInfoType;
use App\Models\MonthConvert;
use App\Models\BankTaxesList;
use App\Models\Service;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\TemplateProcessor;
use URL;

class DocumentController extends GeneratorController
{
    public $ff;
    public $convert;
    public $client;
    public $total_clients;
    public $consent;
    public $consents_id;
    public $contract_generate_file;
    public $consent_generate_file;
    public $developer_statement_generate_file;
    public $questionnaire_generate_file;
    public $bank_account_generate_file;
    public $bank_taxes_generate_file;
    public $style_bold;
    public $style_color;
    public $style_color_and_bold;
    public $style_color_and_italic;
    public $style_end;
    public $style_space_line;
    public $style_space_full_name;

    public function __construct($client, $pack_contract, $consents_id)
    {
        parent::__construct();

        $this->pack_contract = $pack_contract;

        // Оскільки договір може укладати декілька осіб то передача клієнта з якого почався пошук
        // не дасть змогу утвори декілька заяв згод
        // $this->client = $client;
        $this->client = null;
        $this->total_clients = null;
        $this->convert = new ConvertController();
        $this->consent = null;
        $this->consents_id = $consents_id;
        $this->contract_generate_file = null;
        $this->consent_generate_file = null;
        $this->developer_statement_generate_file = null;
        $this->questionnaire_generate_file = null;
        $this->bank_account_generate_file = null;
        $this->bank_taxes_generate_file = null;
        $this->style_color = "</w:t></w:r><w:r><w:rPr><w:highlight w:val=\"yellow\"/></w:rPr><w:t xml:space=\"preserve\">";
        $this->style_bold = "</w:t></w:r><w:r><w:rPr><w:b/></w:rPr><w:t xml:space=\"preserve\">";
        $this->style_color_and_bold = "</w:t></w:r><w:r><w:rPr><w:b/><w:highlight w:val=\"yellow\"/></w:rPr><w:t xml:space=\"preserve\">";
        $this->style_color_and_italic = "</w:t></w:r><w:r><w:rPr><w:i/><w:highlight w:val=\"yellow\"/></w:rPr><w:t xml:space=\"preserve\">";
        $this->style_end = "</w:t></w:r><w:r><w:t xml:space=\"preserve\">";
        $this->style_space_line = "                                    ";
        $this->style_space_full_name = "                                                                              ";
    }

    public function creat_files()
    {
        foreach ($this->pack_contract as $key => $this->contract) {

            $this->ff = new FolderFileController($this->contract);
            $this->total_clients = count($this->contract->clients);

            foreach ($this->contract->clients as $this->client) {

                // dd($this->client->representative->confidant);
                /*
                 * Оскільки в договорі необхідно передати данні про згоду подружжя
                 * або заява про відсутність шлюбних відносин, необхідно виділити одну і єдину згоду або заяву
                 * для підстановки данних в договір cl-sp-word і т.п.
                 * */
                if (count($this->contract->client_spouse_consent) && count($this->contract->client_spouse_consent->where('client_id', $this->client->id)))
                    $this->consent = $this->contract->client_spouse_consent->where('client_id', $this->client->id)->first();
                else
                    $this->consent = null;

                if ($this->contract)
                    $this->contract_template_set_data();
                else
                    $this->notification("Warning", "Контракт відсутній");

                if ($this->contract->questionnaire)
                    $this->questionnaire_template_set_data();
                else
                    $this->notification("Warning", "Анкета відсутняя");

                if ($this->contract->developer_statement)
                    $this->developer_statement_template_set_data();
                else
                    $this->notification("Warning", "Заява від забудовника відсутня");

                if ($this->contract->bank_account_payment)
                    $this->bank_account_template_set_data();
                else
                    $this->notification("Warning", "Рахунок відсутній");

                if ($this->contract->bank_account_payment)
                    $this->bank_account_template_set_data();
                else
                    $this->notification("Warning", "Рахунок відсутній");

                if ($this->contract->bank_taxes_payment)
                    $this->bank_taxes_template_set_data();
                else
                    $this->notification("Warning", "Податки відсутні");

                $this->total_clients--;
            }

            if ($this->client && $this->client->client_spouse_consent) {
                foreach ($this->client->client_spouse_consent as $this->consent) {
                    // УМОВА ДЛЯ УНИКАННЯ ДУБЛЮВАННЯ ОДНАКОВИХ ЗАЯВ-ЗГОД
                    if (isset($this->consent) && !empty($this->consent) && in_array($this->consent->id, $this->consents_id) && $this->client->id == $this->consent->client_id) {
                        $this->consent_template_set_data();
                        if (($del_consents_id = array_search($this->consent->id, $this->consents_id)) !== false) {
                            unset($this->consents_id[$del_consents_id]);
                        }
                    }
                    else
                        $this->notification("Warning", "Згода подружжя відсутня");
                }
            }
        }
    }

    public function contract_template_set_data()
    {
        $this->contract_generate_file = $this->ff->contract_title();

        $this->convert->date_to_string($this->contract, $this->contract->sign_date);
        // містить шаблон для паспорту
        $this->set_full_info_template($this->contract_generate_file);
        $this->set_spouse_word_template_part();
        // метод для декількох файлів, передаєм необхідний шаблон
        $this->set_passport_template_part($this->contract_generate_file);
        // метод тільки для договорів, нема необхідності робити уточнення
        $this->set_current_document_notary($this->contract_generate_file, $this->contract->notary);
        $this->set_sign_date($this->contract_generate_file, $this->contract);

        $word = new TemplateProcessor($this->contract_generate_file);
        $word = $this->set_data_word($word);
        $word->saveAs($this->contract_generate_file);

        unset($word);

        echo "<br>";
    }

    public function questionnaire_template_set_data()
    {
        $this->questionnaire_generate_file = $this->ff->questionnaire_title();

        $this->set_full_info_template($this->questionnaire_generate_file);
        $this->convert->date_to_string($this->contract->questionnaire, $this->contract->questionnaire->sign_date);
        $this->set_passport_template_part($this->questionnaire_generate_file);
        $this->set_current_document_notary($this->questionnaire_generate_file, $this->contract->questionnaire->notary);
        $this->set_sign_date($this->questionnaire_generate_file, $this->contract->questionnaire);

        $word = new TemplateProcessor($this->questionnaire_generate_file);
        $word = $this->set_data_word($word);
        $word->saveAs($this->questionnaire_generate_file);

        unset($word);

        echo "<br>";
    }

    public function developer_statement_template_set_data()
    {
        $this->developer_statement_generate_file = $this->ff->developer_statement_title();

        $this->convert->date_to_string($this->contract->developer_statement, $this->contract->developer_statement->sign_date);
        $this->set_passport_template_part($this->developer_statement_generate_file);
        $this->set_current_document_notary($this->developer_statement_generate_file, $this->contract->developer_statement->notary);
        $this->set_sign_date($this->developer_statement_generate_file, $this->contract->developer_statement);


        $word = new TemplateProcessor($this->developer_statement_generate_file);
        $word = $this->set_data_word($word);
        $word->saveAs($this->developer_statement_generate_file);

        unset($word);

        echo "<br>";
    }

    public function consent_template_set_data()
    {
        $this->consent_generate_file = $this->ff->consent_title($this->consent);

        $this->convert->date_to_string($this->consent, $this->consent->sign_date);
        $this->set_passport_template_part($this->consent_generate_file);
        $this->set_current_document_notary($this->consent_generate_file, $this->consent->notary);
        $this->set_consent_married_template_part();
        $this->set_sign_date($this->consent_generate_file, $this->consent);

        $word = new TemplateProcessor($this->consent_generate_file);
        $word = $this->set_data_word($word);
        $word->saveAs($this->consent_generate_file);

        unset($word);

        echo "<br>";
    }

    public function bank_account_template_set_data()
    {
        $this->bank_account_generate_file = $this->ff->bank_account_title();

        $this->set_passport_template_part($this->bank_account_generate_file);

        /*
         * В рахунку використовується дата підписання Угоди $this->contract
         * */
        $this->set_sign_date($this->bank_account_generate_file, $this->contract);

        $word = new TemplateProcessor($this->bank_account_generate_file);
        $word = $this->set_data_word($word);
        $word->saveAs($this->bank_account_generate_file);

        unset($word);

        echo "<br>";
    }

    public function bank_taxes_template_set_data()
    {
        $this->bank_taxes_generate_file = $this->ff->bank_taxes_title();

        $this->set_passport_template_part($this->bank_taxes_generate_file);

        /*
         * В податкових рахунках використовується дата підписання Угоди $this->contract
         * */
        $this->set_sign_date($this->bank_taxes_generate_file, $this->contract);

        $spreadsheet = IOFactory::load($this->bank_taxes_generate_file);
        $sheet = $spreadsheet->getActiveSheet();
        $this->set_taxes_data($sheet);
        $writer = new Xlsx($spreadsheet);
        $file_name = $this->bank_taxes_generate_file;
        $writer->save($file_name);

        unset($word);

        echo "<br>";
    }


    public function bank_tax_template_set_data()
    {
//        military-tax
//        purchase-tax
//        income-tax
    }

    public function set_data_word($word)
    {
        /*
         * Договір - загальні данні
         * */
        $word = $this->set_contract_data($word);

        /*
         * Забудовник
         * */
        $word = $this->set_developer($word);

        /*
         * Згода подружжя забудовника
         * */
        $word = $this->set_developer_spouse_consent($word);

        /*
         * Договір доручення
         * */
        $word = $this->set_proxy_data($word);

        /*
         * Підписант - представник з боку забудовника
         * */
        $word = $this->set_dev_representative($word);

        /*
         * Інвестиційний договір
         * */
        $word = $this->set_investment_agreement($word);

        /*
         * Покупець
         * */
        $word = $this->set_client($word);

        /*
         * Представник покупця - задати основні данні
         * */
        $word = $this->set_client_representative_confidant($word);

        /*
         * Представник покупця - нотаріальні данні
         * */
        $word = $this->set_client_representative_data($word);
        /*
         * Подружжя покупця
         * */
        $word = $this->set_client_spouse($word);

        /*
         * Згода подружжя - реєстраційний номер
         * */
        $word = $this->set_client_spouse_consent($word);



        $word = $this->set_client_spouse_consent_for_multiple_deal($word);

        /*
         * Об'єкт нерухомості
         * */
        $word = $this->set_immovable($word);

        /*
         * Перевірка обмежень на продавця та майно
         * */
        $word = $this->set_check_fence_info($word);

        /*
         * Данні від оціночної компанії
         * */
        $word = $this->set_property_valuation_prices($word);

        /*
         * Ціна від забудовника
         * */
        $word = $this->set_developer_price($word);

        /*
         * Забезпечувальний платіж до попереднього договору
         * */
        $word = $this->set_secure_payment($word);

        /*
         * Курс долара та посилання на сайт
         * */
        $word = $this->set_exchange_rate($word);

        return $word;
    }

    /*
     * Додати до договору текс-шаблон в пункт згоди подружжя
     * */
    public function set_spouse_word_template_part()
    {
        $word = new TemplateProcessor($this->contract_generate_file);

        if ($this->consent && $this->consent->contract_spouse_word) {
            if ($this->total_clients == 1)
                $word->setValue('cl-sp-word', $this->consent->contract_spouse_word->text);
            else
                $word->setValue('cl-sp-word', $this->consent->contract_spouse_word->text . "<w:br/>\${cl-sp-word}");
        } else {
            $this->notification("Warning", "Договір: текс-шаблон пункту згоди подружжя клієнта або ствердження відсутності шлюбних зв'язквів відсутній");
        }

        $word->saveAs($this->contract_generate_file);
    }

    public function set_full_info_template($template_generate_file)
    {
        $word = new TemplateProcessor($template_generate_file);

        /*
         *
         * */
        if ($this->client->representative) {
            $full_description = MainInfoType::where('alias', 'full-client-and-representative-confidant')->value('description');
        }
        else {
            $full_description = MainInfoType::where('alias', 'full-name-tax-code-id-card-address')->value('description');
        }

        if ($this->total_clients > 1) {
            $full_description = $full_description . ", \${full-name-tax-code-id-card-address}";
        }

        $word->setValue('full-name-tax-code-id-card-address', $this->set_style_color($full_description));

        /*
         *
         * */
        $sign_area_line = MainInfoType::where('alias', 'sign-area-line')->value('description');

        if ($this->client->representative) {
            // проміжок стає коротшим
            $this->style_space_full_name = "                                           ";
            $sign_area_full_name = MainInfoType::where('alias', 'sign-area-representative-client-full-name')->value('description');
        } else {
            $sign_area_full_name = MainInfoType::where('alias', 'sign-area-full-name')->value('description');
        }

        $sign_area_full_name = $this->style_color_and_italic($sign_area_full_name);

        if ($this->total_clients > 1) {
            $sign_area = $sign_area_line . "<w:br/>" . $this->style_space_full_name . $sign_area_full_name . "<w:br/><w:br/>" . $this->style_space_line . "\${sign-area}";
        } else {
            $sign_area = $sign_area_line . "<w:br/>" . $this->style_space_full_name . $sign_area_full_name;
        }

        $word->setValue('sign-area', $sign_area);

        /*
         * Предаставник покупця - підставити шаблон нотаріальних данних довіреності
         * */
        $cr_ntr_representative_client = MainInfoType::where('alias', 'cr-ntr-representative-client')->value('description');

        $word->setValue('cr-ntr-representative-client-up', $this->mb_ucfirst($cr_ntr_representative_client));

        $word->saveAs($template_generate_file);
    }

    public function set_passport_template_part($template_generate_file)
    {
        /*
         * Внесення текстового шаблону паспортних данних ЗАБУДОВНИКА для поспортных даннх в генеруэмий документ
         * */
        if ($this->contract->dev_company && $this->contract->dev_company->owner) {
            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('dev-pssprt-full-n', $this->contract->dev_company->owner->passport_type->description_n);
            $word->setValue('dev-pssprt-full-o', $this->contract->dev_company->owner->passport_type->description_o);
            $word->setValue('dev-pssprt-full-n-up', $this->mb_ucfirst($this->contract->dev_company->owner->passport_type->description_n));
            $word->setValue('dev-pssprt-full-o-up', $this->mb_ucfirst($this->contract->dev_company->owner->passport_type->description_o));
            $word->saveAs($template_generate_file);

            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('pssprt-code', $this->contract->dev_company->owner->passport_code);
            $word->setValue('pssprt-date', $this->display_date($this->contract->dev_company->owner->passport_date));
            $word->setValue('pssprt-depart', $this->contract->dev_company->owner->passport_department);
            $word->setValue('pssprt-demogr', $this->contract->dev_company->owner->passport_demographic_code);
            $word->saveAs($template_generate_file);
        } else {
            $this->notification("Warning", "Паспортний шаблон: данні забудовника відсутні");
        }

        /*
         * Внесення текстового шаблону паспортних данних ІНВЕСТОРА для поспортных даннх в генеруэмий документ
         * */
        if ($this->contract->immovable->developer_building && $this->contract->immovable->developer_building->investment_agreement && $this->contract->immovable->developer_building->investment_agreement->investor) {
            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('inv-pssprt-full-n', $this->contract->immovable->developer_building->investment_agreement->investor->passport_type->description_n);
            $word->setValue('inv-pssprt-full-o', $this->contract->immovable->developer_building->investment_agreement->investor->passport_type->description_o);
            $word->setValue('inv-pssprt-full-n-up', $this->mb_ucfirst($this->contract->immovable->developer_building->investment_agreement->investor->passport_type->description_n));
            $word->setValue('inv-pssprt-full-o-up', $this->mb_ucfirst($this->contract->immovable->developer_building->investment_agreement->investor->passport_type->description_o));
            $word->saveAs($template_generate_file);

            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('pssprt-code', $this->contract->immovable->developer_building->investment_agreement->investor->passport_code);
            $word->setValue('pssprt-date', $this->display_date($this->contract->immovable->developer_building->investment_agreement->investor->passport_date));
            $word->setValue('pssprt-depart', $this->contract->immovable->developer_building->investment_agreement->investor->passport_department);
            $word->setValue('pssprt-demogr', $this->contract->immovable->developer_building->investment_agreement->investor->passport_demographic_code);
            $word->saveAs($template_generate_file);
        } else {
            $this->notification("Warning", "Паспортний шаблон: данні інвестора відсутні");
        }


        /*
         * Внесення текстового шаблону паспортних данних КЛІЄНТА для поспортных даннх в генеруэмий документ
         * */
        if ($this->client) {
            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('cl-pssprt-full-n', $this->client->passport_type->description_n);
            $word->setValue('cl-pssprt-full-o', $this->client->passport_type->description_o);
            $word->setValue('cl-pssprt-full-n-up', $this->mb_ucfirst($this->client->passport_type->description_n));
            $word->setValue('cl-pssprt-full-o-up', $this->mb_ucfirst($this->client->passport_type->description_o));
            $word->setValue('cl-pssprt-id-short', $this->set_style_color($this->client->passport_type->short_info));
            $word->saveAs($template_generate_file);

            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('pssprt-code', $this->client->passport_code);
            $word->setValue('pssprt-date', $this->display_date($this->client->passport_date));
            $word->setValue('pssprt-depart', $this->client->passport_department);
            $word->setValue('pssprt-demogr', $this->client->passport_demographic_code);
            $word->saveAs($template_generate_file);
        } else {
            $this->notification("Warning", "Паспортний шаблон: данні клієнта відсутні");
        }

        /*
         * Внесення текстового шаблону паспортних данних ПРЕДСТАНИКА КЛІЄНТА для поспортных даннх в генеруэмий документ
         * */
        if ($this->client->representative && $this->client->representative->confidant) {
            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('cr-pssprt-full-n', $this->client->representative->confidant->passport_type->description_n);
            $word->setValue('cr-pssprt-full-o', $this->client->representative->confidant->passport_type->description_o);
            $word->setValue('cr-pssprt-full-n-up', $this->mb_ucfirst($this->client->representative->confidant->passport_type->description_n));
            $word->setValue('cr-pssprt-full-o-up', $this->mb_ucfirst($this->client->representative->confidant->passport_type->description_o));
            $word->setValue('cr-pssprt-id-short', $this->client->representative->confidant->passport_type->short_info);
            $word->saveAs($template_generate_file);

            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('pssprt-code', $this->client->representative->confidant->passport_code);
            $word->setValue('pssprt-date', $this->display_date($this->client->representative->confidant->passport_date));
            $word->setValue('pssprt-depart', $this->client->representative->confidant->passport_department);
            $word->setValue('pssprt-demogr', $this->client->representative->confidant->passport_demographic_code);
            $word->saveAs($template_generate_file);
        } else {
            $this->notification("Warning", "Паспортний шаблон: данні подружжя відсутні");
        }

        /*
         * Внесення текстового шаблону паспортних данних ПОДРУЖЖЯ КЛІЄНТА для поспортных даннх в генеруэмий документ
         * */
        if ($this->client->spouse) {
            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('cs-pssprt-full-n', $this->client->spouse->passport_type->description_n);
            $word->setValue('cs-pssprt-full-o', $this->client->spouse->passport_type->description_o);
            $word->setValue('cs-pssprt-full-n-up', $this->mb_ucfirst($this->client->spouse->passport_type->description_n));
            $word->setValue('cs-pssprt-full-o-up', $this->mb_ucfirst($this->client->spouse->passport_type->description_o));
            $word->setValue('cs-pssprt-id-short', $this->client->spouse->passport_type->short_info);
            $word->saveAs($template_generate_file);

            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('pssprt-code', $this->client->spouse->passport_code);
            $word->setValue('pssprt-date', $this->display_date($this->client->spouse->passport_date));
            $word->setValue('pssprt-depart', $this->client->spouse->passport_department);
            $word->setValue('pssprt-demogr', $this->client->spouse->passport_demographic_code);
            $word->saveAs($template_generate_file);
        } else {
            $this->notification("Warning", "Паспортний шаблон: данні подружжя відсутні");
        }
    }

    /*
     * Нотаріус, що працював з документом
     * */
    public function set_current_document_notary($template, $notary)
    {
        if ($notary) {
            $word = new TemplateProcessor($template);
            $word->setValue('ntr-actvt-n', $notary->activity_n);
            $word->setValue('ntr-actvt-r', $notary->activity_r);
            $word->setValue('ntr-actvt-d', $notary->activity_d);
            $word->setValue('ntr-actvt-o', $notary->activity_o);

            $word->setValue('ntr-actvt-n-up', $this->mb_ucfirst($notary->activity_n));
            $word->setValue('ntr-actvt-r-up', $this->mb_ucfirst($notary->activity_r));
            $word->setValue('ntr-actvt-d-up', $this->mb_ucfirst($notary->activity_d));
            $word->setValue('ntr-actvt-o-up', $this->mb_ucfirst($notary->activity_o));

            $word->setValue('ntr-surname-n', $notary->surname_n);
            $word->setValue('ntr-surname-r', $notary->surname_r);
            $word->setValue('ntr-surname-d', $notary->surname_d);
            $word->setValue('ntr-surname-o', $notary->surname_o);
            $word->setValue('ntr-name-n', $notary->name_n);
            $word->setValue('ntr-name-r', $notary->name_r);
            $word->setValue('ntr-name-d', $notary->name_d);
            $word->setValue('ntr-name-o', $notary->name_o);
            $word->setValue('ntr-patr-n', $notary->patr_n);
            $word->setValue('ntr-patr-r', $notary->patr_r);
            $word->setValue('ntr-patr-d', $notary->patr_d);
            $word->setValue('ntr-patr-o', $notary->patr_o);
            $word->setValue('ntr-sh-name', $notary->short_name);
            $word->setValue('ntr-sh-patr', $notary->short_patronymic);
            $word->saveAs($template);
        } else {
            $this->notification("Warning", "Відсутня інформація про нотаріуса у документі {$template}");
        }
    }

    /*
     * Дата підписання документу цифрою та словами
     * */
    public function set_sign_date($template, $document)
    {
        $word = new TemplateProcessor($template);

        $word->setValue('sign-dmy', $this->display_date($document->sign_date));

        $word->setValue('sign-d-r', $document->str_day->title);
        $word->setValue('sign-m-r', $document->str_month->title_r);
        $word->setValue('sign-y-r', $document->str_year->title_r);

        $word->setValue('sign-d-r-up', $this->mb_ucfirst($document->str_day->title));
        $word->setValue('sign-m-r-up', $this->mb_ucfirst($document->str_month->title_r));
        $word->setValue('sign-y-r-up', $this->mb_ucfirst($document->str_year->title_r));

        $word->saveAs($template);
    }

    public function set_contract_data($word)
    {
        /*
         * Тип договору
         * */
        // $word->setValue('template-type', mb_strtolower($this->contract->contract_template->template_type->title));

        /*
         * Данні про місце складання договору
         * */
        /*
        $word->setValue('con-city-type-n', $this->contract->event_city->city_type->title_n);
        $word->setValue('con-city-type-r', $this->contract->event_city->city_type->title_r);
        $word->setValue('con-city-title-n', $this->contract->event_city->title_n);
        $word->setValue('con-dis-title-n', $this->contract->event_city->district->title_n);
        $word->setValue('con-dis-title-r', $this->contract->event_city->district->title_r);
        $word->setValue('con-reg-title-n', $this->contract->event_city->region->title_n);
        $word->setValue('con-reg-title-r', $this->contract->event_city->region->title_r);
        */

        /*
         * Для попереднього договору вноситься дата підписання основного договору
         * */
        if ($this->contract->final_sign_date) {
            $word->setValue('con-final-date-qd-m', $this->day_quotes_month_year($this->contract->final_sign_date->sign_date));
        }

        // Допоміжні данні
        $word->setValue('alias-dis-sh', CityType::where('alias', 'district')->value('short'));
        $word->setValue('alias-dis-n', CityType::where('alias', 'district')->value('title_n'));

        return $word;
    }

    /*
     * Забудовник
     * */
    public function set_developer($word)
    {
        if ($this->contract->dev_company && $this->contract->dev_company->owner) {
            /*
             * Забудовник - ПІБ
             * */
            $word->setValue('dev-full-name-n', $this->get_full_name_n($this->contract->dev_company->owner));

            $word->setValue('dev-surname-n', $this->contract->dev_company->owner->surname_n);
            $word->setValue('dev-name-n', $this->contract->dev_company->owner->name_n);
            $word->setValue('dev-patr-n', $this->contract->dev_company->owner->patronymic_n);

            $word->setValue('dev-surname-r', $this->contract->dev_company->owner->surname_r);
            $word->setValue('dev-name-r', $this->contract->dev_company->owner->name_r);
            $word->setValue('dev-patr-r', $this->contract->dev_company->owner->patronymic_r);

            $word->setValue('dev-surname-d', $this->contract->dev_company->owner->surname_d);
            $word->setValue('dev-name-d', $this->contract->dev_company->owner->name_d);
            $word->setValue('dev-patr-d', $this->contract->dev_company->owner->patronymic_d);

            $word->setValue('dev-birthday', $this->display_date($this->contract->dev_company->owner->birthday));

            /*
             * Забудовник - паспорт та код
             * */
            $word->setValue('dev-tax-code', $this->contract->dev_company->owner->tax_code);
            $word->setValue('dev-psssprt-code', $this->contract->dev_company->owner->passport_code);

            /*
             * Забудовник - місце проживання
             * */
            $word->setValue('dev-f-addr', $this->full_address($this->contract->dev_company->owner));
        } else {
            $this->notification("Warning", "Відсутня інформація про забудовнику");
        }

        return $word;
    }

    /*
     * Згода подружжя забудовника
     * */
    public function set_developer_spouse_consent($word)
    {
        if ($this->contract->dev_company && $this->contract->dev_company->owner && $this->contract->dev_company->owner->married) {
            if ($this->contract->developer_spouse_consent) {
                $word->setValue('dev-consent-sign-date', $this->display_date($this->contract->developer_spouse_consent->sign_date));
                $word->setValue('dev-consent-reg-num', $this->contract->developer_spouse_consent->reg_num);
            } else {
                $this->notification("Warning", "Відсутня інформація про згоду подружжя забудовника");
            }
        } else {
            $this->notification("Warning", "Згода подружжя забудовника: інформація відсутня");
        }

        return $word;
    }

    /*
     * Інвестиційний договір
     * */
    public function set_investment_agreement($word)
    {
        if ($this->contract->immovable && $this->contract->immovable->developer_building && $this->contract->immovable->developer_building->investment_agreement) {
            $word->setValue('inv-num', $this->contract->immovable->developer_building->investment_agreement->number);
            $word->setValue('inv-date', $this->display_date($this->contract->immovable->developer_building->investment_agreement->date));
            $word->setValue('inv-surname-o', $this->contract->immovable->developer_building->investment_agreement->investor->surname_o);
            $word->setValue('inv-name-o', $this->contract->immovable->developer_building->investment_agreement->investor->name_o);
            $word->setValue('inv-patr-o', $this->contract->immovable->developer_building->investment_agreement->investor->patronymic_o);
            $word->setValue('inv-tax-code', $this->contract->immovable->developer_building->investment_agreement->investor->tax_code);

            if ($this->contract->immovable->developer_building->investment_agreement->investor->gender == "male") {
                $citizen_o = KeyWord::where('key', "citizen_male")->value('title_o');
            } else {
                $citizen_o = KeyWord::where('key', "citizen_female")->value('title_o');
            }
            $word->setValue('inv-citizen-o', $citizen_o);
            $word->setValue('inv-full-addr', $this->full_address($this->contract->immovable->developer_building->investment_agreement->investor));
        } else {
            $this->notification("Warning", "Інвестеційний договір: відсутній");
        }

        return $word;
    }

    /*
     * Підписант - представник з боку забудовника
     * */
    public function set_dev_representative($word)
    {
        if ($this->contract && $this->contract->dev_representative) {

            $word->setValue('dev-rep-full-name-n', $this->get_full_name_n($this->contract->dev_representative));

            $word->setValue('dev-rep-surname-n', $this->contract->dev_representative->surname_n);
            $word->setValue('dev-rep-name-n', $this->contract->dev_representative->name_n);
            $word->setValue('dev-rep-patr-n', $this->contract->dev_representative->patronymic_n);

            $word->setValue('dev-rep-surname-r', $this->contract->dev_representative->surname_r);
            $word->setValue('dev-rep-name-r', $this->contract->dev_representative->name_r);
            $word->setValue('dev-rep-patr-r', $this->contract->dev_representative->patronymic_r);

            $word->setValue('dev-rep-surname-d', $this->contract->dev_representative->surname_d);
            $word->setValue('dev-rep-name-d', $this->contract->dev_representative->name_d);
            $word->setValue('dev-rep-patr-d', $this->contract->dev_representative->patronymic_d);

            $word->setValue('dev-rep-surname-o', $this->contract->dev_representative->surname_o);
            $word->setValue('dev-rep-name-o', $this->contract->dev_representative->name_o);
            $word->setValue('dev-rep-patr-o', $this->contract->dev_representative->patronymic_o);

            $word->setValue('dev-rep-birthday', $this->display_date($this->contract->dev_representative->birthday));
        } else {
            $this->notification("Warning", "Підписант - представник з боку забудовника: інформація відсутня");
        }

        return $word;
    }

    /*
     * Клієнт
     * */
    public function set_client($word)
    {
        if ($this->client) {
            /*
             * Клієнт - ПІБ
             * */
            $word->setValue('cl-full-name-n', $this->get_full_name_n($this->client));
            $word->setValue('КЛ-ПІБ', $this->get_full_name_n($this->client));

            $word->setValue('cl-surname-n', $this->client->surname_n);
            $word->setValue('cl-name-n', $this->client->name_n);
            $word->setValue('cl-patr-n', $this->client->patronymic_n);

            $word->setValue('cl-surname-n-b', $this->set_style_color_and_bold($this->client->surname_n));
            $word->setValue('cl-name-n-b', $this->set_style_color_and_bold($this->client->name_n));
            $word->setValue('cl-patr-n-b', $this->set_style_color_and_bold($this->client->patronymic_n));

            $word->setValue('cl-surname-r', $this->client->surname_r);
            $word->setValue('cl-name-r', $this->client->name_r);
            $word->setValue('cl-patr-r', $this->client->patronymic_r);

            $word->setValue('cl-surname-o', $this->client->surname_o);
            $word->setValue('cl-name-o', $this->client->name_o);
            $word->setValue('cl-patr-o', $this->client->patronymic_o);

            $word->setValue('cl-surname-n-up-s', mb_strtoupper($this->client->surname_n));
            $word->setValue('cl-name-n-up-s', mb_strtoupper($this->client->name_n));
            $word->setValue('cl-patr-n-up-s', mb_strtoupper($this->client->patronymic_n));

            $word->setValue('cl-surname-r-up-s', mb_strtoupper($this->client->surname_r));
            $word->setValue('cl-name-r-up-s', mb_strtoupper($this->client->name_r));
            $word->setValue('cl-patr-r-up-s', mb_strtoupper($this->client->patronymic_r));

            $word->setValue('cl-surname-o-up-s', mb_strtoupper($this->client->surname_o));
            $word->setValue('cl-name-o-up-s', mb_strtoupper($this->client->name_o));
            $word->setValue('cl-patr-o-up-s', mb_strtoupper($this->client->patronymic_o));

            $word->setValue('cl-birthday', $this->display_date($this->client->birthday));

            $word->setValue('cl-gender-sp-role-r', KeyWord::where('key', $this->client->gender)->value('title_r'));
            $word->setValue('cl-gender-sp-role-r-up', $this->mb_ucfirst(KeyWord::where('key', $this->client->gender)->value('title_r')));
            $word->setValue('cl-gender-sp-role-o', KeyWord::where('key', $this->client->gender)->value('title_o'));
            $word->setValue('cl-gender-sp-role-o-up', $this->mb_ucfirst(KeyWord::where('key', $this->client->gender)->value('title_o')));

            if ($this->client->spouse)
                $cl_gender_pronoun = GenderWord::where('alias', "whose")->value($this->client->spouse->gender);
            else
                $cl_gender_pronoun = null;

            $word->setValue('cl-gender-pronoun', $cl_gender_pronoun);
            $word->setValue('cl-gender-pronoun-up', $this->mb_ucfirst($cl_gender_pronoun));

            $word->setValue('cl-widowhood', GenderWord::where('alias', "widowhood")->value($this->client->gender));

            $cl_gender_registration = GenderWord::where('alias', "registration")->value($this->client->gender);
            $word->setValue('cl-gender-reg', $cl_gender_registration);

            $cl_gender_which = GenderWord::where('alias', "which")->value($this->client->gender);
            $word->setValue('cl-gender-which', $this->set_style_color($cl_gender_which));

            $cl_gender_which_adjective = GenderWord::where('alias', "which-adjective")->value($this->client->gender);
            $word->setValue('cl-gender-which-adj', $this->set_style_color($cl_gender_which_adjective));

            $cl_gender_acquainted = GenderWord::where('alias', "acquainted")->value($this->client->gender);
            $word->setValue('cl-gender-acq', $this->set_style_color($cl_gender_acquainted));

            /*
             * Клієнт - IПН
             * */
            $word->setValue('cl-tax-code', $this->client->tax_code);
            $word->setValue('cl-tax-code-b', $this->set_style_color_and_bold($this->client->tax_code));

            /*
             * Клієнт - місце проживання
             * */
            $word->setValue('cl-f-addr', $this->set_style_color($this->full_address($this->client)));

            /*
             * Контактні данні
             * */
            $word->setValue('cl-phone', $this->client->phone);
        } else {
            $this->notification("Warning", "Відсутня інформація про клієнта");
        }

        return $word;
    }

    /*
     * Представник - задати основні данні
     * */
    public function set_client_representative_confidant($word)
    {
        if ($this->client->representative && $this->client->representative->confidant) {
            /*
             * Представник - ПІБ
             * */
            $word->setValue('cr-full-name-n', $this->get_full_name_n($this->client->representative->confidant));
            $word->setValue('cr-surname-n', $this->client->representative->confidant->surname_n);
            $word->setValue('cr-name-n', $this->client->representative->confidant->name_n);
            $word->setValue('cr-patr-n', $this->client->representative->confidant->patronymic_n);

            $word->setValue('cr-surname-n-b', $this->set_style_color_and_bold($this->client->representative->confidant->surname_n));
            $word->setValue('cr-name-n-b', $this->set_style_color_and_bold($this->client->representative->confidant->name_n));
            $word->setValue('cr-patr-n-b', $this->set_style_color_and_bold($this->client->representative->confidant->patronymic_n));

            $word->setValue('cr-surname-r', $this->client->representative->confidant->surname_r);
            $word->setValue('cr-name-r', $this->client->representative->confidant->name_r);
            $word->setValue('cr-patr-r', $this->client->representative->confidant->patronymic_r);

            $word->setValue('cr-surname-o', $this->client->representative->confidant->surname_o);
            $word->setValue('cr-name-o', $this->client->representative->confidant->name_o);
            $word->setValue('cr-patr-o', $this->client->representative->confidant->patronymic_o);

            $word->setValue('cr-surname-n-up-s', mb_strtoupper($this->client->representative->confidant->surname_n));
            $word->setValue('cr-name-n-up-s', mb_strtoupper($this->client->representative->confidant->name_n));
            $word->setValue('cr-patr-n-up-s', mb_strtoupper($this->client->representative->confidant->patronymic_n));

            $word->setValue('cr-surname-r-up-s', mb_strtoupper($this->client->representative->confidant->surname_r));
            $word->setValue('cr-name-r-up-s', mb_strtoupper($this->client->representative->confidant->name_r));
            $word->setValue('cr-patr-r-up-s', mb_strtoupper($this->client->representative->confidant->patronymic_r));

            $word->setValue('cr-surname-o-up-s', mb_strtoupper($this->client->representative->confidant->surname_o));
            $word->setValue('cr-name-o-up-s', mb_strtoupper($this->client->representative->confidant->name_o));
            $word->setValue('cr-patr-o-up-s', mb_strtoupper($this->client->representative->confidant->patronymic_o));

            $word->setValue('cr-birthday', $this->display_date($this->client->representative->confidant->birthday));

            $word->setValue('cr-gender-r', KeyWord::where('key', $this->client->representative->confidant->gender)->value('title_r'));
            $word->setValue('cr-gender-r-up', $this->mb_ucfirst(KeyWord::where('key', $this->client->representative->confidant->gender)->value('title_r')));
            $word->setValue('cr-gender-o', KeyWord::where('key', $this->client->representative->confidant->gender)->value('title_o'));
            $word->setValue('cr-gender-o-up', $this->mb_ucfirst(KeyWord::where('key', $this->client->representative->confidant->gender)->value('title_o')));

            /*
             * Представник - IПН
             * */
            $word->setValue('cr-tax-code', $this->client->representative->confidant->tax_code);
            $word->setValue('cr-tax-code-b', $this->set_style_color_and_bold($this->client->representative->confidant->tax_code));

            /*
             * Представник - місце проживання
             * */
            $word->setValue('cr-f-addr', $this->set_style_color($this->full_address($this->client->representative->confidant)));

            $cr_gender_registration = GenderWord::where('alias', "registration")->value($this->client->representative->confidant->gender);
            $word->setValue('cr-gender-reg', $cr_gender_registration);

            $cr_gender_which = GenderWord::where('alias', "which")->value($this->client->representative->confidant->gender);
            $word->setValue('cr-gender-which', $this->set_style_color($cr_gender_which));

            $cr_gender_which_adjective = GenderWord::where('alias', "which-adjective")->value($this->client->representative->confidant->gender);
            $word->setValue('cr-gender-which-adj', $this->set_style_color($cr_gender_which_adjective));

            $cl_gender_acquainted = GenderWord::where('alias', "acquainted")->value($this->client->representative->confidant->gender);
            $word->setValue('cr-gender-acq', $this->set_style_color($cl_gender_acquainted));

            $word->setValue('cr-citizenship', $this->get_citizenship($this->client->representative->confidant));
            /*
             * Представник - контактні данні
             * */
            $word->setValue('cr-phone', $this->client->representative->confidant->phone);

        } else {
            $this->notification("Warning", "Представник відсутній");
        }

        return $word;
    }

    /*
     * Подружжя клієнта
     * */
    public function set_client_spouse($word)
    {
        if ($this->client->spouse) {
            /*
             * Подружжя клієнта - ПІБ
             * */

            $word->setValue('cs-full-name-n', $this->get_full_name_n($this->client->spouse));

            $word->setValue('cs-surname-n', $this->client->spouse->surname_n);
            $word->setValue('cs-name-n', $this->client->spouse->name_n);
            $word->setValue('cs-patr-n', $this->client->spouse->patronymic_n);

            $word->setValue('cs-surname-r', $this->client->spouse->surname_r);
            $word->setValue('cs-name-r', $this->client->spouse->name_r);
            $word->setValue('cs-patr-r', $this->client->spouse->patronymic_r);
            $word->setValue('cs-surname-o', $this->client->spouse->surname_o);
            $word->setValue('cs-name-o', $this->client->spouse->name_o);
            $word->setValue('cs-patr-o', $this->client->spouse->patronymic_o);
            $word->setValue('cs-birthday', $this->display_date($this->client->spouse->birthday));

            /*
             * Подружжя клієнта - паспорт та код
             * */
            $word->setValue('cs-tax-code', $this->client->spouse->tax_code);
            $word->setValue('cs-pssprt-code', $this->client->spouse->passport_code);
            $word->setValue('cs-pssprt-date', $this->display_date($this->client->spouse->passport_date));
            $word->setValue('cs-pssprt-dep', $this->client->spouse->passport_department);

            /*
             * Подружжя клієнта - адреса проживання
             * */
            $word->setValue('cs-f-addr', $this->full_address($this->client->spouse));
            $word->setValue('cs-region', $this->client->spouse->city->region->title_n);
            $word->setValue('cs-city-type-s', $this->client->spouse->city->city_type->short);
            $word->setValue('cs-city', $this->client->spouse->city->title);

            $cs_district = $this->client->spouse->city->district ? $this->client->spouse->city->district->title_n : null;
            $word->setValue('cs-district', $cs_district);
            $word->setValue('cs-addr-type', $this->client->spouse->address_type->short);
            $word->setValue('cs-addr', $this->client->spouse->address);
            $word->setValue('cs-build-type', $this->client->spouse->building_type->short);
            $word->setValue('cs-build-num', $this->client->spouse->building);

            /*
             * Подружжя клієнта - стать Ч/Ж
             * */
            $word->setValue('cs-gender-sp-role-o', KeyWord::where('key', $this->client->spouse->gender)->value('title_o'));
            $word->setValue('cs-gender-sp-role-o-up', $this->mb_ucfirst(KeyWord::where('key', $this->client->spouse->gender)->value('title_o')));

            $cs_gender_pronoun = GenderWord::where('alias', "whose")->value($this->client->spouse->gender);
            $word->setValue('cs-gender-pronoun', $cs_gender_pronoun);
            $word->setValue('cs-gender-pronoun-up', $this->mb_ucfirst($cs_gender_pronoun));

            $cs_gender_mine = GenderWord::where('alias', "mine")->value($this->client->gender);
            $word->setValue('cs-gender-mine', $cs_gender_mine);
            $word->setValue('cs-gender-mine-up', $this->mb_ucfirst($cs_gender_mine));

            $cs_gender_registration = GenderWord::where('alias', "registration")->value($this->client->spouse->gender);
            $word->setValue('cs-gender-reg', $cs_gender_registration);

            $cs_gender_which = GenderWord::where('alias', "which")->value($this->client->spouse->gender);
            $word->setValue('cs-gender-which', $this->set_style_color($cs_gender_which));

            $cs_gender_which_adjective = GenderWord::where('alias', "which-adjective")->value($this->client->spouse->gender);
            $word->setValue('cs-gender-which-adj', $this->set_style_color($cs_gender_which_adjective));

            $cs_gender_acquainted = GenderWord::where('alias', "acquainted")->value($this->client->spouse->gender);
            $word->setValue('cs-gender-acq', $this->set_style_color($cs_gender_acquainted));

            $word->setValue('cs-citizenship', $this->get_citizenship($this->client->spouse));
        } else {
            $this->notification("Warning", "Відсутня інформація про подружжя клієнта");
        }

        return $word;
    }

    /*
     * Згода подружжя
     * Вставити необхідний текс-шаблон підтвердження шлюбу (свідоцтво, рішення суду)
     * */
    public function set_consent_married_template_part()
    {
        if ($this->consent && $this->consent->marriage_type) {
            $word = new TemplateProcessor($this->consent_generate_file);
            $word->setValue('consent-married-part', $this->consent->marriage_type->description);
            $word->saveAs($this->consent_generate_file);
        } else {
            $this->notification("Warning", "Згода подружжя: шаблон підтвердження шлюбу відсутній");
        }
    }

    /*
     * Згода подружжя
     * */
    public function set_client_spouse_consent($word)
    {
        if ($this->consent) {
            /*
             * Згода подружжя - шлюбні данні
             * Данна части може не використовуватись для клієнтів не в шлюбі.
             * Показником наявності шлюбу буде дата укладання шлюбу
             * */
            if ($this->consent->mar_date) {
                $word->setValue('mar-series', $this->consent->mar_series);
                $word->setValue('mar-series-num', $this->consent->mar_series_num);
                $word->setValue('mar-date', $this->display_date($this->consent->mar_date));
                $word->setValue('mar-depart', $this->consent->mar_depart);
                $word->setValue('mar-reg-num', $this->consent->mar_reg_num);
            }

            /*
             * Згода подружжя - реєстраційний номер
             * */
            $word->setValue('cs-consent-sign-date', $this->display_date($this->consent->sign_date));
            $word->setValue('cs-consent-reg-num', $this->consent->reg_num);
        } else {
            $this->notification("Warning", "Відсутня інформація про згоду подружжя клієнта");
        }

        return $word;
    }

    /*
     * Об'єкт нерухомості
     * */
    public function set_immovable($word)
    {
        if ($this->contract->immovable) {
            /*
             * Об'єкт - тип нерухомості
             * */
            $word->setValue('imm-type-n', $this->contract->immovable->immovable_type->title_n);
            $word->setValue('imm-type-z', $this->contract->immovable->immovable_type->title_z);
            $word->setValue('imm-type-r', $this->contract->immovable->immovable_type->title_r);
            $word->setValue('imm-type-o', $this->contract->immovable->immovable_type->title_r);

            if ($this->contract->immovable->roominess)
                $word->setValue('imm-app-type-title', $this->contract->immovable->roominess->title);
            else
                $word->setValue('imm-app-type-title', "");

            /*
             * Об'єкт - адреса
             * */
            $word->setValue('imm-full-addr', $this->contract->immovable->address);

            $word->setValue('imm-num', $this->contract->immovable->immovable_number);
            $word->setValue('imm-num-str', $this->convert->number_to_string($this->contract->immovable->immovable_number));
            $word->setValue('imm-build-num', $this->contract->immovable->developer_building->number); // исправить на number_dig
            $word->setValue('imm-build-num-str', $this->convert->number_to_string($this->contract->immovable->developer_building->number)); // привязать к developer_building(address) как number_str
            $word->setValue('imm-addr-type-n', $this->contract->immovable->developer_building->address_type->title_n); // building
            $word->setValue('imm-addr-type-r', $this->contract->immovable->developer_building->address_type->title_r); // building
            $word->setValue('imm-addr-title', $this->contract->immovable->developer_building->title); // building
            $word->setValue('imm-city-type-n', $this->contract->immovable->developer_building->city->city_type->title_n); // building
            $word->setValue('imm-city-type-r', $this->contract->immovable->developer_building->city->city_type->title_r); // building
            $word->setValue('imm-city-title-n', $this->contract->immovable->developer_building->city->title); // building
            $word->setValue('imm-dis-title-n', $this->contract->immovable->developer_building->city->district->title_n); // building
            $word->setValue('imm-dis-title-r', $this->contract->immovable->developer_building->city->district->title_r); // building
            $word->setValue('imm-reg-title-n', $this->contract->immovable->developer_building->city->region->title_n); // building
            $word->setValue('imm-reg-title-r', $this->contract->immovable->developer_building->city->region->title_r); // building
            $word->setValue('imm-floor-dig', $this->contract->immovable->floor); // building
            $word->setValue('imm-floor-str', KeyWord::where('key', 'floor_' . $this->contract->immovable->floor)->value('title_d')); // building
            $word->setValue('imm-section-dig', $this->contract->immovable->section); // building
            $word->setValue('imm-section-str', $this->convert->number_to_string($this->contract->immovable->section)); // building
            $word->setValue('imm-complex', $this->contract->immovable->developer_building->complex); // building

            /*
             * Об'єкт - загальна та житлова проща
             * */
            $word->setValue('imm-total-space',  $this->convert->get_convert_space($this->contract->immovable->total_space));
            $word->setValue('imm-living-space', $this->convert->get_convert_space($this->contract->immovable->living_space));

            /*
             * Дата підключеня до коммунікацій / Введення в експлуатацію
             * */
            if ($this->contract->immovable->developer_building->exploitation_date && $this->contract->immovable->developer_building->communal_date) {
                $word->setValue('imm-expl-date-m-r', $this->day_quotes_month_year($this->contract->immovable->developer_building->exploitation_date));
                $word->setValue('imm-comm-date-m-r', $this->day_quotes_month_year($this->contract->immovable->developer_building->communal_date));
            }


            /*
             * Об'єкт - дозвіл на будівництво
             * */
            if ($this->contract->immovable->developer_building->building_permit) {
                $word->setValue('imm-res-num', $this->contract->immovable->developer_building->building_permit->resolution);
                $word->setValue('imm-res-date-m-r', $this->day_quotes_month_year($this->contract->immovable->developer_building->building_permit->sign_date));
            }

            /*
             * Об'єкт - реєстраційний номер
             * */
            $word->setValue('imm-reg-num', $this->contract->immovable->registration_number);
        } else {
            $this->notification("Warning", "Відсутня інформація про об'єкт нерухомості");
        }

        return $word;
    }

    /*
     * Перевірка обмежень на продавця та майно
     * */
    public function set_check_fence_info($word)
    {
        /*
         * Об'єкт - перевірка на право власності та данні нотаріуса, що здійснив цю перевірку
         * */
        if ($this->contract->immovable_ownership) {
            $word->setValue('imm-own-gov-reg-num', $this->contract->immovable_ownership->gov_reg_number);
            $word->setValue('imm-own-gov-reg-date', $this->contract->immovable_ownership->gov_reg_date_format);
            $word->setValue('imm-own-dis-date', $this->contract->immovable_ownership->discharge_date_format);
            $word->setValue('imm-own-dis-num', $this->contract->immovable_ownership->discharge_number);
            $word->setValue('imm-own-res-surname-o', $this->contract->notary->surname_o);
            $word->setValue('imm-own-res-sh-name', $this->contract->notary->short_name);
            $word->setValue('imm-own-res-actvt-o', $this->contract->notary->activity_o);
            $word->setValue('imm-own-res-sh-patr', $this->contract->notary->short_patronymic);
        } else {
            $this->notification("Warning", "Перевірка: відсутня інформація про власника майна");
        }

        /*
         * Перевірка заборон на майно
         * */
        if ($this->contract->immovable->fence) {
            $word->setValue('imm-fence-date', $this->display_date($this->contract->immovable->fence->date));
            $word->setValue('imm-fence-num', $this->contract->immovable->fence->number);
        } else {
            $this->notification("Warning", "Перевірка: відсутня інформація по забороні на нерухомість");
        }

        /*
         * Перевірка заборон на власника
         * */
        if ($this->contract->dev_company->owner->fence) {
            $word->setValue('dev-fence-date', $this->display_date($this->contract->dev_company->owner->fence->date));
            $word->setValue('dev-fence-num', $this->contract->dev_company->owner->fence->number);
        } else {
            $this->notification("Warning", "Перевірка: відсутня інформація по заборонам на власника");
        }

        return $word;
    }

    /*
     * Об'єкт - данні від оціночної компанії
     * */
    public function set_property_valuation_prices($word)
    {
        if ($this->contract->immovable->pvprice) {
            $word->setValue('pv-price-date', $this->display_date($this->contract->immovable->pvprice->date));
            $word->setValue('pv-title', $this->contract->immovable->pvprice->property_valuation->title);
            $word->setValue('pv-certificate', $this->contract->immovable->pvprice->property_valuation->certificate);
            $word->setValue('pv-date', $this->display_date($this->contract->immovable->pvprice->property_valuation->date));
            $word->setValue('pv-price-grn', $this->convert->get_convert_price($this->contract->immovable->pvprice->grn, 'grn'));
        } else {
            $this->notification("Warning", "Оцінка: відсутня інформація від оціночної компанії");
        }

        return $word;
    }

    /*
     * Об'єкт - ціна від забудовника
     * */
    public function set_developer_price($word)
    {
        $word->setValue('price-grn', $this->convert->get_convert_price($this->contract->immovable->grn, 'grn'));
        $word->setValue('price-dollar', $this->convert->get_convert_price($this->contract->immovable->dollar, 'dollar'));
        $word->setValue('reserve-grn', $this->convert->get_convert_price($this->contract->immovable->reserve_grn, 'grn'));
        $word->setValue('reserve-dollar', $this->convert->get_convert_price($this->contract->immovable->reserve_dollar, 'dollar'));
        $word->setValue('m2-grn',  $this->convert->get_convert_price($this->contract->immovable->m2_grn, 'grn'));
        $word->setValue('m2-dollar', $this->convert->get_convert_price($this->contract->immovable->m2_dollar, 'dollar'));

        return $word;
    }

    /*
     * Забезпечувальний платіж до попереднього договору
     * */
    public function set_secure_payment($word)
    {
        if ($this->contract->immovable->security_payment) {
            $word->setValue('secur-sign-date', $this->day_quotes_month_year($this->contract->immovable->security_payment->sign_date));
            $word->setValue('secur-reg-num', $this->contract->immovable->security_payment->reg_num);

            $word->setValue('secur-first-grn', $this->convert->get_convert_price($this->contract->immovable->security_payment->first_part_grn, 'grn'));
            $word->setValue('secur-first-dollar', $this->convert->get_convert_price($this->contract->immovable->security_payment->first_part_dollar, 'dollar'));
            $word->setValue('secur-last-grn', $this->convert->get_convert_price($this->contract->immovable->security_payment->last_part_grn, 'grn'));
            $word->setValue('secur-last-dollar', $this->convert->get_convert_price($this->contract->immovable->security_payment->last_part_dollar, 'dollar'));

            $word->setValue('secur-final-date', $this->contract->immovable->security_payment->grn_cent_str);
        } else {
            $this->notification("Warning", "Забезпечувальний платіж до попереднього договору: інформація відсутня");
        }

        return $word;
    }

    /*
     * Курс долара та посилання на сайт
     * */
    public function set_exchange_rate($word)
    {
        if ($this->contract->immovable && $this->contract->immovable->exchange_rate) {
            $word->setValue('imm-exch-link', $this->contract->immovable->exchange_rate->web_site_link);
            $word->setValue('imm-exch-root', $this->contract->immovable->exchange_rate->web_site_root);
            $word->setValue('imm-exch', $this->convert->exchange_price($this->contract->immovable->exchange_rate->rate));
        } else {
            $this->notification("Warning", "Курс долара: інформація відсутня");
        }

        return $word;
    }

    /*
     * Довіреність на представника ПОКУПЦЯ
     * */
    public function set_client_representative_data($word)
    {
        if ($this->client->representative) {
            $word->setValue('cr-ntr-surname-o', $this->set_style_color($this->client->representative->notary->surname_o));
            $word->setValue('cr-ntr-sh-name', $this->set_style_color($this->client->representative->notary->short_name));
            $word->setValue('cr-ntr-sh-patr', $this->set_style_color($this->client->representative->notary->short_patronymic));
            $word->setValue('cr-ntr-actvt-o', $this->set_style_color($this->client->representative->notary->activity_o));
            $word->setValue('cr-reg-date', $this->set_style_color($this->display_date($this->client->representative->reg_date)));
            $word->setValue('cr-reg-num', $this->set_style_color($this->client->representative->reg_num));
        } else {
            $this->notification("Warning", "Ноторіальні данні по довіренності представника покупця: інформація відсутня");
        }

        return $word;
    }

    /*
     * Договір - розділ "Договір доручення"
     * */
    public function set_proxy_data($word)
    {
        if ($this->contract->immovable->proxy) {
            $word->setValue('pr-num', $this->contract->immovable->proxy->number);
            $word->setValue('pr-date', $this->display_date($this->contract->immovable->proxy->date));
            $word->setValue('pr-date-qd-m', $this->day_quotes_month_year($this->contract->immovable->proxy->date));
            $word->setValue('pr-ntr-surname-o', $this->contract->immovable->proxy->notary->surname_o);
            $word->setValue('pr-ntr-sh-name', $this->contract->immovable->proxy->notary->short_name);
            $word->setValue('pr-ntr-sh-patr', $this->contract->immovable->proxy->notary->short_patronymic);
            $word->setValue('pr-ntr-actvt-o', $this->contract->immovable->proxy->notary->activity_o);
            $word->setValue('pr-reg-date', $this->display_date($this->contract->immovable->proxy->reg_date));
            $word->setValue('pr-reg-num', $this->contract->immovable->proxy->reg_num);
        } else {
            $this->notification("Warning", "Договір доручення: інформація відсутня");
        }

        return $word;
    }

    public function set_client_spouse_consent_for_multiple_deal($word)
    {
        $imm_line = null;
        if ($this->consent) {
            // imm['адреса'] = ['нерхомість', 'нерхомість']
            $imm_line = $this->immovable_for_one_consent($this->consent->contracts);

            $word->setValue('imm-type-num-line-r', array_shift($imm_line));
        }
        return $word;
    }

    public function immovable_for_one_consent($spouse_contracts)
    {
        $result = null;
        $imm = [];

        foreach ($spouse_contracts as $sp_con) {

            if ($contract = $this->pack_contract->whereIn('id', $sp_con->id)->first()) {
                $imm_type_r = $contract->immovable->immovable_type->title_r;
                $imm_num_dig = $contract->immovable->immovable_number;
                $imm_num_str = $contract->immovable->immovable_number_string;
                $imm_full_address = $contract->immovable->address;
                $imm[$imm_full_address][$imm_num_dig] = "$imm_type_r $imm_num_dig ($imm_num_str)";
            }
        }

        $result = $this->immovable_type_num_line($imm);
        return $result;
    }

    /*
     * Для відображення декількох адрес підряд, наприклад, в заяві-згоді.
     * */
    public function immovable_type_num_line($imm)
    {
        $line = "";
        foreach ($imm as $address => $building) {
            ksort($building);
            $building = array_values($building);
            $last_key = array_key_last($building);
            foreach ($building as $number => $type_num) {
                if ($number == $last_key) {
                    $line .= " та $type_num";
                } elseif (count($building) > 2 && $number == $last_key - 1) {
                    $line .= $type_num;
                } else {
                    $line .= $type_num . ", ";
                }
            }
            $imm[$address] = $line;
        }

        return $imm;
    }

    public function get_citizenship($client)
    {
        $result = null;

        if ($client->citizenship) {

            if ($client->gender == "male") {
                $citizen_o = KeyWord::where('key', "citizen_male")->value('title_o');
            } else {
                $citizen_o = KeyWord::where('key', "citizen_female")->value('title_o');
            }
            $country_title_r = $client->citizenship->title_r;
            $result = "$citizen_o $country_title_r";
        }

        return $result;
    }

    public function day_quotes_month_year($date)
    {
        $day = $date->format('d');
        $month = MonthConvert::where('original', $date->format('m'))->orWhere('original', strval(intval($date->format('m'))))->value('title_r');
        $year = $date->format('Y');

        $title = "«{$day}» {$month} {$year}";

        return $title;
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

    public function display_date($date)
    {
        $result = null;

        if ($date) {
            $result = $date->format('d.m.Y');
        }

        return $result;
    }

    public function set_style_bold($text)
    {
        $str = $this->style_bold . $text . $this->style_end;

        return $str;
    }

    public function set_style_color($text)
    {
        $str = $this->style_color . $text . $this->style_end;

        return $str;
    }

    public function set_style_color_and_bold($text)
    {
        $str = $this->style_color_and_bold . $text . $this->style_end;

        return $str;
    }

    public function style_color_and_italic($text)
    {
        $str = $this->style_color_and_italic . $text . $this->style_end;

        return $str;
    }

    public function get_full_name_n($client)
    {
        $full_name = $client->surname_n . " " . $client->name_n . " " . $client->patronymic_n;

        return $full_name;
    }

    public function set_taxes_data($sheet)
    {
        $developer = null;

        $price = sprintf("%.2f", $this->contract->immovable->grn/100);
        $sheet->setCellValue("J1", $price);
        $taxes = BankTaxesList::get();

        $i = 2;
        foreach ($taxes as $tax) {
            if ($tax->type == 'developer') {
                $pay_buy_client = $this->contract->dev_company->owner;
            } else {
                $pay_buy_client = $this->client;
            }

            $percent = $tax->percent / 10000; // 5% зберігається у форматі 500, 1% можна ділити на 100 частин
            $this->notification('Warning', $price * $percent . " " . $i);
            $sheet->setCellValue("A{$i}", $price * $percent);
            $sheet->setCellValue("B{$i}", $this->get_full_name_n($pay_buy_client));
            $sheet->setCellValue("C{$i}", $pay_buy_client->tax_code);
            $full_tax_info = $tax->code_and_edrpoy . $pay_buy_client->tax_code . $tax->appointment_payment . $this->get_full_name_n($pay_buy_client);
            $sheet->setCellValue("E{$i}", $full_tax_info);

            $sheet->setCellValue("F{$i}", $tax->mfo);
            $sheet->setCellValue("G{$i}", $tax->bank_account);
            $sheet->setCellValue("H{$i}", $tax->name_recipient);
            $sheet->setCellValue("I{$i}", $tax->okpo);
            $i++;
        }

        $sheet->setCellValue("A8", "покупець");
        $sheet->setCellValue("B8", $this->get_full_name_n($this->client));
        $sheet->setCellValue("C8", $this->client->tax_code);
        $sheet->setCellValue("B9", "продавець");
        $sheet->setCellValue("B9", $this->get_full_name_n($this->contract->dev_company->owner));
        $sheet->setCellValue("C9", $this->contract->dev_company->owner->tax_code);
        $sheet->setCellValue("B10", $this->contract->immovable->address);
        $sheet->setCellValue("B11", $price);
        $sheet->setCellValue("B13", $this->client->phone);

        return $sheet;
    }
}