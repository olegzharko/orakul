<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPositionType extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public $table = "user_position_type";

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function position_type()
    {
        return $this->belongsTo(PositionType::class, 'position_type_id');
    }

    public static function get_user_type($user_id)
    {
        $user_position_type = UserPositionType::where('user_id', $user_id)
            ->join('position_types', 'position_types.id', '=', 'user_position_type.position_type_id')
            ->first();

        if ($user_position_type)
            return $user_position_type->alias;
        else
            return null;
    }
}
