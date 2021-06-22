<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcessingPersonalData extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'contract_id',
        'template_id',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function template()
    {
        return $this->belongsTo(\App\Models\ProcessingPersonalDataTemplate::class, "template_id");
    }
}
