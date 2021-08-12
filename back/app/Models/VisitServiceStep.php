<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitServiceStep extends Model
{
    use HasFactory;

    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    public function service_steps()
    {
        return $this->belongsTo(ServiceSteps::class, 'service_step_id');
    }
}
