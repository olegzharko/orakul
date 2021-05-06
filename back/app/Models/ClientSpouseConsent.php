<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientSpouseConsent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'notary_id',
        'template_id',
        'contract_spouse_word_id',
        'marriage_type_id',
        'mar_series',
        'mar_series_num',
        'mar_date',
        'mar_depart',
        'mar_reg_num',
        'sign_date',
        'reg_num',
    ];

    protected $casts = [
        'sign_date' => 'datetime',
        'mar_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function template()
    {
        return $this->belongsTo(ConsentTemplate::class, 'template_id');
    }

    public function notary()
    {
        return $this->belongsTo(Notary::class);
    }

    public function contracts()
    {
        return $this->belongsToMany(Contract::class);
    }

    public function marriage_type()
    {
        return $this->belongsTo(MarriageType::class, 'marriage_type_id');
    }

    public function contract_spouse_word()
    {
        return $this->belongsTo(SpouseWord::class, 'contract_spouse_word_id');
    }
}
