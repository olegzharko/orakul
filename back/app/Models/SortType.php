<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SortType extends Model
{
    use HasFactory;

    public static function get_all_sort_type()
    {
        return SortType::select('id', 'title')->get();
    }
}