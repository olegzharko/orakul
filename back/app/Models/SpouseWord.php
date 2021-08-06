<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpouseWord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'title',
      'dev_company_id',
      'developer',
      'termination',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function developer()
    {
        return $this->belongsTo(DevCompany::class, 'dev_company_id');
    }
}
