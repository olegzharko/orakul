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
        $rooms = Room::where('active', true)->pluck('id')->toArray();
        $times = Time::where('active', true)->pluck('time')->toArray();

        $height = count($times);

        $date = null;
        $prev_date = null;
        $i = 0;
        $j = 0;
        foreach ($contracts as $key => $contract) {
            if ($contract->event_datetime) {
                if (in_array($contract->room->id, $rooms) && in_array($contract->event_datetime->format('H:i'), $times)) {
                    if ($date == null)
                        $date = strtotime($contract->event_datetime->format('d.m.Y'));
                    if ($date < strtotime($contract->event_datetime->format('d.m.Y'))) {
                        $days_in_seconds = strtotime($contract->event_datetime->format('d.m.Y')) - $date;
                        intval(round($days_in_seconds / (60 * 60 * 24)));
                        $i = $i + $height * intval(round($days_in_seconds / (60 * 60 * 24)));
                        $date = strtotime($contract->event_datetime->format('d.m.Y'));
                    }
                    $contracts[$key]->x = array_search($contract->room->id, $rooms);
                    $contracts[$key]->y = $i + array_search($contract->event_datetime->format('H:i'), $times);
                    $result[$key]['i'] = strval($contracts[$key]->id);
                    $result[$key]['x'] = array_search($contract->room->id, $rooms);
                    $result[$key]['y'] = $i + array_search($contract->event_datetime->format('H:i'), $times);
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

                    $prev_date = strtotime($contract->event_datetime->format('d.m.Y'));
//                    echo "[" . $contracts[$key]->x . "] [" . $contracts[$key]->y . "] - <br>" . $contract->room->id . "<br>" . $contract->event_datetime->format('d.m.Y H:i') . "<br>";
                }
            }
        }

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
