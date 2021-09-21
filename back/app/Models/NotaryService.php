<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaryService extends Model
{
    use HasFactory;

    public function contract_type()
    {
        return $this->belongsTo(ContractType::class, 'contract_type_id');
    }

    public function dev_group()
    {
        return $this->belongsTo(DevGroup::class, 'dev_group_id');
    }
}
