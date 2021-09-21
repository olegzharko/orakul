<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\User;
use App\Models\Contract;

class DatabaseController extends Controller
{
    public function set_database_current_date()
    {
        $date = new \DateTime('today');

//        Card::where('id', '>', 0)->update(['date_time' => '2021-09-19']);die;

        $date_time = Card::orderBy('date_time')->where('id', '=', 500)->first()->value('date_time');

        $date_diff_info = $date_time->diff($date);
        $days = $date_diff_info->days;

        $days = 42;

        $cards_id = Card::pluck('id');

        $i = 0;
        foreach ($cards_id as $key => $id) {
            if ($id >= 500) {
                $card = Card::find($id);

                $new_date = $card->date_time->addDays($days);

                if ($card->date_time < $date)
                    Card::where('id', $id)->update(['date_time' => $new_date]);
            }
        }
    }

    public function set_reader_and_accompanying_for_contracts()
    {
        $readers_id = User::where('reader', true)->pluck('id')->toArray();
        $accompanyings_id = User::where('accompanying', true)->pluck('id')->toArray();

        $contracts_id = Contract::pluck('id');

        foreach ($contracts_id as $contract_id) {
            Contract::find($contract_id)->update(['reader_id' => array_rand($readers_id), 'accompanying_id' => array_rand($accompanyings_id)]);
        }
    }
}
