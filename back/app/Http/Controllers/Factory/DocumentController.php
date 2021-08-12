<?php

namespace App\Http\Controllers\Factory;

use App\Http\Controllers\Rakul\InstallmentController;
use App\Models\BuildingRepresentativeProxy;
use App\Models\CityType;
use App\Models\Client;
use App\Models\ClientContract;
use App\Models\DevCompanyEmployer;
use App\Models\ExchangeRate;
use App\Models\FinalSignDate;
use App\Models\GenderWord;
use App\Models\Installment;
use App\Models\InstallmentPart;
use App\Models\KeyWord;
use App\Models\MainInfoType;
use App\Models\Card;
use App\Models\MonthConvert;
use App\Models\BankTaxesList;
use App\Models\Text;
use App\Models\Service;
use App\Nova\PropertyValuation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\TemplateProcessor;
use ZipArchive;
use File;
use URL;
use DateTime;

class DocumentController extends GeneratorController
{
    public $ff;
    public $convert;
    public $client;
    public $total_clients;
    public $two_clients;
    public $installment;
    public $consent;
    public $bank_account_total_price;
    public $consents_id;
    public $contract_generate_file;
    public $consent_generate_file;
    public $developer_statement_generate_file;
    public $questionnaire_generate_file;
    public $bank_account_generate_file;
    public $bank_taxes_generate_file;
    public $communal_generate_file;
    public $termination_refund_file;
    public $termination_consent_file;
    public $termination_contract_file;
    public $buyer_are_spouse;
    public $style_bold;
    public $style_color;
    public $style_color_and_bold;
    public $style_color_and_italic;
    public $style_end;
    public $style_space_line;
    public $style_space_full_name;
    public $card;
    public $card_id;
    public $paragraph;
    public $company_rate;
    public $both_client_not_married;
    public $contract_type;

    public function __construct($client, $pack_contract, $consents_id, $card_id)
    {
        parent::__construct();

        $this->pack_contract = $pack_contract;

        // Оскільки договір може укладати декілька осіб то передача клієнта з якого почався пошук
        // не дасть змогу утвори декілька заяв згод
        $this->client = null;
        $this->total_clients = null;
        $this->two_clients = false;
//        $this->non_break_space = "</w:t></w:r><w:r><w:t> </w:t></w:r><w:r><w:t>";
        $this->non_break_space = " ";
        $this->convert = new ConvertController($this->non_break_space);
        $this->installment = new InstallmentController();
        $this->consent = null;
        $this->bank_account_total_price = null;
        $this->consents_id = $consents_id;
        $this->contract_generate_file = null;
        $this->consent_generate_file = null;
        $this->developer_statement_generate_file = null;
        $this->questionnaire_generate_file = null;
        $this->bank_account_generate_file = null;
        $this->bank_taxes_generate_file = null;
        $this->communal_generate_file = null;
        $this->termination_refund_file = null;
        $this->termination_consent_file = null;
        $this->termination_contract_file = null;
        $this->buyer_are_spouse = false;
        $this->style_color = "</w:t></w:r><w:r><w:rPr><w:highlight w:val=\"yellow\"/></w:rPr><w:t xml:space=\"preserve\">";
        $this->style_color_red = "</w:t></w:r><w:r><w:rPr><w:highlight w:val=\"red\"/></w:rPr><w:t xml:space=\"preserve\">";
        $this->style_bold = "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Rakul\" w:hAnsi=\"Times New Rakul\" w:cs=\"Times New Rakul\"/><w:b/><w:sz w:val=\"22\"/><w:szCs w:val=\"22\"/></w:rPr><w:t xml:space=\"preserve\">";
        $this->style_color_and_bold = "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Rakul\" w:hAnsi=\"Times New Rakul\" w:cs=\"Times New Rakul\"/><w:b/><w:sz w:val=\"22\"/><w:szCs w:val=\"22\"/><w:highlight w:val=\"yellow\"/></w:rPr><w:t xml:space=\"preserve\">";
        $this->style_color_and_italic = "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Rakul\" w:hAnsi=\"Times New Rakul\" w:cs=\"Times New Rakul\"/><w:i/><w:highlight w:val=\"yellow\"/></w:rPr><w:t xml:space=\"preserve\">";
        $this->style_end = "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Rakul\" w:hAnsi=\"Times New Rakul\" w:cs=\"Times New Rakul\"/><w:sz w:val=\"22\"/><w:szCs w:val=\"22\"/></w:rPr><w:t xml:space=\"preserve\">";
//        $this->non_break_space = "</w:t></w:r><w:r><w:rPr><w:t xml:space=\"preserve\> </w:t></w:rPr></w:r><w:r><w:t xml:space=\"preserve\">";
        $this->paragraph = "</w:t></w:r></w:p><w:p><w:r><w:t>";
        $this->style_space_line = "                                    ";
        $this->style_space_full_name = "                                                                              ";
        $this->card = Card::find($card_id);
        $this->both_client_not_married = false;
        $this->contract_type = false;
    }

    public function creat_files()
    {
        $result = [];

        foreach ($this->pack_contract as $key => $this->contract) {
            $this->ff = new FolderFileController($this->contract);

            $contract_clients = $this->get_contract_clients($this->contract);

            if ($this->contract->type->alias == 'preliminary')
                $this->change_font_size();

            $this->total_clients = count($contract_clients);
            if ($this->total_clients == 2)
                $this->two_clients = true;

            $this->company_rate = $this->get_rate_by_company($this->card->id, $this->contract->immovable->developer_building->dev_company);

            $this->both_client_not_married = $this->check_both_client_not_married($contract_clients);


            foreach ($contract_clients as $this->client) {
                /*
                 * Оскільки в договорі необхідно передати данні про згоду подружжя
                 * або заява про відсутність шлюбних відносин, необхідно виділити одну і єдину згоду або заяву
                 * для підстановки данних в договір cl-sp-word і т.п.
                 * */
                if (count($this->contract->client_spouse_consent) && count($this->contract->client_spouse_consent->where('client_id', $this->client->id))) {
                    if (count($this->contract->client_spouse_consent) == 2) {
                        if ($this->contract->client_spouse_consent[0]->mar_series_num && $this->contract->client_spouse_consent[1]->mar_series_num && $this->contract->client_spouse_consent[0]->mar_series_num == $this->contract->client_spouse_consent[1]->mar_series_num) {
                            $this->buyer_are_spouse = true;
                        }
                    }
                    $this->consent = $this->contract->client_spouse_consent->where('client_id', $this->client->id)->first();
                } else {
                    $this->consent = null;
                }

                if ($this->contract && $this->contract->template_id)
                    $this->contract_template_set_data();
                else
                    $this->notification("Warning", "Контракт відсутній");

                if ($this->contract->questionnaire && $this->contract->questionnaire->template_id)
                    $this->questionnaire_template_set_data();
                else
                    $this->notification("Warning", "Анкета відсутняя");

                if ($this->contract->developer_statement && $this->contract->developer_statement->template_id)
                    $this->developer_statement_template_set_data();
                else
                    $this->notification("Warning", "Заява від забудовника відсутня");

                if ($this->contract->dev_company && $this->contract->dev_company->owner && $this->contract->dev_company->owner->married == false)
                    $this->developer_consent();
                else
                    $this->notification("Warning", "Забудовник в шлюбі");

                if ($this->contract && $this->contract->communal && $this->contract->communal->template_id)
                    $this->communal_template_set_data();
                else
                    $this->notification("Warning", "Коммунальні від забудовника відсутні");

                if ($this->contract && $this->contract->processing_personal_data && $this->contract->processing_personal_data->template_id)
                    $this->processing_personal_data_template_set_data();
                else
                    $this->notification("Warning", "Коммунальні від забудовника відсутні");

                if ($this->contract->bank_account_payment && $this->contract->bank_account_payment->template_id)
                    $this->bank_account_template_set_data();
                else
                    $this->notification("Warning", "Рахунок відсутній");

                if ($this->contract->bank_taxes_payment && $this->contract->bank_taxes_payment->template_id)
                    $this->bank_taxes_template_set_data();
                else
                    $this->notification("Warning", "Податки відсутні");

                if ($this->consent && $this->client && $this->client->client_spouse_consent && $this->client->client_spouse_consent->template_id) {
                    $this->consent_template_set_data();
                    if (($del_consents_id = array_search($this->consent->id, $this->consents_id)) !== false) {
                        unset($this->consents_id[$del_consents_id]);
                    }
                } else {
                    $this->notification("Warning", "Згода подружжя відсутня");
                }

                // додати усі можливі скани документів, які задіяні в угоді
                $this->add_pdf_file();


                $this->total_clients--;
            }

            $termination_clients = $this->get_termination_clients($this->contract->termination_info);

            foreach($termination_clients as $this->client) {
                if ($this->contract->termination_contract && $this->contract->termination_contract->template_id)
                    $this->termination_contract_template_set_data();
                else
                    $this->notification("Warning", "Договір розірвання попереднього договору відсутній");

                if ($this->contract->termination_refund && $this->contract->termination_refund->template_id)
                    $this->termination_refund_template_set_data();
                else
                    $this->notification("Warning", "Заява про повернення коштів згідно попереднього договору");

                if ($this->client && $this->client->termination_consent && $this->client->termination_consent->template_id) {
                    $this->termination_consent_template_set_data();
                } else {
                    $this->notification("Warning", "Згода подружжя на розіврвання попереднього договору відсутня");
                }
            }

            if (file_exists($this->ff->generate_path)) {

                $zip_folder_path_part = 'Zip/';
                $zip = new ZipArchive;

                $fileName = explode("/", $this->ff->generate_path);
                unset($fileName[0]);
                $fileName = implode("/", $fileName);
                $fileName = $fileName . ".zip";

                $fileName = str_replace("/", ": ", $fileName);

                if ($zip->open(public_path($zip_folder_path_part . $fileName), ZipArchive::CREATE) === TRUE)
                {
                    $files = File::files(public_path($this->ff->generate_path));

                    foreach ($files as $key => $value) {
                        $relativeNameInZipFile = $value->getFilename();
                        $zip->addFile($value, $relativeNameInZipFile);
                    }

                    $zip->close();
                }

                $result[] = $zip_folder_path_part .$fileName;
            }
        }

        return $result;
    }

    public function contract_template_set_data()
    {
        $this->contract_type = $this->contract->type->alias;
        $this->contract_generate_file = $this->ff->contract_title();

        $this->convert->date_to_string($this->contract, $this->contract->sign_date);
        // містить шаблон для паспорту
        $this->set_full_info_template($this->contract_generate_file);

        $this->set_spouse_word_template_part($this->contract_generate_file);
        // метод для файлів де використовуються паспортні дані
        // передаєм необхідний шлях до необхідного шаблону
        $this->set_passport_template_part($this->contract_generate_file);

        // Розстрочка
        // тому стоїть на першому місці
        $this->set_installment_table($this->contract_generate_file, $this->contract->immovable);

        // метод тільки для договорів, нема необхідності робити уточнення
        $this->set_current_document_notary($this->contract_generate_file, $this->contract->notary);

        $this->set_sign_date($this->contract_generate_file, $this->contract);
        $word = new TemplateProcessor($this->contract_generate_file);
        $word = $this->set_data_word($word);
        $word->saveAs($this->contract_generate_file);

        unset($word);

        $this->contract_type = null;
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
    }

    public function developer_consent()
    {
        $this->developer_consent_generate_file = $this->ff->developer_consent_title();

        $this->convert->date_to_string($this->contract->dev_company->owner->developer_consent, $this->contract->dev_company->owner->developer_consent->sign_date);
        $this->set_passport_template_part($this->developer_consent_generate_file);
        $this->set_current_document_notary($this->developer_consent_generate_file, $this->contract->dev_company->owner->developer_consent->notary);
        $this->set_sign_date($this->developer_consent_generate_file, $this->contract->dev_company->owner->developer_consent);

        $word = new TemplateProcessor($this->developer_consent_generate_file);
        $word = $this->set_data_word($word);
        $word->saveAs($this->developer_consent_generate_file);

        unset($word);
    }

    public function communal_template_set_data()
    {
        $this->communal_generate_file = $this->ff->communal_title($this->client, $this->contract->communal->template);

        $this->convert->date_to_string($this->contract->communal, $this->contract->communal->sign_date);

        $this->set_passport_template_part($this->communal_generate_file);
        $this->set_current_document_notary($this->communal_generate_file, $this->contract->communal->notary);
        $this->set_sign_date($this->communal_generate_file, $this->contract->communal);

        $word = new TemplateProcessor($this->communal_generate_file);
        $word = $this->set_data_word($word);
        $word->saveAs($this->communal_generate_file);

        unset($word);
    }

    public function processing_personal_data_template_set_data()
    {
        $this->processing_personal_data_generate_file = $this->ff->processing_personal_data_title($this->client, $this->contract->processing_personal_data->template);

        $this->convert->date_to_string($this->contract->processing_personal_data, $this->contract->processing_personal_data->sign_date);

        $this->set_passport_template_part($this->processing_personal_data_generate_file);
        $this->set_current_document_notary($this->processing_personal_data_generate_file, $this->contract->processing_personal_data->notary);
        $this->set_sign_date($this->processing_personal_data_generate_file, $this->contract->processing_personal_data);

        $word = new TemplateProcessor($this->processing_personal_data_generate_file);
        $word = $this->set_data_word($word);
        $word->saveAs($this->processing_personal_data_generate_file);

        unset($word);
    }

    public function termination_contract_template_set_data()
    {
        $this->termination_contract_generate_file = $this->ff->termination_contract_title();

        $this->convert->date_to_string($this->contract->termination_contract, $this->contract->sign_date);

        $this->set_full_info_template($this->termination_contract_generate_file);
        $this->set_spouse_word_template_part($this->termination_contract_generate_file);
        $this->set_passport_template_part($this->termination_contract_generate_file);
        $this->set_current_document_notary($this->termination_contract_generate_file, $this->contract->notary);
        $this->set_sign_date($this->termination_contract_generate_file, $this->contract->termination_contract);

        $word = new TemplateProcessor($this->termination_contract_generate_file);
        $word = $this->set_data_word($word);
        $word->saveAs($this->termination_contract_generate_file);

        unset($word);
    }

    public function termination_refund_template_set_data()
    {
        $this->termination_refund_generate_file = $this->ff->termination_refund_title();

        $this->convert->date_to_string($this->contract->termination_refund, $this->contract->termination_refund->reg_date);

        $this->set_full_info_template($this->termination_refund_generate_file);
        $this->set_passport_template_part($this->termination_refund_generate_file);
        $this->set_current_document_notary($this->termination_refund_generate_file, $this->contract->termination_refund->notary);
        // дату посвідчення заяви у нотаріуса про поверненя коштів беремо з дати підписання договору
        $this->set_sign_date($this->termination_refund_generate_file, $this->contract);

        $word = new TemplateProcessor($this->termination_refund_generate_file);
        $word = $this->set_data_word($word);
        $word->saveAs($this->termination_refund_generate_file);

        unset($word);
    }

    public function consent_template_set_data()
    {
        $this->consent_generate_file = $this->ff->consent_title($this->consent);

        $this->convert->date_to_string($this->consent, $this->consent->sign_date);
        $this->set_spouse_word_template_part($this->consent_generate_file);
        $this->set_passport_template_part($this->consent_generate_file);
        $this->set_current_document_notary($this->consent_generate_file, $this->consent->notary);
        $this->set_consent_married_template_part();
        $this->set_sign_date($this->consent_generate_file, $this->consent);

        $word = new TemplateProcessor($this->consent_generate_file);
        $word = $this->set_data_word($word);
        $word->saveAs($this->consent_generate_file);

        unset($word);
    }

    public function termination_consent_template_set_data()
    {
        $this->termination_consent_generate_file = $this->ff->termination_consent_title($this->client->termination_consent, $this->client);

        $this->convert->date_to_string($this->client->termination_consent, $this->client->termination_consent->sign_date);
        $this->set_passport_template_part($this->termination_consent_generate_file);
        $this->set_current_document_notary($this->termination_consent_generate_file, $this->client->termination_consent->notary);
        $this->set_consent_married_template_part();

        $this->set_sign_date($this->termination_consent_generate_file, $this->client->termination_consent);

        $word = new TemplateProcessor($this->termination_consent_generate_file);
        $word = $this->set_data_word($word);
        $word->saveAs($this->termination_consent_generate_file);

        unset($word);
    }

    public function bank_account_template_set_data()
    {
        $this->bank_account_generate_file = $this->ff->bank_account_title($this->client);

        $this->set_passport_template_part($this->bank_account_generate_file);

        /*
         * В рахунку використовується дата підписання Угоди $this->contract
         * */
        $this->set_sign_date($this->bank_account_generate_file, $this->contract);

        $word = new TemplateProcessor($this->bank_account_generate_file);
        $word = $this->set_data_word($word);
        $word->saveAs($this->bank_account_generate_file);

        unset($word);
    }

    public function bank_taxes_template_set_data()
    {
        if ($this->contract->bank_taxes_payment->template->type == 'excel') {
            $this->bank_taxes_generate_file = $this->ff->bank_taxes_title_excel($this->client);

            $this->set_passport_template_part($this->bank_taxes_generate_file);

            /*
             * В податкових рахунках використовується дата підписання Угоди $this->contract
             * */
            $this->set_sign_date($this->bank_taxes_generate_file, $this->contract);

            // Для Excel
            $spreadsheet = IOFactory::load($this->bank_taxes_generate_file);
            $sheet = $spreadsheet->getActiveSheet();
            if ($this->two_clients)
                $this->set_excel_taxes_data_for_two_clients($sheet);
            else
                $this->set_excel_taxes_data_for_one_client($sheet);
            $writer = new Xlsx($spreadsheet);
            $file_name = $this->bank_taxes_generate_file;
            $writer->save($file_name);

        } elseif ($this->contract->bank_taxes_payment->template->type == 'word') {
            $client_1 = $this->contract->clients[0]->surname_n;
            $client_2 = $this->contract->clients[1]->surname_n;
            $this->bank_taxes_generate_file = $this->ff->bank_taxes_title_word($client_1, $client_2);

            $this->set_passport_template_part($this->bank_taxes_generate_file);

            $this->set_sign_date($this->bank_taxes_generate_file, $this->contract);

            $word = new TemplateProcessor($this->bank_taxes_generate_file);
            $word = $this->set_data_word($word);
            $word->saveAs($this->bank_taxes_generate_file);

            unset($word);
        }
    }

    public function add_pdf_file()
    {
        if ($this->contract && $this->contract->immovable && $this->contract->immovable->proxy) {
            $this->ff->add_proxy_pdf($this->contract->immovable->proxy);
        }

        if ($this->contract && $this->contract->dev_company) {
            $this->ff->add_dev_company_pdf($this->contract->dev_company);
        }

        if ($this->contract && $this->contract->dev_representative) {
            $this->ff->seller_document_pdf($this->contract->dev_representative);
        } elseif ($this->contract && $this->contract->dev_company && $this->contract->dev_company->owner) {
            $this->ff->seller_document_pdf($this->contract->dev_company->owner);
        }

        if ($this->contract && $this->contract->dev_company && $this->contract->dev_representative) {
            $dev_company_employer = DevCompanyEmployer::where('dev_company_id', $this->contract->dev_company->id)->where('employer_id', $this->contract->dev_representative->id)->first();
            if ($dev_company_employer)
                $this->ff->employer_pdf($dev_company_employer);
        }

        if ($this->contract && $this->contract->dev_company && $this->contract->dev_company->owner && $this->contract->dev_company->owner->client_spouse_consent) {
            $this->ff->spouse_consent_pdf($this->contract->dev_company->owner->client_spouse_consent);
        }

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
         * Розстрочка
         * Черз проблему з центами має дублюючі поля інших блоків по цінам
         * тому стоїть на першому місці
         * */
        $word = $this->set_installment_info($word);

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
        $word = $this->set_check_ownership_and_fence_info($word);

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
         * Забезпечувальний платіж до попереднього договору
         * */
        $word = $this->set_termination_info($word);

        /*
         * Забезпечувальний платіж до попереднього договору
         * */
        $word = $this->set_communal_info($word);

        /*
         * Курс долара та посилання на сайт
         * */
        $word = $this->set_exchange_rate($word);

        /*
         * Податки
         * */
        $word = $this->set_taxes_data_for_word($word);

        /*
         * Податки
         * */
        $word = $this->set_bank_account_data($word);

        return $word;
    }

    /*
     * Додати до договору текс-шаблон в пункт згоди подружжя
     * */
    public function set_spouse_word_template_part($template_generate_file)
    {
        $word = new TemplateProcessor($template_generate_file);

        if ($this->contract->dev_company->owner && $this->contract->dev_company->owner->client_spouse_consent) {
            if ($this->contract->dev_company->owner->client_spouse_consent->contract_spouse_word) {
                $word->setValue('ЗГ-ПОДР-ЗБД-ЗАЯВА-ЗГОДА', $this->contract->dev_company->owner->client_spouse_consent->contract_spouse_word->text);
            }
        }


        if ($this->contract->dev_company->owner && $this->contract->dev_company->owner->termination_consent) {
            if ($this->contract->dev_company->owner->termination_consent->termination_spouse_word) {
                $word->setValue('РОЗ-ЗГ-ПОДР-ЗБД-ЗАЯВА-ЗГОДА', $this->contract->dev_company->owner->termination_consent->termination_spouse_word->text);
            }
        }

        if ($this->consent && $this->consent->contract_spouse_word) {

            $cl_sp_word = $this->consent->contract_spouse_word->text;

            if ($this->buyer_are_spouse == false) {
                $word->setValue('ЗАЯВА-ЗГОДА', $cl_sp_word);
                $word->setValue($this->total_clients . '-ЗАЯВА-ЗГОДА', $cl_sp_word);
            } elseif ($this->buyer_are_spouse == true) {
                $word->setValue('2-ЗАЯВА-ЗГОДА', $cl_sp_word);
                $word->setValue('1-ЗАЯВА-ЗГОДА', '');
            }

        } else {
            $this->notification("Warning", "Договір: текс-шаблон пункту згоди подружжя клієнта або ствердження відсутності шлюбних зв'язквів відсутній");
            $word->setValue($this->total_clients . '-ЗАЯВА-ЗГОДА', '');
        }

        if ($this->client->termination_consent && $this->client->termination_consent->termination_spouse_word)
        {
            $termination_sp_word = null;
            if ($this->total_clients > 1) {
                $termination_sp_word = $this->client->termination_consent->termination_spouse_word->text . $this->paragraph . "\${РОЗ-КЛ-ЗАЯВА-ЗГОДА}";
            }
            else {
                $termination_sp_word = $this->client->termination_consent->termination_spouse_word->text;
            }
            $word->setValue('РОЗ-КЛ-ЗАЯВА-ЗГОДА', $termination_sp_word);
        }

        $word->saveAs($template_generate_file);


        if ($this->consent && $this->consent->widow) {
            $word = new TemplateProcessor($template_generate_file);
            $widowhood = MainInfoType::where('alias', 'widow-date')->value('description');
            $word->setValue('ВДІВСТВО-ДАТА', $widowhood . ",$this->non_break_space");
            $word->saveAs($template_generate_file);
        } else {
            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('ВДІВСТВО-ДАТА', '');
            $word->saveAs($template_generate_file);
        }
    }

    public function set_full_info_template($template_generate_file)
    {
        $word = new TemplateProcessor($template_generate_file);

        /*
         * Додати шаблон для даних забудовника так підписанта або чисто шаблон для забудовника
         * */
        if ($this->card->dev_representative) {
            $dev_full_description = MainInfoType::where('alias', 'developer-full-dev-and-dev-representative')->value('description');
        } else {
            $dev_full_description = MainInfoType::where('alias', 'developer-full-name-tax-code-id-card-address')->value('description');
        }

        $word->setValue('ЗБД-ПІБ-ПАСПОРТ-КОД-АДРЕСА', $dev_full_description);

        /*
         * Додати шаблон для даних представника так покупця або чисто шаблон покупця
         * */
        if ($this->client->representative && $this->client->representative->confidant_id) {
            $full_description = MainInfoType::where('alias', 'full-client-and-representative-confidant')->value('description');
            $preliminary_full_description = MainInfoType::where('alias', 'preliminary-full-client-and-representative-confidant')->value('description');
        }
        else {
            $full_description = MainInfoType::where('alias', 'full-name-tax-code-id-card-address')->value('description');
            $preliminary_full_description = MainInfoType::where('alias', 'preliminary-full-name-tax-code-id-card-address')->value('description');
        }

        /*
         * Дані заповнюються в циклі для кожного клієнта окремо,
         * в договір додається новий шаблон для наступного клієнта
         * якщо він є
         * */
        if ($this->total_clients > 1) {
            $full_description = $full_description . ", \${КЛ-ОД-ПІБ-ПАСПОРТ-КОД-АДРЕСА}";
            $preliminary_full_description = $preliminary_full_description . ", \${КЛ-ПД-ПІБ-ПАСПОРТ-КОД-АДРЕСА}";
        }

        $word->setValue('full-name-tax-code-id-card-address', $full_description);
        $word->setValue('ПІБ-ПАСПОРТ-КОД-АДРЕСА', $full_description);
        $word->setValue('КЛ-ПІБ-ПАСПОРТ-КОД-АДРЕСА', $full_description);
        $word->setValue('КЛ-ОД-ПІБ-ПАСПОРТ-КОД-АДРЕСА', $full_description);
        $word->setValue('КЛ-ПД-ПІБ-ПАСПОРТ-КОД-АДРЕСА', $preliminary_full_description);

        /*
         * Лінія для області підпису
         * */
        $sign_area_line = MainInfoType::where('alias', 'sign-area-line')->value('description');

        /*
         * Шаблон в залежності хто підписує, покупець чи його представник
         * */
        if ($this->client->representative) {
            // проміжок стає коротшим
            $this->style_space_full_name = "                                           ";
            $sign_area_full_name = MainInfoType::where('alias', 'sign-area-representative-client-full-name')->value('description');
        } else {
            $sign_area_full_name = MainInfoType::where('alias', 'sign-area-full-name')->value('description');
        }

        /*
         * Додати абзац через стиль XML Word
         * та в залежності від кількості
         * додати наступний шаблон для підпису
         * */
        if ($this->total_clients > 1) {
//            $sign_area = $sign_area_line . "<w:br/>" . $this->style_space_full_name . $sign_area_full_name . "<w:br/><w:br/>" . $this->style_space_line . "\${sign-area}";
            $sign_area = $sign_area_line . $this->paragraph . $sign_area_full_name . $this->paragraph . $this->paragraph . "\${sign-area}";
        } else {
//            $sign_area = $sign_area_line . "<w:br/>" . $this->style_space_full_name . $sign_area_full_name;
            $sign_area = $sign_area_line . $this->paragraph . $sign_area_full_name;
        }

        $word->setValue('MІСЦЕ-ПІДПИСУ', $sign_area);

        /*
         * Предаставник покупця - підставити шаблон нотаріальних данних довіреності
         * */
        $cr_ntr_representative_client = MainInfoType::where('alias', 'cr-ntr-representative-client')->value('description');

        $word->setValue('cr-ntr-representative-client-up', $this->mb_ucfirst($cr_ntr_representative_client));

        // Підставка реквізититів в ПД з представника клієнта
        if ($this->client->representative) {
            $client_and_representative_confidant_details = MainInfoType::where('alias', 'client-and-representative-confidant-details')->value('description');
            $word->setValue('ПРЕДСТАВНИК-КЛ', $client_and_representative_confidant_details);
            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ', $client_and_representative_confidant_details);
        } else {
            $word->setValue('ПРЕДСТАВНИК-КЛ', '');
            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ', '');
        }

        $word->saveAs($template_generate_file);
    }

    public function set_passport_template_part($template_generate_file)
    {
        /*
         * Внесення текстового шаблону паспортних данних ЗАБУДОВНИКА для поспортных даннх в генеруэмий документ
         * */
        if ($this->contract->dev_company && $this->contract->dev_company->owner) {
            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('ЗБД-ПАСПОРТ-Н', $this->contract->dev_company->owner->passport_type->description_n);
            $word->setValue('ЗБД-ПАСПОРТ-О', $this->contract->dev_company->owner->passport_type->description_o);
            $word->setValue('ЗБД-ПАСПОРТ-Н-UP', $this->mb_ucfirst($this->contract->dev_company->owner->passport_type->description_n));
            $word->setValue('ЗБД-ПАСПОРТ-О-UP', $this->mb_ucfirst($this->contract->dev_company->owner->passport_type->description_o));
            $word->setValue('ЗБД-ПАСПОРТ-ID-КОД', $this->contract->dev_company->owner->passport_type->short_info);
            $word->saveAs($template_generate_file);

            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('pssprt-code', str_replace(" ", $this->non_break_space, $this->contract->dev_company->owner->passport_code));
            $word->setValue('pssprt-date', $this->display_date($this->contract->dev_company->owner->passport_date));
            $word->setValue('pssprt-depart', $this->contract->dev_company->owner->passport_department);
            $word->setValue('pssprt-demogr', $this->contract->dev_company->owner->passport_demographic_code);
            $word->saveAs($template_generate_file);

        } else {
            $this->notification("Warning", "Паспортний шаблон: данні забудовника відсутні");
        }

        /*
         * Внесення текстового шаблону паспортних данних ПІДПИСАНТА для поспортных даннх в генеруэмий документ
         * */
        if ($this->contract->dev_representative) {
            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('ПІДПИС-ПАСПОРТ-ID-КОД', $this->contract->dev_representative->passport_type->short_info);
            $word->setValue('ПІДПИС-ПАСПОРТ-Н-UP', $this->mb_ucfirst($this->contract->dev_representative->passport_type->description_n));
            $word->setValue('ПІДПИС-ПАСПОРТ-О', $this->contract->dev_representative->passport_type->description_o);
            $word->saveAs($template_generate_file);

            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('pssprt-code', str_replace(" ", $this->non_break_space, $this->contract->dev_representative->passport_code));
            $word->setValue('pssprt-date', $this->display_date($this->contract->dev_representative->passport_date));
            $word->setValue('pssprt-depart', $this->contract->dev_representative->passport_department);
            $word->setValue('pssprt-demogr', $this->contract->dev_representative->passport_demographic_code);
            $word->saveAs($template_generate_file);
        } else {
            $this->notification("Warning", "Паспортний шаблон: данні підписанта відсутні");
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
            $word->setValue('pssprt-code', str_replace(" ", $this->non_break_space, $this->contract->immovable->developer_building->investment_agreement->investor->passport_code));
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
            $word->setValue('КЛ-ПАСПОРТ-Н', $this->client->passport_type->description_n);
            $word->setValue('КЛ-ПАСПОРТ-О', $this->client->passport_type->description_o);
            $word->setValue('КЛ-ПАСПОРТ-Н-UP', $this->mb_ucfirst($this->client->passport_type->description_n));
            $word->setValue('КЛ-ПАСПОРТ-О-UP', $this->mb_ucfirst($this->client->passport_type->description_o));
            $word->setValue('КЛ-ПАСПОРТ-ID-КОД', $this->client->passport_type ? $this->client->passport_type->short_info . " " : '');
            $word->setValue('КЛ-ДН', $this->display_date($this->client->birth_date));
            // для анкет на двох
            $word->setValue($this->total_clients . '-КЛ-ПАСПОРТ-Н', $this->client->passport_type->description_n);
            $word->setValue($this->total_clients . '-КЛ-ПАСПОРТ-Н-UP', $this->mb_ucfirst($this->client->passport_type->description_n));
            $word->setValue($this->total_clients . '-КЛ-ПАСПОРТ-О', $this->client->passport_type->description_o);
            $word->setValue($this->total_clients . '-КЛ-ДН', $this->display_date($this->client->birth_date));

            $word->saveAs($template_generate_file);

            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('pssprt-code', str_replace(" ", $this->non_break_space, $this->client->passport_code));
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
            $word->setValue('ПРЕДСТАВНИК-КЛ-ПАСПОРТ-Н', $this->client->representative->confidant->passport_type->description_n);
            $word->setValue('ПРЕДСТАВНИК-КЛ-ПАСПОРТ-О', $this->client->representative->confidant->passport_type->description_o);
            $word->setValue('ПРЕДСТАВНИК-КЛ-ПАСПОРТ-Н-UP', $this->mb_ucfirst($this->client->representative->confidant->passport_type->description_n));
            $word->setValue('ПРЕДСТАВНИК-КЛ-ПАСПОРТ-О-UP', $this->mb_ucfirst($this->client->representative->confidant->passport_type->description_o));
            $word->setValue('ПРЕДСТАВНИК-КЛ-ПАСПОРТ-ID-КОД', $this->client->representative->confidant->passport_type ? $this->client->representative->confidant->passport_type->short_info . " " : '');

            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ПАСПОРТ-Н', $this->client->representative->confidant->passport_type->description_n);
            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ПАСПОРТ-О', $this->client->representative->confidant->passport_type->description_o);
            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ПАСПОРТ-Н-UP', $this->mb_ucfirst($this->client->representative->confidant->passport_type->description_n));
            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ПАСПОРТ-О-UP', $this->mb_ucfirst($this->client->representative->confidant->passport_type->description_o));
            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ПАСПОРТ-ID-КОД', $this->client->representative->confidant->passport_type ? $this->client->representative->confidant->passport_type->short_info . " " : '');

            $word->saveAs($template_generate_file);

            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('pssprt-code', str_replace(" ", $this->non_break_space, $this->client->representative->confidant->passport_code));
            $word->setValue('pssprt-date', $this->display_date($this->client->representative->confidant->passport_date));
            $word->setValue('pssprt-depart', $this->client->representative->confidant->passport_department);
            $word->setValue('pssprt-demogr', $this->client->representative->confidant->passport_demographic_code);
            $word->saveAs($template_generate_file);
        } else {
            $this->notification("Warning", "Паспортний шаблон: данні представника покупця відсутні");
        }

        /*
         * Внесення текстового шаблону паспортних данних ПОДРУЖЖЯ КЛІЄНТА для поспортных даннх в генеруэмий документ
         * */

        if ($this->client->married && $this->client->married->spouse && $this->client->married->spouse->passport_type) {
            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('ПОД-ПАСПОРТ-Н', $this->client->married->spouse->passport_type->description_n);
            $word->setValue('ПОД-ПАСПОРТ-О', $this->client->married->spouse->passport_type->description_o);
            $word->setValue('ПОД-ПАСПОРТ-Н-UP', $this->mb_ucfirst($this->client->married->spouse->passport_type->description_n));
            $word->setValue('ПОД-ПАСПОРТ-О-UP', $this->mb_ucfirst($this->client->married->spouse->passport_type->description_o));
            $word->setValue('ПОД-ПАСПОРТ-ID-КОРОТКО', $this->client->married->spouse->passport_type->short_info);
            $word->saveAs($template_generate_file);

            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('pssprt-code', str_replace(" ", $this->non_break_space, $this->client->married->spouse->passport_code));
            $word->setValue('pssprt-date', $this->display_date($this->client->married->spouse->passport_date));
            $word->setValue('pssprt-depart', $this->client->married->spouse->passport_department);
            $word->setValue('pssprt-demogr', $this->client->married->spouse->passport_demographic_code);
            $word->saveAs($template_generate_file);
        } else {
            $this->notification("Warning", "Паспортний шаблон: данні подружжя відсутні");
        }

        if ($this->contract->immovable->developer_building->investment_agreement && $this->contract->immovable->developer_building->investment_agreement->investor) {
            $investor = $this->contract->immovable->developer_building->investment_agreement->investor;
            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('ІНВ-ПАСПОРТ-Н', $investor->passport_type->description_n);
            $word->saveAs($template_generate_file);

            $word = new TemplateProcessor($template_generate_file);
            $word->setValue('pssprt-code', str_replace(" ", $this->non_break_space, $investor->passport_code));
            $word->setValue('pssprt-date', $this->display_date($investor->passport_date));
            $word->setValue('pssprt-depart', $investor->passport_department);
            $word->setValue('pssprt-demogr', $investor->passport_demographic_code);
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

            $word->setValue('НОТ-ПІБ-ІНІЦІАЛИ-Н', $this->convert->get_surname_and_initials_n($notary));
            $word->setValue('НОТ-ПІБ-ІНІЦІАЛИ-Р', $this->convert->get_surname_and_initials_r($notary));
            $word->setValue('НОТ-ПІБ-ІНІЦІАЛИ-Д', $this->convert->get_surname_and_initials_d($notary));
            $word->setValue('НОТ-ПІБ-ІНІЦІАЛИ-О', $this->convert->get_surname_and_initials_o($notary));

            $word->setValue('НОТ-ІНІЦІАЛИ-ПІБ-Н', $this->convert->get_initials_and_surname_n($notary));
            $word->setValue('НОТ-ІНІЦІАЛИ-ПІБ-О', $this->convert->get_initials_and_surname_o($notary));

            $word->setValue('НОТ-АКТ-Н', $notary->activity_n);
            $word->setValue('НОТ-АКТ-Р', $notary->activity_r);
            $word->setValue('НОТ-АКТ-Д', $notary->activity_d);
            $word->setValue('НОТ-АКТ-О', $notary->activity_o);

            $word->setValue('НОТ-АКТ-Н-UP', $this->mb_ucfirst($notary->activity_n));
            $word->setValue('НОТ-АКТ-Р-UP', $this->mb_ucfirst($notary->activity_r));
            $word->setValue('НОТ-АКТ-Д-UP', $this->mb_ucfirst($notary->activity_d));
            $word->setValue('НОТ-АКТ-О-UP', $this->mb_ucfirst($notary->activity_o));

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

        $word->setValue('ДАТА-ЦИФРАМИ', $this->display_date($document->sign_date));

        if ($document->sign_date) {
            $days = $this->convert->next_three_work_banking_days($document->sign_date);
            $word->setValue('ДАТА-СПЛАТИ+3', $this->day_quotes_month_year($document->sign_date->addDays($days)));
        }

        if ($document->str_day && $document->str_month && $document->str_year)
            $word->setValue('ДАТА-СЛОВАМИ-UP', $this->mb_ucfirst($document->str_day->title . " " . $document->str_month->title_r . " " . $document->str_year->title_r));
        if ($document->str_day && $document->str_month && $document->str_year)
        $word->setValue('ДАТА-СЛОВАМИ', $document->str_day->title . " " . $document->str_month->title_r . " " . $document->str_year->title_r);

        $word->setValue('ДАТА-МС', $this->day_quotes_month_year($document->sign_date));
        if ($document->sign_date)
            $word->setValue('ДАТА-МС+1М', $this->day_quotes_month_year($document->sign_date->addMonths(1)));

        $word->setValue('ЗБРН-Н-ДАТА', $this->display_date($document->sign_date));
        $word->setValue('ЗБРН-ЗАБ-ДАТА', $this->display_date($document->sign_date));
        $word->saveAs($template);
    }

    public function set_contract_data($word)
    {
        /*
         * Для попереднього договору вноситься дата підписання основного договору
         * */
        if ($final_sing_date = FinalSignDate::where('contract_id', $this->contract->id)->first()) {
            $word->setValue('con-final-date-qd-m', $this->day_quotes_month_year($final_sing_date->sign_date));

            if ($final_sing_date->sign_date > $this->contract->sign_date) {
                $word->setValue('ОД-ДАТА', $this->day_quotes_month_year($final_sing_date->sign_date));
            }
        } else {
            if ($this->contract->immovable->developer_building && $this->contract->immovable->developer_building->communal_date)
                $word->setValue('ОД-ДАТА', $this->day_quotes_month_year($this->contract->immovable->developer_building->communal_date));
            else
                $word->setValue('ОД-ДАТА', $this->set_style_color_warning("######"));
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
            $word->setValue('ЗБД-ГРОМАДЯН', $this->convert->get_client_citizenship_n($this->contract->dev_company->owner));
            $word->setValue('ЗБД-ГРОМАДЯН-Н', $this->convert->get_client_citizenship_n($this->contract->dev_company->owner));
            $word->setValue('ЗБД-ГРОМАДЯН-Р', $this->convert->get_client_citizenship_r($this->contract->dev_company->owner));
            $word->setValue('ЗБД-ГРОМАДЯН-Р-UP', $this->mb_ucfirst($this->convert->get_client_citizenship_r($this->contract->dev_company->owner)));
            $word->setValue('ЗБД-ПРІЗВ-Н', $this->contract->dev_company->owner->surname_n);
            $word->setValue('ЗБД-ПРІЗВ-Н-UP', mb_strtoupper($this->contract->dev_company->owner->surname_n));
            $word->setValue('ЗБД-ІМЯ-Н', $this->contract->dev_company->owner->name_n);
            $word->setValue('ЗБД-ІМЯ-Н-UP', mb_strtoupper($this->contract->dev_company->owner->name_n));
            $word->setValue('ЗБД-ПОБАТЬК-Н', $this->contract->dev_company->owner->patronymic_n);
            $word->setValue('ЗБД-ДН', $this->display_date($this->contract->dev_company->owner->birth_date));

            $word->setValue('ЗБД-ПІБ-Н', $this->convert->get_full_name_n($this->contract->dev_company->owner));
            $word->setValue('ЗБД-ПІБ-Н-Ж', $this->set_style_bold($this->convert->get_full_name_n($this->contract->dev_company->owner)));
            $word->setValue('ЗБД-ПІБ-Р', $this->convert->get_full_name_r($this->contract->dev_company->owner));
            $word->setValue('ЗБД-ПІБ-Д', $this->convert->get_full_name_d($this->contract->dev_company->owner));
            $word->setValue('ЗБД-ПІБ-О', $this->convert->get_full_name_o($this->contract->dev_company->owner));
            $word->setValue('ЗБД-ПІБ-Н-I', $this->convert->get_full_name_n($this->contract->dev_company->owner));
            $word->setValue('ЗБД-ПІБ-Р-I', $this->convert->get_full_name_r($this->contract->dev_company->owner));
            $word->setValue('ЗБД-ІПН', $this->contract->dev_company->owner->tax_code);
            $word->setValue('ЗБД-ІПН-Ж', $this->set_style_bold($this->contract->dev_company->owner->tax_code));
            $word->setValue('ЗБД-ПАСПОРТ-ID-КОД', $this->contract->dev_company->owner->passport_type->short_info);

            if ($this->contract->dev_company->owner->registration)
                $dev_registration = GenderWord::where('alias', "registration")->value($this->contract->dev_company->owner->gender);
            else
                $dev_registration = GenderWord::where('alias', "reside")->value($this->contract->dev_company->owner->gender);
            $word->setValue('ЗБД-ЗАРЕЄСТР', $dev_registration);

            $word->setValue('ЗБД-П-АДР-СК', $this->convert->client_full_address_short($this->contract->dev_company->owner));

            $dev_gender_which_adjective = GenderWord::where('alias', "which")->value($this->contract->dev_company->owner->gender);
            $word->setValue('ЗБД-ЯК', $dev_gender_which_adjective);

            $dev_gender_whose = GenderWord::where('alias', "whose")->value($this->contract->dev_company->owner->gender);
            $word->setValue('ЗБД-ЇХ', $dev_gender_whose);
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
            if ($this->contract->dev_company->owner->married->spouse) {

                $dev_spouse_type_by_gender = KeyWord::where('key', $this->contract->dev_company->owner->married->spouse->gender)->value('title_o');
                $word->setValue('ЗГ-ПОДР-ЗБД-РОЛЬ-О-UP', $this->mb_ucfirst($dev_spouse_type_by_gender));
                $word->setValue('ЗГ-ПОДР-ЗБД-ПІБ-О', $this->convert->get_full_name_o($this->contract->dev_company->owner->married->spouse));

                $dev_spouse_gender_whose = GenderWord::where('alias', "whose")->value($this->contract->dev_company->owner->married->spouse->gender);
                $word->setValue('ЗГ-ПОДР-ЗБД-ЇХ', $dev_spouse_gender_whose);
                $word->setValue('ЗГ-ПОДР-ЗБД-НОТ-ПІБ-О', $this->convert->get_surname_and_initials_o($this->contract->dev_company->owner->client_spouse_consent->notary));
                $word->setValue('ЗГ-ПОДР-ЗБД-НОТ-АКТИВНІСТЬ-О', $this->contract->dev_company->owner->client_spouse_consent->notary->activity_o);
                $word->setValue('ЗГ-ПОДР-ЗБД-НОТ-ДАТА', $this->display_date($this->contract->dev_company->owner->client_spouse_consent->sign_date));
                $word->setValue('ЗГ-ПОДР-ЗБД-НОТ-НОМЕР', $this->contract->dev_company->owner->client_spouse_consent->reg_num);
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
            $investment_agreement = $this->contract->immovable->developer_building->investment_agreement;

            if ($investment_agreement->investor->gender == "male") {
                $citizen_o = KeyWord::where('key', "citizen_male")->value('title_o');
            } else {
                $citizen_o = KeyWord::where('key', "citizen_female")->value('title_o');
            }

            $word->setValue('ІНВ-НОМЕР', $investment_agreement->number);
            $word->setValue('ІНВ-ДАТА', $this->display_date($investment_agreement->date));
            $word->setValue('ІНВ-ГРОМАД', $citizen_o);

            if ($investment_agreement->investor->gender == "male") {
                $citizen_n = KeyWord::where('key', "citizen_male")->value('title_n');
            } else {
                $citizen_n = KeyWord::where('key', "citizen_female")->value('title_n');
            }

            $word->setValue('ІНВ-ГРОМАД-Н', $citizen_n);

            if ($investment_agreement->investor->gender)
                $inv_registration = GenderWord::where('alias', "registration")->value($investment_agreement->investor->gender);
            else
                $inv_registration = GenderWord::where('alias', "reside")->value($investment_agreement->investor->gender);
            $word->setValue('ІНВ-ЗАРЕЄСТР', $inv_registration);
            $word->setValue('ІНВ-ЯК', GenderWord::where('alias', "which-adjective")->value($investment_agreement->investor->gender));
            $word->setValue('ІНВ-ПІБ', $this->convert->get_full_name_n($investment_agreement->investor));
            $word->setValue('ІНВ-ПІБ-Н', $this->convert->get_full_name_n($investment_agreement->investor));
            $word->setValue('ІНВ-ПІБ-О', $this->convert->get_full_name_o($investment_agreement->investor));
            $word->setValue('ІНВ-ПІБ-Р', $this->convert->get_full_name_r($investment_agreement->investor));
            $word->setValue('ІНВ-ІПН', $investment_agreement->investor->tax_code);
            $word->setValue('ІНВ-П-АДР', $this->convert->get_client_full_address_n($investment_agreement->investor));
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
            $word->setValue('ПРОДАВЕЦЬ-Н', mb_strtoupper(Text::where('alias', 'representative-seller-n')->value('value')));
            $word->setValue('ПРОДАВЕЦЬ-Р', mb_strtoupper(Text::where('alias', 'representative-seller-r')->value('value')));
        } else {
            $word->setValue('ПРОДАВЕЦЬ-Н', mb_strtoupper(Text::where('alias', 'seller-n')->value('value')));
            $word->setValue('ПРОДАВЕЦЬ-Р', mb_strtoupper(Text::where('alias', 'seller-r')->value('value')));
        }

        if ($this->contract->dev_company && $this->contract->dev_company->owner && $this->contract->dev_representative
            && $this->contract->dev_company->owner->tax_code == $this->contract->dev_representative->tax_code) {
            return $word;
        }

        if ($this->contract && $this->contract->dev_representative) {

            $word->setValue('ПІДПИС-ГРОМАДЯН', $this->convert->get_client_citizenship_n($this->contract->dev_representative));
            $word->setValue('ПІДПИС-ГРОМАДЯН-Н', $this->convert->get_client_citizenship_n($this->contract->dev_representative));
            $word->setValue('ПІДПИС-ГРОМАДЯН-Р', $this->convert->get_client_citizenship_r($this->contract->dev_representative));
            $word->setValue('ПІДПИС-ГРОМАДЯН-Р-UP', $this->mb_ucfirst($this->convert->get_client_citizenship_r($this->contract->dev_representative)));
            $word->setValue('ПІДПИС-ПРІЗВ-Н', $this->contract->dev_representative->surname_n);
            $word->setValue('ПІДПИС-ПРІЗВ-Н-UP', mb_strtoupper($this->contract->dev_representative->surname_n));
            $word->setValue('ПІДПИС-ІМЯ-Н', $this->contract->dev_representative->name_n);
            $word->setValue('ПІДПИС-ІМЯ-Н-UP', mb_strtoupper($this->contract->dev_representative->name_n));
            $word->setValue('ПІДПИС-ПОБАТЬК-Н', $this->contract->dev_representative->patronymic_n);

            $word->setValue('ПІДПИС-ПІБ-Н', $this->convert->get_full_name_n($this->contract->dev_representative));
            $word->setValue('ПІДПИС-ПІБ-Н-Ж', $this->set_style_bold($this->convert->get_full_name_n($this->contract->dev_representative)));
            $word->setValue('ПІДПИС-ПІБ-Р', $this->convert->get_full_name_r($this->contract->dev_representative));
            $word->setValue('ПІДПИС-ІПН', $this->contract->dev_representative->tax_code);
            $word->setValue('ПІДПИС-ІПН-Ж', $this->set_style_bold($this->contract->dev_representative->tax_code));
            $word->setValue('ПІДПИС-ДН', $this->display_date($this->contract->dev_representative->birth_date));

            $word->setValue('ПІДПИС-П-АДР-СК', $this->convert->client_full_address_short($this->contract->dev_representative));
            $word->setValue('ПІДПИС-ПОВНА-АДРЕСА', $this->convert->get_client_full_address_n($this->contract->dev_representative));

            if ($this->contract->dev_representative->gender)
                $dev_representative_registration = GenderWord::where('alias', "registration")->value($this->contract->dev_representative->gender);
            else
                $dev_representative_registration = GenderWord::where('alias', "reside")->value($this->contract->dev_representative->gender);
            $word->setValue('ПІДПИС-ЗАРЕЄСТР', $dev_representative_registration);

            $dev_gender_which_adjective = GenderWord::where('alias', "which-adjective")->value($this->contract->dev_representative->gender);
            $word->setValue('ПІДПИС-ЯК', $dev_gender_which_adjective);

            $dev_rep_gender_whose = GenderWord::where('alias', "whose")->value($this->contract->dev_representative->gender);
            $word->setValue('ПІДПИС-ЇХ', $dev_rep_gender_whose);

            $dev_rep_gender_acquainted = GenderWord::where('alias', "acquainted")->value($this->contract->dev_representative->gender);
            $word->setValue('ПІДПИС-ОЗНАЙ', $dev_rep_gender_acquainted);

            $building_id = $this->contract->immovable->developer_building_id;
            $dev_representative_id = $this->contract->dev_representative->id;

            if ($this->contract->immovable->proxy) {
                $proxy_id = $this->contract->immovable->proxy->id;

                $proxy = BuildingRepresentativeProxy::get_proxy($building_id, $dev_representative_id, $proxy_id);

                /*
                 * PROXY - довіреність тільки якщо є Представник
                 * */
                $word->setValue('ЗБД-ДОВ-НОТ-ПІБ-О', $this->convert->get_surname_and_initials_o($this->contract->immovable->proxy->notary));
                $word->setValue('ЗБД-ДОВ-НОТ-АКТИВНІСТЬ-О', $this->contract->immovable->proxy->notary->activity_o);

                $word->setValue('ЗБД-ДОВ-НОТ-ДАТА', $this->display_date($this->contract->immovable->proxy->reg_date));
                $word->setValue('ЗБД-ДОВ-НОТ-НОМЕР', $this->contract->immovable->proxy->reg_num);
            }
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
        if ($this->client && $this->client->gender) {
            /*
             * Клієнт - ПІБ
             * */
            $word->setValue('КЛ-ГРОМАДЯН-Н', $this->convert->get_client_citizenship_n($this->client));
            $word->setValue('КЛ-ГРОМАДЯН-Р', $this->convert->get_client_citizenship_r($this->client));
            $word->setValue('КЛ-ГРОМАДЯН-Р-UP', $this->mb_ucfirst($this->convert->get_client_citizenship_r($this->client)));

            $word->setValue($this->total_clients . '-КЛ-ГРОМАДЯН-Н', $this->convert->get_client_citizenship_n($this->client));
            $word->setValue($this->total_clients . '-КЛ-ГРОМАДЯН-Р', $this->convert->get_client_citizenship_r($this->client));
            $word->setValue($this->total_clients . '-КЛ-ГРОМАДЯН-Р-UP', $this->mb_ucfirst($this->convert->get_client_citizenship_r($this->client)));

//            $word->setValue('cl-full-name-n', $this->convert->get_full_name_n($this->client));
            $word->setValue('КЛ-ПІБ', $this->convert->get_full_name_n($this->client));
            $word->setValue('КЛ-ПІБ-ПІДПИС', $this->convert->get_full_name_n_for_sing_area($this->client));
            $word->setValue('КЛ-ІНІЦ-ПРІЗВ', $this->convert->get_initials_and_surname_n($this->client));
            $word->setValue('КЛ-ПІБ-Н', $this->convert->get_full_name_n($this->client));
            $word->setValue('КЛ-ПІБ-Н-ПІДПИС', $this->convert->get_full_name_n_for_sing_area($this->client));
            $word->setValue($this->total_clients . '-КЛ-ПІБ-Н-ПІДПИС', $this->convert->get_full_name_n_for_sing_area($this->client));
            $word->setValue($this->total_clients . '-КЛ-ПІБ-ПІДПИС', $this->convert->get_full_name_n_for_sing_area($this->client));
            $word->setValue($this->total_clients . '-КЛ-ПІБ-Н', $this->convert->get_full_name_n($this->client));
            $word->setValue($this->total_clients . '-КЛ-ПІБ-Р', $this->convert->get_full_name_r($this->client));
            $word->setValue('КЛ-ПІБ-О', $this->convert->get_full_name_o($this->client));
            $word->setValue('КЛ-ПІБ-Р', $this->convert->get_full_name_r($this->client));
            $word->setValue('КЛ-ПІБ-Д', $this->convert->get_full_name_d($this->client));
            $word->setValue('КЛ-ПІБ-ВЕЛИКИМИ-БУКВАМИ', $this->convert->get_full_name_n_upper($this->client));
            $word->setValue($this->total_clients . '-КЛ-ПІБ-ВЕЛИКИМИ-БУКВАМИ', $this->convert->get_full_name_n_upper($this->client));

            $word->setValue('КЛ-ПРІЗВ-Н', $this->client->surname_n);
            $word->setValue('КЛ-ІМЯ-Н', $this->client->name_n);
            $word->setValue('КЛ-ПОБАТЬК-Н', $this->client->patronymic_n);

            $word->setValue('КЛ-ПІБ-Н-Ж', $this->set_style_bold($this->convert->get_full_name_n($this->client)));

            $word->setValue('КЛ-ШЛ-РОЛЬ-Р', KeyWord::where('key', $this->client->gender)->value('title_r'));
            $word->setValue('КЛ-ШЛ-РОЛЬ-Р-UP', $this->mb_ucfirst(KeyWord::where('key', $this->client->gender)->value('title_r')));

            $word->setValue('КЛ-ШЛ-РОЛЬ-О', KeyWord::where('key', $this->client->gender)->value('title_o'));
            $word->setValue('КЛ-ШЛ-РОЛЬ-О-UP', $this->mb_ucfirst(KeyWord::where('key', $this->client->gender)->value('title_o')));

            if ($this->client->married)
                $cs_agree = GenderWord::where('alias', "agree")->value($this->client->married->spouse->gender);
            else
                $cs_agree = null;
            $word->setValue('ПОД-ЗГОД', $cs_agree);

            if ($this->client->married && $this->client->married->spouse)
                $cl_gender_pronoun = GenderWord::where('alias', "whose")->value($this->client->married->spouse->gender);
            else
                $cl_gender_pronoun = null;

            if ($this->client->married || $this->buyer_are_spouse == true)
                $word->setValue('КОШТИ-ТИП', "сімейні");
            else
                $word->setValue('КОШТИ-ТИП', "особисті");

            $cl_gender_whose = GenderWord::where('alias', "whose")->value($this->client->gender);

            $word->setValue('КЛ-ЇХ', $cl_gender_whose);
            $word->setValue('КЛ-ЇХ-UP', $this->mb_ucfirst($cl_gender_whose));

            $cl_gender_him_her = GenderWord::where('alias', "him-her")->value($this->client->gender);

            $word->setValue('КЛ-НИМ', $cl_gender_him_her);
            $word->setValue('КЛ-НИМ-UP', $this->mb_ucfirst($cl_gender_him_her));

            $cl_gender_proved = GenderWord::where('alias', "proved")->value($this->client->gender);
            $word->setValue('КЛ-ДОВІВ', $cl_gender_proved);
            $word->setValue('КЛ-ДОВІВ-UP', $this->mb_ucfirst($cl_gender_proved));

            $cl_gender_received = GenderWord::where('alias', "received")->value($this->client->gender);
            $word->setValue('КЛ-ОТРИМАТИ', $cl_gender_received);
            $word->setValue('КЛ-ОТРИМАТИ', $this->mb_ucfirst($cl_gender_received));

            if ($this->client->registration)
                $cl_registration = GenderWord::where('alias', "registration")->value($this->client->gender);
            else
                $cl_registration = GenderWord::where('alias', "reside")->value($this->client->gender);

            $word->setValue('КЛ-ЗАРЕЄСТР', $cl_registration);
            $word->setValue($this->total_clients . '-КЛ-ЗАРЕЄСТР', $cl_registration);

            $cl_gender_which = GenderWord::where('alias', "which")->value($this->client->gender);
            $word->setValue('КЛ-ЯКИХ', $cl_gender_which);

            $cl_gender_acquainted = GenderWord::where('alias', "acquainted")->value($this->client->gender);
            $word->setValue('КЛ-ОЗНАЙ', $cl_gender_acquainted);

            $cl_gender_informed = GenderWord::where('alias', "informed")->value($this->client->gender);
            $word->setValue('КЛ-ПРОІНФОРМ', $cl_gender_informed);

            /*
             * Клієнт - IПН
             * */
            $word->setValue('КЛ-ІПН', $this->client->tax_code);
            $word->setValue('КЛ-ІПН-Ж', $this->set_style_bold($this->client->tax_code));

            // для анкет на двох
            $word->setValue($this->total_clients . '-КЛ-ІПН', $this->client->tax_code);

            /*
             * Клієнт - місце проживання
             * */
            if ($this->contract_type == 'main') {
                $word->setValue('КЛ-П-АДР', $this->convert->client_full_address_short($this->client));
                $word->setValue($this->total_clients . '-КЛ-П-АДР', $this->convert->client_full_address_short($this->client));
                $word->setValue('КЛ-ПОВНА-АДРЕСА', $this->convert->client_full_address_short($this->client));
            } elseif ($this->contract_type == 'preliminary') {
                $word->setValue('КЛ-П-АДР', $this->convert->get_client_full_address_n($this->client));
                $word->setValue($this->total_clients . '-КЛ-П-АДР', $this->convert->get_client_full_address_n($this->client));
                $word->setValue('КЛ-ПОВНА-АДРЕСА', $this->convert->get_client_full_address_n($this->client));
            } else {
                $word->setValue('КЛ-П-АДР', $this->convert->get_client_full_address_n($this->client));
                $word->setValue($this->total_clients . '-КЛ-П-АДР', $this->convert->get_client_full_address_n($this->client));
                $word->setValue('КЛ-ПОВНА-АДРЕСА', $this->convert->client_full_address_short($this->client));
            }

            $word->setValue('КЛ-П-АДР-СК', $this->convert->client_full_address_short($this->client));
            $word->setValue('КЛ-ПОВНА-АДРЕСА-СК', $this->convert->client_full_address_short($this->client));


            // для анкет на двох
            $word->setValue($this->total_clients . '-КЛ-П-АДР-СК', $this->convert->client_full_address_short($this->client));

            /*
             * Контактні данні
             * */
//            $word->setValue('cl-phone', $this->convert->phone_number($this->client->phone));
            $word->setValue('КЛ-ТЕЛЕФОН', $this->convert->phone_number($this->client->phone));
            $word->setValue($this->total_clients . '-КЛ-ТЕЛЕФОН', $this->client->phone);

            /*
             * Для Анкета На двох
             * */
            $word->setValue($this->total_clients . '-КЛ-ПРІЗВ-Н', $this->client->surname_n);
            $word->setValue($this->total_clients . '-КЛ-ІМЯ-Н', $this->client->name_n);
            $word->setValue($this->total_clients . '-КЛ-ПОБАТЬК-Н', $this->client->patronymic_n);
            $word->setValue($this->total_clients . '-КЛ-ПІБ-Н', $this->convert->get_full_name_n($this->client));
            $word->setValue($this->total_clients . '-КЛ-ЇХ', $cl_gender_whose);

            if ($this->client->representative) {
                if ($this->both_client_not_married) {
                    $word->setValue('ПОКУПЕЦЬ', mb_strtoupper(Text::where('alias', 'representative')->value('value')) . " " . $this->convert->get_full_name_r($this->client));
                    $word->setValue('ПОКУПЕЦЬ-АБО-ПІБ-Н', $this->convert->get_full_name_n($this->client));
                }
                else {
                    $word->setValue('ПОКУПЕЦЬ', mb_strtoupper(Text::where('alias', 'representative-buyer')->value('value')));
                    $word->setValue('ПОКУПЕЦЬ-АБО-ПІБ-Н', mb_strtoupper(Text::where('alias', 'buyer')->value('value')));
                }
            } else {
                if ($this->both_client_not_married) {
                    $word->setValue('ПОКУПЕЦЬ', $this->convert->get_full_name_n($this->client));
                    $word->setValue('ПОКУПЕЦЬ-АБО-ПІБ-Н', $this->convert->get_full_name_n($this->client));
                }
                else {
                    $word->setValue('ПОКУПЕЦЬ', mb_strtoupper(Text::where('alias', 'buyer')->value('value')));
                    $word->setValue('ПОКУПЕЦЬ-АБО-ПІБ-Н', mb_strtoupper(Text::where('alias', 'buyer')->value('value')));
                }
            }
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
            $confidant = $this->client->representative->confidant;

            if ($confidant->patronymic_n) {
                $word->setValue('ПРЕДСТАВНИК-КЛ-ПРІЗВ-Н', $confidant->surname_n);
                $word->setValue('ПРЕДСТАВНИК-КЛ-ІМЯ-Н', $confidant->name_n);
                $word->setValue('ПРЕДСТАВНИК-КЛ-ПОБАТЬК-Н', $confidant->patronymic_n);

                $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ПРІЗВ-Н', $confidant->surname_n);
                $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ІМЯ-Н', $confidant->name_n);
                $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ПОБАТЬК-Н', $confidant->patronymic_n);
            }
            else {
                $word->setValue('ПРЕДСТАВНИК-КЛ-ПРІЗВ-Н', mb_strtoupper($confidant->surname_n));
                $word->setValue('ПРЕДСТАВНИК-КЛ-ІМЯ-Н', mb_strtoupper($confidant->name_n));
                $word->setValue('ПРЕДСТАВНИК-КЛ-ПОБАТЬК-Н', '-');

                $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ПРІЗВ-Н', mb_strtoupper($confidant->surname_n));
                $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ІМЯ-Н', mb_strtoupper($confidant->name_n));
                $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ПОБАТЬК-Н', '-');
            }

            $word->setValue('ПРЕДСТАВНИК-КЛ-ГРОМАДЯН-Н', $this->convert->get_client_citizenship_n($confidant));
            $word->setValue('ПРЕДСТАВНИК-КЛ-ГРОМАДЯН-Р', $this->convert->get_client_citizenship_r($confidant));
            $word->setValue('ПРЕДСТАВНИК-КЛ-ГРОМАДЯН-Р-UP', $this->mb_ucfirst($this->convert->get_client_citizenship_r($confidant)));

            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ГРОМАДЯН-Н', $this->convert->get_client_citizenship_n($confidant));
            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ГРОМАДЯН-Р', $this->convert->get_client_citizenship_r($confidant));
            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ГРОМАДЯН-Р-UP', $this->mb_ucfirst($this->convert->get_client_citizenship_r($confidant)));

            $word->setValue('ПРЕДСТАВНИК-КЛ-ПІБ-Н', $this->convert->get_full_name_n($confidant));
            $word->setValue('ПРЕДСТАВНИК-КЛ-ПІБ-Р', $this->convert->get_full_name_r($confidant));
            $word->setValue('ПРЕДСТАВНИК-КЛ-ПІБ-ВЕЛИКИМИ-БУКВАМИ', $this->convert->get_full_name_n_upper($confidant));

            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ПІБ-Н', $this->convert->get_full_name_n($confidant));
            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ПІБ-Р', $this->convert->get_full_name_r($confidant));
            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ПІБ-ВЕЛИКИМИ-БУКВАМИ', $this->convert->get_full_name_n_upper($confidant));

            /*
             * Представник - IПН
             * */
            $word->setValue('ПРЕДСТАВНИК-ІПН', $confidant->tax_code);
            $word->setValue('ПРЕДСТАВНИК-КЛ-ІПН', $confidant->tax_code);
            $word->setValue('ПРЕДСТАВНИК-ІПН-Ж', $this->set_style_bold($confidant->tax_code));

            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-ІПН', $confidant->tax_code);
            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ІПН', $confidant->tax_code);
            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-ІПН-Ж', $this->set_style_bold($confidant->tax_code));

            /*
             * Представник - місце проживання
             * */
            if ($this->contract_type == 'main') {
                $word->setValue('ПРЕДСТАВНИК-КЛ-П-АДР', $this->convert->client_full_address_short($confidant));
                $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-П-АДР', $this->convert->client_full_address_short($confidant));
            } elseif ($this->contract_type == 'preliminary') {
                $word->setValue('ПРЕДСТАВНИК-КЛ-П-АДР', $this->convert->get_client_full_address_n($confidant));
                $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-П-АДР', $this->convert->get_client_full_address_n($confidant));
            } else {
                $word->setValue('ПРЕДСТАВНИК-КЛ-П-АДР', $this->convert->client_full_address_short($confidant));
                $word->setValue('ПРЕДСТАВНИК-КЛ-П-АДР-СК', $this->convert->client_full_address_short($confidant));
                $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-П-АДР', $this->convert->client_full_address_short($confidant));
                $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-П-АДР-СК', $this->convert->client_full_address_short($confidant));
            }


            $cr_gender_registration = GenderWord::where('alias', "registration")->value($confidant->gender);
            $word->setValue('ПРЕДСТАВНИК-КЛ-ЗАРЕЄСТР', $cr_gender_registration);
            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ЗАРЕЄСТР', $cr_gender_registration);

            /*
             * Представник - контактні данні
             * */
            $word->setValue('ПРЕДСТАВНИК-КЛ-ПАСПОРТ-ID-КОД', $confidant->passport_type ? $confidant->passport_type->short_info . " " : '');
            $word->setValue('ПРЕДСТАВНИК-КЛ-ДН', $this->display_date($confidant->birth_date));
            $word->setValue('ПРЕДСТАВНИК-КЛ-ДН', $this->display_date($confidant->birth_date));
            $word->setValue('ПРЕДСТАВНИК-КЛ-ТЕЛЕФОН', $confidant->phone);

            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ПАСПОРТ-ID-КОД', $confidant->passport_type ? $confidant->passport_type->short_info . " " : '');
            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ДН', $this->display_date($confidant->birth_date));
            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ДН', $this->display_date($confidant->birth_date));
            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ТЕЛЕФОН', $confidant->phone);

            $cr_gender_whose = GenderWord::where('alias', "whose")->value($confidant->gender);

            $word->setValue('ПРЕДСТАВНИК-КЛ-ЇХ', $cr_gender_whose);
            $word->setValue('ПРЕДСТАВНИК-КЛ-ЇХ-UP', $this->mb_ucfirst($cr_gender_whose));

            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ЇХ', $cr_gender_whose);
            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-ЇХ-UP', $this->mb_ucfirst($cr_gender_whose));

            $cr_gender_acquainted = GenderWord::where('alias', "acquainted")->value($confidant->gender);
            $word->setValue('ПРЕДСТАВНИК-КЛ-ОЗНАЙ', $cr_gender_acquainted);
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
        if ($this->client->married) {
            /*
             * Подружжя клієнта - ПІБ
             * */
            $word->setValue('ПОД-ПІБ-Н', $this->convert->get_full_name_n($this->client->married->spouse));
            $word->setValue('ПОД-ПІБ-Р', $this->convert->get_full_name_r($this->client->married->spouse));
            $word->setValue('ПОД-ПІБ-О', $this->convert->get_full_name_o($this->client->married->spouse));
            $word->setValue('ПОД-ДН', $this->display_date($this->client->married->spouse->birth_date));

            $word->setValue('ПОД-ГРОМАДЯН-Н', $this->convert->get_client_citizenship_n($this->client));
            $word->setValue('ПОД-ГРОМАДЯН-Р', $this->convert->get_client_citizenship_r($this->client));
            $word->setValue('ПОД-ГРОМАДЯН-Р-UP', $this->mb_ucfirst($this->convert->get_client_citizenship_r($this->client)));

            /*
             * Подружжя клієнта - паспорт та код
             * */
            $word->setValue('ПОД-ІПН', $this->client->married->spouse->tax_code);

            /*
             * Подружжя клієнта - адреса проживання
             * */
            $word->setValue('ПОД-ПОВНА-АДРЕСА', $this->convert->get_client_full_address_n($this->client->married->spouse));
            $word->setValue('ПОД-ПОВНА-АДРЕСА-СК', $this->convert->client_full_address_short($this->client->married->spouse));

            /*
             * Подружжя клієнта - стать Ч/Ж
             * */

            $word->setValue('ПОД-ШЛ-РОЛЬ-О', KeyWord::where('key', $this->client->married->spouse->gender)->value('title_o'));
            $word->setValue('ПОД-ШЛ-РОЛЬ-О-UP', $this->mb_ucfirst(KeyWord::where('key', $this->client->married->spouse->gender)->value('title_o')));

            $cs_gender_pronoun = GenderWord::where('alias', "whose")->value($this->client->married->spouse->gender);
            $word->setValue('ПОД-ЇХ', $cs_gender_pronoun);
            $word->setValue('ПОД-ЇХ-UP', $this->mb_ucfirst($cs_gender_pronoun));


            $cs_gender_mine = GenderWord::where('alias', "mine")->value($this->client->gender);

            $word->setValue('ПОД-МОЄ', $cs_gender_mine);
            $word->setValue('ПОД-МОЄ-UP', $this->mb_ucfirst($cs_gender_mine));

            if ($this->client->married->spouse->gender)
                $cs_registration = GenderWord::where('alias', "registration")->value($this->client->married->spouse->gender);
            else
                $cs_registration = GenderWord::where('alias', "reside")->value($this->client->married->spouse->gender);

            $word->setValue('ПОД-ЗАРЕЄСТР', $cs_registration);

            $cs_gender_which_adjective = GenderWord::where('alias', "which-adjective")->value($this->client->married->spouse->gender);
            $word->setValue('ПОД-ЯК', $cs_gender_which_adjective);

            $cs_gender_sign = GenderWord::where('alias', "sign")->value($this->client->married->spouse->gender);
            $word->setValue('ПОД-ПІДПИС', $cs_gender_sign);

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
            $word->setValue('ШАБЛОН-ДЛЯ-ДОКУМЕНТА', $this->consent->marriage_type->description);
            $word->saveAs($this->consent_generate_file);
        } else {
            $this->notification("Warning", "Згода подружжя: шаблон підтвердження шлюбу відсутній");
        }

        if ($this->consent && $this->consent->widow) {
            $word = new TemplateProcessor($this->consent_generate_file);
            $me_widowhood = MainInfoType::where('alias', 'me-widow-date')->value('description');
            $word->setValue('Я-ВДІВСТВО-ДАТА', $me_widowhood . ",$this->non_break_space");
            $word->saveAs($this->consent_generate_file);
        } else {
            $word = new TemplateProcessor($this->consent_generate_file);
            $word->setValue('Я-ВДІВСТВО-ДАТА', '');
            $word->saveAs($this->consent_generate_file);
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

                $word->setValue('СВ-СЕРІЯ', $this->consent->mar_series);
                $word->setValue('СВ-НОМЕР-СЕРІЇ', $this->consent->mar_series_num);
                $word->setValue('СВ-ДАТА', $this->display_date($this->consent->mar_date));
                $word->setValue('СВ-ВІДДІЛ', $this->consent->mar_depart);
                $word->setValue('СВ-РЕЄСТРАЦІЙНИЙ-НОМЕР', $this->consent->mar_reg_num);

                if ($this->consent->original) // original не правильно названа переменная - надо duplicate
                    $word->setValue('СВ-ПОВТОРНО',  KeyWord::where('key', "repeatedly")->value('title_n') . " ");
                else
                    $word->setValue('СВ-ПОВТОРНО', '');
            } elseif ($this->consent && $this->consent->mar_date) {
                $this->notification("Warning", "Дата про шлюбні документи відсутні");
            }

            /*
             * Згода подружжя або заява від покупця про відсутність шлюбних відносин - реєстраційний номер
             * */
            if ($this->consent->notary) {
                $word->setValue('ЗГ-ПОД-НОТ-ПІБ-ІНІЦІАЛИ-О', $this->convert->get_surname_and_initials_o($this->consent->notary));
                $word->setValue('ЗГ-ПОД-НОТ-АКТ-О', $this->consent->notary->activity_o);
            }
            $word->setValue('ЗГ-ПОД-НОТ-ДАТА', $this->display_date($this->consent->sign_date));
//            $word->setValue('cs-consent-sign-date', $this->display_date($this->consent->sign_date));
            if ($this->consent->reg_num) {
                $word->setValue('ЗГ-ПОД-НОТ-НОМЕР', $this->consent->reg_num);
                $word->setValue('cs-consent-reg-num', $this->consent->reg_num);
            }
            else {
                $word->setValue('ЗГ-ПОД-НОТ-НОМЕР', $this->set_style_color_warning("####"));
//                $word->setValue('cs-consent-reg-num', $this->set_style_color_warning("####"));
            }

            if ($this->consent->widow) {
                $widowhood = GenderWord::where('alias', 'widowhood')->value($this->client->gender);
                $word->setValue('КЛ-ВДОВ', $widowhood);
                $word->setValue('КЛ-ВДІВСТВО-ДАТА', $this->display_date($this->consent->widow_date));
            }
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

            $word->setValue('Н-ТИП-Н', $this->contract->immovable->immovable_type->title_n);
            $word->setValue('Н-ТИП-Р', $this->contract->immovable->immovable_type->title_r);
            $word->setValue('Н-ТИП-Р-UP',  $this->mb_ucfirst($this->contract->immovable->immovable_type->title_r));

            $immovable_gender = GenderWord::where('alias', 'located')->value($this->contract->immovable->immovable_type->gender);
            $word->setValue('Н-РОЗТАШОВ', $immovable_gender);

            if ($this->contract->immovable->roominess) {
//                $word->setValue('imm-app-type-title', $this->contract->immovable->roominess->title);
                $word->setValue('H-КІМНАТНІСТЬ', $this->contract->immovable->roominess->title);
                $word->setValue('H-КІМНАТНІСТЬ-ЦФР', $this->contract->immovable->roominess->number);
                $word->setValue('H-ЖИТЛОВИХ-КІМНАТ', $this->contract->immovable->roominess->living_room);
            }
            else {
//                $word->setValue('imm-app-type-title', "");
                $word->setValue('H-КІМНАТНІСТЬ', "");
                $word->setValue('H-КІМНАТНІСТЬ-ЦФР', "");
                $word->setValue('H-ЖИТЛОВИХ-КІМНАТ', "");
            }

            /*
             * Об'єкт - адреса
             * */
            $word->setValue('Н-КОМПЛЕКС', $this->contract->immovable->developer_building->complex); // building
            $word->setValue('H-ПОВНА-АДРЕСА', $this->contract->immovable->address);

            $word->setValue('H-ПОВНА-АДРЕСА-ОСН', $this->convert->building_full_address_main($this->contract->immovable));
            $word->setValue('H-ПОВНА-АДРЕСА-ЗАЯВА', $this->convert->building_full_address_main($this->contract->immovable));
            $word->setValue('H-ПОВНА-АДРЕСА-СПД', $this->convert->building_full_address_by_type($this->contract->immovable, 'desc'));
            $word->setValue('H-ПОВНА-АДРЕСА-СПД-СК', $this->convert->building_full_address_by_type_short($this->contract->immovable, 'desc'));
            $word->setValue('Н-БУДИНОК', $this->convert->building_street_and_num($this->contract->immovable)); // building
            $word->setValue('Н-БУДИНОК-ЦФР', $this->contract->immovable->developer_building->number); // building
            $word->setValue('Н-НОМЕР', $this->convert->immovable_number_with_string($this->contract->immovable->immovable_number));
            $word->setValue('Н-НОМЕР-ЦФР', $this->contract->immovable->immovable_number);

            /*
             * Об'єкт - загальна та житлова проща
             * */
            $word->setValue('Н-ПЛ-З-ЦФР', str_replace('.', ',', $this->contract->immovable->total_space));
            $word->setValue('Н-ПЛ-Ж-ЦФР', str_replace('.', ',', $this->contract->immovable->living_space));
            $word->setValue('Н-ПЛ-З', $this->convert->get_convert_space($this->contract->immovable->total_space));
            $word->setValue('Н-ПЛ-Ж', $this->convert->get_convert_space($this->contract->immovable->living_space));

            $word->setValue('Н-ПОВЕРХУ', $this->convert->get_immovable_floor($this->contract->immovable->floor));
            $word->setValue('Н-ПОВЕРХУ-ЦФР', $this->contract->immovable->floor);
            $word->setValue('Н-CЕКЦІЯ', $this->convert->number_with_string($this->contract->immovable->section));
            $word->setValue('Н-CЕКЦІЯ-ЦФР', $this->contract->immovable->section);
            /*
             * Дата підключеня до коммунікацій / Введення в експлуатацію
             * */

            if ($this->contract->immovable->developer_building->exploitation_date && $this->contract->immovable->developer_building->communal_date) {
                $word->setValue('Н-ДАТА-ЕКСПЛ', $this->day_quotes_month_year($this->contract->immovable->developer_building->exploitation_date));
                $word->setValue('Н-ДАТА-КОМ', $this->day_quotes_month_year($this->contract->immovable->developer_building->communal_date));
            }

            if ($this->contract->immovable->developer_building->exploitation_quarter) {
                $word->setValue('Н-КВАРТАЛ-ДАТА-ЕКСПЛ', $this->contract->immovable->developer_building->exploitation_quarter);
            } else {
                $word->setValue('Н-КВАРТАЛ-ДАТА-ЕКСПЛ', $this->set_style_color_warning("## ####### ####"));
            }


            /*
             * Об'єкт - дозвіл на будівництво
             * */

            if ($this->contract->immovable->developer_building->building_permit) {
                $word->setValue('Н-ДОЗВІЛ-КОД', $this->contract->immovable->developer_building->building_permit->resolution);
                $word->setValue('Н-ДОЗВІЛ-ДАТА', $this->day_without_quotes_month_year($this->contract->immovable->developer_building->building_permit->sign_date));
                $word->setValue('Н-ДОЗВІЛ-ВИДАНО', $this->contract->immovable->developer_building->building_permit->organization);
            }

            /*
             * Об'єкт - реєстраційний номер
             * */
//            $word->setValue('imm-reg-num', $this->contract->immovable->registration_number);
            $word->setValue('Н-РЕЄСТР-НОМ', $this->contract->immovable->registration_number);

            if ($this->buyer_are_spouse == false && count($this->contract->clients) == 2) {
                $word->setValue('ВЛАСНИК-1/2', $this->non_break_space . "за яким мені буде належити 1/2 частка вищевказаної " . $this->contract->immovable->immovable_type->title_r . ", ");
            } else {
                $word->setValue('ВЛАСНИК-1/2', '');
            }
        } else {
            $this->notification("Warning", "Відсутня інформація про об'єкт нерухомості");
        }

        return $word;
    }

    /*
     * Перевірка обмежень на продавця та майно
     * */
    public function set_check_ownership_and_fence_info($word)
    {
        /*
         * Об'єкт - перевірка на право власності та данні нотаріуса, що здійснив цю перевірку
         * */

        if ($this->contract->immovable_ownership) {
            $word->setValue('ПР-ВЛ-РСТР-НОМ', $this->contract->immovable_ownership->gov_reg_number);
            $word->setValue('ПР-ВЛ-РСТР-ДАТА', $this->contract->immovable_ownership->gov_reg_date_format);
            $word->setValue('ПР-ВЛ-ВТГ-ДАТА', $this->contract->immovable_ownership->discharge_date_format);
            $word->setValue('ПР-ВЛ-ВТГ-НОМ', $this->contract->immovable_ownership->discharge_number);

            if ($this->contract->immovable_ownership->notary) {
                $word->setValue('ПР-ВЛ-НОТ-ПІБ-О', $this->convert->get_full_name_o($this->contract->immovable_ownership->notary));
                $word->setValue('ПР-ВЛ-НОТ-АКТИВНІСТЬ-О', $this->contract->immovable_ownership->notary->activity_o);
            }
        } else {
            $this->notification("Warning", "Перевірка: відсутня інформація про власника майна");
        }

        /*
        /*
         * Перевірка заборон на майно
         * */
        if ($this->contract->immovable->fence && $this->contract->immovable->fence->number && $this->contract->immovable->fence->date) {
            $word->setValue('ЗБРН-Н-ДАТА', $this->display_date($this->contract->immovable->fence->date));
            $word->setValue('ЗБРН-Н-НОМ', $this->contract->immovable->fence->number);
        } else {
            $word->setValue('ЗБРН-Н-НОМ', $this->set_style_color_warning("########"));
            $this->notification("Warning", "Перевірка: відсутня інформація по забороні на нерухомість");
        }

        /*
         * Перевірка заборон на власника
         * */
        if ($this->contract->dev_company && $this->contract->dev_company->fence && $this->contract->dev_company->fence->number && $this->contract->dev_company->fence->date) {
            $word->setValue('dev-fence-date', $this->display_date($this->contract->dev_company->fence->date));
            $word->setValue('dev-fence-num', $this->contract->dev_company->fence->number);

            $word->setValue('ЗБРН-ЗАБ-ДАТА', $this->display_date($this->contract->dev_company->fence->date));
            $word->setValue('ЗБРН-ЗАБ-НОМ', $this->contract->dev_company->fence->number);
        } else {
            $word->setValue('ЗБРН-ЗАБ-НОМ', $this->set_style_color_warning("########"));
            $this->notification("Warning", "Перевірка: відсутня інформація по заборонам на власника");
        }

        return $word;
    }

    /*
     * Об'єкт - данні від оціночної компанії
     * */
    public function set_property_valuation_prices($word)
    {
        if ($this->contract->immovable->pvprice && $this->contract->immovable->pvprice->property_valuation) {
            $word->setValue('ОК-НАЗВА', $this->contract->immovable->pvprice->property_valuation->title);
            $word->setValue('ОК-ЗАГОЛОВОК', $this->contract->immovable->pvprice->property_valuation->type);
            $word->setValue('ОК-СРТФКТ-НОМ', $this->contract->immovable->pvprice->property_valuation->certificate);
            $word->setValue('ОК-СРТФКТ-ДАТА', $this->display_date($this->contract->immovable->pvprice->property_valuation->date));
            $word->setValue('ОК-ОЦ-ДАТА', $this->display_date($this->contract->immovable->pvprice->date));
            $word->setValue('ОК-ОЦ-ЦІНА', $this->convert->get_convert_price($this->contract->immovable->pvprice->grn, 'grn'));
        } else {
            $this->notification("Warning", "Оцінка: відсутня інформація від оціночної компанії");
        }

        return $word;
    }

    /*
     * Об'єкт - ціна від забудовника ++++++
     * */
    public function set_developer_price($word)
    {
        $word->setValue('Н-ЦІНА-ЗАГ-ГРН', $this->convert->get_convert_price($this->contract->immovable->grn, 'grn'));
        $half_price = $this->contract->immovable->grn / 2;
        $word->setValue('Н-ЦІНА-ЗАГ-ГРН-1/2', $this->convert->get_convert_price($half_price, 'grn'));

        if ($this->company_rate) {
            $dollar_price = intval(round($this->contract->immovable->grn / $this->company_rate * 100));
            $word->setValue('Н-ЦІНА-ЗАГ-ДОЛ', $this->convert->get_convert_price($dollar_price, 'dollar'));
        } else {
            $word->setValue('Н-ЦІНА-ЗАГ-ДОЛ', $this->set_style_color_warning("##########"));
        }

        $word->setValue('Н-ЦІНА-М2-ГРН',  $this->convert->get_convert_price($this->contract->immovable->m2_grn, 'grn'));

        if ($this->company_rate) {
            $m2_dollar = intval(round($this->contract->immovable->m2_grn / $this->company_rate * 100));
            $word->setValue('Н-ЦІНА-М2-ДОЛ', $this->convert->get_convert_price($m2_dollar, 'dollar'));
        } else {
            $word->setValue('Н-ЦІНА-М2-ДОЛ', $this->set_style_color_warning("##########"));
        }

        $word->setValue('Н-ЦІНА-РЕЗ-ГРН', $this->convert->get_convert_price($this->contract->immovable->reserve_grn, 'grn'));

        if ($this->company_rate) {
            $reserve_dollar = intval(round($this->contract->immovable->reserve_grn / $this->company_rate * 100));
            $word->setValue('Н-ЦІНА-РЕЗ-ДОЛ', $this->convert->get_convert_price($reserve_dollar, 'dollar'));
            $word->setValue('Н-ЦІНА-РЕЗ-1/2-ДОЛ', $this->convert->get_convert_price($reserve_dollar / 2, 'dollar'));
        } else {
            $word->setValue('Н-ЦІНА-РЕЗ-ДОЛ', $this->set_style_color_warning("##########"));
            $word->setValue('Н-ЦІНА-РЕЗ-1/2-ДОЛ', $this->set_style_color_warning("##########"));
        }

        $word->setValue('Н-ЦІНА-РЕЗ-1/2-ГРН', $this->convert->get_convert_price($this->contract->immovable->reserve_grn / 2, 'grn'));
        return $word;
    }

    /*
     * Забезпечувальний платіж до попереднього договору
     * */
    public function set_secure_payment($word)
    {
        if ($this->contract->immovable->security_payment) {
            $word->setValue('Н-ЗАБ-ПЛ-Ч1-ГРН', $this->convert->get_convert_price($this->contract->immovable->security_payment->first_part_grn, 'grn'));

            if ($this->company_rate) {
                $immovable_reserve_dollar = round($this->contract->immovable->reserve_grn / $this->company_rate, 2);
                $first_part_dollar = round($this->contract->immovable->security_payment->first_part_grn / $this->company_rate, 2);
                $last_part_dollar = round(($this->contract->immovable->reserve_grn - $this->contract->immovable->security_payment->first_part_grn) / $this->company_rate, 2);
                while ($immovable_reserve_dollar && ($first_part_dollar + $last_part_dollar) > $immovable_reserve_dollar) {
                    $first_part_dollar = $first_part_dollar - 0.01;
                }

                $word->setValue('Н-ЗАБ-ПЛ-Ч1-ДОЛ', $this->convert->get_convert_price($first_part_dollar * 100, 'dollar'));
                $word->setValue('Н-ЗАБ-ПЛ-Ч2-ДОЛ', $this->convert->get_convert_price($last_part_dollar * 100, 'dollar'));
                $word->setValue($this->total_clients . '-Н-ЗАБ-ПЛ-Ч2-1/2-ДОЛ', $this->convert->get_convert_price($last_part_dollar / 2, 'dollar'));
            } else {
                $word->setValue('Н-ЗАБ-ПЛ-Ч1-ДОЛ', $this->set_style_color_warning("##########"));
                $word->setValue('Н-ЗАБ-ПЛ-Ч2-ДОЛ', $this->set_style_color_warning("##########"));
                $word->setValue($this->total_clients . '-Н-ЗАБ-ПЛ-Ч2-1/2-ДОЛ', $this->set_style_color_warning("##########"));
            }

            $word->setValue('Н-ЗАБ-ПЛ-Ч2-ГРН', $this->convert->get_convert_price($this->contract->immovable->security_payment->last_part_grn, 'grn'));

            // якщо суму не визначив блок розстрочки, то задаємо залишкове значення
            if (!$this->bank_account_total_price) {
                if ($this->two_clients)
                    $this->bank_account_total_price = $this->convert->get_convert_price($this->contract->immovable->security_payment->last_part_grn / 2, 'grn');
                else
                    $this->bank_account_total_price = $this->convert->get_convert_price($this->contract->immovable->security_payment->last_part_grn, 'grn');
            }
            $word->setValue($this->total_clients . '-Н-ЗАБ-ПЛ-Ч2-1/2-ГРН', $this->convert->get_convert_price($this->contract->immovable->security_payment->last_part_grn / 2, 'grn'));

            if ($this->contract->immovable->security_payment->reg_num)
                $word->setValue('Н-ЗАБ-ПЛ-НОМ', $this->contract->immovable->security_payment->reg_num);
            else
                $word->setValue('Н-ЗАБ-ПЛ-НОМ', $this->set_style_color_warning("####"));


            if ($this->contract->immovable->security_payment->sign_date) {
                $word->setValue('Н-ЗАБ-ПЛ-ДАТА-ПІДП', $this->day_quotes_month_year($this->contract->immovable->security_payment->sign_date));
                $word->setValue('Н-ЗАБ-ПЛ-ДАТА-ПІДП-ДМР', $this->display_date($this->contract->immovable->security_payment->sign_date));
            }
            else
                $word->setValue('Н-ЗАБ-ПЛ-ДАТА-ПІДП', $this->set_style_color_warning("## ####### ####"));
        } else {
            $this->notification("Warning", "Забезпечувальний платіж до попереднього договору: інформація відсутня");
        }

        return $word;
    }

    public function set_installment_table($template_generate_file, $immovable)
    {
        $installment = Installment::where('immovable_id', $immovable->id)->first();

        if ($installment) {
            $installment_part = InstallmentPart::where('month', $installment->total_month)->where('type', $installment->type)->where('client_num', count($this->contract->clients))->first();
            if ($installment_part) {
                $word = new TemplateProcessor($template_generate_file);
                $word->setValue('ТАБЛИЦЯ-РОЗСТРОЧКИ', $installment_part->block);
                $word->setValue('НА-ДВОХ-ТАБЛИЦЯ-РОЗСТРОЧКИ', $installment_part->block);
                $word->saveAs($template_generate_file);
            }
        }
    }

    public function set_installment_info($word)
    {
        $dollar_sum_float = 0;
        // 2 або 1
        $client_num = count($this->contract->clients);

        // розстрочка на двох

        if ($this->contract->immovable->installment && $this->company_rate) {
            // 5 000 000 00
            $installment_grn_int = $this->contract->immovable->installment->total_price;

            $installment = $this->installment->get_data_for_doc($this->card, $this->contract->immovable, $this->contract->sign_date, $client_num);

            $i = 1;
            $installment_dollar_float = 0;
            $final_installment_date = null;
            foreach ($installment as $key => $price) {
                $word->setValue('РОЗСТ-ДАТА-' . $i, $key);
                $word->setValue('РОЗСТ-ГРН-' . $i, number_format($price['grn'], 2, ',', $this->non_break_space));
                $word->setValue('РОЗСТ-ДОЛАР-' . $i, number_format($price['dollar'], 2,',', $this->non_break_space));
                $installment_dollar_float += $price['dollar'];
                $i++;

                $final_installment_date = $key;
            }

            // отримати загальну суму в доларах
            $installment_dollar_float = $installment_dollar_float * $client_num;
            $dollar_sum_float += $installment_dollar_float;
            // 1 824 818
            $installment_dollar_int = $installment_dollar_float * 100;

            if ($this->contract->immovable->security_payment) {
                // 245 000 00  = ( 990 000 00  -  500 000 00 ) / 2  - 10 000 00 / 2
                $grn_part_int = intval(round($this->contract->immovable->reserve_grn - $this->contract->immovable->installment->total_price - $this->contract->immovable->security_payment->first_part_grn));
                // 8 941 60  =  245 000 00 / 2740 * 100
                $dollar_part_int = intval(round($grn_part_int / $this->company_rate * 100));
                // + 17 883 21 = 245 000 00 / 2740 * 2
                // $dollar_sum_float += $grn_part_int / $this->company_rate;

                $word->setValue('Н-ЗАБ-ПЛ-Ч2-БЕЗ-РОЗСТ-ГРН', $this->convert->get_convert_price($grn_part_int, 'grn'));

                if ($this->two_clients)
                    $this->bank_account_total_price = $this->convert->get_convert_price($grn_part_int / 2, 'grn');
                else
                    $this->bank_account_total_price = $this->convert->get_convert_price($grn_part_int, 'grn');

                $word->setValue('Н-ЗАБ-ПЛ-Ч2-БЕЗ-РОЗСТ-ДОЛ', $this->convert->get_convert_price($dollar_part_int, 'dollar'));

                // розстрочка для двох клієнтів
                if ($client_num == 2) {
                    $client_2 = $this->contract->clients[0];
                    $client_1 = $this->contract->clients[1];

                    // забезпечувальний платіж за конкретною людиною
                    if ($this->contract->immovable->security_payment->client_id) {
                        $reserve_part_who_pay_security_dollar_int = ($this->contract->immovable->reserve_grn - $this->contract->immovable->installment->total_price) / $client_num - $this->contract->immovable->security_payment->first_part_grn;
                        $reserve_part_who_pay_security_dollar_int = intval(round($reserve_part_who_pay_security_dollar_int / $this->company_rate * 100));

                        $reserve_part_who_dont_pay_security_dollar_int = ($this->contract->immovable->reserve_grn - $this->contract->immovable->installment->total_price) / $client_num;
                        $reserve_part_who_dont_pay_security_dollar_int = intval(round($reserve_part_who_dont_pay_security_dollar_int / $this->company_rate * 100));

                        $dollar_sum_float += round($reserve_part_who_pay_security_dollar_int / 100, 2);
                        $dollar_sum_float += round($reserve_part_who_dont_pay_security_dollar_int / 100, 2);
                        if ($client_2 && $this->contract->immovable->security_payment->client_id == $client_2->id) {
                            $word->setValue('2-Н-ЗАБ-ПЛ-Ч2-БЕЗ-РОЗСТ-1/2-ГРН', $this->convert->get_convert_price(($this->contract->immovable->reserve_grn - $this->contract->immovable->installment->total_price) / $client_num - $this->contract->immovable->security_payment->first_part_grn, 'grn'));
                            $word->setValue('2-Н-ЗАБ-ПЛ-Ч2-БЕЗ-РОЗСТ-1/2-ДОЛ', $this->convert->get_convert_price($reserve_part_who_pay_security_dollar_int, 'dollar'));
                        } else {
                            $word->setValue('2-Н-ЗАБ-ПЛ-Ч2-БЕЗ-РОЗСТ-1/2-ГРН', $this->convert->get_convert_price(($this->contract->immovable->reserve_grn - $this->contract->immovable->installment->total_price) / $client_num, 'grn'));
                            $word->setValue('2-Н-ЗАБ-ПЛ-Ч2-БЕЗ-РОЗСТ-1/2-ДОЛ', $this->convert->get_convert_price($reserve_part_who_dont_pay_security_dollar_int, 'dollar'));
                        }
                        if ($client_1 && $this->contract->immovable->security_payment->client_id == $client_1->id) {
                            $word->setValue('1-Н-ЗАБ-ПЛ-Ч2-БЕЗ-РОЗСТ-1/2-ГРН', $this->convert->get_convert_price(($this->contract->immovable->reserve_grn - $this->contract->immovable->installment->total_price) / $client_num - $this->contract->immovable->security_payment->first_part_grn, 'grn'));
                            $word->setValue('1-Н-ЗАБ-ПЛ-Ч2-БЕЗ-РОЗСТ-1/2-ДОЛ', $this->convert->get_convert_price($reserve_part_who_pay_security_dollar_int, 'dollar'));
                        } else {
                            $word->setValue('1-Н-ЗАБ-ПЛ-Ч2-БЕЗ-РОЗСТ-1/2-ГРН', $this->convert->get_convert_price(($this->contract->immovable->reserve_grn - $this->contract->immovable->installment->total_price) / $client_num, 'grn'));
                            $word->setValue('1-Н-ЗАБ-ПЛ-Ч2-БЕЗ-РОЗСТ-1/2-ДОЛ', $this->convert->get_convert_price($reserve_part_who_dont_pay_security_dollar_int, 'dollar'));
                        }
                    // забезпечувальний платіж у рівних частинах на двох
                    } elseif ($this->contract->immovable->security_payment->client_id == null) {
                        // 245 000 00  = ( 990 000 00  -  500 000 00 ) / 2  - 10 000 00 / 2
                        $half_part_grn_int = intval(round(($this->contract->immovable->reserve_grn - $this->contract->immovable->installment->total_price) / $client_num - ($this->contract->immovable->security_payment->first_part_grn / $client_num)));
                         // 8 941 60  =  245 000 00 / 2740 * 100
                        $half_part_dollar_int = intval(round($half_part_grn_int / $this->company_rate * 100));
                        // + 17 883 21 = 245 000 00 / 2740 * 2
                        $dollar_sum_float += ($half_part_grn_int / $this->company_rate) * $client_num;

                        $word->setValue('2-Н-ЗАБ-ПЛ-Ч2-БЕЗ-РОЗСТ-1/2-ГРН', $this->convert->get_convert_price($half_part_grn_int, 'grn'));
                        $word->setValue('2-Н-ЗАБ-ПЛ-Ч2-БЕЗ-РОЗСТ-1/2-ДОЛ', $this->convert->get_convert_price($half_part_dollar_int, 'dollar'));
                        $word->setValue('1-Н-ЗАБ-ПЛ-Ч2-БЕЗ-РОЗСТ-1/2-ГРН', $this->convert->get_convert_price($half_part_grn_int, 'grn'));
                        $word->setValue('1-Н-ЗАБ-ПЛ-Ч2-БЕЗ-РОЗСТ-1/2-ДОЛ', $this->convert->get_convert_price($half_part_dollar_int, 'dollar'));

                    }
                // розстрочка для одного клієнта
                } elseif ($client_num == 1) {
                    $grn_part_int = intval(round($this->contract->immovable->reserve_grn - $this->contract->immovable->installment->total_price - $this->contract->immovable->security_payment->first_part_grn));
                    $dollar_sum_float += round($grn_part_int / $this->company_rate, 2);
                }
            // без забезпечувального платежу
            } elseif ($this->contract->immovable->security_payment == null) {
                if ($client_num == 2) {
                    $half_part_grn_int = ($this->contract->immovable->reserve_grn - $this->contract->immovable->installment->total_price) / $client_num;
                    $half_part_dollar_int = intval(round($half_part_grn_int / $this->company_rate * 100));

                    $dollar_sum_float += $half_part_grn_int / $this->company_rate * $client_num;

                    $word->setValue('2-Н-ЗАБ-ПЛ-БЕЗ-РОЗСТ-1/2-ГРН', $this->convert->get_convert_price($half_part_grn_int, 'grn'));
                    $word->setValue('2-Н-ЗАБ-ПЛ-БЕЗ-РОЗСТ-1/2-ДОЛ', $this->convert->get_convert_price($half_part_dollar_int, 'dollar'));
                    $word->setValue('1-Н-ЗАБ-ПЛ-БЕЗ-РОЗСТ-1/2-ГРН', $this->convert->get_convert_price($half_part_grn_int, 'grn'));
                    $word->setValue('1-Н-ЗАБ-ПЛ-БЕЗ-РОЗСТ-1/2-ДОЛ', $this->convert->get_convert_price($half_part_dollar_int, 'dollar'));

                    $grn_part_int = ($this->contract->immovable->reserve_grn - $this->contract->immovable->installment->total_price);
                    $dollar_part_int = intval(round($grn_part_int / $this->company_rate * 100));

//                    $dollar_sum_float += $grn_part_int / $this->company_rate;

                    $word->setValue('Н-ЗАБ-ПЛ-БЕЗ-РОЗСТ-ГРН', $this->convert->get_convert_price($grn_part_int, 'grn'));
                    if ($this->two_clients)
                        $this->bank_account_total_price = $this->convert->get_convert_price($grn_part_int / 2, 'grn');
                    else
                        $this->bank_account_total_price = $this->convert->get_convert_price($grn_part_int, 'grn');
                    $word->setValue('Н-ЗАБ-ПЛ-БЕЗ-РОЗСТ-ДОЛ', $this->convert->get_convert_price($dollar_part_int, 'dollar'));
                } else {
                    $grn_part_int = ($this->contract->immovable->reserve_grn - $this->contract->immovable->installment->total_price);
                    $dollar_part_int = intval(round($grn_part_int / $this->company_rate * 100));

                    $dollar_sum_float += $grn_part_int / $this->company_rate;

                    $word->setValue('Н-ЗАБ-ПЛ-БЕЗ-РОЗСТ-ГРН', $this->convert->get_convert_price($grn_part_int, 'grn'));

                    if ($this->two_clients)
                        $this->bank_account_total_price = $this->convert->get_convert_price($grn_part_int / 2, 'grn');
                    else
                        $this->bank_account_total_price = $this->convert->get_convert_price($grn_part_int, 'grn');
                    $word->setValue('Н-ЗАБ-ПЛ-БЕЗ-РОЗСТ-ДОЛ', $this->convert->get_convert_price($dollar_part_int, 'dollar'));
                }
            }

            // Таблиця розстрочки - Всього: загальна сума знизу
            if ($client_num == 2) {
                $word->setValue('РОЗСТ-ГРН-ВСЬОГО', number_format(($installment_grn_int / 100) / $client_num, 2, ',', $this->non_break_space));
                $word->setValue('РОЗСТ-ДОЛАР-ВСЬОГО', number_format($installment_dollar_float / $client_num, 2, ',', $this->non_break_space));
            } else {
                $word->setValue('РОЗСТ-ГРН-ВСЬОГО', number_format($installment_grn_int / 100, 2, ',', $this->non_break_space));
                $word->setValue('РОЗСТ-ДОЛАР-ВСЬОГО', number_format($installment_dollar_float, 2, ',', $this->non_break_space));
            }

            // Розстрочка з ЗП - загальна сума розстрочки до споати
            $word->setValue('Н-ЗАБ-ПЛ-Ч2-РОЗСТ-ГРН', $this->convert->get_convert_price($this->contract->immovable->installment->total_price, 'grn'));
            $word->setValue('Н-ЗАБ-ПЛ-Ч2-РОЗСТ-ДОЛАР', $this->convert->get_convert_price($installment_dollar_int, 'dollar'));

            // Розстрочка без ЗП - загальна сума розстрочки до сплати
            $word->setValue('Н-ЗАБ-ПЛ-РОЗСТ-ГРН', $this->convert->get_convert_price($this->contract->immovable->installment->total_price, 'grn'));
            $word->setValue('Н-ЗАБ-ПЛ-РОЗСТ-ДОЛАР', $this->convert->get_convert_price($installment_dollar_int, 'dollar'));

            $word->setValue('Н-ЗАБ-ПЛ-Ч2-ДОЛ', $this->convert->get_convert_price($dollar_sum_float * 100, 'dollar'));

            $reserve_dollar_total = round($this->contract->immovable->reserve_grn / $this->company_rate * 100);
            $word->setValue('Н-ЦІНА-РЕЗ-ДОЛ', $this->convert->get_convert_price($reserve_dollar_total, 'dollar'));

            $first_part_reserve_dollar = intval(round($reserve_dollar_total - $dollar_sum_float * 100));

            $word->setValue('Н-ЗАБ-ПЛ-Ч1-ДОЛ', $this->convert->get_convert_price($first_part_reserve_dollar, 'dollar'));

            $word->setValue('Н-ЦІНА-РЕЗ-ДОЛ', $this->convert->get_convert_price($dollar_sum_float * 100, 'dollar'));

            $final_installment_date = new DateTime($final_installment_date);
            $word->setValue('ФІНАЛЬНА-ДАТА-ЗАБ-ПЛ', $this->day_quotes_month_year($final_installment_date));
        } elseif ($this->contract->immovable->installment && $this->company_rate == null) {

            $i = 1;
            $y = 36;
            while($i < $y) {
                $word->setValue('РОЗСТ-ДАТА-' . $i, $this->set_style_color_warning("############"));
                $word->setValue('РОЗСТ-ГРН-' . $i, $this->set_style_color_warning("############"));
                $word->setValue('РОЗСТ-ДОЛАР-' . $i, $this->set_style_color_warning("############"));
                $i++;
            }

            $word->setValue('Н-ЗАБ-ПЛ-Ч2-БЕЗ-РОЗСТ-ГРН', $this->set_style_color_warning("############"));
            $word->setValue('Н-ЗАБ-ПЛ-Ч2-БЕЗ-РОЗСТ-ДОЛ', $this->set_style_color_warning("############"));
            $word->setValue('2-Н-ЗАБ-ПЛ-Ч2-БЕЗ-РОЗСТ-1/2-ГРН', $this->set_style_color_warning("############"));
            $word->setValue('2-Н-ЗАБ-ПЛ-Ч2-БЕЗ-РОЗСТ-1/2-ДОЛ', $this->set_style_color_warning("############"));
            $word->setValue('1-Н-ЗАБ-ПЛ-Ч2-БЕЗ-РОЗСТ-1/2-ГРН', $this->set_style_color_warning("############"));
            $word->setValue('1-Н-ЗАБ-ПЛ-Ч2-БЕЗ-РОЗСТ-1/2-ДОЛ', $this->set_style_color_warning("############"));
            $word->setValue('2-Н-ЗАБ-ПЛ-БЕЗ-РОЗСТ-1/2-ГРН', $this->set_style_color_warning("############"));
            $word->setValue('2-Н-ЗАБ-ПЛ-БЕЗ-РОЗСТ-1/2-ДОЛ', $this->set_style_color_warning("############"));
            $word->setValue('1-Н-ЗАБ-ПЛ-БЕЗ-РОЗСТ-1/2-ГРН', $this->set_style_color_warning("############"));
            $word->setValue('1-Н-ЗАБ-ПЛ-БЕЗ-РОЗСТ-1/2-ДОЛ', $this->set_style_color_warning("############"));
            $word->setValue('Н-ЗАБ-ПЛ-БЕЗ-РОЗСТ-ГРН', $this->set_style_color_warning("############"));
            $word->setValue('Н-ЗАБ-ПЛ-БЕЗ-РОЗСТ-ДОЛ', $this->set_style_color_warning("############"));
            $word->setValue('РОЗСТ-ГРН-ВСЬОГО', $this->set_style_color_warning("############"));
            $word->setValue('РОЗСТ-ДОЛАР-ВСЬОГО', $this->set_style_color_warning("############"));
            $word->setValue('Н-ЗАБ-ПЛ-Ч2-РОЗСТ-ГРН', $this->set_style_color_warning("############"));
            $word->setValue('Н-ЗАБ-ПЛ-Ч2-РОЗСТ-ДОЛАР', $this->set_style_color_warning("############"));
            $word->setValue('Н-ЗАБ-ПЛ-РОЗСТ-ГРН', $this->set_style_color_warning("############"));
            $word->setValue('Н-ЗАБ-ПЛ-РОЗСТ-ДОЛАР', $this->set_style_color_warning("############"));
            $word->setValue('Н-ЗАБ-ПЛ-Ч2-ДОЛ', $this->set_style_color_warning("############"));
            $word->setValue('Н-ЦІНА-РЕЗ-ДОЛ', $this->set_style_color_warning("############"));
            $word->setValue('Н-ЗАБ-ПЛ-Ч1-ДОЛ', $this->set_style_color_warning("############"));
            $word->setValue('ФІНАЛЬНА-ДАТА-ЗАБ-ПЛ', $this->set_style_color_warning("############"));
        }


        return $word;
    }

    /*
     * Розірвання або повернення коштів
     * */
    public function set_termination_info($word)
    {
        if ($this->contract->termination_info && $this->contract->termination_info->notary) {
            $word->setValue('РОЗ-НОТ-ПІБ-ІНІЦІАЛИ-О', $this->convert->get_surname_and_initials_o($this->contract->termination_info->notary));
            $word->setValue('РОЗ-НОТ-АКТ-О', $this->contract->termination_info->notary->activity_o);
            $word->setValue('РОЗ-НОТ-ДАТА', $this->display_date($this->contract->termination_info->reg_date));
            $word->setValue('РОЗ-НОТ-НОМЕР', $this->contract->termination_info->reg_num);
            $word->setValue('РОЗ-Н-ЦІНА-ЗАГ-ГРН', $this->convert->get_convert_price($this->contract->termination_info->price_grn, 'grn'));
            $word->setValue('РОЗ-Н-ЦІНА-ЗАГ-ДОЛ', $this->convert->get_convert_price($this->contract->termination_info->price_dollar, 'dollar'));
        } else {
            $this->notification("Warning", "Інформація про розірвання відсутне");
        }

        if ($this->contract->dev_company->owner && $this->contract->dev_company->owner->termination_consent && $this->contract->dev_company->owner->termination_consent->notary) {
            $word->setValue('РОЗ-ЗГ-ПОДР-ЗБД-НОТ-ПІБ-О', $this->convert->get_surname_and_initials_o($this->contract->dev_company->owner->termination_consent->notary));
            $word->setValue('РОЗ-ЗГ-ПОДР-ЗБД-НОТ-АКТИВНІСТЬ-О', $this->contract->dev_company->owner->termination_consent->notary->activity_o);
            $word->setValue('РОЗ-ЗГ-ПОДР-ЗБД-НОТ-ДАТА',  $this->display_date($this->contract->dev_company->owner->termination_consent->reg_date));
            $word->setValue('РОЗ-ЗГ-ПОДР-ЗБД-НОТ-НОМЕР', $this->contract->dev_company->owner->termination_consent->reg_num);
        } else {
            $this->notification("Warning", "Інформація про розірвання відсутне");
        }

        return $word;
    }

    public function set_communal_info($word)
    {
        if ($this->contract->communal && $this->contract->communal->final_date) {
            $this->convert->date_to_string($this->contract->communal, $this->contract->communal->final_date);
            $word->setValue('ДОВ-КОММ-ДАТА-СЛОВАМИ-ДО', $this->contract->communal->str_day->title . " " . $this->contract->communal->str_month->title_r . " " . $this->contract->communal->str_year->title_r);
        }

        return $word;
    }

    /*
     * Курс долара та посилання на сайт
     * */
    public function set_exchange_rate($word)
    {
        if ($this->contract->immovable  && $this->company_rate) {
            $word->setValue('КУРС-ДОЛАРА', $this->convert->exchange_price($this->card->exchange_rate->rate));
            if ($this->card->exchange_rate->contract_buy)
                $word->setValue('КУРС-ДОЛАРА+5', $this->convert->exchange_price($this->card->exchange_rate->contract_buy + 5));
            else
                $word->setValue('КУРС-ДОЛАРА+5', $this->convert->exchange_price($this->card->exchange_rate->rate + 5));
            $word->setValue('КУРС-ДОЛАРА-КУПІВЛЯ', $this->convert->exchange_price($this->card->exchange_rate->contract_buy));
            $word->setValue('КУРС-ДОЛАРА-ПРОДАЖ', $this->convert->exchange_price($this->card->exchange_rate->contract_sell));
        } else {
            $word->setValue('КУРС-ДОЛАРА', $this->set_style_color_warning("##########"));
            $word->setValue('КУРС-ДОЛАРА+5', $this->set_style_color_warning("##########"));
            $word->setValue('КУРС-ДОЛАРА-КУПІВЛЯ', $this->set_style_color_warning("##########"));
            $word->setValue('КУРС-ДОЛАРА-ПРОДАЖ', $this->set_style_color_warning("##########"));

            $this->notification("Warning", "Курс долара: інформація відсутня");
        }

        return $word;
    }

    /*
     * Довіреність на представника ПОКУПЦЯ
     * */
    public function set_client_representative_data($word)
    {
        if ($this->client->representative && $this->client->representative->notary) {
            $word->setValue('ПРЕДСТАВНИК-КЛ-НОТ-ПІБ-ІНІЦІАЛИ-О', $this->convert->get_surname_and_initials_o($this->client->representative->notary));
            $word->setValue('ПРЕДСТАВНИК-КЛ-НОТ-АКТ-О', $this->client->representative->notary->activity_o);
            $word->setValue('ПРЕДСТАВНИК-КЛ-НОТ-ДАТА', $this->display_date($this->client->representative->reg_date));
            $word->setValue('ПРЕДСТАВНИК-КЛ-НОТ-НОМЕР', $this->client->representative->reg_num);

            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-НОТ-ПІБ-ІНІЦІАЛИ-О', $this->convert->get_surname_and_initials_o($this->client->representative->notary));
            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-НОТ-АКТ-О', $this->client->representative->notary->activity_o);
            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-НОТ-ДАТА', $this->display_date($this->client->representative->reg_date));
            $word->setValue($this->total_clients . '-ПРЕДСТАВНИК-КЛ-НОТ-НОМЕР', $this->client->representative->reg_num);
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
            $word->setValue('ДД-НОМЕР', $this->contract->immovable->proxy->number);
            $word->setValue('ДД-ДАТА', $this->display_date($this->contract->immovable->proxy->date));
            $word->setValue('ДД-ДАТА-МС', $this->day_without_quotes_month_year($this->contract->immovable->proxy->date));

            $word->setValue('ДД-НОТ-ПІБ-ІНІЦІАЛИ-Н', $this->convert->get_surname_and_initials_n($this->contract->immovable->proxy->notary));
            $word->setValue('ДД-НОТ-ПІБ-ІНІЦІАЛИ-Р', $this->convert->get_surname_and_initials_r($this->contract->immovable->proxy->notary));
            $word->setValue('ДД-НОТ-ПІБ-ІНІЦІАЛИ-Д', $this->convert->get_surname_and_initials_d($this->contract->immovable->proxy->notary));
            $word->setValue('ДД-НОТ-ПІБ-ІНІЦІАЛИ-О', $this->convert->get_surname_and_initials_o($this->contract->immovable->proxy->notary));

            $word->setValue('ДД-НОТ-ДАТА', $this->display_date($this->contract->immovable->proxy->reg_date));
            $word->setValue('ДД-НОТ-НОМЕР', $this->contract->immovable->proxy->reg_num);
        } else {
            $this->notification("Warning", "Договір доручення: інформація відсутня");
        }

        return $word;
    }

    public function set_taxes_data_for_word($word)
    {
        $word->setValue('ЗБІР-З-ОПЕРАЦІЙ-ПРИДБАННЯ-1/2', round($this->contract->immovable->grn / 100 * 0.01 / 2, 2));
        $word->setValue('ПОДАТОК-НА-ДОХОДИ-ФІЗИЧНИХ-ОСІБ', round($this->contract->immovable->grn / 100 * 0.05, 2));
        $word->setValue('ВІЙСЬКОВИЙ-ЗБІР', round($this->contract->immovable->grn / 100 * 0.015, 2));

        return $word;
    }

    public function set_bank_account_data($word)
    {
        if ($this->bank_account_total_price)
            $word->setValue('СУМА-ДО-СПЛАТИ', $this->bank_account_total_price);
        else {
            if ($this->two_clients == 2) {
                if ($this->contract->immovable->security_payment)
                    $word->setValue('СУМА-ДО-СПЛАТИ', $this->convert->get_convert_price($this->contract->immovable->security_payment->last_part_grn / 2, 'grn'));
                else
                    $word->setValue('СУМА-ДО-СПЛАТИ', $this->convert->get_convert_price($this->contract->immovable->reserve_grn / 2, 'grn'));

            } else {
                if ($this->contract->immovable->security_payment)
                    $word->setValue('СУМА-ДО-СПЛАТИ', $this->convert->get_convert_price($this->contract->immovable->security_payment->last_part_grn, 'grn'));
                else
                    $word->setValue('СУМА-ДО-СПЛАТИ', $this->convert->get_convert_price($this->contract->immovable->reserve_grn, 'grn'));
            }
        }
//            $word->setValue('СУМА-ДО-СПЛАТИ', $this->convert->get_convert_price($this->contract->immovable->grn, 'grn'));



//        if ($this->two_clients == 2) {
//            if ($this->contract->immovable->security_payment)
//                $word->setValue('КВИТАНЦІЯ-Н-ЗАБ-ПЛ-Ч2-ГРН', $this->convert->get_convert_price($this->contract->immovable->security_payment->last_part_grn / 2, 'grn'));
//            else
//                $word->setValue('КВИТАНЦІЯ-Н-ЗАБ-ПЛ-Ч2-ГРН', $this->convert->get_convert_price($this->contract->immovable->reserve_grn / 2, 'grn'));
//
//        } else {
//            if ($this->contract->immovable->security_payment)
//                $word->setValue('КВИТАНЦІЯ-Н-ЗАБ-ПЛ-Ч2-ГРН', $this->convert->get_convert_price($this->contract->immovable->security_payment->last_part_grn, 'grn'));
//            else
//                $word->setValue('КВИТАНЦІЯ-Н-ЗАБ-ПЛ-Ч2-ГРН', $this->convert->get_convert_price($this->contract->immovable->reserve_grn, 'grn'));
//
//        }

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
                $imm_num_str = $this->convert->building_num_to_str($contract->immovable->immovable_number);
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
        $title = "«##» ###### ####";

        if ($date) {
            $day = $date->format('d');
            $month = MonthConvert::where('original', $date->format('m'))->orWhere('original', strval(intval($date->format('m'))))->value('title_r');
            $year = $date->format('Y');

            $title = "«" . $day . "»" . $this->non_break_space . $month . $this->non_break_space . $year;
        }

        return $title;
    }

    public function day_without_quotes_month_year($date)
    {
        $title = "## ###### ####";

        if ($date) {
            $day = $date->format('d');
            $month = MonthConvert::where('original', $date->format('m'))->orWhere('original', strval(intval($date->format('m'))))->value('title_r');
            $year = $date->format('Y');

            $title = $day . $this->non_break_space . $month . $this->non_break_space . $year;
        }

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

    public function set_style_color_warning($text)
    {
        $str = $this->style_color_red . $text . $this->style_end;

        return $str;
    }

    public function set_style_color_and_bold($text)
    {
        $str = $this->style_color_and_bold . $text . $this->style_end;

        return $str;
    }

    public function set_style_color_and_italic($text)
    {
        $str = $this->style_color_and_italic . $text . $this->style_end;

        return $str;
    }

    public function set_excel_taxes_data_for_one_client($sheet)
    {
        $developer = null;
        $taxes = BankTaxesList::get();

        $price = sprintf("%.2f", $this->contract->immovable->grn/100);
        $sheet->setCellValue("J1", $price);

        $i = 2;
        foreach ($taxes as $tax) {
            if ($tax->type == 'developer') {
                $pay_buy_client = $this->contract->dev_company->owner;
            } else {
                $pay_buy_client = $this->client;
            }

            $percent = $tax->percent / 10000; // 5% зберігається у форматі 500, 1% можна ділити на 100 частин
            $sheet->setCellValue("A{$i}", $price * $percent);
            $sheet->setCellValue("B{$i}", $this->convert->get_full_name_n($pay_buy_client));
            $sheet->setCellValue("C{$i}", $pay_buy_client->tax_code);
            $full_tax_info = $tax->code_and_edrpoy . $pay_buy_client->tax_code . $tax->appointment_payment . $this->convert->get_full_name_n($pay_buy_client);
            $sheet->setCellValue("E{$i}", $full_tax_info);

            $sheet->setCellValue("F{$i}", $tax->mfo);
            $sheet->setCellValue("G{$i}", $tax->bank_account);
            $sheet->setCellValue("H{$i}", $tax->name_recipient);
            $sheet->setCellValue("I{$i}", $tax->okpo);
            $i++;
        }

        $sheet->setCellValue("A8", "покупець");
        $sheet->setCellValue("B8", $this->convert->get_full_name_n($this->client));
        $sheet->setCellValue("C8", $this->client->tax_code);
        $sheet->setCellValue("B9", "продавець");
        $sheet->setCellValue("B9", $this->convert->get_full_name_n($this->contract->dev_company->owner));
        $sheet->setCellValue("C9", $this->contract->dev_company->owner->tax_code);
        $sheet->setCellValue("B10", $this->convert->building_full_address_with_imm_for_taxes($this->contract->immovable));
        $sheet->setCellValue("B11", $price);
        $sheet->setCellValue("B13", $this->client->phone);
        if ($this->contract->dev_representative) {
            $sheet->setCellValue("E9", "через " . $this->contract->dev_representative->surname_n);
        }

        return $sheet;
    }

    public function set_excel_taxes_data_for_two_clients($sheet)
    {
        $taxes = BankTaxesList::get();
        $developer = $this->contract->dev_company->owner;
        $first_client = $this->contract->clients[0];
        $second_client = $this->contract->clients[1];

        $price = sprintf("%.2f", $this->contract->immovable->grn/100);
        $sheet->setCellValue("J1", $price);

        $i = 2;
        foreach ($taxes as $tax) {
            $pay_buy_client = [];
            if ($tax->type == 'developer') {
                $pay_buy_client[] = $developer;
            } else {
                $pay_buy_client[] = $first_client;
                $pay_buy_client[] = $second_client;
            }

            $percent = $tax->percent / 10000; // 5% зберігається у форматі 500, 1% можна ділити на 100 частин
            foreach ($pay_buy_client as $client) {
                if ($tax->type == 'developer')
                    $sheet->setCellValue("A{$i}", $price * $percent);
                else
                    $sheet->setCellValue("A{$i}", $price * $percent / 2);
                $sheet->setCellValue("B{$i}", $this->convert->get_full_name_n($client));
                $sheet->setCellValue("C{$i}", $client->tax_code);
                $full_tax_info = $tax->code_and_edrpoy . $client->tax_code . $tax->appointment_payment . $this->convert->get_full_name_n($client);
                $sheet->setCellValue("E{$i}", $full_tax_info);

                $sheet->setCellValue("F{$i}", $tax->mfo);
                $sheet->setCellValue("G{$i}", $tax->bank_account);
                $sheet->setCellValue("H{$i}", $tax->name_recipient);
                $sheet->setCellValue("I{$i}", $tax->okpo);
                $i++;
            }
        }

        $sheet->setCellValue("A9", "покупець 1");
        $sheet->setCellValue("B9", $this->convert->get_full_name_n($first_client));
        $sheet->setCellValue("C9", $first_client->tax_code);
        $sheet->setCellValue("A10", "покупець 2");
        $sheet->setCellValue("B10", $this->convert->get_full_name_n($second_client));
        $sheet->setCellValue("C10", $second_client->tax_code);
        $sheet->setCellValue("B11", "продавець");
        $sheet->setCellValue("B11", $this->convert->get_full_name_n($developer));
        $sheet->setCellValue("C11", $developer->tax_code);
        $sheet->setCellValue("B12", $this->convert->building_full_address_with_imm_for_taxes($this->contract->immovable));
        $sheet->setCellValue("B13", $price);
        $sheet->setCellValue("B15", $first_client->phone);
        if ($this->contract->dev_representative) {
            $sheet->setCellValue("E11", "через " . $this->contract->dev_representative->surname_n);
        }

        return $sheet;
    }

    public function get_rate_by_company($card_id, $dev_company)
    {
        $exchange_rate = ExchangeRate::where('card_id', $card_id)->first();

        if ($dev_company->contract_rate == true) {
            $rate = $exchange_rate->contract_buy;
        } else {
            $rate = $exchange_rate->rate;
        }

        return $rate;
    }

    public function check_both_client_not_married($clients)
    {
        if (count($clients) > 1)
            $both_client_not_married = true;
        else
            $both_client_not_married = false;

        foreach ($clients as $client) {

            if ($client->spouse) {
                $both_client_not_married = false;
            }
        }

        return $both_client_not_married;
    }

    public function get_contract_clients($contract)
    {
        $result = [];

        if (!$contract)
            return $result;

        $clients_id = ClientContract::where('contract_id', $contract->id)->whereIn('previous_buyer', [null, 0])->pluck('client_id');

        $result = Client::whereIn('id', $clients_id)->get();

        if ($result && count($result) == 2) {
            $first_client = $result[0];
            $second_client = $result[1];

            if ($first_client->representative) {
                unset($result);
                $result = [];
                $result[0] = $second_client;
                $result[1] = $first_client;
            }
        }

        return $result;
    }

    public function get_termination_clients($termination_info)
    {
        $result = [];

        if ($termination_info) {
            if ($termination_info->first_client_id)
                $result[] = Client::find($termination_info->first_client_id);

            if ($termination_info->second_client_id)
                $result[] = Client::find($termination_info->second_client_id);
        }

        return $result;
    }

    public function change_font_size()
    {
        $this->style_bold = "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Rakul\" w:hAnsi=\"Times New Rakul\" w:cs=\"Times New Rakul\"/><w:b/><w:sz w:val=\"24\"/><w:szCs w:val=\"24\"/></w:rPr><w:t xml:space=\"preserve\">";
        $this->style_color_and_bold = "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Rakul\" w:hAnsi=\"Times New Rakul\" w:cs=\"Times New Rakul\"/><w:b/><w:sz w:val=\"24\"/><w:szCs w:val=\"24\"/><w:highlight w:val=\"yellow\"/></w:rPr><w:t xml:space=\"preserve\">";
        $this->style_end = "</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii=\"Times New Rakul\" w:hAnsi=\"Times New Rakul\" w:cs=\"Times New Rakul\"/><w:sz w:val=\"24\"/><w:szCs w:val=\"24\"/></w:rPr><w:t xml:space=\"preserve\">";
    }
}
