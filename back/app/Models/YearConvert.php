<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class YearConvert extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public static function convert($num_year)
    {
        $month = YearConvert::where('original', $num_year)->orWhere('original', strval(intval($num_year)))->first();

        return $month;
    }
}
