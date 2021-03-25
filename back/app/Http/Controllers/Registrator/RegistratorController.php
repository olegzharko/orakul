<?php

namespace App\Http\Controllers\Registrator;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;
use App\Http\Controllers\Factory\GeneratorController;
use App\Models\ClientType;
use App\Models\DeveloperBuilding;
use App\Models\DevFence;
use Illuminate\Http\Request;
use App\Models\Immovable;
use App\Models\DevCompany;
use App\Models\Contract;
use App\Models\Client;
use Laravel\Nova\Fields\DateTime;
use Validator;

class RegistratorController extends BaseController
{
    public $tools;
    public $genrator;
    public $convert;
    public $date;

    public function __construct()
    {
        $this->tools = new ToolsController();
        $this->generator = new GeneratorController();
        $this->convert = new ConvertController();
        $this->date = new \DateTime();
    }

    public function developers()
    {
        $result = [];

        $dev_companies_query = $this->get_query_dev_company_fence();

        $dev_companies = $dev_companies_query->get();

        $result['date_info'] = $this->date->format('d.m.Y');
        $result['devolepr'] = $dev_companies;

        return $this->sendResponse($result, 'Забудовники на перевірку реєстратором');
    }

    public function get_developer($developer_id)
    {
        $result = [];

        if (!$developer = DevCompany::find($developer_id)) {
            return $this->sendError('', "Забудовник по ID: $developer_id не знайдений");
        }

        $dev_companies_query = $this->get_query_dev_company_fence();
        $dev_companies_id = $dev_companies_query->pluck('dev_companies.id')->toArray();

        $developer_type_id = ClientType::get_developer_type_id();
        $dev_company_owner = DevCompany::
            select(
                'dev_companies.title',
                'dev_companies.color',
                'clients.surname_n',
                'clients.name_n',
                'clients.patronymic_n',
                'clients.tax_code',
                'dev_fences.date',
                'dev_fences.number',
                'dev_fences.pass',
            )
            ->where('dev_companies.id', $developer_id)
            ->where('clients.type', $developer_type_id)
            ->join('clients', 'clients.dev_company_id', '=', 'dev_companies.id')
            ->join('dev_fences', 'dev_fences.dev_company_id', '=', 'dev_companies.id')
            ->first();

        $prew_next = $this->get_prew_next_id($dev_companies_id, $developer_id);

        $result['title'] = $dev_company_owner->title;
        $result['color'] = $dev_company_owner->color;
        $result['full_name'] = $this->convert->get_full_name($dev_company_owner);
        $result['tax_code'] = $dev_company_owner->tax_code;
        $result['date'] = $dev_company_owner->date;
        $result['number'] = $dev_company_owner->number;
        $result['pass'] = $dev_company_owner->pass;

        $result = array_merge($result, $prew_next);

        return $this->sendResponse($result, "Дані забудовник з ID:$developer_id");
    }

    public function update_developer($developer_id, Request $r)
    {
        if (!$developer = DevCompany::find($developer_id)) {
            return $this->sendError('', "Забудовник по ID: $developer_id не знайдений");
        }

        $validator = $this->validate_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        DevFence::where('dev_company_id', $developer_id)->update([
            'date' => $r['date'],
            'number' => $r['number'],
            'pass' => $r['pass'],
        ]);

        return $this->sendResponse('', 'Перевірку на заборону для забудовника з ID:' . $developer_id . ' оновлено');
    }

    public function immovables()
    {
        $result = [];

        $immovables_query = $this->get_query_immovables_fence();
        $immovables = $immovables_query->get();

        $imm_res = [];
        foreach ($immovables as $key => $imm) {
            $imm_res[$key]['id'] = $imm->id;
            $imm_res[$key]['title'] = $this->convert->get_full_address(DeveloperBuilding::find($imm->building_id)) . ' ' . $imm->immovable_type . ' ' . $imm->immovable_number;
            $imm_res[$key]['date'] = $imm->date;
            $imm_res[$key]['number'] = $imm->number;
            $imm_res[$key]['status'] = $imm->status;
        }

        $result['date_info'] = $this->date->format('d.m.Y');
        $result['immovables'] = $immovables;

        return $this->sendResponse($result, 'Забудовники на перевірку реєстратором');
    }

    public function get_immovable($immovable_id)
    {

    }

    public function update_immovable($immovable_id, Request $r)
    {

    }

    private function validate_data($r)
    {
        if (isset($r['date']) && !empty($r['date']))
            $r['date'] = \DateTime::createFromFormat('d.m.Y', $r['date']);

        $validator = Validator::make([
            'date' => $r['date'] ? $r['date']->format('Y.m.d.') : null,
            'number' => $r['number'],
            'pass' => $r['pass'],
        ], [
            'date' => ['date_format:Y.m.d.', 'nullable'],
            'number' => ['numeric', 'nullable'],
            'pass' => ['numeric', 'nullable'],
        ], [
            'date.date_format' => 'Необхідно передати дату у форматі d.m.Y',
            'number.numeric' => 'Необхідно передати номер в числовому форматі',
            'pass.numeric' => 'Необхідно передати валідацію в числовому форматі',
        ]);

//        $errors = $validator->errors()->messages();
//
//        if (!isset($errors['id']) && isset($r['id']) && !empty($r['id'])) {
//            if (!Client::find($r['id'])) {
//                $validator->getMessageBag()->add('id', 'Клієнта з ID:' . $r['id'] . " не знайдено");
//            }
//        }

        return $validator;
    }

    public function get_query_dev_company_fence()
    {
        $now = new \DateTime();

        $dev_companies = Contract::select(
                'dev_companies.id',
                'dev_companies.title',
                'dev_companies.color',
                'dev_fences.date',
                'dev_fences.number',
                'dev_fences.pass',
            )->where('ready', true)->whereDate('sign_date', '>=', $now->format('Y-m-d'))
            ->join('immovables', 'immovables.id', '=', 'contracts.immovable_id')
            ->join('developer_buildings', 'developer_buildings.id', '=', 'immovables.developer_building_id')
            ->join('dev_companies', 'dev_companies.id', '=', 'developer_buildings.dev_company_id')
            ->join('dev_fences', 'dev_fences.dev_company_id', '=', 'dev_companies.id');


        return $dev_companies;
    }

    public function get_prew_next_id($dev_companies_id, $developer_id)
    {
        $result = [];
        $result['prew'] = null;
        $result['next'] = null;

        if (in_array($developer_id, $dev_companies_id)) {
            $key = array_search($developer_id, $dev_companies_id);
            if ($key > 0) {
                $result['prew'] = $dev_companies_id[$key - 1];
            }
            if (array_key_last($dev_companies_id) > $key) {
                $result['next'] = $dev_companies_id[$key + 1];
            }
        }

        return $result;
    }

    public function get_query_immovables_fence()
    {
        $now = new \DateTime();

        $immovables = Contract::select(
                'developer_buildings.id as building_id',
                'immovable_types.short as immovable_type',
                'immovables.id',
                'immovables.immovable_number',
                'immovables.registration_number',
                'imm_fences.date',
                'imm_fences.number',
                'imm_fences.pass',
            )->where('ready', true)->whereDate('sign_date', '>=', $now->format('Y-m-d'))
            ->join('immovables', 'immovables.id', '=', 'contracts.immovable_id')
            ->join('immovable_types', 'immovable_types.id', '=', 'immovables.immovable_type_id')
            ->join('developer_buildings', 'developer_buildings.id', '=', 'immovables.developer_building_id')
            ->join('imm_fences', 'imm_fences.immovable_id', '=', 'immovables.id');

        return $immovables;
    }
}
