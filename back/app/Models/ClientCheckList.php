<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientCheckList extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_check_lists';

    protected $fillable = [
        "client_id",
        "spouse_consent",
        "current_place_of_residence",
        "photo_in_the_passport",
        "immigrant_help",
        "passport",
        "tax_code",
        "evaluation_in_the_fund",
        "check_fop",
        "document_scans",
        "unified_register_of_court_decisions",
        "sanctions",
        "financial_monitoring",
        "unified_register_of_debtors",
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
