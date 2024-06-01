<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TerminationRefund extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contract_id',
        'template_id',
        'notary_id',
        'reg_date',
        'reg_num'
    ];

    protected $casts = [
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
        return $this->belongsTo(TerminationRefundTemplate::class, 'template_id');
    }
}
