<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TerminationConsent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
//        'immovable_id',
        'client_id',
        'template_id',
        'notary_id',
        'sign_date',
        'reg_num'
    ];

    protected $casts = [
        'sign_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function notary()
    {
        return $this->belongsTo(Notary::class, 'notary_id');
    }

//    public function immovable()
//    {
//        return $this->belongsTo(Immovable::class, 'immovable_id');
//    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function template()
    {
        return $this->belongsTo(TerminationRefundTemplate::class, 'template_id');
    }
}
