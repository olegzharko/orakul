<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\RoomType;
use App\Models\Deal;
use App\Models\Room;
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

    /*
     * Передає список кімнат - рецепція, кімнати ділових переговорів, кабінети нотаріусів
     * Дані по угоді, що проходить в переговорній кімнаті або кабінеті нотаріуса
     * */
    public function space()
    {
        $deal_info = Deal::select(
            'deals.id as deal_id',
            'cards.id as card_id',
            'cards.notary_id as notary_id',
            'cards.date_time as start_time',
            'deals.arrival_time as visit_time',
            'deals.waiting_time',
            'deals.total_time',
            'deals.number_of_people',
            'deals.children',
            'deals.in_progress',
            'deals.representative_arrived',
            'deals.room_id',
            'dev_groups.color',
        )->where('deals.ready', 0)
        ->leftJoin('cards', 'cards.id', '=', 'deals.card_id')
        ->leftJoin('dev_groups', 'dev_groups.id', '=', 'cards.dev_group_id')
        ->get();

        $result = [];

        foreach ($deal_info as $key => $info) {
            $info->children = $info->children ? true : false;
            $info['invite_room_title'] = $this->tools->get_invite_title($info->card_id);
            $info['notary'] = $this->tools->get_notary_id_and_title($info->notary_id);
            $info['reader'] = $this->tools->get_staff_by_card($info->card_id, 'reader');
            $info['accompanying'] = $this->tools->get_staff_by_card($info->card_id, 'accompanying');
            $info['representative'] = $this->tools->get_representative_by_card($info->card_id, 'accompanying');
            $info['immovable'] = $this->tools->get_immovables_by_card($info->card_id);
            $info['buyer'] = $this->tools->get_clients_by_card($info->card_id);

            $room_type = $info->room->type->alias;
            unset($info->room);
            if ($info->room_id && $room_type == 'reception') {
                $result['reception'][] = $info;
            } elseif ($info->room_id && $room_type == 'meeting_room') {
                $result['meeting_room'][] = $info;
            } elseif  ($info->room_id && $room_type == 'notary_cabinet') {
                $result['notary_cabinet'][] = $info;
            }

            unset($info);
        }

        $result['rooms'] = $this->tools->get_rooms();

        return $this->sendResponse($result, 'Дані для локацій');
    }

    public function close($deal_id)
    {
        if (Deal::where('id', $deal_id)->update(['ready' => true])) {
            return $this->sendResponse('', "Угоду №$deal_id завершено");
        } else {
            return $this->sendResponse('', "Угоду №$deal_id відсутня");
        }
    }

    public function move_to_reception($deal_id)
    {
        $reception_type_id = RoomType::where('alias', 'reception')->value('id');
        if (!$reception = Room::where(['type_id' => $reception_type_id, 'location' => 'rakul'])->first())
            return $this->sendResponse('', "Приймальня відсутня");
        if (Deal::where('id', $deal_id)->update(['room_id' => $reception->id]))
            return $this->sendResponse('', "Клієнти по угоді №$deal_id перейшли до " . $reception->title);
        else
            return $this->sendResponse('', "Угода відсутня");
    }

    public function move_to_room($room_id, $deal_id)
    {
        if (!$room = Room::where(['id' => $room_id, 'location' => 'rakul'])->first())
            return $this->sendResponse('', "Приймальня відсутня");

        if (Deal::where('id', '!=', $deal_id)->where(['room_id' => $room->id, 'ready' => false])->first())
            return $this->sendResponse('', "Кімната зайнята");

        Deal::where(['id' => $deal_id])->update(['room_id' => $room->id, 'ready' => false]);

        $deal = Deal::find($deal_id);
        if (!$deal->invite_time) {
            $now = new \DateTime();
            Deal::where(['id' => $deal_id])->update(['invite_time' => $now]);
        }

        return $this->sendResponse('', "Угода з ID: $deal_id перейшла до $room->title");
    }

    public function move_to_notary($deal_id)
    {
        if ($deal = Deal::find($deal_id)) {
            $card = Card::find($deal->card_id);
            $room_id = $card->notary->room->id;
            if (Deal::where(['room_id' => $room_id, 'ready' => false])->where('card_id', '!=', $card->id)->first())
                return $this->sendResponse('', "Кабінет нотаріуса зайнятий");
            elseif ($room_id && Deal::where('id', $deal_id)->update(['room_id' => $room_id])) {
                $deal = Deal::find($deal_id);
                if (!$deal->invite_time) {
                    $now = new \DateTime();
                    Deal::where(['id' => $deal_id])->update(['invite_time' => $now]);
                }
                return $this->sendResponse('', "Клієнти по угоді №$deal_id перейшли до нотаріуса");
            }
        } else {
            return $this->sendResponse('', "Угоду №$deal_id відсутня");
        }
    }
}
