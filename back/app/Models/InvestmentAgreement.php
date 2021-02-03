<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentAgreement extends Model
{
    use HasFactory;

    public $casts = [
      'date' => 'datetime',
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
