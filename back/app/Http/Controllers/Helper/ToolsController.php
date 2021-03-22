<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\WorkDay;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    public function __construct()
    {

    }

    public function header_info($card)
    {
        $result = null;
        $week = null;
        $room = null;

        $week = WorkDay::where('active', true)->orderBy('num')->pluck('title', 'num')->toArray();
        $room = Room::where('id', $card->room_id)->value('title');

        $result['day'] = $week[$card->date_time->format('w')];
        $result['date'] = $card->date_time->format('d.m');
        $result['time'] = $card->date_time->format('H:i');
        $result['room'] = $room;

        return $result;
    }
}
