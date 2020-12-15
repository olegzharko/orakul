<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Immovable extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function immovable_type()
    {
        return $this->belongsTo(ImmovableType::class);
    }

    public function developer_address()
    {
        return $this->belongsTo(DeveloperAddress::class);
    }

    public function roominess()
    {
        return $this->belongsTo(AppartmentType::class, 'appartment_type_id');
    }

    public static function get_immovable($immovable_id)
    {
        $immovable = Immovable::where('id', $immovable_id)->first();
        $immovable->grn = number_format($immovable->developer_price / 100, 0, ".",  " " );
        $immovable->coin = sprintf("%02d", number_format($immovable->developer_price % 100));

        return $immovable;
    }

}
