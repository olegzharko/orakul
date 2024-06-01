<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FullSettlementApplication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contract_id',
        'template_id',
        'notary_id',
        'full_settlement_date',
        'reg_date',
        'reg_number'
    ];

    protected $casts = [
        'full_settlement_date' => 'datetime',
        'reg_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function notary()
    {
        return $this->belongsTo(Notary::class, 'notary_id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function template()
    {
        return $this->belongsTo(FullSettlementApplicationTemplate::class, 'template_id');
    }
}
