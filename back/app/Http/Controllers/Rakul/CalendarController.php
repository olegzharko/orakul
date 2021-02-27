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

        $contract = Contract::where('ready', false)->orderBy('event_datetime')->get();
        $contract = $this->convert_room($contract);

        $result = [
            'rooms' => $rooms,
            'work_time' => $time,
        ];

        return $this->sendResponse($result, 'кімнати');
    }

    public function convert_room($contracts)
    {
        $rooms = Room::where('active', true)->pluck('id')->toArray();
        $times = Time::where('active', true)->pluck('time')->toArray();

        foreach ($contracts as $key => $contract) {
            $contracts[$key]->x = array_search($contract->room, $rooms);
            $contracts[$key]->y = array_search($contract->event_datetime->format('H:i'), $times);
        }
    }
}
