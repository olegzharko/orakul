<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proxy extends Model
{
    use HasFactory;


    protected $casts = [
        'date' => 'datetime',
        'reg_date' => 'datetime',
    ];

    public function dev_company()
    {
        return $this->belongsTo(DevCompany::class, 'dev_company_id');
    }

    public function notary()
    {
        return $this->belongsTo(Notary::class);
    }

    public function member()
    {
        return $this->hasMany(Client::class, 'dev_company_id');
    }

    public function building()
    {
        return $this->hasMany(DeveloperAddress::class, 'dev_company_id');
    }
}
