<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use URL;

class ContractTemplate extends Model implements Sortable, HasMedia
{
    use HasFactory, SortableTrait, InteractsWithMedia;

    public $table = "contract_templates";

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function type()
    {
        return $this->belongsTo(ContractType::class, 'type_id');
    }

    public function developer()
    {
        return $this->belongsTo(DevCompany::class);
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
