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
use App\Models\Notary;
use App\Models\SortType;
use App\Models\Staff;
use DB;

class FilterController extends BaseController
{
    public $tools;
    public $convert;
    public $card;

    public function __construct()
    {
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
        $printer = $this->tools->get_printer_staff();
        $contract_type = ContractType::get_active_contract_type();
        $developer = $this->tools->get_developer();
        $sort_type = SortType::get_all_sort_type();

        $result = [
            'notary' => $notary,
            'reader' => $reader,
            'accompanying' => $accompanying,
            'printer' => $printer,
            'contract_type' => $contract_type,
            'developer' => $developer,
            'sort_type' => $sort_type,
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

        if (!$developer = DevCompany::find($id))
            return $this->sendError("Забудовника з ID: $id не було знайдено!");

        if ($developer) {
            $representative_type_id = ClientType::get_representative_type_id();
            $manager_type_id = ClientType::get_manager_type_id();

            $representative = $this->tools->developer_employer_by_type($developer->id, $representative_type_id);
            $manager = $this->tools->developer_employer_by_type($developer->id, $manager_type_id);
            $building = $this->tools->developer_building($developer->id);
        }

        $result = [
          'representative' => $representative,
          'manager' => $manager,
          'building' => $building,
        ];

        return $this->sendResponse($result, 'Додаткова інформація по забудовнику ID: ' . $id);
    }
}
