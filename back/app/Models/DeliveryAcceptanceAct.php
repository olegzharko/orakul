<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryAcceptanceAct extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    public $fillable = [
        'contract_id',
        'template_id',
        'notary_id',
        'sign_date',
    ];

    protected $casts = [
        'sign_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function template()
    {
        return $this->belongsTo(DeliveryAcceptanceActTemplate::class, 'template_id');
    }

    public function notary()
    {
        return $this->belongsTo(Notary::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
}
