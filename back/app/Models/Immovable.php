<?php

namespace App\Models;

use App\Models\NumericConvert;
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

    public static function get_immovable($immovable)
    {
        $immovable->grn = number_format($immovable->developer_price / 100, 0, ".",  " " );
        $immovable->coin = sprintf("%02d", number_format($immovable->developer_price % 100));
        $immovable->building_number_string = \App\Models\NumericConvert::where('original', $immovable->building_number)->value('title_n');
        $immovable->immovable_number_string = \App\Models\NumericConvert::where('original', $immovable->immovable_number)->value('title_n');
        $immovable->fence = \App\Models\ImmFence::where('immovable_id', $immovable->id)->first();
//        $immovable->address_area = Immovable::imm_address($immovable);

        return $immovable;
    }

//    public static function imm_address($imm)
//    {
//        $result;
//
//        $city_type = $imm->developer_address->developer_city->city_type->title_m;
//        $city_title = $imm->developer_address->developer_city->title_n;
//        $district = $imm->developer_address->developer_city->district->title_r;
//        $region = $imm->developer_address->developer_city->region->title_r;
//        $result = "$city_type $city_title, $district $region";
//
//        return $result;
//    }
}
