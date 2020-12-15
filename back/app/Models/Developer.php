<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Developer extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $casts = [
        'birthday' => 'datetime',
        'passport_date' => 'datetime',
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function developer_spouses()
    {
        return $this->belongsTo(DeveloperSpouse::class);
    }

    public function passport_type()
    {
        return $this->belongsTo(PassportType::class, 'passport_type_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function city_type()
    {
        return $this->belongsTo(CityType::class, 'city_type_id');
    }

    public function address_type()
    {
        return $this->belongsTo(AddressType::class, 'address_type_id');
    }

    public static function get_developer($developer_id)
    {
        $developer = Developer::select(
            "id",
            "title",
            "surname",
            "name",
            "patronymic",
            "developer_spouses_id",
            "tax_code",
            "passport_type_id",
            "passport_code",
            "passport_date",
            "passport_department",
            "passport_demographic_code",
            "region_id",
            "city_type_id",
            "city",
            "address_type_id",
            "address",
            "building",
            "apartment",
            "birthday",
        )->where('id', $developer_id)->with('passport_type')->first();

        $developer->address_full = Developer::convert_address($developer);

        return $developer;
    }

    public static function convert_address($d)
    {
        $region_type_short = trim(GlobalText::where('key', 'region')->value('short'));
        $region_title = trim($d->region->title);
        $city_type_short = trim($d->city_type->short);
        $city_title = trim($d->city);
        $address_type_short = trim($d->address_type->short);
        $address_title = trim($d->address);
        $building_type_short = trim(GlobalText::where('key', 'building')->value('short'));
        $building = trim($d->building);


        $apartment = $d->apartment ? ", " . trim(GlobalText::where('key', 'apartment')->value('short')) . " " . trim($d->apartment) : null;

        $full_address = "$region_title $region_type_short $city_type_short $city_title $address_type_short $address_title $building_type_short $building" . "$apartment";
        $d->full_address = trim($full_address);

        return $d;
    }
}
