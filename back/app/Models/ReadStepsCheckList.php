<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadStepsCheckList extends Model
{
    use HasFactory;

    protected $casts = [
      'date_time' => 'datetime',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function read_step()
    {
        return $this->belongsTo(ReadStep::class, 'read_step_id');
    }
}
