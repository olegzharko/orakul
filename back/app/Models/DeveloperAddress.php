<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class DeveloperAddress extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $table = "developer_address";

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function developer_city()
    {
        return $this->belongsTo(DeveloperCity::class);
    }

    public function address_type()
    {
        return $this->belongsTo(AddressType::class);
    }
}
