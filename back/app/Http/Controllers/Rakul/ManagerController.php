<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Models\ContractType;
use App\Models\Room;
use App\Models\Time;
use App\Models\Card;
use DB;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends BaseController
{
    public $card;
    public $date;
    public $rooms;
    public $times;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->rooms = Room::where('active', true)->pluck('id')->toArray();
        $this->times = Time::where('active', true)->pluck('time')->toArray();
        $this->card = new CardController();
    }

    /*
     * Зібрати доступні для користувача id карток
     * */
    public function get_cards_id_by_user_role()
    {
//        $result = [];

        $result = Card::pluck('id');

        /*
         * query to card by user type
         * */

        return $result;
    }

    public function total_cards($role = null)
    {
        $cards_id = null;
        if ($role)
            $cards_id = $this->get_cards_id_by_user_role();
        dd($cards_id);

        $cards = Card::where(function ($query) use ($cards_id) {
            if (count($cards_id)) {
                $query = $query->whereIn('id', $cards_id);
            }
            return $query;
        })->where('date_time', '>=', $this->date)->orderBy('date_time')->get();

        $result = $this->card->get_cards_in_generator_format($cards);

        return $this->sendResponse($result, 'Усі картки для менеджера');
    }

    public function ready_cards()
    {
        $result = null;

        $cards_id = $this->get_cards_id_by_user_role();

        $cards = Card::where(function ($query) use ($cards_id) {
            if (count($cards_id)) {
                $query = $query->whereIn('id', $cards_id);
            }
            return $query;
        })->whereIn('room_id', $this->rooms)->where('ready', true)->where('date_time', '>=', $this->date)->get();

        $result = $this->card->get_cards_in_generator_format($cards);

        return $this->sendResponse($result, 'Картки з договорами готовими до видачі');

    }

    public function cards_by_contract_type($type, $page)
    {
        $result = null;

        $cards_id = $this->get_cards_id_by_user_role();

        if (!$contract_type_id = ContractType::where('alias', $type)->value('id'))
            return $this->sendError("Данний ключ типу договору відсутній");

        $cards = Card::select(
                "cards.notary_id",
                "cards.room_id",
                "cards.date_time",
                "cards.city_id",
                "cards.dev_company_id",
                "cards.dev_representative_id",
                "cards.dev_manager_id",
                "cards.generator_step",
                "cards.ready",
                "cards.cancelled",
            )->where(function ($query) use ($cards_id) {
                if (count($cards_id)) {
                    $query = $query->whereIn('id', $cards_id);
                }
                return $query;
            })
            ->whereIn('cards.room_id', $this->rooms)->where('cards.date_time', '>=', $this->date)
            ->leftJoin('card_contract', 'cards.id', '=', 'card_contract.card_id')
            ->leftJoin('contracts', 'contracts.id', '=', 'card_contract.contract_id')
            ->where('contracts.type_id', $contract_type_id)
            ->get();

        if ($page == 'calendar') {
            $result = $this->card->get_cards_in_calendar_format($cards, $this->rooms, $this->times, $this->date);
        }
        elseif ($page == 'generator') {
            $result = $this->card->get_cards_in_generator_format($cards);
        }
        else {
            return $this->sendError("Тип сторінки $page не підримується");
        }

        return $this->sendResponse($result, 'Картки в яких присутні основні договори');
    }

    public function cancelled_cards($page)
    {
        $cards_id = $this->get_cards_id_by_user_role();

        $cards = Card::where(function ($query) use ($cards_id) {
            if (count($cards_id)) {
                $query = $query->whereIn('id', $cards_id);
            }
            return $query;
        })->whereIn('room_id', $this->rooms)->where('date_time', '>=', $this->date)->where('cancelled', true)->get();

        if ($page == 'generator')
            $result = $this->card->get_cards_in_calendar_format($cards, $this->rooms, $this->times, $this->date);
        else {
            return $this->sendError("Тип сторінки $page не підримується");
        }

        return $this->sendResponse($result, 'Усі картки з договорами');
    }
}
