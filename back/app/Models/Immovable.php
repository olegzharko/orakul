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

    public function developer_building()
    {
        return $this->belongsTo(DeveloperBuilding::class);
    }

    public function roominess()
    {
        return $this->belongsTo(AppartmentType::class, 'roominess_id');
    }

    public function proxy()
    {
        return $this->belongsTo(Proxy::class, 'proxy_id');
    }

    public function security_payment()
    {
        return $this->hasOne(SecurityPayment::class, 'immovable_id');
    }

    public function exchange_rate()
    {
        return $this->hasOne(ExchangeRate::class, 'immovable_id');
    }

    public function pvprice()
    {
        return $this->hasOne(PropertyValuationPrice::class, 'immovable_id');
    }

    public static function get_immovable($immovable)
    {
        $immovable->building_number_string = \App\Models\NumericConvert::where('original', $immovable->developer_building->number)->value('title_n');
        $immovable->immovable_number_string = \App\Models\NumericConvert::where('original', $immovable->immovable_number)->value('title_n');
        $immovable->fence = \App\Models\ImmFence::where('immovable_id', $immovable->id)->first();
        $immovable->immovable_full_ascending_address_r = Immovable::full_ascending_address_r($immovable);
        $immovable->building_address = Immovable::building_address_r($immovable);
        $immovable->immovable_full_descending_address_n = Immovable::full_descending_address_n($immovable);

        return $immovable;
    }

    public static function full_ascending_address_r($immovable)
    {
        $imm_num = $immovable->immovable_number;
        $imm_num_str = $immovable->immovable_number_string;
        $imm_build_num = $immovable->developer_building->number;
        $imm_build_num_str = $immovable->building_number_string;
        $imm_addr_type_n = $immovable->developer_building->address_type->title_n;
        $imm_addr_type_r = $immovable->developer_building->address_type->title_r;
        $imm_addr_title = $immovable->developer_building->title;
        $imm_city_type_n = $immovable->developer_building->city->city_type->title_n;
        $imm_city_type_r = $immovable->developer_building->city->city_type->title_r;
        $imm_city_type_m = $immovable->developer_building->city->city_type->title_m;
        $imm_city_title_n = $immovable->developer_building->city->title_n;
        $imm_dis_title_n = $immovable->developer_building->city->district->title_n;
        $imm_dis_title_r = $immovable->developer_building->city->district->title_r;
        $imm_reg_title_n = $immovable->developer_building->city->region->title_n;
        $imm_reg_title_r = $immovable->developer_building->city->region->title_r;

        $address = "номер $imm_num ($imm_num_str), що знаходиться в будинку номер $imm_build_num ($imm_build_num_str) по "
                 . "$imm_addr_type_r $imm_addr_title у $imm_city_type_m $imm_city_title_n, "
                 . "$imm_dis_title_r району "
                 . "$imm_reg_title_r області"
                 . "";

        return $address;
    }

    public static function full_descending_address_n($immovable)
    {
        $imm_num = $immovable->immovable_number;
        $imm_num_str = $immovable->immovable_number_string;
        $imm_build_num = $immovable->developer_building->number;
        $imm_build_num_str = $immovable->building_number_string;
        $imm_addr_type_n = $immovable->developer_building->address_type->title_n;
        $imm_addr_type_r = $immovable->developer_building->address_type->title_r;
        $imm_addr_title = $immovable->developer_building->title;
        $imm_city_type_n = $immovable->developer_building->city->city_type->title_n;
        $imm_city_type_r = $immovable->developer_building->city->city_type->title_r;
        $imm_city_type_m = $immovable->developer_building->city->city_type->title_m;
        $imm_city_title_n = $immovable->developer_building->city->title_n;
        $imm_dis_title_n = $immovable->developer_building->city->district->title_n;
        $imm_dis_title_r = $immovable->developer_building->city->district->title_r;
        $imm_reg_title_n = $immovable->developer_building->city->region->title_n;
        $imm_reg_title_r = $immovable->developer_building->city->region->title_r;

        $address = ""
            . "$imm_reg_title_n область, "
            . "$imm_dis_title_n район, "
            . "$imm_city_type_n $imm_city_title_n, "
            . "$imm_addr_type_n $imm_addr_title, "
            . "будинок $imm_build_num ($imm_build_num_str), "
            . "квартира $imm_num ($imm_num_str)"
            . "";

        return $address;
    }

    public static function building_address_r($immovable)
    {
        $imm_num = $immovable->immovable_number;
        $imm_num_str = $immovable->immovable_number_string;
        $imm_build_num = $immovable->developer_building->number;
        $imm_build_num_str = $immovable->building_number_string;
        $imm_addr_type_n = $immovable->developer_building->address_type->title_n;
        $imm_addr_type_r = $immovable->developer_building->address_type->title_r;
        $imm_addr_title = $immovable->developer_building->title;
        $imm_city_type_n = $immovable->developer_building->city->city_type->title_n;
        $imm_city_type_r = $immovable->developer_building->city->city_type->title_r;
        $imm_city_type_m = $immovable->developer_building->city->city_type->title_m;
        $imm_city_title_n = $immovable->developer_building->city->title_n;
        $imm_dis_title_n = $immovable->developer_building->city->district->title_n;
        $imm_dis_title_r = $immovable->developer_building->city->district->title_r;
        $imm_reg_title_n = $immovable->developer_building->city->region->title_n;
        $imm_reg_title_r = $immovable->developer_building->city->region->title_r;

        $address = ""
            . "$imm_reg_title_n область, "
            . "$imm_dis_title_n район, "
            . "$imm_city_type_n $imm_city_title_n, "
            . "$imm_addr_type_n $imm_addr_title, "
            . "будинок $imm_build_num ($imm_build_num_str)"
            . "";

        return $address;
    }
}
