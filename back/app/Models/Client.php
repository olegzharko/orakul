<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Http\Requests\NovaRequest;
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

    public function client_type()
    {
        return $this->belongsTo(ClientType::class, 'type');
    }

    public function citizenship()
    {
        return $this->belongsTo(Citizenship::class, 'citizenship_id');
    }

    public function spouse()
    {
        return $this->belongsTo(Client::class, 'spouse_id');
    }

    public function member()
    {
        return $this->belongsTo(DevCompany::class, 'dev_company_id');
    }

    public function client_spouse_consent()
    {
        return $this->hasMany(ClientSpouseConsent::class);
    }

    public function contracts()
    {
        return $this->belongsToMany(Contract::class);
    }

    public function representative()
    {
        return $this->hasOne(Representative::class, 'client_id');
    }
}
