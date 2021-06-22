<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientContract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'contract_id',
        'previous_buyer',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    protected $table = "client_contract";

    public static function create_card_client($card_id, $client_id)
    {
        $card_client = new CardClient();
        $card_client->card_id = $card_id;
        $card_client->client_id = $client_id;
        $card_client->save();
    }
}
