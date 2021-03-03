<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Factory\ConvertController;
use App\Models\Card;
use App\Models\CardContract;
use App\Models\Client;
use App\Models\ClientType;
use App\Models\ContractType;
use App\Models\DeveloperBuilding;
use App\Models\DevCompany;
use App\Models\Notary;
use App\Models\Room;
use App\Models\Staff;
use App\Models\Time;
use App\Models\Contract;
use Illuminate\Http\Request;
use DB;

class FilterController extends BaseController
{
    public $convert;
    public $card;

    public function __construct()
    {
        $this->convert = new ConvertController();
        $this->card = new CardController();
    }

    public function dropdown()
    {
        $result = [];

        $notary = $this->get_notary();
        $reader = $this->get_reader_staff();
        $accompanying = $this->get_accompanying_staff();
        $contract_type = ContractType::select('id', 'alias')->where('active', true)->pluck('id', 'alias')->toArray();
        $developer = $this->get_developer();;

        $result = [
            'notary' => $notary,
            'reader' => $reader,
            'accompanying' => $accompanying,
            'contract_type' => $contract_type,
            'developer' => $developer,
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

        $result_representative = null;
        $result_manager = null;
        $result_building = null;

        $developer = DevCompany::find($id);

        if ($developer) {
            $dev_representative_id = ClientType::where('key', 'representative')->value('id');
            $dev_manager_id = ClientType::where('key', 'manager')->value('id');

            $dev_representative = Client::select('id', 'surname_n', 'name_n', 'patronymic_n')->where('type', $dev_representative_id)->get();
            foreach ($dev_representative as $key => $representative) {
                $result_representative[$key]['id'] = $representative->id;
                $result_representative[$key]['title'] = $this->convert->get_full_name($representative);
            }

            $dev_manager = Client::select('id', 'surname_n', 'name_n', 'patronymic_n')->where('type', $dev_manager_id)->get();
            foreach ($dev_manager as $key => $manager) {
                $result_manager[$key]['id'] = $manager->id;
                $result_manager[$key]['title'] = $this->convert->get_full_name($manager);
            }

            $dev_building = DeveloperBuilding::where('dev_company_id', $developer->id)->get();
            foreach ($dev_building as $key => $building) {
                $result_building[$key]['id'] = $building->id;
                $result_building[$key]['title'] = $this->convert->get_full_address($building);
            }
        }

        $result = [
          'representative' => $result_representative,
          'manager' => $result_manager,
          'building' => $result_building,
        ];

        return $this->sendResponse($result, 'Додаткова інформація по забудовнику ID: ' . $id);
    }

    public function get_notary()
    {
        $notary = Notary::where('rakul_company', true)->get();

        return $this->convertor_full_name($notary, 'surname_initial');
    }

    public function get_reader_staff()
    {
        $reader = Staff::where('reader', true)->get();

        return $this->convertor_full_name($reader, 'full_name');
    }

    public function get_accompanying_staff()
    {
        $accompanying = Staff::where('accompanying', true)->get();

        return $this->convertor_full_name($accompanying, 'full_name');
    }

    public function get_developer()
    {
        $developer = DevCompany::where('active', true)->get();

        return $this->convertor_full_name($developer, 'title');
    }

    public function convertor_full_name($staff, $name_type)
    {
        $convert_data = [];

        foreach ($staff as $key => $value) {
            $convert_data[$key]['id'] = $value->id;
            if ($name_type == 'full_name')
                $convert_data[$key]['title'] = $this->convert->get_full_name($value);
            elseif($name_type == 'surname_initial')
                $convert_data[$key]['title'] = $this->convert->get_surname_and_initials($value);
            elseif($name_type == 'title')
                $convert_data[$key]['title'] = $value->title;
        }

        return $convert_data;
    }

    public function cards_ready()
    {
        $result = null;
        $date = new \DateTime();

        $rooms = Room::where('active', true)->pluck('id')->toArray();
        $times = Time::where('active', true)->pluck('time')->toArray();

        $cards = Card::whereIn('room_id', $rooms)->where('ready', true)->where('date_time', '>=', $date)->get();

        $result = $this->card->get_cards_in_calendar_format($cards, $rooms, $times, $date);

        return $this->sendResponse($result, 'Картки з договорами готовими до видачі');
    }

    public function cards_by_contract_type($type)
    {
        $result = null;
        $date = new \DateTime();

        $rooms = Room::where('active', true)->pluck('id')->toArray();
        $times = Time::where('active', true)->pluck('time')->toArray();
        $contract_type_main = ContractType::where('alias', $type)->value('id');

        if ($contract_type_main) {
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
            )
                ->whereIn('cards.room_id', $rooms)->where('cards.date_time', '>=', $date)
                ->leftJoin('card_contract', 'cards.id', '=', 'card_contract.card_id')
                ->leftJoin('contracts', 'contracts.id', '=', 'card_contract.contract_id')
                ->where('contracts.type_id', $contract_type_main)
                ->get();

            $result = $this->card->get_cards_in_calendar_format($cards, $rooms, $times, $date);

            return $this->sendResponse($result, 'Картки в яких присутні основні договори');
        } else {
            return $this->sendError("Данний ключ до типу договору відсутній");
        }
    }

    public function cancelled_cards()
    {
        $date = new \DateTime();

        $rooms = Room::where('active', true)->pluck('id')->toArray();
        $times = Time::where('active', true)->pluck('time')->toArray();

        $cards = Card::whereIn('room_id', $rooms)->where('date_time', '>=', $date)->where('cancelled', true)->get();

        $result = $this->card->get_cards_in_calendar_format($cards, $rooms, $times, $date);

        return $this->sendResponse($result, 'Усі картки з договорами');
    }
}
