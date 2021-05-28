<?php

namespace App\Http\Controllers\Factory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KeyWord;
//use MongoDB\Driver\Session;
use URL;
use Auth;
use Session;

class FolderFileController extends Controller
{
    public $contract;

    public $root_http;
    public $generate_path;
    public $date_month;
    public $contract_type;
    public $developer_company;
    public $subscriber;
    public $client_surname;
    public $address_type;
    public $address_title;
    public $address_num;
    public $immovable_type;
    public $immovable_num;
    public $married;
    public $consent;
    public $consent_template_title;
    public $developer_statement;
    public $termination_contract;
    public $questionnaires;
    public $bank_account_payment;
    public $bank_taxes_payment;
    public $spouses_male;
    public $file_type_docx;
    public $file_type_excel;

    public function __construct($contract)
    {
        $this->contract = $contract;

        $this->root_http = URL::to('/') . "/";
        $this->generate_path = null;
        $this->date_month = null;
        $this->contract_type = null;
        $this->developer_company = null;
        $this->subscriber = null;
        $this->client_surname = null;
        $this->address_type = null;
        $this->address_title = null;
        $this->address_num = null;
        $this->immovable_type = null;
        $this->immovable_num = null;
        $this->married = null;
        $this->consent = null;
        $this->consent_template_title = null;
        $this->developer_statement = null;
        $this->questionnaires = null;
        $this->bank_account_payment = null;
        $this->bank_taxes_payment = null;
        $this->termination_contract = null;
        $this->spouses_male = null;
        $this->file_type_docx = ".docx";
        $this->file_type_excel = ".xlsx";

        $this->set_value();
        $this->save_folder();
    }


    private function set_value()
    {
        if (!$this->contract) {
            dd("Warning: There are no contract to create folder or file");
        }

        if ($this->contract->event_datetime) {
            $this->date_month = $this->contract->event_datetime->format('d.m');
        }

        if ($this->contract->template && $this->contract->template->template_type) {
            $this->contract_type = $this->contract->template->template_type->title;
        }

        if ($this->contract->dev_company) {
            $this->developer_company = $this->contract->dev_company->title;
        }

        if ($this->contract->assistant) {
            $this->subscriber .= $this->contract->assistant->surname_n;
        } elseif ($this->contract->dev_company && $this->contract->dev_company->owner) {
            $this->subscriber = $this->contract->dev_company->owner->surname_n;
        }

        if ($this->contract->client) {
            $this->client_surname = $this->contract->client->surname_n;
        }

        if ($this->contract->immovable && $this->contract->immovable->developer_building) {
            if ($this->contract->immovable->developer_building->address_type)
                $this->address_type = $this->contract->immovable->developer_building->address_type->short;
            $this->address_title = $this->contract->immovable->developer_building->title;
            $this->address_num = $this->contract->immovable->developer_building->number;
        }

        if ($this->contract->immovable) {
            if ($this->contract->immovable->immovable_type)
                $this->immovable_type = $this->contract->immovable->immovable_type->short;
            $this->immovable_num = $this->contract->immovable->immovable_number;
        }

        if ($this->contract->client) {
            if ($this->contract->client->married) {
                $this->married = "в шл";
            } else {
                $this->married = "не в шл";
            }
        }

        if ($this->contract->client &&  $this->contract->client->married->spouse) {
            $this->spouses_male = KeyWord::where('key', $this->contract->client->married->spouse->gender)->value('title_r');
        }

        if ($this->contract->developer_statement && $this->contract->developer_statement->template) {
            $this->developer_statement = $this->contract->developer_statement->template->title;
        }

        if ($this->contract->questionnaire && $this->contract->questionnaire->template) {
            $this->questionnaires = $this->contract->questionnaire->template->title;
        }

        if ($this->contract->bank_account_payment && $this->contract->bank_account_payment->template) {
            $this->bank_account_payment = $this->contract->bank_account_payment->template->title;
        }

        if ($this->contract->bank_taxes_payment && $this->contract->bank_taxes_payment->template) {
            $this->bank_taxes_payment = $this->contract->bank_taxes_payment->template->title;
        }
    }

    public function root_title()
    {

        $type = $this->contract->template ? $this->contract->template->type->title : ' - ';


        $title = ""
            . "{$this->date_month} $type {$this->developer_company} ({$this->subscriber}) - "
            . "{$this->client_surname} {$this->address_type} {$this->address_title} "
            . "{$this->address_num} {$this->immovable_type} {$this->immovable_num} {$this->married} ";

        $title = trim($title);
        $title = str_replace("/", "-", $title);


        return $title;
    }

    public function save_folder()
    {
        // Однакова назва для папки та договору
        $folder = $this->root_title();
        // echo "{$folder}<br><br>";
        $dev_company = $this->contract->dev_company->title;

        // Створення папки забудовника
        if (!file_exists("{$dev_company}"))
            mkdir($dev_company, 0777, true);
        // Створення папки договору для конкретної угоди
        if (file_exists("$dev_company/$folder")) {}
            $this->deleteDirectory("$dev_company/$folder");
        if (!file_exists("{$dev_company}/{$folder}"))
            mkdir("$dev_company/$folder", 0777, true);

        $this->generate_path = "{$dev_company}/{$folder}";
    }

    public function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
    }

    public function contract_title()
    {
        $title = null;
        $title = "{$this->generate_path}/" . $this->root_title() . "{$this->file_type_docx}";

//        $title = str_replace(" ", "_", $title);

        $title = trim($title);

        $template = $this->file_path($this->contract->template);

        $this->create_file_for_contract($template, $title);
        return $title;
    }

    public function consent_title($consent)
    {
        $title = null;

        if ($consent && $consent->template) {
            $this->consent_template_title = $consent->template->title . " " . $consent->client->surname_n . " " . $consent->client->tax_code;
        }

        $title = "{$this->generate_path}/"
            . "{$this->consent_template_title}"
            . "{$this->file_type_docx}"
            . "";

        $template = $this->file_path($consent->template);
        $this->create_file_for_contract($template, $title);
        return $title;
    }

    public function termination_consent_title($termination_consent, $client)
    {
        $title = null;

        $title = "{$this->generate_path}/"
            . $termination_consent->template->title . " " . $client->surname_n
            . "$this->file_type_docx"
            . "";

        $template = $this->file_path($termination_consent->template);
        $this->create_file_for_contract($template, $title);
        return $title;
    }

    public function developer_statement_title()
    {
        $title = null;
        $title = "{$this->generate_path}/"
            . "{$this->developer_statement} {$this->subscriber} {$this->client_surname}"
            . "{$this->file_type_docx}"
            . "";

        $template = $this->file_path($this->contract->developer_statement->template);
        $this->create_file_for_contract($template, $title);
        return $title;
    }

    public function developer_consent_title()
    {
        $template_title = $this->contract->dev_company->owner->developer_consent->template->title;
        $surname = $this->contract->dev_company->owner->surname_n;
        $title = null;
        $title = "{$this->generate_path}/"
            . "$template_title $surname"
            . "{$this->file_type_docx}"
            . "";

        $template = $this->file_path($this->contract->dev_company->owner->developer_consent->template);
        $this->create_file_for_contract($template, $title);
        return $title;
    }

    public function communal_title($client, $template)
    {
        $title = null;
        $title = "{$this->generate_path}/"
            . "$template->title $this->subscriber $client->surname_n $client->tax_code"
            . "$this->file_type_docx"
            . "";

        $template = $this->file_path($template);
        $this->create_file_for_contract($template, $title);
        return $title;
    }

    public function termination_contract_title()
    {
        $title = null;
        $title = "{$this->generate_path}/"
            . $this->contract->termination_contract->template->title
            . $this->file_type_docx
            . "";

        $template = $this->file_path($this->contract->termination_contract->template);
        $this->create_file_for_contract($template, $title);

        return $title;
    }

    public function termination_refund_title()
    {
        $title = null;
        $title = "{$this->generate_path}/"
            . $this->contract->termination_refund->template->title
            . $this->file_type_docx
            . "";

        $template = $this->file_path($this->contract->termination_refund->template);
        $this->create_file_for_contract($template, $title);

        return $title;
    }

    public function questionnaire_title()
    {
        $title = null;
        $title = "{$this->generate_path}/"
            . "{$this->questionnaires} {$this->subscriber} {$this->client_surname}"
            . "{$this->file_type_docx}"
            . "";

        $template = $this->file_path($this->contract->questionnaire->template);

        $this->create_file_for_contract($template, $title);
        return $title;
    }

    public function bank_account_title()
    {
        $title = null;
        $title = "{$this->generate_path}/"
            . "{$this->bank_account_payment}"
            . "{$this->file_type_docx}"
            . "";


        $template = $this->file_path($this->contract->bank_account_payment->template);

        $this->create_file_for_contract($template, $title);

        return $title;
    }

    public function bank_taxes_title($client)
    {
        $title = null;
        $title = "{$this->generate_path}/"
            . "{$this->bank_taxes_payment} (" . $client->surname_n . ")"
            . "{$this->file_type_excel}"
            . "";

        $template = $this->file_path($this->contract->bank_taxes_payment->template);
        $this->create_file_for_contract($template, $title);
        return $title;
    }

    /*
     * В проекті використовується плагін для зберігання файлів який веде облік файлів в оквремій таблиці
     * */
    public function file_path($model)
    {
        if ($file = $model->getMedia('path')->first()) {
//            $template->document = str_replace(URL::to('/'), '', $file->getUrl());
            $model->document_path = $file->getUrl();
        } else {
            $model->document_path = null;
        }

        return $model->document_path;
    }

    public function create_file_for_contract($template, $title)
    {
        if (!file_exists($title)) {
//            $data = file_get_contents($template);

            $data =curl_init();
            curl_setopt($data, CURLOPT_URL,$template);
            curl_setopt($data, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($data, CURLOPT_USERAGENT, 'Document Template');
            $result = curl_exec($data);
            curl_close($data);

            file_put_contents($title, $result);
        }
    }
}
