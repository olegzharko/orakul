<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Models\Card;
use App\Models\Room;
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
        $validator = $this->validate_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        $cards = Card::where(function ($query) use ($r) {
                if ($r['notary_id'])
                    $query = $query->where('cards.notary_id', $r['notary_id']);
                if ($r['dev_company_id'])
                    $query = $query->where('cards.dev_company_id', $r['dev_company_id']);
                if ($r['dev_representative_id'])
                    $query = $query->where('cards.dev_representative_id', $r['dev_representative_id']);
                if ($r['reader_id'])
                    $query = $query->where('contracts.reader_id', $r['reader_id']);
                if ($r['accompanying_id'])
                    $query = $query->where('contracts.accompanying_id', $r['accompanying_id']);

            return $query;
        })
            ->leftJoin('card_contract', 'cards.id', '=', 'card_contract.card_id')
            ->leftJoin('contracts', 'contracts.id', '=', 'card_contract.contract_id')
            ->where('cards.date_time', '>=', $this->date)
            ->get();

        if (auth()->user()->type == 'reception') {
            $result = $this->card->get_cards_in_reception_format($cards, $this->rooms, $this->times, $this->date);
        }
        elseif (auth()->user()->type == 'generator') {
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
