<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Models\Room;
use App\Models\Time;
use Illuminate\Http\Request;

class CalendarController extends BaseController
{
    public function calendar()
    {
        $rooms = Room::select('title', 'sort_order')->where('active', true)->get();
        $time = Time::select('time', 'sort_order')->where('active', true)->get();

        $result = [
            'rooms' => $rooms,
            'work_time' => $time,
        ];

        return $this->sendResponse($result, 'кімнати');
    }
}
