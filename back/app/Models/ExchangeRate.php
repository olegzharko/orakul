<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExchangeRate extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'deleted_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'card_id',
        'rate',
        'contract_buy',
        'contract_sell',
        'nbu_ask',
        'updated_at',
    ];

    public function immovable()
    {
        return $this->belongsTo(Immovable::class, 'immovable_id');
    }

//    public static function get_rate_by_card_id($card_id)
//    {
////        return ExchangeRate::where('card_id', $card_id)->value('rate');
//        return ExchangeRate::where('card_id', $card_id)->get();
//    }

    public static function update_rate($card_id, $rate)
    {
        ExchangeRate::updateOrCreate(['card_id' => $card_id], ['rate' => $rate]);
    }
}
