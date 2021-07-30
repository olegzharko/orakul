<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Factory\ConvertController;
use App\Models\ContractType;
use App\Models\DevCompany;
use App\Models\DevGroup;
use App\Models\Room;
use App\Models\Time;
use App\Models\Notary;
use App\Models\WorkDay;
use App\Models\ImmovableType;
use Illuminate\Http\Request;

class ReceptionController extends BaseController
{
    public $convert;

    public function __construct()
    {
        $this->convert = new ConvertController();
    }
    public function reception()
    {
        $rooms = Room::select('id', 'title', 'sort_order', 'color')->where('active', true)->get();
        
        $time = Time::select('time', 'sort_order')->where('active', true)->get();
        $work_days_and_date = $this->get_day_and_date();
        $form_date = $this->form_data();
        
        

        $result = [
            'rooms' => $rooms,
            'work_time' => $time,
            'day_and_date' => $work_days_and_date,
            'form_data' => $form_date,
        ];

        return $this->sendResponse($result, 'кімнати');
    }

    public function get_day_and_date()
    {
        $week = WorkDay::where('active', true)->orderBy('num')->pluck('short', 'num')->toArray();

        $d = 0;
        $date = new \DateTime();
        while ($d < 31) {
            $day_num = $date->format('w');
            if (isset($week[$day_num])) {
                $result[$d]['day'] = $week[$date->format('w')];
                $result[$d]['year'] = $date->format('Y');
                $result[$d]['date'] = $date->format('d.m');
                $d++;
            }
            $date = $date->modify('+1 day');
        }

        return $result;
    }

    public function form_data()
    {
        $result = null;
        $convert_developer = [];
        $convert_contract_type = [];
        $convert_immovable_type = [];
        $convert_notary = [];

        $convert_contract_type = ContractType::select('id', 'title')->where('active', true)->get()->toArray();

//        $convert_developer = DevCompany::select('id', 'title')->where('active', true)->get()->toArray();
        $convert_developer = DevGroup::select('id', 'title')->where('active', true)->get()->toArray();

        $convert_immovable_type = ImmovableType::select('id', 'short as title')->where('form', true)->get()->toArray();

        $notary = Notary::select('id', 'name_n', 'patronymic_n')->where('rakul_company', true)->get();
        foreach ($notary as $key => $value) {
            $convert_notary[$key]['id'] = $value->id;
            $convert_notary[$key]['title'] = $this->convert->get_short_name($value);
        }

        $result = [
            'contract_type' => $convert_contract_type,
            'developer' => $convert_developer,
            'immovable_type' => $convert_immovable_type,
            'notary' => $convert_notary,
        ];

        return $result;
    }
}
