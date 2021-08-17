<?php

namespace App\Http\Controllers\Generator;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;
use App\Models\BuildingRepresentativeProxy;
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
use App\Models\Proxy;
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

        dd($card, 1);
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

        $dev_representatives_id = [];
        foreach ($dev_representatives as $key => $representative) {
            $dev_representatives_id[] = $representative->id;
            $result['dev_representative'][$key]['id'] = $representative->id;
            $result['dev_representative'][$key]['title'] = $this->convert->get_full_name($representative);
        }

        if ($card->dev_representative && !in_array($card->dev_representative->id, $dev_representatives_id)) {
            Card::where('id', $card_id)->update(['dev_representative_id' => null]);
            $card = Card::find($card_id);
        }

        $representative = $card->dev_representative;

        $result['representative_id'] = $representative ? $representative->id : null;

        $result['representative_info'] = [];
        if ($representative) {
//            $result['representative_info'][] = ['title' => 'Телефон', 'value' => $representative->phone ?? '-'];
            $result['representative_info'][] = ['title' => 'Дата народження', 'value' => $representative->birth_date ? $representative->birth_date->format('d.m.Y') : '-'];
            $result['representative_info'][] = ['title' => 'ІПН', 'value' => $representative->tax_code ?? '-'];
            $result['representative_info'][] = ['title' => 'Тип паспорту', 'value' => $representative->passport_type ? $representative->passport_type->title : '-'];
            $result['representative_info'][] = ['title' => 'Серія/Номер паспорту', 'value' => $representative->passport_code ?? '-'];
            $result['representative_info'][] = ['title' => 'Виданий', 'value' => $representative->passport_date ? $representative->passport_date->format('d.m.Y') : '-'];
            $result['representative_info'][] = ['title' => 'Дійсний до:', 'value' => $representative->passport_finale_date ? $representative->passport_finale_date->format('d.m.Y') : '-'];


            $developer_buildings_id = Card::select('developer_buildings.*')->where('cards.id', $card_id)
            ->leftJoin('contracts', 'contracts.card_id', '=', 'cards.id')
            ->leftJoin('immovables', 'contracts.immovable_id', '=', 'immovables.id')
            ->leftJoin('developer_buildings', 'developer_buildings.id', '=', 'immovables.developer_building_id')
            ->pluck('developer_buildings.id');

            $proxies_id = BuildingRepresentativeProxy::select('proxies.*')
            ->whereIn('building_id', $developer_buildings_id)
            ->where('dev_representative_id', $representative->id)
            ->leftJoin('proxies', 'proxies.id', '=', 'building_representative_proxies.proxy_id')
            ->pluck('proxies.id');

            $proxies = Proxy::whereIn('id', $proxies_id)->get();

            $result['representative_doc'] = [];
            foreach ($proxies as $value) {
                $result['representative_doc'][] = ['title' => 'Номер довіреності', 'value' => $value->reg_num];
                $result['representative_doc'][] = ['title' => 'Дата посвідчення', 'value' => $value->reg_date ? $value->reg_date->format('d.m.Y') : '-'];
                $result['representative_doc'][] = ['title' => 'Дат закінчення', 'value' => $value->final_date ? $value->final_date->format('d.m.Y') : '-'];
            }

            if (!count($result['representative_doc']))
                $result['representative_doc'][] = ['title' => 'ВІДСУТНЯ ДОВІРЕНІСТЬ', 'value' => ''];
        }

        return $this->sendResponse($result, 'Продавці відносно будинку та підписанти.');
    }

    public function main($dev_company_id, $card_id)
    {
        $result = [];

        $dev_company = DevCompany::find($dev_company_id);

        $result['dev_company']['title'] = $dev_company->title;
        $result['dev_company']['color'] = $dev_company->color;
        $result['dev_company']['info'] = [];
        $result['ceo_spouse_info'] = [];

        $owner = DevCompanyEmployer::where('dev_company_id', $dev_company_id)->where('type_id', 1)->first();
        if ($owner) {
            $owner = $owner->employer;

            // компанія
            $result['dev_company']['info'][] = ['title' => 'ПІБ', 'value' => $this->convert->get_full_name_n($owner)];
            $result['dev_company']['info'][] = ['title' => 'Телефон', 'value' => $owner->phone ?? '-'];
            $result['dev_company']['info'][] = ['title' => 'Дата народження', 'value' => $owner->birth_date ? $owner->birth_date->format('d.m.Y') : '-'];
            $result['dev_company']['info'][] = ['title' => 'ІПН', 'value' => $owner->tax_code ?? '-'];
            $result['dev_company']['info'][] = ['title' => 'Тип паспорту', 'value' => $owner->passport_type ? $owner->passport_type->title : '-'];
            $result['dev_company']['info'][] = ['title' => 'Серія/Номер паспорту', 'value' => $owner->passport_code ?? '-'];
            $result['dev_company']['info'][] = ['title' => 'Виданий', 'value' => $owner->passport_date ? $owner->passport_date->format('d.m.Y') : '-'];
            $result['dev_company']['info'][] = ['title' => 'Дійсний до:', 'value' => $owner->passport_finale_date ? $owner->passport_finale_date->format('d.m.Y') : '-'];
        } else {
            $result['dev_company']['info'][] = ['title' => 'Фонд', 'value' => ''];
        }

        // подружжя забудовника

        if ($owner && $owner->married && $owner->married->spouse) {
            $spouse = $owner->married->spouse;
            $result['ceo_spouse_info'][] = ['title' => 'ПІБ', 'value' => $this->convert->get_full_name_n($spouse)];
            $result['ceo_spouse_info'][] = ['title' => 'Телефон', 'value' => $spouse->phone ?? '-'];
            $result['ceo_spouse_info'][] = ['title' => 'Дата народження', 'value' => $spouse->birth_date ? $spouse->birth_date->format('d.m.Y') : '-'];
            $result['ceo_spouse_info'][] = ['title' => 'ІПН', 'value' => $spouse->tax_code ?? '-'];
            $result['ceo_spouse_info'][] = ['title' => 'Тип паспорту', 'value' => $spouse->passport_type ? $spouse->passport_type->title : '-'];
            $result['ceo_spouse_info'][] = ['title' => 'Серія/Номер паспорту', 'value' => $spouse->passport_code ?? '-'];
            $result['ceo_spouse_info'][] = ['title' => 'Виданий', 'value' => $spouse->passport_date ? $spouse->passport_date->format('d.m.Y') : '-'];
            $result['ceo_spouse_info'][] = ['title' => 'Дійсний до:', 'value' => $spouse->passport_finale_date ? $spouse->passport_finale_date->format('d.m.Y') : '-'];
        } else {
            $result['ceo_spouse_info'][] = ['title' => 'Фонд', 'value' => ''];
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


    // Видали функцію після видалення запиту
    public function get_representative($client_id)
    {
        return [];
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
