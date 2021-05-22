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
