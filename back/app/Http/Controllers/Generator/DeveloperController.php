<?php

namespace App\Http\Controllers\Generator;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Factory\ConvertController;
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
    public $developer_type;
    public $representative_type;

    public function __construct()
    {
        $this->convert = new ConvertController();
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

        $result['representative_id'] = $representative->id;
        $result['representative_info'][] = ['title' => 'Тест 1', 'value' => 'Значення 1'];
        $result['representative_info'][] = ['title' => 'Тест 2', 'value' => 'Значення 2'];
        $result['representative_info'][] = ['title' => 'Тест 3', 'value' => 'Значення 3'];
        $result['representative_info'][] = ['title' => 'Тест 4', 'value' => 'Значення 4'];
        $result['representative_info'][] = ['title' => 'Тест 5', 'value' => 'Значення 5'];
        $result['representative_info'][] = ['title' => 'Тест 6', 'value' => 'Значення 6'];

        $result['representative_doc'][] = ['title' => 'Дані 1', 'value' => 'Текст 1'];
        $result['representative_doc'][] = ['title' => 'Дані 2', 'value' => 'Текст 2'];
        $result['representative_doc'][] = ['title' => 'Дані 3', 'value' => 'Текст 3'];
        $result['representative_doc'][] = ['title' => 'Дані 4', 'value' => 'Текст 4'];
        $result['representative_doc'][] = ['title' => 'Дані 5', 'value' => 'Текст 5'];
        $result['representative_doc'][] = ['title' => 'Дані 6', 'value' => 'Текст 6'];

        return $this->sendResponse($result, 'Продавці відносно будинку та підписанти.');
    }

    public function main($dev_company_id)
    {
        $result = [];

        $dev_company = DevCompany::find($dev_company_id);

        $result['dev_company']['title'] = $dev_company->title;
        $result['dev_company']['color'] = $dev_company->color;

//        $owner = DevCompanyEmployer::select('clients.*')
//            ->where('dev_company_id', $dev_company->id)
//            ->where('type_id', $this->developer_type)
//            ->join('clients', 'clients.id', '=', 'dev_company_employers.employer_id')
//            ->first();
//
//        $owner->name = $this->convert->get_full_name($owner);
//        $owner->address = $this->convert->get_client_full_address($owner);

        $result['ceo_info'][] = ['title' => 'CEO 1', 'value' => 'DATA 1'];
        $result['ceo_info'][] = ['title' => 'CEO 2', 'value' => 'DATA 2'];
        $result['ceo_info'][] = ['title' => 'CEO 3', 'value' => 'DATA 3'];
        $result['ceo_info'][] = ['title' => 'CEO 4', 'value' => 'DATA 4'];
        $result['ceo_info'][] = ['title' => 'CEO 5', 'value' => 'DATA 5'];
        $result['ceo_info'][] = ['title' => 'CEO 6', 'value' => 'DATA 6'];

        $result['ceo_spouse_info'][] = ['title' => 'SPOUSE 1', 'value' => 'INFO 1'];
        $result['ceo_spouse_info'][] = ['title' => 'SPOUSE 2', 'value' => 'INFO 2'];
        $result['ceo_spouse_info'][] = ['title' => 'SPOUSE 3', 'value' => 'INFO 3'];
        $result['ceo_spouse_info'][] = ['title' => 'SPOUSE 4', 'value' => 'INFO 4'];
        $result['ceo_spouse_info'][] = ['title' => 'SPOUSE 5', 'value' => 'INFO 5'];
        $result['ceo_spouse_info'][] = ['title' => 'SPOUSE 6', 'value' => 'INFO 6'];

//        $result['ceo_info']['name'] = $owner->name;
//        $result['ceo_info']['tax_code'] = $owner->code;
//        $result['ceo_info']['married'] = $owner->spouse_id ? Text::where('alias', 'yes')->value('value') : Text::where('alias', 'no')->value('value');
//        $owner->passport_date = \DateTime::createFromFormat('Y-m-d H:i:s', $owner->passport_date);
//        $result['ceo_info'] = array_merge($result['ceo_info'], $this->collect_passport_info($owner));
//        $result['ceo_info']['address'] = $owner->address;

        $result['dev_fence']['date'] = null;
        $result['dev_fence']['number'] = null;
        $result['dev_fence']['pass'] = null;

        if ($fence = DevFence::where('dev_company_id', $dev_company->owner->id)->orderBy('date', 'desc')->first() ) {
            $result['dev_fence']['date'] = $fence->date->format('d.m.Y. H:i');
            $result['dev_fence']['number'] = $fence->number;
            $result['dev_fence']['pass'] = $fence->pass;
        }


        return $this->sendResponse($result, 'Загальні дані по забудовнику.');
    }

//    public function get_fence($card_id)
//    {
//        $result = [];
//        $card = Card::find($card_id);
//
//        $result['date'] = null;
//        $result['number'] = null;
//        $result['pass'] = null;
//
//        $card->dev_company->owner = $card->dev_company->member->where('type_id', $this->developer_type)->first();
//        if ($fence = DevFence::where('dev_company_id', $card->dev_company->owner->id)->orderBy('date', 'desc')->first() ) {
//            $result['date'] = $fence->date->format('d.m.Y. H:i');
//            $result['number'] = $fence->number;
//            $result['pass'] = $fence->pass;
//        }
//
//        return $this->sendResponse($result, "Дані по забороні на продавця");
//    }

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

        DevFence::where('card_id', $card_id)->update([
            'date' => $r['date'] ? $r['date']->format('Y.m.d') : null,
            'number' => $r['number'],
            'pass' => $r['pass'],
        ]);

//        DevFence::updateOrCreate(
//            [
//                'card_id', $card_id
//            ],[
//                'dev_company_id' => $dev_company_id,
//                'date' => $r['date'] ? $r['date']->format('Y.m.d') : null,
//                'number' => $r['number'],
//                'pass' => $r['pass'],
//            ]);

        return $this->sendResponse('', 'Дані по забороні на продавця оновлені');
    }

//    public function spouse($card_id)
//    {
//        $card = Card::find($card_id);
//
//        $card->dev_company->owner = $card->dev_company->member->where('type_id', $this->developer_type)->first();
//
//        if ($card->dev_company->owner->spouse) {
//            return $this->sendResponse('', 'Дані про подружжя не підготовлені. Розділ знаходиться на уточненні');
//        } else {
//            return $this->sendResponse('', 'Дані про подружжя відсутні');
//        }
//    }

    public function get_representative($card_id)
    {
        $result = [];

//        $card = Card::find($card_id);
//        $result['dev_representative'] = $this->get_dev_company_representative($card);
//        $result['dev_representative_id'] = $card->dev_representative_id;
//
//        $representative = Client::find($card->dev_representative_id);
//
//        $result['representative']['name'] =  $this->convert->get_full_name($representative);
//        $result['representative']['tax_code'] = $representative->code;
//        $result['representative'] = array_merge($result['representative'], $this->collect_passport_info($representative));
//        $result['representative']['address'] = $this->convert->get_client_full_address($representative);

        $result['representative_info'][] = ['title' => 'Тест 1', 'value' => 'Значення 1'];
        $result['representative_info'][] = ['title' => 'Тест 2', 'value' => 'Значення 2'];
        $result['representative_info'][] = ['title' => 'Тест 3', 'value' => 'Значення 3'];
        $result['representative_info'][] = ['title' => 'Тест 4', 'value' => 'Значення 4'];
        $result['representative_info'][] = ['title' => 'Тест 5', 'value' => 'Значення 5'];
        $result['representative_info'][] = ['title' => 'Тест 6', 'value' => 'Значення 6'];

        $result['representative_doc'][] = ['title' => 'Дані 1', 'value' => 'Текст 1'];
        $result['representative_doc'][] = ['title' => 'Дані 2', 'value' => 'Текст 2'];
        $result['representative_doc'][] = ['title' => 'Дані 3', 'value' => 'Текст 3'];
        $result['representative_doc'][] = ['title' => 'Дані 4', 'value' => 'Текст 4'];
        $result['representative_doc'][] = ['title' => 'Дані 5', 'value' => 'Текст 5'];
        $result['representative_doc'][] = ['title' => 'Дані 6', 'value' => 'Текст 6'];

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

        $dev_company_id = Card::where('id', $card_id)->value('dev_company_id');
        $developer_representative = Client::where('id', $r['dev_representative_id'])
            ->where('type_id', $this->representative_type)
            ->where('dev_company_id', $dev_company_id)
            ->first();

        if (!isset($errors['dev_representative_id']) && !$developer_representative) {
            $validator->getMessageBag()->add('dev_representative_id', 'Представник забудовника з ID:' . $r['dev_representative_id'] . " не знайдено");
        }

        if (count($validator->errors()->getMessages())) {
            return $this->sendError("Карта $card_id має наступні помилки", $validator->errors());
        }

        Card::where('id', $card_id)->update([
           'dev_representative_id' => $r['dev_representative_id']
        ]);

        return $this->sendResponse('', "Дані були успішно оновлені");
    }

//    private function ceo_info($dev_company_id)
//    {
//        $ceo = Client::where('type_id', $this->developer_type)->where('dev_company_id', $dev_company_id)->first();
//
//        $ceo->name = $this->convert->get_full_name($ceo);
//        $ceo->address = $this->convert->get_client_full_address($ceo);
//
//        return $ceo;
//    }

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

//    private function get_dev_company_representative($card)
//    {
//        $result = [];
//
//        $dev_representative = Client::select('id', 'surname_n', 'name_n', 'patronymic_n')
//            ->where('type_id', $this->representative_type)
//            ->where('dev_company_id', $card->dev_company_id)
//            ->get();
//
//
//        foreach ($dev_representative as $key => $representative) {
//            $result[$key]['id'] = $representative->id;
//            $result[$key]['title'] = $this->convert->get_full_name($representative);
//        }
//
//        return $result;
//    }
}
