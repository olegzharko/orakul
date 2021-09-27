<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Models\Card;
use App\Models\Region;
use App\Models\Room;
use App\Models\City;
use App\Models\Time;
use App\Models\User;
use App\Models\Contract;
use App\Models\ImmovableType;
use App\Models\DeveloperBuilding;
use App\Models\Client;
use Illuminate\Http\Request;
use Validator;
use Spatie\QueryBuilder\QueryBuilder;


class SearchController extends BaseController
{
    public $card;

    public function __construct()
    {
        $this->card = new CardController();
    }

    public function search(Request $r)
    {
        $validator = $this->validate_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        $text = $r->text;

        $result = $this->get_query_to_cards($text);

        return $this->sendResponse($result, 'За ключовими словами: ' . $text . ', було знайдено наступне');
    }

    public function validate_data($r)
    {
        $validator = Validator::make([
            'text' => $r['text'],
        ], [
            'text' => ['string', 'nullable'],
        ], [
            'text.required' => 'Необхідно передати дані в параметрі text',
            'text.string' => 'Тип данних для поля text - string',
        ]);

        return $validator;
    }

    public function get_query_to_cards($text)
    {
        $result = null;
        $date = new \DateTime();

        $rooms = Room::where('active', true)->pluck('id')->toArray();
        $times = Time::where('active', true)->pluck('time')->toArray();

        $query = Card::
            whereIn('cards.room_id', $rooms)
            ->whereDate('cards.date_time', '>=', $date->format('Y-m-d'))
            ->join('contracts','contracts.card_id', '=', 'cards.id')
            ->join('client_contract', 'client_contract.contract_id', '=', 'contracts.id')
            ->join('clients', 'clients.id', '=', 'client_contract.client_id')
            ->join('cities', 'cities.id', '=', 'cards.city_id')
            ->join('regions', 'regions.id', '=',  'cities.region_id')
            ->join('immovables', 'immovables.id', '=', 'contracts.immovable_id')
            ->join('immovable_types', 'immovable_types.id', '=', 'immovables.immovable_type_id')
            // ->join('contract_templates', 'contract_templates.id', '=', 'contracts.template_id')
            ->join('developer_buildings', 'immovables.developer_building_id', '=', 'developer_buildings.id')
        ;


        // dd(array_values(array_unique($query->orderBy('cards.id')->pluck('cards.id')->toArray())));
        if ($text)
            $query = $this->search_text_in_query($query, $text);

        $cards_id = array_values(array_unique($query->pluck('cards.id')->toArray()));

        $cards_query = Card::whereIn('cards.id', $cards_id)->whereIn('cards.room_id', $rooms)
                ->where('cards.date_time', '>=', $date->format('Y.m.d'));

        if (auth()->user()->type == 'reception') {
            $cards = $cards_query->where('cards.cancelled', false)->get();
            $result = $this->card->get_cards_in_reception_format($cards);
        }
        elseif (auth()->user()->type == 'generator') {
            // картки для генерації договору
            $cards_generator = $cards_query->where('cards.staff_generator_id', auth()->user()->id)
                ->where('cards.generator_step', true)->orderBy('cards.date_time')->get();
            $result['generator'] = $this->card->get_cards_in_generator_format($cards_generator);

            // з'єднати договори картки з договорами
            $cards_query->leftJoin('contracts', 'contracts.card_id', '=', 'cards.id');

            // картки для читки договорів
            $cards_id = $cards_query->where('contracts.reader_id', auth()->user()->id)
                ->where('contracts.ready', true)->orderBy('cards.date_time')->pluck('cards.id');
            $cards_reader = Card::whereIn('id', $cards_id)->get();
            $result['reader'] = $this->card->get_cards_in_generator_format($cards_reader);

            // картки для видачі договорів
            $cards_id = $cards_query->where('contracts.accompanying_id', auth()->user()->id)
                ->where('contracts.ready', true)->orderBy('cards.date_time')->pluck('cards.id');
            $cards_accompanying = Card::whereIn('id', $cards_id)->get();
            $result['accompanying'] = $this->card->get_cards_in_generator_format($cards_accompanying);

        }

        return $result;
    }

    public function search_text_in_query($query, $text)
    {
        $text = explode(" ", $text);

        $client_id = [];
        $client_id = array_merge($client_id, Client::whereIn('surname_n', $text)->pluck('id')->toArray());
        $client_id = array_merge($client_id, Client::whereIn('name_n', $text)->pluck('id')->toArray());
        $client_id = array_merge($client_id, Client::whereIn('patronymic_n', $text)->pluck('id')->toArray());

        $client_id = array_values(array_unique($client_id));

        if (count($client_id)) {
            $query->whereIn('clients.id', $client_id);
        }

        $region_id = Region::whereIn('title_n', $text)->pluck('id');

        if (count($region_id)) {
            $query->where('regions.id', $region_id);
        }

        $city_id = City::whereIn('title', $text)->pluck('id');

        if (count($city_id)) {
            $query->whereIn('cities.id', $city_id);
        }

        $imm_type_id = ImmovableType::whereIn('short', $text)->orWhereIn('title_n', $text)->pluck('id');

        if (count($imm_type_id)) {
            $query->whereIn('immovable_types.id', $imm_type_id);
        }

        $building_id_by_title = DeveloperBuilding::whereIn('title', $text)->pluck('id')->toArray();

        $building_id_by_number = DeveloperBuilding::whereIn('number', $text)->pluck('id')->toArray();

        $building_id = array_merge($building_id_by_title, $building_id_by_number);

        if (count($building_id)) {
            $query->whereIn('developer_buildings.id', $building_id);
        }

        return $query;
    }
}
