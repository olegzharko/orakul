<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccompanyingStepCheckList extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'accompanying_step_id',
        'date_time',
        'status',
    ];

    protected $casts = [
      'date_time' => 'datetime',
      'status' => 'boolean',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function accompanying_step()
    {
        return $this->belongsTo(AccompanyingStep::class, 'accompanying_step_id');
    }
}
