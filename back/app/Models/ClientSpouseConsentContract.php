<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientSpouseConsentContract extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    protected $table = 'client_spouse_consent_contract';

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function client_spouse_consent()
    {
        return $this->belongsTo(ClientSpouseConsent::class, 'client_spouse_consent_id');
    }
}
