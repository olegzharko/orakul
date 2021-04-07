<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthConvert extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public static function convert($num_month = null)
    {
        $month = MonthConvert::where('original', $num_month)->orWhere('original', strval(intval($num_month)))->first();

        return $month;
    }
}
