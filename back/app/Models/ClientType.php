<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientType extends Model
{
    use HasFactory, SoftDeletes;
//
//    protected $casts = [
//        'deleted_at' => 'datetime',
//    ];
//
//    public static function get_representative_type_id()
//    {
//        return ClientType::where('key', 'representative')->value('id');
//    }
//
//    public static function get_manager_type_id()
//    {
//        return ClientType::where('key', 'manager')->value('id');
//    }
//
//    public static function get_developer_type_id()
//    {
//        return ClientType::where('key', 'developer')->value('id');
//    }
}
