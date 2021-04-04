<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevCompanyEmployer extends Model
{
    use HasFactory;

    protected $table = 'dev_company_employers';

    public function dev_company()
    {
        return $this->belongsTo(DevCompany::class, 'dev_company_id');
    }

    public function employer()
    {
        return $this->belongsTo(Client::class, 'employer_id');
    }
}
