<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Helper\ToolsController;
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
    public $tools;

    public function __construct()
    {
        $this->date = new \DateTime('today');
        $this->rooms = Room::where('active', true)->pluck('id')->toArray();
        $this->times = Time::where('active', true)->pluck('time')->toArray();
        $this->card = new CardController();
        $this->tools = new ToolsController();
    }

    public function sort(Request $r)
    {
        $result = null;
        $cards_id = null;
        $user_type = null;
        $validator = $this->validate_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        if (isset($r['user_type']) && !empty($r['user_type']))
            $user_type = $r['user_type'];
        else
            $user_type = auth()->user()->type;

        $query_cards_id = Card::select(
            'cards.id',
            'cards.notary_id',
            'cards.room_id',
            'cards.date_time',
            'cards.city_id',
            'cards.dev_group_id',
            'cards.dev_representative_id',
            'cards.dev_manager_id',
            'cards.generator_step',
            'cards.cancelled',
        )->where(function ($query) use ($r) {
                if ($r['notary_id'])
                    $query = $query->where('cards.notary_id', $r['notary_id']);
                ######################### Старый вариант передачи данных с формы
                if ($r['developer_id'])
                    $query = $query->where('cards.dev_group_id', $r['developer_id']);
                ########################## Конец старого варианта
                if ($r['dev_company_id'])
                    $query = $query->where('cards.dev_group_id', $r['dev_company_id']);
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
            ->leftJoin('contracts', 'contracts.card_id', '=', 'cards.id')
            ->where('cards.date_time', '>=', $this->date->format('Y.m.d'))
            ->distinct('cards.id')->pluck('cards.id');

        if ($query_cards_id)
            $cards_id = array_values(array_unique($query_cards_id->toArray()));

        // объеденить запрос с запросом,что выше для значений фильтра
        $cards_query = Card::whereIn('cards.id', $cards_id)
                        ->whereIn('cards.room_id', $this->rooms)
                        ->where('cards.cancelled', false)
                        ->where('cards.date_time', '>=', $this->date->format('Y.m.d'))
                        ->orderBy('cards.date_time')
                        ;

        if ($user_type == 'reception') {
            $cards = $cards_query->where('cards.cancelled', false)->get();
            $result = $this->card->get_cards_in_reception_format($cards);
        } elseif ($user_type == 'generator') {
            // картки для генерації договору
            $cards_generator_query = clone $cards_query;
            $cards_generator_id = $cards_generator_query->where('cards.staff_generator_id', auth()->user()->id)->where('cards.generator_step', true)->pluck('cards.id');
            $cards_generator = $cards_query->where('cards.staff_generator_id', auth()->user()->id)->where('cards.generator_step', true)->get();
//
            $result['generator'] = $this->card->get_cards_in_generator_format($cards_generator, $r['sort_type']);
            // з'єднати договори картки з договорами
            $cards_query->where('contracts.ready', true)->orderBy('cards.date_time')
                ->leftJoin('contracts', 'contracts.card_id', '=', 'cards.id');

            // картки для читки договорів
            $cards_reader_query = clone $cards_query;
            $cards_read_id = $cards_reader_query->where('contracts.reader_id', auth()->user()->id)->pluck('cards.id');
            $cards_reader = Card::whereIn('id', $cards_read_id)->get();
            $result['reader'] = $this->card->get_cards_in_generator_format($cards_reader);

            // картки для видачі договорів
            $cards_accompanying_query = clone $cards_query;
            $cards_accompanying_id = $cards_accompanying_query->where('contracts.accompanying_id', auth()->user()->id)->pluck('cards.id');
            $cards_accompanying = Card::whereIn('id', $cards_accompanying_id)->get();
            $result['accompanying'] = $this->card->get_cards_in_generator_format($cards_accompanying);

            $info['generate'] = $this->tools->count_generate_cards($cards_generator_id);
            $info['read'] = $this->tools->count_read_cards($cards_read_id);
            $info['accompanying'] = $this->tools->count_accompanying_cards($cards_accompanying_id);

            $result['info'] = $info;
        } elseif ($user_type == 'manager' || $user_type == 'assistant') {
            $cards = $cards_query->orderBy('cards.date_time')->get();
            $result = $this->card->get_cards_in_generator_format($cards, $r['sort_type']);
        } else {
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
