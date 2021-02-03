<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;

class Questionnaire extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $casts = [
        'sign_date' => 'datetime',
    ];

    public function template()
    {
        return $this->belongsTo(QuestionnaireTemplate::class, 'template_id');
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
