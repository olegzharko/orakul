<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $fillable = [
      'immovable_id',
      'rate',
    ];

    public function immovable()
    {
        return $this->belongsTo(Immovable::class, 'immovable_id');
    }
}
