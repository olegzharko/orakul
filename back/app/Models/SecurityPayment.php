<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecurityPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'immovable_id',
        'first_part_grn',
        'client_id',
        'sign_date',
        'reg_num',
        'first_part_grn',
        'first_part_dollar',
        'last_part_grn',
        'last_part_dollar',
        'final_date',
        'client_id',
    ];

    protected $casts = [
        'sign_date' => 'datetime',
        'final_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function immovable()
    {
        return $this->belongsTo(Immovable::class, 'immovable_id');
    }
}
