<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Notary extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $fillable = [
            'surname_n',
            'name_n',
            'short_name',
            'patronymic_n',
            'short_patronymic',
            'surname_o',
            'name_o',
            'patronymic_o',
            'activity_n',
            'activity_o',
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

//    public static function get_notary($notary_id)
//    {
//        $notary = Notary::where('id', $notary_id)->first();
//
//        return $notary;
//    }
}
