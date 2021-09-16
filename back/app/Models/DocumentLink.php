<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentLink extends Model
{
    use HasFactory;

    protected $fillable = [
      'card_id',
      'contract_id',
      'type',
      'link',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public static function set_document_link($card_id, $contract_id, $type,  $link)
    {

        DocumentLink::updateOrCreate(
            ['card_id' => $card_id, 'contract_id' => $contract_id, 'type' => $type],
            ['link' => $link]
        );
    }
}
