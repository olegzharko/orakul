<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\RoomType;
use App\Models\Visit;
use App\Nova\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;

class SpaceController extends BaseController
{
    public $convert;
    public $tools;

    public function __construct()
    {
        $this->convert = new ConvertController();
        $this->tools = new ToolsController();
    }

    public function space()
    {
        $visit_info = Visit::select(
            'visits.id as visit_id',
            'cards.id as card_id',
            'cards.notary_id as notary_id',
            'cards.date_time as start_time',
            'visits.arrival_time',
            'visits.waiting_time',
            'visits.total_time',
            'visits.number_of_people',
            'visits.children',
            'visits.in_progress',
            'visits.room_id',
        )->where('visits.ready', 0)
        ->leftJoin('cards', 'cards.id', '=', 'visits.card_id')
        ->get();

        $result = [];

        foreach ($visit_info as $key => $info) {
            $info['notary'] = $this->tools->get_notary_id_and_title($info->notary_id);
            $info['reader'] = $this->tools->get_staff_by_card($info->card_id, 'reader');
            $info['accompanying'] = $this->tools->get_staff_by_card($info->card_id, 'accompanying');
            $info['representative'] = $this->tools->get_representative_by_card($info->card_id, 'accompanying');
            $info['immovable'] = $this->tools->get_immovables_by_card($info->card_id);
            $info['buyer'] = $this->tools->get_clients_by_card($info->card_id);
            if ($info->room_id && $info->room->type->alias == 'meeting_room') {
                $result['meeting_room'][$info->room_id] = $info;
            } elseif ($info->room_id && $info->room->type->alias == 'reception') {
                $result['reception'][$info->room_id] = $info;
            }
        }

        $result['rooms'] = $this->tools->get_rooms();

        return $this->sendResponse($result, 'Дані для локацій');
    }

    public function close($card_id)
    {
        if ($card = Card::find($card_id)) {
            if (Visit::where('card_id', $card_id)->update(['ready' => true]))
                return $this->sendResponse('', "Угоду №$card_id завершено");
        } else {
            return $this->sendResponse('', "Угоду №$card_id відсутня");
        }
    }

    public function move_to_reception($card_id)
    {
        if ($card = Card::find($card_id)) {
            $reception_type_id = RoomType::where('alias', 'reception')->value('id');
            $reception = \App\Models\Room::where(['type_id' => $reception_type_id, 'location' => 'rakul'])->first();
            if ($reception && Visit::where('card_id', $card_id)->update(['room_id' => $reception->id]))
                return $this->sendResponse('', "Клієнти по угоді №$card_id перейшли до приймальні №" . $reception->id);
            else
                return $this->sendResponse('', "Приймальня відсутня");
        } else {
            return $this->sendResponse('', "Угоду №$card_id відсутня");
        }
    }

    public function move_to_notary($card_id)
    {
        if ($card = Card::find($card_id)) {
            $room_id = $card->notary->room->id;
            if (Visit::where(['room_id' => $room_id, 'ready' => false])->where('card_id', '!=', $card_id)->first())
                return $this->sendResponse('', "Кімната зайнята");
            elseif ($room_id && Visit::where('card_id', $card_id)->update(['room_id' => $room_id]))
                return $this->sendResponse('', "Клієнти по угоді №$card_id перейшли до нотаріуса");
        } else {
            return $this->sendResponse('', "Угоду №$card_id відсутня");
        }
    }
}
