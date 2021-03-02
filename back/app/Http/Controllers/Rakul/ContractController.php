<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\Controller;
use App\Models\CardContract;
use App\Models\Contract;
use App\Models\Immovable;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function add_contracts_on_immovabel($card_id, $immovables_id)
    {
        foreach ($immovables_id as $imm_id) {
            $contract = Contract::where('immovable_id', $imm_id)->first();

            if (!$contract) {
                $contract = new Contract();
                $contract->immovable_id = $imm_id;
                $contract->save();

                if ($contract) {
                    $card_contract_exist = CardContract::where('card_id', $card_id)->where('contract_id', $contract->id)->first();
                    if (!$card_contract_exist) {
                        $card_contract = new CardContract();
                        $card_contract->card_id = $card_id;
                        $card_contract->contract_id = $contract->id;
                        $card_contract->save();
                    } else {
                        echo "ID катки та договору вже використувуються<br>";

                    }
                } else {
                    echo "Договір не був створений<br>";
                }
            }
        }
    }

    public function delete_contracts_by_immovables_id($immovables_id)
    {
        Contract::whereIn('immovable_id', $immovables_id)->delete();
    }
}
