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

        dd($result);

        return $this->sendResponse($result, 'За ключовими словами було знайдено наступне');
    }

    public function validate_data($r)
    {
        $validator = Validator::make([
            'text' => $r['text'],
        ], [
            'text' => ['required', 'string'],
        ], [
            'text.required' => 'Необхідно передати дані в параметрі text',
            'text.string' => 'Необхідно передати ID менеджера забудовника в числовому форматі',
        ]);

        return $validator;
    }

    public function get_query_to_cards($text)
    {
        $result = null;
        $date = new \DateTime();

        $rooms = Room::where('active', true)->pluck('id')->toArray();
        $times = Time::where('active', true)->pluck('time')->toArray();

        $query = Card::select(
            'contracts.id',
            'contracts.type_id',
            'contracts.delivery_id',
            'contracts.reader_id',
            'contracts.contract_template_id',
            'contracts.immovable_id',
            'contracts.client_id',
            'contracts.sign_date',
            'cards.notary_id',
            'cards.room_id',
            'cards.date_time',
            'cards.city_id',
            'cards.dev_company_id',
            'cards.dev_representative_id',
            'cards.dev_manager_id',
            'cards.generator_step',
            'cards.cancelled',
            'cities.region_id',
            'cities.district_id',
            'cities.city_type_id',
            'cities.title',
            'immovables.immovable_type_id',
            'immovables.proxy_id',
            'immovables.developer_building_id',
            'immovables.immovable_number',
            'immovables.registration_number',
            'developer_buildings.address_type_id',
            'developer_buildings.title',
            'developer_buildings.number as dev_building_number',
            'immovable_types.short',
            'immovable_types.title_n',
        )
            ->whereIn('room_id', $rooms)
            ->where('cards.date_time', '>=', $date)
            ->join('card_contract', 'cards.id', '=', 'card_contract.card_id')
            ->join('contracts', 'card_contract.contract_id', '=', 'contracts.id')
            ->join('clients', 'contracts.client_id', '=', 'clients.id')
            ->join('cities', 'cards.city_id', '=', 'cities.id')
            ->join('regions', 'cities.region_id', '=', 'regions.id')
            ->join('immovables', 'contracts.immovable_id', '=', 'immovables.id')
            ->join('immovable_types', 'immovables.immovable_type_id', '=', 'immovable_types.id')
            ->join('developer_buildings', 'immovables.developer_building_id', '=', 'developer_buildings.id');

        $cards = $this->search_text_in_query($query, $text);

        $result = $this->card->get_cards_in_calendar_format($cards, $rooms, $times, $date);

        return $result;
    }

    public function search_text_in_query($query, $text)
    {
        $text = explode(" ", $text);

        $client_id = Client::whereIn('surname_n', $text)->pluck('id');

        if (count($client_id)) {
            $query->where('clients.id', $client_id);
        }

        $region_id = Region::whereIn('title_n', $text)->pluck('id');

        if (count($region_id)) {
            $query->where('regions.id', $region_id);
        }

        $city_id = City::whereIn('title', $text)->pluck('id');

        if (count($city_id)) {
            $query->where('cities.id', $city_id);
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

        $cards = $query->get();

        return $cards;
    }
}
