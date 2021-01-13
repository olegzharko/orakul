<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthConvert extends Model
{
    use HasFactory;

    public static function convert($num_month)
    {
        $month = MonthConvert::where('original', $num_month)->orWhere('original', strval(intval($num_month)))->first();

        return $month;
    }
}
