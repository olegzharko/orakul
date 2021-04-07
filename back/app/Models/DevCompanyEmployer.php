<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DevCompanyEmployer extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    protected $table = 'dev_company_employers';

    public function dev_company()
    {
        return $this->belongsTo(DevCompany::class, 'dev_company_id');
    }

    public function employer()
    {
        return $this->belongsTo(Client::class, 'employer_id');
    }

    public function type()
    {
        return $this->belongsTo(DevEmployerType::class, 'type_id');
    }
}
