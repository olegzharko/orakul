<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuildingPermit extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'sign_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function developer_building()
    {
        return $this->belongsTo(DeveloperBuilding::class, 'developer_building_id');
    }
}
