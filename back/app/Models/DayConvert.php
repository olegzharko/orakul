<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DayConvert extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public static function convert($num_day)
    {
        $day = DayConvert::where('original', $num_day)->orWhere('original', strval(intval($num_day)))->first();

        return $day;
    }
}
