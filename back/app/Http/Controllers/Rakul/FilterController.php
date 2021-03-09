<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Factory\ConvertController;
use App\Models\Client;
use App\Models\ClientType;
use App\Models\ContractType;
use App\Models\DeveloperBuilding;
use App\Models\DevCompany;
use App\Models\Notary;
use App\Models\Staff;
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

        if (!$developer = DevCompany::find($id))
            return $this->sendError("Забудовника з ID: $id не було знайдено!");

        if ($developer) {
            $cl_type_representative_id = ClientType::where('key', 'representative')->value('id');
            $cl_type_manager_id = ClientType::where('key', 'manager')->value('id');

            $dev_representative = Client::select('id', 'surname_n', 'name_n', 'patronymic_n')
                ->where('type', $cl_type_representative_id)
                ->where('dev_company_id', $developer->id)
                ->get();
            foreach ($dev_representative as $key => $representative) {
                $result_representative[$key]['id'] = $representative->id;
                $result_representative[$key]['title'] = $this->convert->get_full_name($representative);
            }

            $dev_manager = Client::select('id', 'surname_n', 'name_n', 'patronymic_n')
                ->where('type', $cl_type_manager_id)
                ->where('dev_company_id', $developer->id)
                ->get();
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
}
