<?php

namespace App\Http\Controllers\Generator;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;
use App\Models\ClientType;
use App\Models\DevCompany;
use App\Models\DevCompanyEmployer;
use App\Models\DevEmployerType;
use App\Models\DevFence;
use App\Models\PassportTemplate;
use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Client;
use App\Models\Text;
use Validator;

class DeveloperController extends BaseController
{
    public $convert;
    public $tools;
    public $developer_type;
    public $representative_type;

    public function __construct()
    {
        $this->convert = new ConvertController();
        $this->tools = new ToolsController();
        $this->developer_type = DevEmployerType::where('alias', 'developer')->value('id');
        $this->representative_type = DevEmployerType::where('alias', 'representative')->value('id');
    }

    public function group($card_id)
    {
        $result = [];

        $card = Card::find($card_id);

        $dev_company_query = DevCompany::select(
                'dev_companies.*'
            )
            ->where('contracts.card_id', $card_id)
            ->where('contracts.deleted_at', null)
            ->join('developer_buildings', 'developer_buildings.dev_company_id', 'dev_companies.id')
            ->join('immovables', 'immovables.developer_building_id', 'developer_buildings.id')
            ->join('contracts', 'contracts.immovable_id', 'immovables.id')
            ->distinct('dev_companies.id');


        $dev_companies_id = $dev_company_query->pluck('dev_companies.id')->toArray();
        $dev_company = $dev_company_query->get();

        foreach ($dev_company as $key => $company) {
            $result['dev_companies'][$key]['id'] = $company->id;
            $result['dev_companies'][$key]['title'] = $company->title;
            $result['dev_companies'][$key]['color'] = $company->color;
            $result['dev_companies'][$key]['info'][] = "Група: " . $card->dev_group->title;
        }

        $dev_representatives = Client::select(
                'clients.id',
                'clients.surname_n',
                'clients.name_n',
                'clients.patronymic_n'
            )
            ->whereIn('dev_company_employers.dev_company_id', $dev_companies_id)
            ->where('dev_company_employers.type_id', $this->representative_type)
            ->join('dev_company_employers', 'dev_company_employers.employer_id', '=', 'clients.id')
            ->join('dev_companies', 'dev_companies.id', '=', 'dev_company_employers.dev_company_id')
            ->get();

        foreach ($dev_representatives as $key => $representative) {
            $result['dev_representative'][$key]['id'] = $representative->id;
            $result['dev_representative'][$key]['title'] = $this->convert->get_full_name($representative);
        }

        $representative = $card->dev_representative;

        $result['representative_id'] = $representative ? $representative->id : null;

        $result['representative_info'] = [];
        $result['representative_doc'] = [];
        if ($representative) {
            $result['representative_info'][] = ['title' => 'Дата народження', 'value' => $representative->birth_date ? $representative->birth_date->format('d.m.Y') : null];
            $result['representative_info'][] = ['title' => 'ІПН', 'value' => $representative->code];
            $result['representative_info'][] = ['title' => 'Паспорт Серія-номер', 'value' => $representative->passport_date];


            $result['representative_doc'][] = ['title' => 'Дані 1', 'value' => 'Текст 1'];
        }

        return $this->sendResponse($result, 'Продавці відносно будинку та підписанти.');
    }

    public function main($dev_company_id, $card_id)
    {
        $result = [];

        $dev_company = DevCompany::find($dev_company_id);

        $result['dev_company']['title'] = $dev_company->title;
        $result['dev_company']['color'] = $dev_company->color;

        // компанія
        $result['dev_company']['info'][] = ['title' => 'Група: ', 'value' => $dev_company->dev_group->title];

        // owner влоасник забудовник
        $result['ceo_info'][] = ['title' => 'CEO 1', 'value' => 'DATA 1'];

        // подружжя забудовника
        $result['ceo_spouse_info'][] = ['title' => '', 'value' => ''];

        $result['dev_fence']['date'] = null;
        $result['dev_fence']['number'] = null;
        $result['dev_fence']['pass'] = null;

        if ($fence = DevFence::where('dev_company_id', $dev_company_id)->where('card_id', $card_id)->orderBy('date', 'desc')->first() ) {
            $result['dev_fence']['date'] = $fence->date ? $fence->date->format('d.m.Y. H:i') : null;
            $result['dev_fence']['number'] = $fence->number;
            $result['dev_fence']['pass'] = $fence->pass;
        }

        return $this->sendResponse($result, 'Загальні дані по забудовнику.');
    }

    public function update_fence($dev_company_id, $card_id, Request $r)
    {
        $result = [];

        $r['date'] = \DateTime::createFromFormat('d.m.Y H:i', $r['date']);

        $validator = Validator::make([
            'date' => $r['date'],
            'number' => $r['number'],
        ], [
            'date' => ['required'],
            'number' => ['required', 'numeric'],
        ], [
            'date.required' => 'Необхідно передати дату перевірки',
            'number.required' => 'Необхідно передати номер перевірки',
            'number.numeric' => 'Необхідно передати номер перевірки у числовому форматі',
        ]);

        if (!$card = Card::find($card_id)){
            return $this->sendError( '', "Карта $card_id відсутня");
        }

        if (!$dev_company = DevCompany::where('id', $dev_company_id)->where('dev_group_id', $card->dev_group_id)->first()) {
            return $this->sendError( '', "Забудовник $dev_company_id відсутній");
        }

        if (count($validator->errors()->getMessages())) {
            return $this->sendError($validator->errors(), "Карта $card_id має наступні помилки");
        }

        DevFence::where(['dev_company_id' => $dev_company_id, 'card_id' => $card_id])->update([
            'date' => $r['date'],
            'number' => $r['number'],
            'pass' => $r['pass'],
        ]);

        return $this->sendResponse('', 'Дані по забороні на продавця оновлені');
    }

    public function get_representative($card_id)
    {
        $result = [];

        $result['representative_info'][] = ['title' => 'Cтатус: ', 'value' => 'актуальна'];
        $result['representative_doc'][] = ['title' => 'Cтатус: ', 'value' => 'актуальна'];

        return $this->sendResponse($result, "Загальні дані по представнику забудовника.");
    }

    public function update_representative($card_id, Request $r)
    {
        $validator = Validator::make([
            'dev_representative_id' => $r['dev_representative_id'],
        ], [
            'dev_representative_id' => ['required', 'numeric'],
        ], [
            'dev_representative_id.required' => 'Необхідно передати ID представника через dev_representative_id',
            'dev_representative_id.numeric' => 'Необхідно передати ID представника у числовому форматі',
        ]);

        $errors = $validator->errors()->messages();

        $card = Card::find($card_id);

        $dev_representative = $this->tools->dev_group_employer_by_type($card->dev_group_id, $this->representative_type);

        if ($dev_representative) {
            Card::where('id', $card_id)->update([
               'dev_representative_id' => $r['dev_representative_id']
            ]);

            return $this->sendResponse('', "Дані були успішно оновлені");
        } else {
            return $this->sendError('', "Представник відсутній");
        }

    }

    private function collect_passport_info($client)
    {
        $result = [];

        $result['passport_type'] = PassportTemplate::where('id', $client->passport_type_id)->value('title');
        $result['passport_code'] = $client->passport_code;
        $result['passport_date'] = $client->passport_date ? $client->passport_date->format('d.m.Y') : null;
        $result['passport_department'] = $client->passport_department;
        $result['passport_demographic_code'] = $client->passport_demographic_code;
        $result['address'] = $client->address;

        return $result;
    }
}
