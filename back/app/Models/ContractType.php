<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractType extends Model
{
    use HasFactory;

    public static function get_active_contract_type()
    {
        return ContractType::select('id', 'title')->where('active', true)->get();
    }
}
