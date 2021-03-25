<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $table = 'cards';

    protected $fillable = [
        'notary_id',
    ];

    protected $casts = [
        'date_time' => 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function event_city()
    {
        return $this->belongsTo(City::class, 'event_city_id');
    }

    public function notary()
    {
        return $this->belongsTo(Notary::class, 'notary_id');
    }

    public function manager()
    {
        return $this->belongsTo(Client::class, 'manager_id');
    }

    public function dev_company()
    {
        return $this->belongsTo(DevCompany::class, 'dev_company_id');
    }

    public function dev_representative()
    {
        return $this->belongsTo(Client::class, 'dev_representative_id');
    }

    public function has_contracts()
    {
        return $this->hasMany(CardContract::class, 'card_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public static function new_card($r)
    {
        $work_city = \App\Models\City::where('notary', 1)->first();

        $card = new Card();
        $card->notary_id = $r['notary_id'];
        $card->room_id = $r['room_id'];
        $card->city_id = $work_city ? $work_city->id : null;
        $card->date_time = \DateTime::createFromFormat('Y.m.d. H:i', $r['date_time']);
        $card->dev_company_id = $r['dev_company_id'];
        $card->dev_representative_id = $r['dev_representative_id'];
        $card->dev_manager_id = $r['dev_manager_id'];
        $card->save();

        return $card->id;
    }

//    public static function update_card($id, $r)
//    {
//        Card::where('id', $id)->update([
//            'notary_id' => $r['notary_id'],
//            'room_id' => $r['room_id'],
//            'date_time' => new \DateTime($r['date_time']),
//            'dev_company_id' => $r['dev_company_id'],
//            'dev_representative_id' => $r['dev_representative_id'],
//            'dev_manager_id' => $r['dev_manager_id'],
//        ]);
//    }

    public static function get_card_immovable_id($card_id)
    {
        $immovables_id = Card::where('cards.id', $card_id)
            ->leftJoin('card_contract', 'cards.id', '=', 'card_contract.card_id')
            ->leftJoin('contracts', 'contracts.id', '=', 'card_contract.contract_id')
            ->leftJoin('immovables', 'contracts.immovable_id', '=', 'immovables.id')
            ->pluck('immovables.id');

        return $immovables_id;
    }
}
