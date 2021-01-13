<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class City extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $table = "cities";

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function city_type()
    {
        return $this->belongsTo(CityType::class);
    }

    public static function get_event_city($city_id)
    {
        return City::where('id', $city_id)->first();

//
//        $city_type_n = $city->city_type->title_z;
//        $city_title_n = $city->title_n;
//        $city_district_r = $city->district->title_r;
//        $city_region_r = $city->region->title_r;
//        dd($city_type_n, $city_title_n, $city_district_r, $city_region_r);
    }
}
