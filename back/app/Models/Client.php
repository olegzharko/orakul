<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Tests\Fixtures\Address;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;

class Client extends Model implements Sortable, HasMedia
{
    use HasFactory, InteractsWithMedia, SortableTrait, SoftDeletes;

    protected $fillable = [
        'surname_n',
        'name_n',
        'patronymic_n',
        'surname_r',
        'name_r',
        'patronymic_r',
        'surname_d',
        'name_d',
        'patronymic_d',
        'surname_o',
        'name_o',
        'patronymic_o',
        'citizenship_id',
        'registration',
        'gender',
        'birth_date',
        'tax_code',
        'passport_type_id',
        'passport_code',
        'passport_date',
        'passport_department',
        'passport_demographic_code',
        'passport_finale_date',
        'district_id',
    ];

    protected $casts = [
        'birth_date' => 'datetime',
        'passport_date' => 'datetime',
        'deleted_at' => 'datetime',
        'passport_finale_date' => 'datetime',
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function passport_type()
    {
        return $this->belongsTo(PassportTemplate::class, 'passport_type_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
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

    public function client_type()
    {
        return $this->belongsTo(ClientType::class, 'type_id');
    }

    public function citizenship()
    {
        return $this->belongsTo(Citizenship::class, 'citizenship_id');
    }

    public function married()
    {
        return $this->hasOne(Spouse::class, 'client_id');
    }

    public function member()
    {
        return $this->belongsTo(DevCompany::class, 'dev_company_id');
    }

    public function client_spouse_consent()
    {
        return $this->hasOne(ClientSpouseConsent::class);
    }

    public function developer_consent()
    {
        return $this->hasOne(ClientSpouseConsent::class, 'client_id');
    }

    public function termination_consent()
    {
        return $this->hasOne(TerminationConsent::class, 'client_id');
    }

    public function contracts()
    {
        return $this->belongsToMany(Contract::class);
    }

    public function representative()
    {
        return $this->hasOne(Representative::class, 'client_id');
    }

    public function communal()
    {
        return $this->hasOne(Communal::class, 'client_id');
    }

    public function actual_address()
    {
        return $this->hasOne(ActualAddress::class, 'client_id');
    }

    public function native_address()
    {
        return $this->hasOne(NativeAddress::class, 'client_id');
    }

    public function building_part()
    {
        return $this->belongsTo(BuildingPart::class, 'building_part_id');
    }

    public function client_work()
    {
        return $this->hasOne(ClientWork::class, 'client_id');
    }

    public function check_list()
    {
        return $this->hasOne(ClientCheckList::class, 'client_id');
    }

    public function trustorPowersOfAttorney()
    {
        return $this->hasMany(PowerOfAttorney::class, 'trustor_id');
    }

    public function agentPowersOfAttorney()
    {
        return $this->hasMany(PowerOfAttorney::class, 'agent_id');
    }
}
