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

    public static function get_dev_employers_by_type($dev_company_id, $employer_type_id)
    {
        return Client::select(
                        'clients.*'
                    )
                    ->where('dev_employer_types.id', $employer_type_id)
                    ->where('dev_company_employers.dev_company_id', $dev_company_id)
                    ->join('dev_company_employers', 'dev_company_employers.employer_id', '=', 'clients.id')
                    ->join('dev_employer_types', 'dev_employer_types.id', '=', 'dev_company_employers.type_id')
                    ->get();
    }
}
