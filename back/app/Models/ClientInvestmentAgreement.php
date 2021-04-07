<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientInvestmentAgreement extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    protected $table = "client_investment_agreement";

    public function developer()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function investment_agreement()
    {
        return $this->belongsTo(InvestmentAgreement::class, 'investment_agreement_id');
    }
}
