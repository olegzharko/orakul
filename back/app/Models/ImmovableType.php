<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImmovableType extends Model implements Sortable
{
    use HasFactory, SortableTrait, SoftDeletes;

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public static function get_immovable_type()
    {
        return ImmovableType::select('id', 'title_n as title')->get();
    }
}
