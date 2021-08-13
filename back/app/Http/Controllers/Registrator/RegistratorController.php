<?php

namespace App\Http\Controllers\Registrator;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;
use App\Http\Controllers\Factory\GeneratorController;
use App\Models\ClientType;
use App\Models\DeveloperBuilding;
use App\Models\DevEmployerType;
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
        $res_dev = [];

        $check_dev_company = Contract::select(
               'dev_companies.id',
            )->where('contracts.ready', true)->whereDate('sign_date', '=', $this->date->format('Y-m-d'))
            ->join('immovables', 'immovables.id', '=', 'contracts.immovable_id')
            ->join('developer_buildings', 'developer_buildings.id', '=', 'immovables.developer_building_id')
            ->join('dev_companies', 'dev_companies.id', '=', 'developer_buildings.dev_company_id')
//            ->join('dev_fences', 'dev_fences.dev_company_id', '=', 'dev_companies.id')
            ->distinct('dev_companies.id')->pluck('dev_companies.id')
        ;

        if ($check_dev_company) {

            $dev_companies = DevCompany::whereIn('dev_companies.id', $check_dev_company)->get();

            $dev_length = count($dev_companies);

            foreach ($dev_companies as $key => $company) {

                $owner = Client::select(
                        'clients.*'
                    )
                    ->where('dev_employer_types.alias', 'developer')
                    ->where('dev_company_employers.dev_company_id', $company->id)
                    ->join('dev_company_employers', 'dev_company_employers.employer_id', '=', 'clients.id')
                    ->join('dev_employer_types', 'dev_employer_types.id', '=', 'dev_company_employers.type_id')
                    ->first();

                if (!$owner)
                    continue;

                $dev_fence = DevFence::where('dev_company_id', $company->id)->firstOrCreate();
                $color = $this->get_status_color($dev_fence->pass);

                $res_dev[$key]['id'] = $company->id;
                $res_dev[$key]['title'] = $company->title;
                $res_dev[$key]['color'] = $color;
                $res_dev[$key]['full_name'] = $this->convert->get_full_name($owner);
                $res_dev[$key]['tax_code'] = $owner ? $owner->tax_code : null;
//                $res_dev[$key]['date'] = $dev_fence->date ? $dev_fence->date->format('d.m.Y H:i') : '';
                $res_dev[$key]['date'] = $this->date->format('d.m.Y');
                $res_dev[$key]['number'] = $dev_fence->number ?? '';
                $res_dev[$key]['pass'] = $dev_fence->pass ? true : false;
                $res_dev[$key]['prev'] = null;
                $res_dev[$key]['next'] = null;

                if ($key > 0) {
                    $res_dev[$key]['prev'] = $dev_companies[$key - 1]->id;
                }

                if ($dev_length > $key + 1) {
                    $res_dev[$key]['next'] = $dev_companies[$key + 1]->id;
                }
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

        DevFence::updateOrCreate(
            ['dev_company_id' => $developer_id],
            [
                'date' => $r['date'],
                'number' => $r['number'],
                'pass' => $r['pass'],
            ]);

        return $this->sendResponse('', 'Перевірку на заборону для забудовника з ID:' . $developer_id . ' оновлено');
    }

    public function get_immovables()
    {
        $result = [];
        $imm_res = [];

        $immovables = Contract::select(
                'developer_buildings.id as building_id',
                'immovable_types.short as immovable_type',
                'immovables.id',
                'immovables.immovable_number',
                'immovables.registration_number as immovable_code',
//                'imm_fences.date',
//                'imm_fences.number',
//                'imm_fences.pass',
            )->where('ready', true)->where('type_id', 1)->whereDate('sign_date', '=', $this->date->format('Y-m-d'))
            ->join('immovables', 'immovables.id', '=', 'contracts.immovable_id')
            ->join('immovable_types', 'immovable_types.id', '=', 'immovables.immovable_type_id')
            ->join('developer_buildings', 'developer_buildings.id', '=', 'immovables.developer_building_id')
//            ->join('imm_fences', 'imm_fences.immovable_id', '=', 'immovables.id')
            ->get()
            ;

        $imm_length = count($immovables);
        foreach ($immovables as $key => $imm) {

            $imm_fence = ImmFence::where('immovable_id', $imm->id)->firstOrCreate();

            $color = $this->get_status_color($imm_fence->pass);

            $imm_res[$key]['id'] = $imm->id;
            $imm_res[$key]['title'] = $this->convert->building_address_type_title_number(DeveloperBuilding::find($imm->building_id)) . ' ' . $imm->immovable_type . ' ' . $imm->immovable_number;
            $imm_res[$key]['immovable_code'] = $imm->immovable_code;
//            $imm_res[$key]['date'] = $imm_fence->date ? $imm_fence->date->format('d.m.Y H:i') : '';
            $imm_res[$key]['date'] = $this->date->format('d.m.Y');
            $imm_res[$key]['number'] = $imm_fence->number ?? '';
            $imm_res[$key]['color'] = $color;
            $imm_res[$key]['pass'] = $imm_fence->pass ? true : false;
            $res_dev[$key]['prev'] = null;
            $res_dev[$key]['next'] = null;

            if ($key > 0) {
                $imm_res[$key]['prev'] = $immovables[$key - 1]->id;
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

        ImmFence::updateOrCreate(
            ['immovable_id' => $immovable_id],
            [
                'date' => $r['date'],
                'number' => $r['number'],
                'pass' => $r['pass'],
            ]);

        return $this->sendResponse('', 'Перевірку на заборону для нерухомості з ID:' . $immovable_id . ' оновлено');
    }

    private function validate_data($r)
    {
        if (isset($r['date']) && !empty($r['date']))
            $r['date'] = \DateTime::createFromFormat('d.m.Y H:i', $r['date']);

        $validator = Validator::make([
            'date' => $r['date'] ? $r['date']->format('Y.m.d.') : null,
            'number' => $r['number'],
            'pass' => $r['pass'],
        ], [
            'date' => ['date_format:Y.m.d.', 'nullable'],
            'number' => ['numeric', 'nullable'],
            'pass' => ['boolean', 'nullable'],
        ], [
            'date.date_format' => 'Необхідно передати дату у форматі d.m.Y',
            'number.numeric' => 'Необхідно передати номер в числовому форматі',
            'pass.boolean' => 'Необхідно передати валідацію в числовому форматі',
        ]);

        return $validator;
    }

    private function get_status_color($pass)
    {
        if ($pass === null) {
            $color = "#000000";
        } elseif ($pass == false) {
            $color = "#ff4d4d";
        } elseif ($pass == true) {
            $color = "#009933";
        }

        return $color;
    }
}
