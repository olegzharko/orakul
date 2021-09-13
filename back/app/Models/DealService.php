<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealService extends Model
{
    use HasFactory;

    public function visit()
    {
        return $this->belongsTo(Deal::class, 'deal_id');
    }

    public function notary_service()
    {
        return $this->belongsTo(NotaryService::class, 'notary_service_id');
    }
}
