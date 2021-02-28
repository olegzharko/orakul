<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Models\Contract;
use App\Models\Room;
use App\Models\Time;
use App\Models\WorkDay;
use App\Nova\DevCompany;
use Illuminate\Http\Request;

class CalendarController extends BaseController
{
    public function calendar()
    {
        $rooms = Room::select('title', 'sort_order')->where('active', true)->get();
        $time = Time::select('time', 'sort_order')->where('active', true)->get();
        $work_days_and_date = $this->get_day_and_date();

        $contracts = Contract::orderBy('event_datetime')->get();

        if ($contracts)
            $contracts = $this->convert_room($contracts);
        else
            $contract = null;

        $result = [
            'rooms' => $rooms,
            'work_time' => $time,
            'day_and_date' => $work_days_and_date,
            'contracts' => $contracts,
        ];

        return $this->sendResponse($result, 'кімнати');
    }

    public function convert_room($contracts)
    {
        $result = [];
        $rooms = Room::where('active', true)->pluck('id')->toArray();
        $times = Time::where('active', true)->pluck('time')->toArray();
        $time_length = count($times);
        $current_date = date('d.m.Y');
        $current_date = "01.03.2021";////////////////////DEL ME/////////////////////////
        $current_date = strtotime($current_date);

        foreach ($contracts as $key => $contract) {
            if ($contract->event_datetime && $current_date <= strtotime($contract->event_datetime->format('d.m.Y'))) {
                if (in_array($contract->room->id, $rooms) && in_array($contract->event_datetime->format('H:i'), $times)) {

                    $time_height = array_search($contract->event_datetime->format('H:i'), $times);
                    $day_height = strtotime($contract->event_datetime->format('d.m.Y')) - $current_date;
                    $day_height = intval(round($day_height / (60 * 60 * 24)));
                    $result[$key]['i'] = strval($contracts[$key]->id);
                    $result[$key]['x'] = array_search($contract->room->id, $rooms);
                    if ($day_height)
                        $result[$key]['y'] = $time_height + $time_length * $day_height;
                    else
                        $result[$key]['y'] = $time_height;
                    $result[$key]['w'] = 1;
                    $result[$key]['h'] = 1;
                    $result[$key]['color'] = $contract->dev_company->color;
                    $result[$key]['title'] = 'Корол 2 прим 185 (осн) Імекова - Пішина (без банку)';
                    $result[$key]['short_info'] = [
                        'notary' => 'ОВ',
                        'notary_assistant_reader' => 'ГК',
                        'notary_assistant_giver' => 'БМ',
                        'developer_assistant' => 'ВВ',
                    ];
                    echo "[" . $result[$key]['x'] . "] [" . $result[$key]['y'] . "] - <br>" . $contract->room->id . "<br>" . $contract->event_datetime->format('d.m.Y H:i') . "<br>";
                }
            }
        }

        dd($result);
        return $result;
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
