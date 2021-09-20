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

        $date_time = Card::orderBy('date_time')->first()->value('date_time');

        $date_diff_info = $date_time->diff($date);
        $days = $date_diff_info->days;

        $cards_id = Card::pluck('id');

        foreach ($cards_id as $key => $id) {
            if ($id > 300) {
                $current = Card::find($id);
                $new_date = $current->date_time->addDays($days);
                if ($current->date_time < $date)
                    Card::where('id', $id)->update(['date_time' => $new_date]);
            }
        }

        $i = 0;
        while($i < 10) {
            Card::where('id', rand(300, 1000))->update(['date_time' => $date]);
            $i++;
        }
    }

//    public function set_database_current_date()
//    {
//        $date = new \DateTime('today');
//
//        $date_time = Card::orderBy('date_time')->first()->value('date_time');
//
//        $date_diff_info = $date_time->diff($date);
//        $days = 1;
//        $d = 1;
//
//        $cards_id = Card::pluck('id');
//        foreach ($cards_id as $key => $id) {
//            $current = Card::find($id)->update('date_time', $date);
//            $new_date = $current->date_time->addDays($days);
//            if ($current->date_time < $date)
//                Card::where('id', $id)->update(['date_time' => $new_date]);
//
//        }
//    }
}
