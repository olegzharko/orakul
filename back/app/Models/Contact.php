<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function contact_type()
    {
        return $this->belongsTo(ContractTemplate::class, 'contact_type_id');
    }

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }

    public static function contact_by_card($card_id)
    {
        return Contact::select(
            "id",
            "contact_type_id",
            "full_name",
            "phone",
            "email",
        )->where('card_id', $card_id)->get();
    }
}
