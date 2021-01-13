<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevCompany extends Model
{
    use HasFactory;

    public function member()
    {
        return $this->hasMany(Client::class, 'dev_company_id');
    }

    public function proxy()
    {
        return $this->hasMany(Proxy::class, 'dev_company_id');
    }

    public function building()
    {
        return $this->hasMany(DeveloperAddress::class, 'dev_company_id');
    }
}
