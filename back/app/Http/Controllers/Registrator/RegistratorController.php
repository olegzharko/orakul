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
use App\Models\ImmFence;
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

    public function get_developers()
    {
        $result = [];

        $now = new \DateTime();

        $dev_companies = Contract::select(
                'dev_companies.id',
                'dev_companies.title',
                'dev_companies.color',
                'clients.surname_n',
                'clients.name_n',
                'clients.patronymic_n',
                'clients.tax_code',
                'dev_fences.date',
                'dev_fences.number',
                'dev_fences.pass',
            )->where('ready', true)->whereDate('sign_date', '>=', $now->format('Y-m-d'))
            ->join('immovables', 'immovables.id', '=', 'contracts.immovable_id')
            ->join('developer_buildings', 'developer_buildings.id', '=', 'immovables.developer_building_id')
            ->join('dev_companies', 'dev_companies.id', '=', 'developer_buildings.dev_company_id')
            ->join('clients', 'clients.dev_company_id', '=', 'dev_companies.id')
            ->join('dev_fences', 'dev_fences.dev_company_id', '=', 'dev_companies.id')->distinct()->get()->unique('dev_companies.id');

        $res_dev = [];
        $dev_length = count($dev_companies);

        foreach ($dev_companies as $key => $owner) {
            $res_dev[$key]['id'] = $owner->id;
            $res_dev[$key]['title'] = $owner->title;
            $res_dev[$key]['color'] = $owner->color;
            $res_dev[$key]['full_name'] = $this->convert->get_full_name($owner);
            $res_dev[$key]['tax_code'] = $owner->tax_code;
            $res_dev[$key]['date'] = $owner->date;
            $res_dev[$key]['number'] = $owner->number;
            $res_dev[$key]['pass'] = $owner->pass === null ? 2 : $owner->pass;
            $res_dev[$key]['prew'] = null;
            $res_dev[$key]['next'] = null;
            if ($key > 0) {
                $res_dev[$key]['prew'] = $dev_companies[$key - 1]->id;
            }

            if ($dev_length > $key + 1) {
                $res_dev[$key]['next'] = $dev_companies[$key + 1]->id;
            }
        }

        $result['date_info'] = $this->date->format('d.m.Y');
        $result['developers'] = $res_dev;

        return $this->sendResponse($result, 'Забудовники на перевірку реєстратором');
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

    public function get_immovables()
    {
        $result = [];

        $now = new \DateTime();

        $immovables = Contract::select(
                'developer_buildings.id as building_id',
                'immovable_types.short as immovable_type',
                'immovables.id',
                'immovables.immovable_number',
                'immovables.registration_number as immovable_code',
                'imm_fences.date',
                'imm_fences.number',
                'imm_fences.pass',
            )->where('ready', true)->whereDate('sign_date', '>=', $now->format('Y-m-d'))
            ->join('immovables', 'immovables.id', '=', 'contracts.immovable_id')
            ->join('immovable_types', 'immovable_types.id', '=', 'immovables.immovable_type_id')
            ->join('developer_buildings', 'developer_buildings.id', '=', 'immovables.developer_building_id')
            ->join('imm_fences', 'imm_fences.immovable_id', '=', 'immovables.id')->get();

        $imm_res = [];
        $imm_length = count($immovables);
        foreach ($immovables as $key => $imm) {
            $imm_res[$key]['id'] = $imm->id;
            $imm_res[$key]['title'] = $this->convert->get_full_address(DeveloperBuilding::find($imm->building_id)) . ' ' . $imm->immovable_type . ' ' . $imm->immovable_number;
            $imm_res[$key]['immovable_code'] = $imm->immovable_code;
            $imm_res[$key]['date'] = $imm->date;
            $imm_res[$key]['number'] = $imm->number;
            $imm_res[$key]['pass'] = $imm->pass === null ? 2 : $imm->pass;
            $res_dev[$key]['prew'] = null;
            $res_dev[$key]['next'] = null;
            if ($key > 0) {
                $imm_res[$key]['prew'] = $immovables[$key - 1]->id;
            }

            if ($imm_length > $key + 1) {
                $imm_res[$key]['next'] = $immovables[$key + 1]->id;
            }
        }

        $result['date_info'] = $this->date->format('d.m.Y');
        $result['immovables'] = $imm_res;

        return $this->sendResponse($result, 'Нерухомість для перевірки реєстратором');
    }

    public function update_immovable($immovable_id, Request $r)
    {
        if (!$immovable = Immovable::find($immovable_id)) {
            return $this->sendError('', "Нерухомість по ID: $immovable_id не знайдений");
        }

        $validator = $this->validate_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        ImmFence::where('immovable_id', $immovable_id)->update([
            'date' => $r['date'],
            'number' => $r['number'],
            'pass' => $r['pass'],
        ]);

        return $this->sendResponse('', 'Перевірку на заборону для нерухомості з ID:' . $immovable_id . ' оновлено');
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

        return $validator;
    }
}
