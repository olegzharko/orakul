<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevFence extends Model
{
    use HasFactory;

    protected $casts = [
        'date' => 'datetime',
    ];

//    public function developer()
//    {
//        return $this->belongsTo(Client::class);
//    }

    public function immovable()
    {
        return $this->belongsTo(Immovable::class);
    }
}
