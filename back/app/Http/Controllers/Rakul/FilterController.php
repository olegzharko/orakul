<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;
use App\Models\Client;
use App\Models\ClientType;
use App\Models\ContractType;
use App\Models\DeveloperBuilding;
use App\Models\DevCompany;
use App\Models\DevGroup;
use App\Models\FilterType;
use App\Models\Notary;
use App\Models\SortType;
use App\Models\Staff;
use DB;
use App\Models\Room;
use App\Models\Time;
use App\Models\Card;
use App\Models\User;
use App\Models\DevEmployerType;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;

class FilterController extends BaseController
{
    public $date;
    public $rooms;
    public $times;
    public $tools;
    public $convert;
    public $card;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->rooms = Room::where('active', true)->pluck('id')->toArray();
        $this->times = Time::where('active', true)->pluck('time')->toArray();
        $this->tools = new ToolsController();
        $this->convert = new ConvertController();
        $this->card = new CardController();
    }

    public function dropdown()
    {
        $result = [];

        $notary = $this->tools->get_company_notary();
        $reader = $this->tools->get_reader_staff();
        $accompanying = $this->tools->get_accompanying_staff();
        $generator = $this->tools->get_generator_staff();
        $contract_type = ContractType::get_active_contract_type();
        $developer = $this->tools->get_developer();
        $sort_type = SortType::get_all_sort_type();
        $filter_type = $this->get_filter_type();

        $result = [
            'notary' => $notary,
            'reader' => $reader,
            'accompanying' => $accompanying,
            'printer' => $generator,
            'contract_type' => $contract_type,
            'developer' => $developer,
            'sort_type' => $sort_type,
            'filter_type' => $filter_type,
        ];

        return $this->sendResponse($result, 'Фільтер dropdown data');
    }

    public function developer_info($id)
    {
        $result = [];

        $developer = null;
        $dev_representative = null;
        $dev_manager = null;
        $dev_building = null;

        $representative = null;
        $manager = null;
        $building = null;

//        if (!$developer = DevCompany::find($id))
//            return $this->sendError("Забудовника з ID: $id не було знайдено!");
//        if ($developer) {
//            $representative_type_id = ClientType::get_representative_type_id();
//            $manager_type_id = ClientType::get_manager_type_id();
//
//            $representative = $this->tools->developer_employer_by_type($developer->id, $representative_type_id);
//            $manager = $this->tools->developer_employer_by_type($developer->id, $manager_type_id);
//            $building = $this->tools->developer_building($developer->id);
//        }

        if (!$dev_groupe = DevGroup::find($id))
            return $this->sendError("Забудовника з ID: $id не було знайдено!");

        if ($dev_groupe) {
            $representative_type_id = DevEmployerType::get_representative_type_id();
            $manager_type_id = DevEmployerType::get_manager_type_id();

            $representative = $this->tools->dev_group_employer_by_type($dev_groupe->id, $representative_type_id);
            $manager = $this->tools->dev_group_employer_by_type($dev_groupe->id, $manager_type_id);
            $building = $this->tools->dev_group_buildings($dev_groupe->id);
        }

        $result = [
          'representative' => $representative,
          'manager' => $manager,
          'building' => $building,
        ];

        return $this->sendResponse($result, 'Додаткова інформація по забудовнику ID: ' . $id);
    }

    public function ready_cards()
    {
        $result = null;

        $cards = Card::where('staff_generator_id', auth()->user()->id)
            ->whereIn('room_id', $this->rooms)
            ->where('ready', true)
            ->where('date_time', '>=', $this->date)
            ->get();

        $result = $this->card->get_cards_in_generator_format($cards);

        return $this->sendResponse($result, 'Картки з договорами готовими до видачі');
    }

    public function cards_by_contract_type($contract_type)
    {
        $result = null;
        $cards_id = [];

        if (!$contract_type_id = ContractType::where('alias', $contract_type)->value('id'))
            return $this->sendError("Данний ключ типу договору відсутній");

        $cards = Card::select(
                "cards.id",
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
            )
        ->where('staff_generator_id', auth()->user()->id)
        ->whereIn('cards.room_id', $this->rooms)
        ->where('cards.date_time', '>=', $this->date)
        ->where('contract_types.id', $contract_type_id)
        ->leftJoin('contracts', 'contracts.card_id', '=', 'cards.id')
        ->leftJoin('contract_templates', 'contract_templates.id', '=', 'contracts.template_id')
        ->distinct('cards.id')
        ->get();

        $result = $this->card->get_cards_in_generator_format($cards);

        return $this->sendResponse($result, 'Картки в яких присутні основні договори');
    }

    public function cancelled_cards()
    {
        $cards = Card::where('staff_generator_id', auth()->user()->id)
            ->whereIn('room_id', $this->rooms)
            ->where('date_time', '>=', $this->date)
            ->where('cancelled', true)
            ->get();

        if (auth()->user()->type != 'reception') {
            $result = $this->card->get_cards_in_generator_format($cards);
        }
        else {
            return $this->sendError("Тип сторінки $page не підримується");
        }

        return $this->sendResponse($result, 'Усі картки з договорами');
    }

    private function get_filter_type()
    {
        $result = [];

        $filter_tyep = FilterType::select('alias', 'title')->where('active', true)->get();

        foreach ($filter_tyep as $key => $type) {
            if ($type->alias == 'ready') {
                $result[$key]['type'] = $type->alias;
                $result[$key]['count'] = $this->count_ready_cards();
            } elseif ($type->alias == 'main') {
                $result[$key]['type'] = $type->alias;
                $result[$key]['count'] = $this->count_by_type($type->alias);
            } elseif ($type->alias == 'preliminary') {
                $result[$key]['type'] = $type->alias;
                $result[$key]['count'] = $this->count_by_type($type->alias);
            } elseif ($type->alias == 'cancelled') {
                $result[$key]['type'] = $type->alias;
                $result[$key]['count'] = $this->count_cancelled_cards();
            }
        }

        return $result;
    }

    private function count_by_type($contract_type)
    {
        if (!$contract_type_id = ContractType::where('alias', $contract_type)->value('id'))
            return null;

        $count_cards = Card::select(
                "cards.id",
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
            )
        ->where('staff_generator_id', auth()->user()->id)
        ->whereIn('cards.room_id', $this->rooms)
        ->where('cards.date_time', '>=', $this->date)
        ->where('contracts.type_id', $contract_type_id)
        ->leftJoin('contracts', 'contracts.card_id', '=', 'cards.id')
        ->distinct('cards.id')
        ->count();

        return $count_cards;
    }

    private function count_ready_cards()
    {
        $count_cards = Card::where('staff_generator_id', auth()->user()->id)
            ->whereIn('room_id', $this->rooms)
            ->where('ready', true)
            ->where('date_time', '>=', $this->date)
            ->count();

        return $count_cards;
    }

    private function count_cancelled_cards()
    {
        $count_cards = Card::where('staff_generator_id', auth()->user()->id)
            ->whereIn('room_id', $this->rooms)
            ->where('date_time', '>=', $this->date)
            ->where('cancelled', true)
            ->count();

        return $count_cards;
    }
}
