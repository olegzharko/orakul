<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Factory\ConvertController;
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

        $result['day'] = $week[$card->date_time->format('w')];
        $result['date'] = $card->date_time->format('d.m');
        $result['time'] = $card->date_time->format('H:i');
        $result['room'] = $room;

        return $result;
    }

    public function developer_employer_by_type($dev_company_id, $employer_type)
    {
        $result = [];

        $dev_employers = Client::get_dev_employers_by_type($dev_company_id, $employer_type);

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
