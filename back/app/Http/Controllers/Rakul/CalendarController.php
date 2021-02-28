<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Models\Contract;
use App\Models\Room;
use App\Models\Time;
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
        $rooms = Room::where('active', true)->pluck('id')->toArray();
        $times = Time::where('active', true)->pluck('time')->toArray();

        $height = count($times);

        $i = 0;
        $date = null;
        $result = [];
        foreach ($contracts as $key => $contract) {
            if ($contract->event_datetime) {
                if (array_search($contract->room->id, $rooms) && array_search($contract->event_datetime->format('H:i'), $times)) {
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
                    $result[$key]['contract_id'] = $contracts[$key]->id;
                    $result[$key]['x'] = array_search($contract->room->id, $rooms);
                    $result[$key]['y'] = $i + array_search($contract->event_datetime->format('H:i'), $times);
                    $result[$key]['color'] = 'red';
                    $result[$key]['title'] = 'Корол 2 прим 185 (осн) Імекова - Пішина (без банку)';
                    $result[$key]['short_info'] = [
                        'notary' => 'ОВ',
                        'notary_assistant_reader' => 'ГК',
                        'notary_assistant_giver' => 'БМ',
                        'developer_assistant' => 'ВВ',
                    ];

//                    echo "[" . $contracts[$key]->x . "] [" . $contracts[$key]->y . "] - <br>" . $contract->room->id . "<br>" . $contract->event_datetime->format('d.m.Y H:i') . "<br>";
                }
            }
        }

        return $result;

    }
}
