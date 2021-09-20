<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;

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
//                dd($days, $card->date_time, $card->date_time->addDays($days));
                $new_date = $card->date_time->addDays($days);

                if ($card->date_time < $date)
                    Card::where('id', $id)->update(['date_time' => $new_date]);
            }
        }

//        $i = 0;
//        while($i < 10) {
//            Card::where('id', rand(300, 1000))->update(['date_time' => $date]);
//            $i++;
//        }
    }
}
