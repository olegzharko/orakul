<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingPermit extends Model
{
    use HasFactory;

    protected $casts = [
        'sign_date' => 'datetime',
    ];

    public function developer_building()
    {
        return $this->belongsTo(DeveloperBuilding::class, 'developer_building_id');
    }
}
