<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPositionType extends Model
{
    use HasFactory;

    public $table = "user_position_type";

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function position_type()
    {
        return $this->belongsTo(PositionType::class, 'position_type_id');
    }
}
