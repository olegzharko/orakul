<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RakulController extends Controller
{
    public $word;
    public $contract;
    public $contract_ctrl;

    public function __construct()
    {
        $this->contract = null;
        $this->contract_ctrl = null;
    }

    public function create_contract(Request $request)
    {
        $id = $request->input('id');

        $this->contract_ctrl = new ContractController();
        $this->contract = $this->contract_ctrl->get_contract($id);

        $this->word = new WordController($this->contract);
        $this->word->read_contract_template();


    }
}
