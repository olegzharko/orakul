<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayConvert extends Model
{
    use HasFactory;

    public static function convert($num_day)
    {
        $day = DayConvert::where('original', $num_day)->orWhere('original', strval(intval($num_day)))->first();

        return $day;
    }
}
