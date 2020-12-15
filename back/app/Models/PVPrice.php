<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class PVPrice extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function immovable()
    {
        return $this->belongsTo(Immovable::class);
    }

    public function property_valuation()
    {
        return $this->belongsTo(PropertyValuation::class, 'pv_id', 'id');
    }

    public static function get_pvprice($pvprice_id)
    {
        $pvprice = PVPrice::where('id', $pvprice_id)->first();
        $pvprice->date_format = $pvprice->date->format('d.m.Y');
        $pvprice->grn =  number_format(intval($pvprice->price / 100), 0, ".",  " " );
        $pvprice->coin = sprintf("%02d", number_format($pvprice->price % 100));

        return $pvprice;
    }
}
