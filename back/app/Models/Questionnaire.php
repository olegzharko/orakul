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
        'date' => 'datetime',
    ];

    public function questionnaire_template()
    {
        return $this->belongsTo(QuestionnaireTemplate::class);
    }

    public function notary()
    {
        return $this->belongsTo(Notary::class);
    }

    public function developer()
    {
        return $this->belongsTo(Client::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
