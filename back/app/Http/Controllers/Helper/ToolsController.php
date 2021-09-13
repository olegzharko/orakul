<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factory\ConvertController;
use App\Models\ClientCheckList;
use App\Models\DevCompanyEmployer;
use App\Models\DevGroup;
use App\Models\Room;
use App\Models\ServiceSteps;
use App\Models\User;
use App\Models\DealServiceStep;
use App\Models\WorkDay;
use App\Models\Client;
use App\Models\Notary;
use App\Models\Text;
use App\Models\Card;
use App\Models\Contract;
use App\Models\DevCompany;
use App\Models\DeveloperBuilding;
use App\Models\Deal;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    public $convert;

    public function __construct()
    {
        $this->convert = new ConvertController();
    }

    public function header_info($card)
    {
        $result = null;
        $week = null;
        $room = null;

        $week = WorkDay::where('active', true)->orderBy('num')->pluck('title', 'num')->toArray();
        $room = Room::where('id', $card->room_id)->value('title');

        $result['day'] = $card->date_time->format('w') ? $week[$card->date_time->format('w')] : "Вихідний";
        $result['date'] = $card->date_time->format('d.m');
        $result['time'] = $card->date_time->format('H:i');
        $result['room'] = $room;

        return $result;
    }

    public function developer_employer_by_type($dev_company_id, $employer_type_id)
    {
        $result = [];

        $dev_employers = DevCompanyEmployer::get_dev_employers_by_type($dev_company_id, $employer_type_id);
        foreach ($dev_employers as $key => $employer) {
            $result[$key]['id'] = $employer->id;
            $result[$key]['title'] = $this->convert->get_full_name($employer);
        }

        return $result;
    }

    public function dev_group_employer_by_type($dev_group_id, $employer_type)
    {
        $result = [];

        $dev_employers = DevGroup::select(
            'clients.*'
        )
            ->where('dev_groups.id', $dev_group_id)
            ->where('dev_company_employers.type_id', $employer_type)
            ->join('dev_companies', 'dev_companies.dev_group_id', '=', 'dev_groups.id')
            ->join('dev_company_employers', 'dev_company_employers.dev_company_id', '=', 'dev_companies.id')
            ->join('clients', 'clients.id', '=', 'dev_company_employers.employer_id')
            ->distinct('dev_company_employers.employer_id')
            ->get();

        foreach ($dev_employers as $key => $employer) {
            $result[$key]['id'] = $employer->id;
            $result[$key]['title'] = $this->convert->get_full_name($employer);
        }

        return $result;
    }


    public function developer_building($dev_company)
    {
        $result_building = [];

        $dev_building = DeveloperBuilding::get_developer_company_building($dev_company);
        foreach ($dev_building as $key => $building) {
            $result_building[$key]['id'] = $building->id;
            $result_building[$key]['title'] = $this->convert->building_address_type_title_number($building);
        }

        return $result_building;
    }

    public function dev_group_buildings($dev_group_id)
    {
        $result_building = [];

        $buildings_id = DevGroup::select(
                'developer_buildings.*'
            )
            ->where('dev_groups.id', $dev_group_id)
            ->join('dev_companies', 'dev_companies.dev_group_id', '=', 'dev_groups.id')
            ->join('developer_buildings', 'developer_buildings.dev_company_id', '=', 'dev_companies.id')
            ->distinct('developer_buildings.id')
            ->pluck('developer_buildings.id');

        $dev_building = DeveloperBuilding::get_dev_group_buildings($buildings_id);

        foreach ($dev_building as $key => $building) {
            $result_building[$key]['id'] = $building->id;
            $result_building[$key]['title'] = $this->convert->building_address_type_title_number($building);
        }

        return $result_building;
    }

    public function get_company_notary()
    {
        $notary = Notary::where('rakul_company', true)->get();

        return $this->convertor_full_name($notary, 'surname_initial');
    }

    public function get_reader_staff()
    {
        $reader = User::where('reader', true)->orderBy('surname')->get();

        return $this->convertor_full_name($reader, 'full_name');
    }

    public function get_accompanying_staff()
    {
        $accompanying = User::where('accompanying', true)->orderBy('surname')->get();

        return $this->convertor_full_name($accompanying, 'full_name');
    }

    public function get_generator_staff()
    {
        $accompanying = User::where('generator', true)->orderBy('surname')->get();

        return $this->convertor_full_name($accompanying, 'full_name');
    }

    public function get_dev_group()
    {
        $developer = DevGroup::where('active', true)->get();

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
                $convert_data[$key]['title'] = $this->convert->get_surname_and_initials_n($value);
            elseif($name_type == 'title')
                $convert_data[$key]['title'] = $value->title;
        }

        return $convert_data;
    }

    public function get_client_data_for_manager($client)
    {
        $resutl = [];

        $resutl['id'] = null;
        $resutl['surname'] = null;
        $resutl['name'] = null;
        $resutl['patronymic'] = null;

        if ($client) {
            $resutl['id'] = $client->id;
            $resutl['surname'] = $client->surname_n;
            $resutl['name'] = $client->name_n;
            $resutl['patronymic'] = $client->patronymic_n;
            $resutl['passport_type_id'] = $client->passport_type_id;
            $resutl['married_type_id'] = $client->client_spouse_consent ? $client->client_spouse_consent->marriage_type_id : null;
        }

        return $resutl;
    }

    public function clinet_quesetionnaire_info($client_id)
    {
        $result = [];

        $client_check_list = ClientCheckList::select(
            "spouse_consent",
            "current_place_of_residence",
            "photo_in_the_passport",
            "immigrant_help",
            "passport",
            "tax_code",
            "evaluation_in_the_fund",
            "check_fop",
            "document_scans",
            "unified_register_of_court_decisions",
            "sanctions",
            "financial_monitoring",
            "unified_register_of_debtors",
        )->firstOrCreate(['client_id' => $client_id])->toArray();

        $i = 0;
        foreach ($client_check_list as $key => $value) {

            $result[$i]['title'] = Text::where('alias', $key)->value('value');
            $result[$i]['key'] = $key;
            $result[$i]['value'] = $value ? true : false;
            $i++;
        }

        return $result;
    }

    public function get_notary_id_and_title($notary_id)
    {
        $result = [];

        if ($notary = Notary::where('id', $notary_id)->get()) {
            foreach ($notary as $key => $value) {
                $result[$key]['id'] = $notary_id;
                $result[$key]['title'] = $this->convert->get_full_name($value);
            }
        }

        return $result;
    }

    public function get_staff_id_and_title($staff_id)
    {
        $result = [];

        if ($staff = User::find($staff_id)) {
            $result['id'] = $staff_id;
            $result['title'] = $this->convert->get_staff_full_name($staff);
        }

        return $result;
    }

    public function get_staff_by_card($card_id, $staff_type)
    {
        $result = [];

        if (Card::find($card_id)) {

            if ($staff_type == 'reader') {
                $staff_id = Contract::where('card_id', $card_id)->pluck('reader_id')->toArray();
            } elseif ($staff_type == 'accompanying') {
                $staff_id = Contract::where('card_id', $card_id)->pluck('accompanying_id')->toArray();
            }

            $staff = User::whereIn('id', $staff_id)->get();

            if (isset($staff) && count($staff)) {
                foreach ($staff as $key => $value) {
                    $result[$key] = $this->get_staff_id_and_title($value->id);
                }
            }
        }

        return $result;
    }

    public function get_representative_by_card($card_id)
    {
        $result = [];

        if ($card = Card::find($card_id)) {
            $dev_representative = Client::where('id', $card->dev_representative_id)->get();
            foreach ($dev_representative as $key => $value) {
                $result[$key]['id'] = $value->id;
                $result[$key]['title'] = $this->convert->get_full_name_n($value);
            }
        }

        return $result;
    }

    public function get_immovables_by_card($card_id)
    {
        $result  = [];

        if ($card = Card::find($card_id)) {
            $contracts = Contract::where('card_id', $card_id)->get();
            foreach ($contracts as $key => $contract) {
                $result[$key]['id'] = $contract->id;
                $result[$key]['title'] = $this->convert->immovable_building_address($contract->immovable);
            }
        }

        return $result;
    }

    public function get_clients_by_card($card_id)
    {
        $result  = [];

        if ($card = Card::find($card_id)) {
            $contract = Contract::where('card_id', $card_id)->first();
            $clients = $contract->clients;
            foreach ($clients as $key => $value) {
                $result[$key]['id'] = $value->id;
                $result[$key]['title'] = $this->convert->get_full_name_n($value);
            }
        }

        return $result;
    }

    public function get_rooms()
    {
        $rooms = Room::select('rooms.id', 'rooms.title', 'room_types.alias')->where(['rooms.active' => true, 'rooms.location' => 'rakul'])->leftJoin('room_types', 'room_types.id', '=', 'rooms.type_id')->orderBy('rooms.sort_order')->get();

        return $rooms;
    }

    public function get_deal_time($deal)
    {
        $result = [];
        $current_time = new \DateTime;

        $card = Card::find($deal->card_id);
        $date_time = $card->date_time;
        $result[0]['title'] = $this->convert->mb_ucfirst(Text::where('alias', 'start_time')->value('value'));
        $result[0]['value'] = $date_time ? $date_time->format('H:i') : null;

        $arrival_time = $deal->arrival_time;
        $result[1]['title'] = $this->convert->mb_ucfirst(Text::where('alias', 'arrival_time')->value('value'));
        $result[1]['value'] = $arrival_time ? $arrival_time->format('H:i') : null;

        $waiting_time = $deal->waiting_time;
        $result[2]['title'] = $this->convert->mb_ucfirst(Text::where('alias', 'waiting_time')->value('value'));
        $result[2]['value'] = $waiting_time ? $waiting_time->format('H:i') : null;

        $start = $arrival_time ? $arrival_time->format('H:i') : null;
        $end = $current_time ? $current_time->format('H:i') : null;
        $result[3]['title'] = $this->convert->mb_ucfirst(Text::where('alias', 'total_time')->value('value'));
        $result[3]['value'] = $end && $start ? (strtotime($end) - strtotime($start)) / 60 : null;

        return $result;
    }

    public function get_deal_info($card)
    {
        $result = [];

        $number_of_people = Deal::where('card_id', $card->id)->value('number_of_people');
        $result[0]['title'] = $this->convert->mb_ucfirst(Text::where('alias', 'number_of_people')->value('value'));
        $result[0]['value'] = $number_of_people;

        $children = Deal::where('card_id', $card->id)->value('children');
        $result[1]['title'] = $this->convert->mb_ucfirst(Text::where('alias', 'children')->value('value'));
        $result[1]['value'] = $children;

        return $result;
    }

    public function get_deal_step_list($deal)
    {
        $result = [];

        $card = Card::find($deal->card_id);

        $contracts = $card->has_contracts;
        foreach ($contracts as $c_key => $contract) {
            $result[$c_key]['contract_id'] = $contract->id;
            $steps = ServiceSteps::select('id', 'title')->where(['notary_service_id' => $contract->notary_service_id, 'active' => true])->orderBy('sort')->get()->toArray();
            foreach ($steps as $s_key => $step) {
                $pass_time = DealServiceStep::where('deal_id', $deal->id)->where('service_step_id', $step['id'])->value('pass');
                $steps[$s_key]['value'] = $pass_time ? $pass_time->format('H:i') : null;
            }

            $result[$c_key]['steps'] = $steps;
        }

        return $result;
    }
}
