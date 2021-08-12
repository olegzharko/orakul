<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSteps extends Model
{
    use HasFactory;

    public function notary_service()
    {
        return $this->belongsTo(NotaryService::class, 'notary_service_id');
    }
}
