<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSpouse extends Model
{
    use HasFactory;

    protected $casts = [
        'birthday' => 'datetime',
        'passport_date' => 'datetime',
        'mar_date' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
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

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function address_type()
    {
        return $this->belongsTo(AddressType::class, 'address_type_id');
    }

    public function building_type()
    {
        return $this->belongsTo(BuildingType::class, 'building_type_id');
    }

    public function marriage_type()
    {
        return $this->belongsTo(MarriageType::class, 'marriage_type_id');
    }

}
