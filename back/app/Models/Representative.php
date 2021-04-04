<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representative extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'confidant_id',
        'notary_id',
        'reg_num',
        'reg_date',
    ];

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
