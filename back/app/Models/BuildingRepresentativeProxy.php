<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuildingRepresentativeProxy extends Model
{
    use HasFactory, SoftDeletes;

    public function building()
    {
        return $this->belongsTo(DeveloperBuilding::class, 'building_id');
    }

    public function representative()
    {
        return $this->belongsTo(Client::class, 'dev_representative_id');
    }

    public function proxy()
    {
        return $this->belongsTo(Proxy::class, 'proxy_id');
    }
}
