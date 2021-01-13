<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeveloperStatement extends Model
{
    use HasFactory;

    protected $casts = [
        'date' => 'datetime',
    ];

    public function statement_template()
    {
        return $this->belongsTo(StatementTemplate::class);
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
}
