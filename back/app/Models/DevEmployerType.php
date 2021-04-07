<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DevEmployerType extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public static function get_representative_type_id()
    {
        return DevEmployerType::where('alias', 'representative')->value('id');
    }

    public static function get_manager_type_id()
    {
        return DevEmployerType::where('alias', 'manager')->value('id');
    }

    public static function get_developer_type_id()
    {
        return DevEmployerType::where('alias', 'developer')->value('id');
    }
}
