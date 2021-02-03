<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representative extends Model
{
    use HasFactory;

    protected $casts = [
        'reg_date' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function confidant()
    {
        return $this->belongsTo(Client::class, 'confidant_id');
    }

    public function notary()
    {
        return $this->belongsTo(Notary::class, 'notary_id');
    }
}
