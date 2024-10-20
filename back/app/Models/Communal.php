<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Communal extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'contract_id',
        'template_id',
        'notary_id',
        'sign_date',
        'final_date',
        'reg_num',
        'active',
    ];

    protected $casts = [
        'sign_date' => 'datetime',
        'final_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function template()
    {
        return $this->belongsTo(CommunalTemplate::class, "template_id");
    }

    public function notary()
    {
        return $this->belongsTo(Notary::class, 'notary_id');
    }
}
