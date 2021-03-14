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
    public $card;

    public function __construct()
    {
        $this->card = new CardController();
    }

    public function sort($page, Request $r)
    {
        $result = null;
        $validator = $this->validate_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        $search_cards_id = DB::table('cards')
            ->leftJoin('card_contract', 'cards.id', '=', 'card_contract.card_id')
            ->leftJoin('contracts', 'contracts.id', '=', 'card_contract.contract_id')
            ->where(function ($query) use ($r) {
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
        })->pluck('id');

        $cards = $this->card->get_all_calendar_cards();

        foreach ($cards as $key => $card) {
            if (!in_array($card->id, $search_cards_id))
                $cards[$key]->title = "";
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
//            'notary_id' => ['required', 'numeric', 'nullable'],
//            'reader_id' => ['required', 'numeric', 'nullable'],
//            'giver_id' => ['required', 'numeric', 'nullable'],
//            'dev_company_id' => ['required', 'numeric', 'nullable'],
//            'dev_representative_id' => ['required', 'numeric', 'nullable'],
//            'sort_type_id' => ['required', 'numeric', 'nullable'],

            'notary_id' => ['numeric', 'nullable'],
            'reader_id' => ['numeric', 'nullable'],
            'accompanying_id' => ['numeric', 'nullable'],
            'dev_company_id' => ['numeric', 'nullable'],
            'dev_representative_id' => ['numeric', 'nullable'],
            'contract_type_id' => ['numeric', 'nullable'],
            'sort_type_id' => ['numeric', 'nullable'],
        ], [
//            'notary_id.required' => 'Необхідно передати ID нотаріса або 0',
//            'reader_id.required' => 'Необхідно передати ID читача або 0',
//            'giver_id.required' => 'Необхідно передати ID видавача або 0',
//            'dev_company_id.required' => 'Необхідно передати ID компанії забудовника або 0',
//            'dev_representative_id.required' => 'Необхідно передати ID представника забудовника або 0',
//            'sort_type_id.required' => 'Необхідно передати ID метода сортування або 0',
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
