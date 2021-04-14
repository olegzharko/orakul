<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proxy extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'date' => 'datetime',
        'reg_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function dev_company()
    {
        return $this->belongsTo(DevCompany::class, 'dev_company_id');
    }

    public function notary()
    {
        return $this->belongsTo(Notary::class);
    }

//    public function member()
//    {
//        return $this->hasMany(Client::class, 'dev_company_id');
//    }

    public function building()
    {
        return $this->hasMany(DeveloperBuilding::class, 'dev_company_id');
    }

    public function dev_representative()
    {
        return $this->belongsTo(Client::class, 'dev_representative_id');
    }
}
