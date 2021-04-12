<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factory\ConvertController;
use App\Models\DevCompanyEmployer;
use App\Models\DevGroup;
use App\Models\Room;
use App\Models\User;
use App\Models\WorkDay;
use App\Models\Client;
use App\Models\Notary;
use App\Models\DevCompany;
use App\Models\DeveloperBuilding;
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

        $result['day'] = $week[$card->date_time->format('w') + 1];
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
            $result_building[$key]['title'] = $this->convert->get_full_address($building);
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
            ->orderBy('developer_buildings.title')
            ->distinct('developer_buildings.id')
            ->pluck('developer_buildings.id');

        $dev_building = DeveloperBuilding::get_dev_group_buildings($buildings_id);

        foreach ($dev_building as $key => $building) {
            $result_building[$key]['id'] = $building->id;
            $result_building[$key]['title'] = $this->convert->get_full_address($building);
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
        $reader = User::where('reader', true)->get();

        return $this->convertor_full_name($reader, 'full_name');
    }

    public function get_accompanying_staff()
    {
        $accompanying = User::where('accompanying', true)->get();

        return $this->convertor_full_name($accompanying, 'full_name');
    }

    public function get_generator_staff()
    {
        $accompanying = User::where('generator', true)->get();

        return $this->convertor_full_name($accompanying, 'full_name');
    }

    public function get_developer()
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
                $convert_data[$key]['title'] = $this->convert->get_surname_and_initials($value);
            elseif($name_type == 'title')
                $convert_data[$key]['title'] = $value->title;
        }

        return $convert_data;
    }

    public function get_id_and_full_name($client)
    {
        $resutl = [];

        $resutl['id'] = null;
        $resutl['full_name'] = null;

        if ($client) {
            $resutl['id'] = $client->id;
            $resutl['full_name'] = $this->convert->get_full_name($client);
        }

        return $resutl;
    }
}
