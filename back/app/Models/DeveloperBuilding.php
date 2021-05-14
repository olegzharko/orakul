<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeveloperBuilding extends Model implements Sortable
{
    use HasFactory, SortableTrait, SoftDeletes;

    protected $table = "developer_buildings";

    public $casts = [
        'exploitation_date' => 'datetime',
        'communal_date' => 'datetime',
        'deleted_at' => 'datetime',
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

    public static function get_developer_company_building($dev_company)
    {
        return DeveloperBuilding::where('dev_company_id', $dev_company)->get();;
    }

    public static function get_dev_group_buildings($buildings_id)
    {


        return DeveloperBuilding::whereIn('id', $buildings_id)->orderBy('address_type_id')->orderBy('title')->orderByRaw("CAST(number as UNSIGNED) ASC")->get();
    }

    public static function get_developer_building($dev_company_id)
    {
            return DeveloperBuilding::where([
                        'dev_company_id' => $dev_company_id,
                        'active' => true,
                    ])->get();
    }
}
