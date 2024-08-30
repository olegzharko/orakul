<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PowerOfAttorneyGeneralCar extends Model
{
    use HasFactory;

    protected $fillable = [
        'power_of_attorney_id',
        'car_make',
        'commercial_description',
        'type',
        'special_notes',
        'year_of_manufacture',
        'vin_code',
        'registration_number',
        'registered',
        'registration_date',
        'registration_certificate',
    ];

    protected $casts = [
        'registration_date' => 'datetime'
    ];

    public function powerOfAttorney(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PowerOfAttorney::class, 'power_of_attorney_id', 'id');
    }
}
