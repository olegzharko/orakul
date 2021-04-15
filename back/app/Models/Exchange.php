<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exchange extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function get_minfin_rate()
    {
        return Exchange::orderBy('created_at', 'desc')->value('rate');
    }
}
