<?php

namespace App\Http\Controllers\Word;

use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\TemplateProcessor;

class WordStatementController extends Controller
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
//    public function statement_template_set_data($consent, $contract)
//    {
//        $this->consent = $consent;
//        $this->contract = $contract;
//
//        $this->consent->consents_template->getMedia('path')->first();
//        $filename = "Згода.docx";
//        $file_path = $this->get_statement_path();
//
//        $word = new TemplateProcessor($file_path);
//
//        $word->setValue('ntr-actvt-n', $this->contract->str_year->title_r);
//
//        $word->saveAs($filename);
//    }
//
//    public function get_statement_path()
//    {
//
//    }
}
