<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvestmentAgreement extends Model
{
    use HasFactory, SoftDeletes;

    public $casts = [
        'date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function dev_company()
    {
        return $this->belongsTo(DevCompany::class);
    }

    public function investor()
    {
        return $this->belongsTo(Client::class, 'investor_id');
    }
}
