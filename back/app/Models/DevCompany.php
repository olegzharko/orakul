<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;

class DevCompany extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    protected $fillable = [
        'dev_company_id',
        'city_id',
        'address_type_id',
        'title',
        'number',
    ];

//    public function member()
//    {
//        return $this->hasMany(Client::class, 'dev_company_id');
//    }

    public function proxy()
    {
        return $this->hasMany(Proxy::class, 'dev_company_id');
    }

    public function building()
    {
        return $this->hasMany(DeveloperBuilding::class, 'dev_company_id');
    }

    public function investment_agreement()
    {
        return $this->hasMany(InvestmentAgreement::class, 'dev_company_id');
    }

    public function employer()
    {
        return $this->hasMany(DevCompanyEmployer::class, 'dev_company_id');
    }

    public function dev_group()
    {
        return $this->belongsTo(DevGroup::class, 'dev_group_id');
    }

//    public static function get_active_developer()
//    {
//        return DevCompany::select('id', 'title')->where('active', true)->get();
//    }
}
