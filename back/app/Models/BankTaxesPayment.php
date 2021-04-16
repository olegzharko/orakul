<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankTaxesPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'deleted_at' => 'datetime',
        'sign_date' => 'datetime',
    ];

    public $fillable = [
        'contract_id',
        'template_id',
        'sign_date',
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
