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

    public function visit()
    {
        return $this->belongsTo(Deal::class, 'deal_id');
    }

    public function service_steps()
    {
        return $this->belongsTo(AccompanyingStep::class, 'service_step_id');
    }
}
