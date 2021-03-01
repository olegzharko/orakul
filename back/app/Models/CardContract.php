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
}
