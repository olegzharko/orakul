<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TerminationConsent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'template_id',
        'spouse_word_id',
        'notary_id',
        'sign_date',
        'reg_num'
    ];

    protected $casts = [
        'sign_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function notary()
    {
        return $this->belongsTo(Notary::class, 'notary_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function template()
    {
        return $this->belongsTo(TerminationConsentTemplate::class, 'template_id');
    }

    public function termination_spouse_word()
    {
        return $this->belongsTo(SpouseWord::class, 'termination_spouse_word_id');
    }
}
