<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImmFence extends Model
{
    use HasFactory;

    protected $fillable = [
            'date',
            'number',
            'pass',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function immovable()
    {
        return $this->belongsTo(Immovable::class);
    }
}
