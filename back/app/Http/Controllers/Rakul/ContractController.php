<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Immovable;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function add_contracts($clients, $developer, $assistant, $manager, $immovables_id)
    {
        foreach ($clients as $client) {
            $this->create($client, $developer, $assistant, $manager, $immovables_id);
        }
    }

    public function create($client, $developer, $assistant, $manager, $immovables_id)
    {
        foreach ($immovables_id as $imm_id) {
            if ($this->fresh_contract($developer, $imm_id)) {
                $imm = new Contract();
                $imm->immovable_id = $imm_id;
                $imm->dev_company_id = $developer ? $developer->id : null;
                $imm->dev_representative_id = $assistant ? $assistant->id : null;
                $imm->manager_id = $manager ? $manager->id : null;
                $imm->save();
            }
        }
    }

    public function fresh_contract($developer, $imm_id)
    {
        $contract = Contract::where([
            'immovable_id' => $imm_id,
            'dev_company_id' => $developer->id,
        ])->first();

        if ($contract)
            return false;
        else
            return true;
    }
}
