<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActualAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'district_id',
        'city_id',
        'address_type_id',
        'address',
        'building_type_id',
        'building',
        'building_part_id',
        'building_part_num',
        'apartment_type_id',
        'apartment_num',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
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

    public function apartment_type()
    {
        return $this->belongsTo(ApartmentType::class, 'apartment_type_id');
    }
}
