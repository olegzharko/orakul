<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements Sortable, HasMedia
{
    use HasFactory, SortableTrait, HasTranslations, InteractsWithMedia;

    public $table = 'service';

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public $translatable = [
        'title',
        'logo_alt',
        'text',
        'image_alt',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function appointment()
    {
        return $this->hasMany(Appointment::class);
    }

    // public function service_type()
    // {
    //     return $this->belongsTo(ServiceType::class);
    // }

    public function service_type()
    {
        return $this->belongsToMany(ServiceType::class);
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }

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
