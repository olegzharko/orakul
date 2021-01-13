<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSpouseConsent extends Model
{
    use HasFactory;

    protected $casts = [
        'date' => 'datetime',
        'mar_date' => 'datetime',
    ];

    public function consents_template()
    {
        return $this->belongsTo(ConsentTemplate::class);
    }

    public function notary()
    {
        return $this->belongsTo(Notary::class);
    }

    public function client_spouse()
    {
        return $this->belongsTo(ClientSpouse::class);
    }

    public function marriage_type()
    {
        return $this->belongsTo(MarriageType::class, 'marriage_type_id');
    }
}
