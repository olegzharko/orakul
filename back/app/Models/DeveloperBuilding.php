<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;


class DeveloperBuilding extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $table = "developer_buildings";

    public $casts = [
      'exploitation_date' => 'datetime',
      'communal_date' => 'datetime',
    ];
    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function dev_company()
    {
        return $this->belongsTo(DevCompany::class, 'dev_company_id');
    }

    public function investment_agreement()
    {
        return $this->belongsTo(InvestmentAgreement::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function address_type()
    {
        return $this->belongsTo(AddressType::class);
    }

    public function building_permit()
    {
        return $this->hasOne(BuildingPermit::class, 'developer_building_id');
    }
}
