<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardContract extends Model
{
    use HasFactory;

    protected $table = "card_contract";

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public static function get_card_by_contract($contract_id)
    {
        return CardContract::select(
            'cards.*',
        )->where('card_contract.contract_id', $contract_id)->join('cards', 'cards.id', '=', 'card_contract.card_id')->first();
    }
}
