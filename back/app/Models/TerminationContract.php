<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TerminationContract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contract_id',
        'template_id',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

//    public function immovable()
//    {
//        return $this->belongsTo(Immovable::class, 'immovable_id');
//    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

//    public function client()
//    {
//        return $this->belongsTo(Client::class, 'client_id');
//    }

    public function template()
    {
        return $this->belongsTo(TerminationRefundTemplate::class, 'template_id');
    }
}
