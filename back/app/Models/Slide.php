<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;

class Slide extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;


    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(500)
            ->height(330);

        $this->addMediaConversion('mobile')
            ->width(375);

        $this->addMediaConversion('tablet')
            ->width(768);

    }
}