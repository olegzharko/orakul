<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Tests\Fixtures\Address;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Client extends Model implements Sortable
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

    public static function get_client($client_id)
    {
        $client = Client::where('id', $client_id)->first();
        $client->address_full = Client::convert_address($client);

        return $client;
    }

    public static function convert_address($c)
    {
        $region_type_short = trim(GlobalText::where('key', 'region')->value('short'));
        $region_title = trim($c->region->title);
        $city_type_short = trim($c->city_type->short);
        $city_title = trim($c->city);
        $address_type_short = trim($c->address_type->short);
        $address_title = trim($c->address);
        $building_type_short = trim(GlobalText::where('key', 'building')->value('short'));
        $building = trim($c->building);

        $apartment = $c->apartment ? ", " . trim(GlobalText::where('key', 'apartment')->value('short')) . " " . trim($c->apartment) : null;

        $full_address = "$region_title $region_type_short $city_type_short $city_title $address_type_short $address_title $building_type_short $building" . "$apartment";

        $c->full_address = trim($full_address);

        return $c;
    }
}
