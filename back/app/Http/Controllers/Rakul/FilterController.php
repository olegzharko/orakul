<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Factory\ConvertController;
use App\Models\Client;
use App\Models\ClientType;
use App\Models\DeveloperBuilding;
use App\Models\DevCompany;
use Illuminate\Http\Request;

class FilterController extends BaseController
{
    public $convert;

    public function __construct()
    {
        $this->convert = new ConvertController();
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

        return $this->sendResponse($result, 'кімнати');
    }
}
