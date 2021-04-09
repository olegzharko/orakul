<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DevFence extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'dev_company_id',
        'card_id',
        'number',
        'date',
        'pass',
    ];

    protected $casts = [
        'date' => 'datetime',
        'deleted_at' => 'datetime',
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
