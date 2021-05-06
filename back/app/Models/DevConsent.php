<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DevConsent extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'reg_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function template()
    {
        return $this->belongsTo(DevConsentTemplate::class, 'template_id');
    }

    public function contract_spouse_word()
    {
        return $this->belongsTo(SpouseWord::class, 'contract_spouse_word_id');
    }

    public function notary()
    {
        return $this->belongsTo(Notary::class, 'notary_id');
    }
}
