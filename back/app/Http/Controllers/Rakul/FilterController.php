<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;
use App\Http\Controllers\Staff\StaffController;
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
        $this->staff = new StaffController();
    }

    public function dropdown($user_type = null)
    {
        $result = [];

        $notary = $this->tools->get_company_notary();
        $reader = $this->tools->get_reader_staff();
        $accompanying = $this->tools->get_accompanying_staff();
        $generator = $this->tools->get_generator_staff();
        $contract_type = ContractType::get_active_contract_type();
        $developer = $this->tools->get_dev_group();
        $sort_type = SortType::get_all_sort_type();
        $filter_type = $this->get_filter_type($user_type);

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

    /*
     * Фільтр, що готує дані по забудовнику, в формі створення нової картки, з боку ресепшена
     * */
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

    public function ready_cards($user_type = null)
    {
        $result = null;

        if (!$user_type) {
            $user_type = auth()->user()->type;
        }

        $cards_query = Card::whereIn('cards.room_id', $this->rooms)
            ->where('cards.ready', true)
            ->orderBy('cards.date_time')
            ->where('cards.date_time', '>=', $this->date->format('Y.m.d'));

        if ($user_type == 'generator') {
            // картки для генерації договору
            $cards_generator = $cards_query->where('staff_generator_id', auth()->user()->id)
                ->where('generator_step', true)->orderBy('date_time')->get();
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

            $user = auth()->user();
            $info['generate'] = $this->staff->get_staff_generate_info($user);
            $info['read'] = $this->staff->get_staff_read_info($user);
            $info['accompanying'] = $this->staff->get_staff_generate_info($user);

            $result['info'] = $info;
        } else {
            // картки для менеджера
            $cards = $cards_query->get();
            $result = $this->card->get_cards_in_generator_format($cards);
        }

        return $this->sendResponse($result, 'Картки з договорами готовими до видачі');
    }

    public function process_cards($user_type = null)
    {
        $result = null;

        if (!$user_type) {
            $user_type = auth()->user()->type;
        }

        $cards_query = Card::whereIn('cards.room_id', $this->rooms)
            ->where('cards.ready', false)
            ->orderBy('cards.date_time')
            ->where('cards.date_time', '>=', $this->date->format('Y.m.d'));

        if ($user_type == 'generator') {
            // картки для генерації договору
            $cards_generator = $cards_query->where('staff_generator_id', auth()->user()->id)
                ->where('generator_step', true)->orderBy('date_time')->get();
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

            $user = auth()->user();
            $info['generate'] = $this->staff->get_staff_generate_info($user);
            $info['read'] = $this->staff->get_staff_read_info($user);
            $info['accompanying'] = $this->staff->get_staff_generate_info($user);

            $result['info'] = $info;
        } else {
            // картки для менеджера
            $cards = $cards_query->get();
            $result = $this->card->get_cards_in_generator_format($cards);
        }

        return $this->sendResponse($result, 'Картки з договорами готовими до видачі');
    }

    public function cards_by_contract_type($contract_type, $user_type = null)
    {
        $result = null;
        $cards_id = [];

        if (!$user_type) {
            $user_type = auth()->user()->type;
        }

        if (!$contract_type_id = ContractType::where('alias', $contract_type)->value('id'))
            return $this->sendError("Данний ключ типу договору відсутній");

        $cards_query = Card::select(
                "cards.id",
                "cards.notary_id",
                "cards.room_id",
                "cards.date_time",
                "cards.city_id",
                "cards.dev_group_id",
                "cards.dev_representative_id",
                "cards.dev_manager_id",
                "cards.generator_step",
                "cards.ready",
                "cards.cancelled",
            )
        ->whereIn('cards.room_id', $this->rooms)
            ->where('cards.date_time', '>=', $this->date->format('Y.m.d'))
            ->where('contract_types.id', $contract_type_id)
            ->leftJoin('contracts', 'contracts.card_id', '=', 'cards.id')
            ->leftJoin('contract_types', 'contract_types.id', '=', 'contracts.type_id')
            ->leftJoin('contract_templates', 'contract_templates.id', '=', 'contracts.template_id')
            ->orderBy('cards.date_time')
            ->distinct('cards.id');

        if ($user_type == 'generator') {
            // картки для генерації договору
            $cards_generator = $cards_query->where('staff_generator_id', auth()->user()->id)
                ->where('generator_step', true)->orderBy('date_time')->get();
            $result['generator'] = $this->card->get_cards_in_generator_format($cards_generator);

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

            $user = auth()->user();
            $info['generate'] = $this->staff->get_staff_generate_info($user);
            $info['read'] = $this->staff->get_staff_read_info($user);
            $info['accompanying'] = $this->staff->get_staff_generate_info($user);

            $result['info'] = $info;
        } else {
            // картки для менеджера
            $cards = $cards_query->get();
            $result = $this->card->get_cards_in_generator_format($cards);
        }

        return $this->sendResponse($result, 'Картки в яких присутні основні договори');
    }

    public function cancelled_cards($user_type = null)
    {
        if (!$user_type) {
            $user_type = auth()->user()->type;
        }

        $cards_query = Card::whereIn('cards.room_id', $this->rooms)
            ->where('cards.date_time', '>=', $this->date->format('Y.m.d'))
            ->orderBy('cards.date_time')
            ->where('cards.cancelled', true);

        if ($user_type == 'generator') {
            // картки для генерації договору
            $cards_generator = $cards_query->where('staff_generator_id', auth()->user()->id)
                ->where('generator_step', true)->orderBy('date_time')->get();
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

            $user = auth()->user();
            $info['generate'] = $this->staff->get_staff_generate_info($user);
            $info['read'] = $this->staff->get_staff_read_info($user);
            $info['accompanying'] = $this->staff->get_staff_generate_info($user);

            $result['info'] = $info;
        } else {
            // картки для менеджера
            $cards = $cards_query->get();
            $result = $this->card->get_cards_in_generator_format($cards);
        }

        return $this->sendResponse($result, 'Усі картки зі скасованими договорами');
    }

    private function get_filter_type($user_type)
    {
        $result = [];

        $filter_type = FilterType::select('alias', 'title')->where('active', true)->orderBy('sort_order')->get();
//        dd($filter_type);

        foreach ($filter_type as $key => $type) {
            $result[$key]['title'] = $type->title;

            if ($user_type)
                $result[$key]['type'] = $type->alias . "/" . $user_type;
            else
                $result[$key]['type'] = $type->alias;

            if (strpos($type->alias, 'total')) {
                $result[$key]['count'] = $this->count_total_cards();
            } elseif (strpos($type->alias, 'ready')) {
                $result[$key]['count'] = $this->count_ready_cards();
            } elseif (strpos($type->alias,'main')) {
                $result[$key]['count'] = $this->count_by_type('main');
            } elseif (strpos($type->alias, 'preliminary')) {
                $result[$key]['count'] = $this->count_by_type('preliminary');
            } elseif (strpos($type->alias, 'cancelled')) {
                $result[$key]['count'] = $this->count_cancelled_cards();
            } elseif (strpos($type->alias, 'process')) {
                $result[$key]['count'] = $this->count_process_cards();
            } else {
                $result[$key]['count'] = null;
            }
        }

        return $result;
    }

    private function start_card_query()
    {
        $query_cards = Card::whereIn('room_id', $this->rooms)
            ->where('date_time', '>=', $this->date->format('Y.m.d'));

        return $query_cards;
    }

    private function query_for_generator($query_cards)
    {
        return $query_cards->where('staff_generator_id', auth()->user()->id)
                        ->where('generator_step', true);
    }

    private function count_by_type($contract_type)
    {
        if (!$contract_type_id = ContractType::where('alias', $contract_type)->value('id'))
            return null;

        $query_cards = $this->start_card_query();

        $query_cards = $query_cards->select(
                "cards.id",
                "cards.notary_id",
                "cards.room_id",
                "cards.date_time",
                "cards.city_id",
                "cards.dev_group_id",
                "cards.dev_representative_id",
                "cards.dev_manager_id",
                "cards.generator_step",
                "cards.ready",
                "cards.cancelled",
            )
        ->where('contracts.type_id', $contract_type_id)
        ->leftJoin('contracts', 'contracts.card_id', '=', 'cards.id')
        ->distinct('cards.id');

        if (auth()->user()->type == 'generator'){
            $query_cards = $this->query_for_generator($query_cards);
        }

        $count_cards = $query_cards->count();

        return $count_cards;
    }

    private function count_total_cards()
    {
        $query_cards = $this->start_card_query();

        if (auth()->user()->type == 'generator'){
            $query_cards = $this->query_for_generator($query_cards);
        }

        $count_cards = $query_cards->count();

        return $count_cards;
    }

    private function count_ready_cards()
    {
        $query_cards = $this->start_card_query();

        if (auth()->user()->type == 'generator'){
            $query_cards = $this->query_for_generator($query_cards);
        }

        $count_cards = $query_cards->where('ready', true)->count();

        return $count_cards;
    }

    private function count_cancelled_cards()
    {
        $query_cards = $this->start_card_query();

        if (auth()->user()->type == 'generator') {
             $query_cards = $this->query_for_generator($query_cards);
        }

        $count_cards = $query_cards->where('cancelled', true)->count();

        return $count_cards;
    }

    public function count_process_cards()
    {
        $query_cards = $this->start_card_query();

        if (auth()->user()->type == 'generator'){
            $query_cards = $this->query_for_generator($query_cards);
        }

        $count_cards = $query_cards->where('ready', false)->count();

        return $count_cards;
    }
}
