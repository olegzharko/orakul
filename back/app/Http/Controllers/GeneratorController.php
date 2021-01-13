<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Word\WordConsentController;
use App\Http\Controllers\Word\WordStatementController;
use Illuminate\Http\Request;

class GeneratorController extends Controller
{
    public $word;

    public $contract;
    public $contract_data;

    public $consent;
    public $consent_data;
    public $word_consent;

    public $statement;
    public $statement_data;
    public $word_statement;

    public function __construct()
    {
        $this->contract = null;
        $this->contract_data = null;

        $this->consent = null;
        $this->consent_data = null;
        $this->word_consent = null;

        $this->statement = null;
        $this->statement_data = null;
        $this->word_statement = null;
    }

    public function creat_contract(Request $request)
    {
        $id = $request->input('id');

        // Угода по нерухомості підготовка данних
        $this->contract = new ContractController();
        $this->contract_data = $this->contract->get_contract($id);

        // Згода подружжя підготовка данних
//        $this->consent = new ConsentController();
//        $this->consent_data = $this->consent->get_consent_spouses($this->contract_data->client);

        // Запит підготовка данних
//         $this->statement = new StatementController();
//         $this->statement_data = $this->statement->get_statement_spouses($this->contract_data);

        // Угода друк данних
        $this->word = new WordController();
        $this->word->contract_template_set_data($this->contract_data);
        $this->word->consent_template_set_data($this->contract_data);
        $this->word->developer_statement_template_set_data($this->contract_data);
        $this->word->questionnaire_template_set_data($this->contract_data);

        // Згода подружжя друк данних
//        $this->word_consent = new WordConsentController();
//        $this->word_consent->consent_template_set_data($this->consent, $this->contract_data);

        // Запит друк данних
//        $this->word_statement = new WordStatementController();
//        $this->word_statement->statement_template_set_data($this->statement, $this->contract_data);
    }
}
