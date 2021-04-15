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
    ];

    protected $fillable = [
      'immovable_id',
      'rate',
    ];

    public function immovable()
    {
        return $this->belongsTo(Immovable::class, 'immovable_id');
    }

    public static function get_rate_by_imm_id($card_id)
    {
        return ExchangeRate::where('card_id', $card_id)->value('rate');
    }

    public function update_rate($card_id, $rate)
    {
        ExchangeRate::updateOrCreate(['card_id' => $card_id], ['rate' => $rate]);
    }
}
