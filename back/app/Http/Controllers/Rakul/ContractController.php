<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Immovable;
use App\Models\Card;
use App\Models\NotaryService;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function add_contracts_on_immovabel($card_id, $immovables_info)
    {
        $card = Card::find($card_id);

        foreach ($immovables_info as $imm) {

            if (!$contract = Contract::where('immovable_id', $imm['immovable_id'])->first()) {

                $notary_service_id = NotaryService::where(['dev_group_id' => $card->dev_group->id, 'contract_type_id' => $imm['contract_type_id']])->value('id');

                $contract = new Contract();
                $contract->immovable_id = $imm['immovable_id'];
                $contract->bank = $imm['bank'];
                $contract->proxy = $imm['proxy'];
                $contract->type_id = $imm['contract_type_id'];
                $contract->card_id = $card_id;
                $contract->notary_service_id = $notary_service_id;
                $contract->save();
            }
        }
    }

    public function delete_contracts_by_immovables_id($immovables_id)
    {
        Contract::whereIn('immovable_id', $immovables_id)->delete();
    }
}
