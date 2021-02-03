<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityPayment extends Model
{
    use HasFactory;

    protected $casts = [
      'sign_date' => 'datetime',
      'final_date' => 'datetime',
    ];

    public function immovable()
    {
        return $this->belongsTo(Immovable::class, 'immovable_id');
    }
}
