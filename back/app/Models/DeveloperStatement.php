<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeveloperStatement extends Model
{
    use HasFactory;

    public $fillable = [
        'contract_id',
        'template_id',
    ];

    protected $casts = [
        'sign_date' => 'datetime',
    ];

    public function template()
    {
        return $this->belongsTo(StatementTemplate::class, "template_id");
    }

    public function notary()
    {
        return $this->belongsTo(Notary::class);
    }

    public function developer()
    {
        return $this->belongsTo(Client::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
}
