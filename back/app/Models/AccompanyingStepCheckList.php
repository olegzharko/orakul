<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccompanyingStepCheckList extends Model
{
    use HasFactory;

    protected $casts = [
      'date_time' => 'datetime',
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
