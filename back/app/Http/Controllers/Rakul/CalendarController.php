<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Models\Room;
use App\Models\Time;
use App\Models\WorkDay;
use Illuminate\Http\Request;

class CalendarController extends BaseController
{
    public function calendar()
    {
        $rooms = Room::select('id as room_id', 'title', 'sort_order')->where('active', true)->get();
        $time = Time::select('time', 'sort_order')->where('active', true)->get();
        $work_days_and_date = $this->get_day_and_date();

        $result = [
            'rooms' => $rooms,
            'work_time' => $time,
            'day_and_date' => $work_days_and_date,
            'contracts' => null, // DEL ME ##################################################### OLD PART
        ];

        return $this->sendResponse($result, 'кімнати');
    }

    public function get_day_and_date()
    {
        $week = WorkDay::where('active', true)->orderBy('num')->pluck('short', 'num')->toArray();

        $d = 0;
        $date = new \DateTime();
        while ($d < 31) {
            $day_num = $date->format('w');
            if (isset($week[$day_num])) {
                $result[$d]['day'] = $week[$date->format('w')];
                $result[$d]['date'] = $date->format('d.m');
                $d++;
            }
            $date = $date->modify('+1 day');
        }

        return $result;
    }
}
