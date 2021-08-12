<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankFiles extends Model
{
    use HasFactory;

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }
}
