<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankTaxesPayment extends Model
{
    use HasFactory;

    public $fillable = [
        'contract_id',
        'template_id',
    ];

    public function template()
    {
        return $this->belongsTo(BankTaxesTemplate::class, 'template_id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
}
