<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Models\Card;
use App\Models\Room;
use App\Models\SortType;
use App\Models\Time;
use Illuminate\Http\Request;
use Validator;
use DB;

class SortController extends BaseController
{
    public $date;
    public $rooms;
    public $times;
    public $card;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->rooms = Room::where('active', true)->pluck('id')->toArray();
        $this->times = Time::where('active', true)->pluck('time')->toArray();
        $this->card = new CardController();
    }

    public function sort(Request $r)
    {
        $result = null;
        $cards_id = null;
        $validator = $this->validate_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        $query_cards_id = Card::select(
            'cards.id',
            'cards.notary_id',
            'cards.room_id',
            'cards.date_time',
            'cards.city_id',
            'cards.dev_company_id',
            'cards.dev_representative_id',
            'cards.dev_manager_id',
            'cards.generator_step',
            'cards.cancelled',
        )->where(function ($query) use ($r) {
                if ($r['notary_id'])
                    $query = $query->where('cards.notary_id', $r['notary_id']);
                ######################### Старый вариант передачи данных с формы
                if ($r['developer_id'])
                    $query = $query->where('cards.dev_company_id', $r['developer_id']);
//                if ($r['giver_id'])
//                    $query = $query->where('contracts.accompanying_id', $r['giver_id']);
//                if ($r['dev_assistant_id'])
//                    $query = $query->where('cards.dev_representative_id', $r['dev_assistant_id']);
                if ($r['dev_company_id'])
                    $query = $query->where('cards.dev_company_id', $r['dev_company_id']);
                ########################## Конец старого варианта
                if ($r['dev_representative_id'])
                    $query = $query->where('cards.dev_representative_id', $r['dev_representative_id']);
                if ($r['reader_id'])
                    $query = $query->where('contracts.reader_id', $r['reader_id']);
                if ($r['accompanying_id'])
                    $query = $query->where('contracts.accompanying_id', $r['accompanying_id']);
                if ($r['contract_type_id'])
                    $query = $query->where('contracts.type_id', $r['contract_type_id']);

            return $query;
        })
            ->leftJoin('card_contract', 'cards.id', '=', 'card_contract.card_id')
            ->leftJoin('contracts', 'contracts.id', '=', 'card_contract.contract_id')
            ->where('cards.date_time', '>=', $this->date->format('Y.m.d'))
            ->distinct('cards.id');

        if ($query_cards_id->pluck('cards.id'))
            $cards_id = array_values(array_unique($query_cards_id->pluck('cards.id')->toArray()));

        $cards_query = Card::whereIn('id', $cards_id)
                        ->whereIn('room_id', $this->rooms)
                        ->where('date_time', '>=', $this->date->format('Y.m.d'))
                        ->orderBy('cards.date_time')
                        ;


        // if ($r['sort_type'] == 'asc') {
        //     // dd(1);
        //     $cards_query = $cards_query->orderBy('cards.id', 'asc');
        // } elseif ($r['sort_type'] == 'desc') {
        //     // dd(2);
        //     $cards_query = $cards_query->orderBy('cards.id', 'desc');
        // } else {
        //     // dd(3);
        //   $cards_query = $cards_query->orderBy('cards.date_time');
        // }


        if (auth()->user()->type == 'reception') {
            $cards = $cards_query->where('cancelled', false)->get();
            $result = $this->card->get_cards_in_reception_format($cards);
        }
        elseif (auth()->user()->type == 'generator') {
            $cards = $cards_query->where('staff_generator_id', auth()->user()->id)->where('generator_step', true)->get();
            $result = $this->card->get_cards_in_generator_format($cards);
        }
        else {
            return $this->sendError("Користувач не може завантажити даний розділ");
        }

        return  $this->sendResponse($result, 'Картки після сортування');
    }

    public function validate_data($r)
    {
        $validator = Validator::make([
            'notary_id' => $r['notary_id'],
            'reader_id' => $r['reader_id'],
            'accompanying_id' => $r['accompanying_id'],
            'dev_company_id' => $r['dev_company_id'],
            'dev_representative_id' => $r['dev_representative_id'],
            'contract_type_id' => $r['contract_type_id'],
            'sort_type_id' => $r['sort_type_id'],
        ], [
            'notary_id' => ['numeric', 'nullable'],
            'reader_id' => ['numeric', 'nullable'],
            'accompanying_id' => ['numeric', 'nullable'],
            'dev_company_id' => ['numeric', 'nullable'],
            'dev_representative_id' => ['numeric', 'nullable'],
            'contract_type_id' => ['numeric', 'nullable'],
            'sort_type_id' => ['numeric', 'nullable'],
        ], [
            'notary_id.numeric' => 'Необхідно передати ID нотаріса в числовому форматі',
            'reader_id.numeric' => 'Необхідно передати ID читача в числовому форматі',
            'accompanying_id.numeric' => 'Необхідно передати ID видавача в числовому форматі',
            'dev_company_id.numeric' => 'Необхідно передати ID компанії забудовника в числовому форматі',
            'dev_representative_id.numeric' => 'Необхідно передати ID представника забудовника в числовому форматі',
            'contract_type_id.numeric' => 'Необхідно передати ID типу договору в числовому форматі',
            'sort_type_id.numeric' => 'Необхідно передати ID метода сортування в числовому форматі',
        ]);

        return $validator;
    }

}
