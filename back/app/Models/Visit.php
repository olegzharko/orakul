<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $casts = [
        'arrival_time' => 'datetime',
        'waiting_time' => 'datetime',
        'total_time' => 'datetime',
        'deleted_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
