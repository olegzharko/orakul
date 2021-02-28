<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Models\Contract;
use App\Models\Room;
use App\Models\Time;
use App\Nova\DevCompany;
use Illuminate\Http\Request;

class CalendarController extends BaseController
{
    public function calendar()
    {
        $rooms = Room::select('title', 'sort_order')->where('active', true)->get();
        $time = Time::select('time', 'sort_order')->where('active', true)->get();

        $contracts = Contract::orderBy('event_datetime')->get();
        if ($contracts)
            $contracts = $this->convert_room($contracts);
        else
            $contract = null;

        $result = [
            'rooms' => $rooms,
            'work_time' => $time,
            'contract_groups' => $contracts,
        ];

        return $this->sendResponse($result, 'кімнати');
    }

    public function convert_room($contracts)
    {
        $week = [
            '-',
            'Пн',
            'Вт',
            'Ср',
            'Чт',
            'Пт',
            'Сб',
            'Нд',
        ];
        $prev_date = null;
        $rooms = Room::where('active', true)->pluck('id')->toArray();
        $times = Time::where('active', true)->pluck('time')->toArray();

        $height = count($times);

        $i = 0;
        $date = null;
        $result = [];
        $j = 0;
        foreach ($contracts as $key => $contract) {
            if ($contract->event_datetime) {
                if ($prev_date == null || $prev_date < strtotime($contract->event_datetime->format('d.m.Y'))) {
                    $j++;
                    $result[$j]['day'] = $week[$contract->event_datetime->format('w')];
                    $result[$j]['date'] = $contract->event_datetime->format('d.m');
                    $result[$j]['contracts'] = [];
                    echo $j . "<br>";
                }

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
                    $result[$j]['contracts'][$key]['i'] = strval($contracts[$key]->id);
                    $result[$j]['contracts'][$key]['x'] = array_search($contract->room->id, $rooms);
                    $result[$j]['contracts'][$key]['y'] = $i + array_search($contract->event_datetime->format('H:i'), $times);
                    $result[$j]['contracts'][$key]['w'] = 1;
                    $result[$j]['contracts'][$key]['h'] = 1;
                    $result[$j]['contracts'][$key]['color'] = $contract->dev_company->color;
                    $result[$j]['contracts'][$key]['title'] = 'Корол 2 прим 185 (осн) Імекова - Пішина (без банку)';
                    $result[$j]['contracts'][$key]['short_info'] = [
                        'notary' => 'ОВ',
                        'notary_assistant_reader' => 'ГК',
                        'notary_assistant_giver' => 'БМ',
                        'developer_assistant' => 'ВВ',
                    ];

                    $prev_date = strtotime($contract->event_datetime->format('d.m.Y'));
//                    echo "[" . $contracts[$key]->x . "] [" . $contracts[$key]->y . "] - <br>" . $contract->room->id . "<br>" . $contract->event_datetime->format('d.m.Y H:i') . "<br>";
                } else {
                    dd($contract, $contract->room->id, $rooms, in_array($contract->room->id, $rooms), in_array($contract->event_datetime->format('H:i'), $times));
                }
            }
        }

        return $result;

    }
}
