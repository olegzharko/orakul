<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'card_id',
        'number_of_people',
        'children',
        'room_id',
        'in_progress',
        'representative_arrived',
        'arrival_time',
        'invite_time',
        'waiting_time',
        'total_time',
    ];

    protected $casts = [
        'arrival_time' => 'datetime',
        'waiting_time' => 'datetime',
        'total_time' => 'datetime',
        'deleted_at' => 'datetime',
        'updated_at' => 'datetime',
        'children' => 'boolean',
        'in_progress' => 'boolean',
        'representative_arrived' => 'boolean',
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
