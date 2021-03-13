<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\Controller;
use App\Models\CardContract;
use App\Models\Contract;
use App\Models\Immovable;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function add_contracts_on_immovabel($card_id, $immovables_info)
    {
        foreach ($immovables_info as $imm) {

            if (!$contract = Contract::where('immovable_id', $imm['immovable_id'])->first()) {
                $contract = new Contract();
                $contract->immovable_id = $imm['immovable_id'];
                $contract->bank = $imm['bank'];
                $contract->proxy = $imm['proxy'];
                $contract->type_id = $imm['contract_type_id'];
                $contract->save();

                $card_contract = new CardContract();
                $card_contract->card_id = $card_id;
                $card_contract->contract_id = $contract->id;
                $card_contract->save();
            }
        }
    }

    public function delete_contracts_by_immovables_id($immovables_id)
    {
        Contract::whereIn('immovable_id', $immovables_id)->delete();
    }
}
