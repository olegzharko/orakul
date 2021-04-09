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
            $result['dev_representatives'][$key]['id'] = $representative->id;
            $result['dev_representatives'][$key]['title'] = $this->convert->get_full_name($representative);
        }

        $representative = $card->dev_representative;

        $result['representative']['id'] = $representative->id;
        $result['representative']['name'] =  $this->convert->get_full_name($representative);
        $result['representative']['tax_code'] = $representative->code;
        $result['representative']['address'] = $this->convert->get_client_full_address($representative);
        $result['representative']['passpot_info'] = $this->collect_passport_info($representative);

        return $this->sendResponse($result, 'Продавці відносно будинку та підписанти.');
    }

    public function main($card_id)
    {
        $result = [];

        $dev_group = Card::find($card_id)->dev_group;

        $result['dev_company']['title'] = $dev_group->title;
        $result['dev_company']['color'] = $dev_group->color;

        $ceo = $this->ceo_info($dev_group->id);
        $result['ceo_info']['name'] = $ceo->name;
        $result['ceo_info']['tax_code'] = $ceo->code;
        $result['ceo_info']['married'] = $ceo->spouse_id ? Text::where('alias', 'yes')->value('value') : Text::where('alias', 'no')->value('value');
        $result['ceo_info'] = array_merge($result['ceo_info'], $this->collect_passport_info($ceo));
        $result['ceo_info']['address'] = $ceo->address;

        return $this->sendResponse($result, 'Загальні дані по забудовнику.');
    }

    public function get_fence($card_id)
    {
        $result = [];
        $card = Card::find($card_id);

        $result['date'] = null;
        $result['number'] = null;
        $result['pass'] = null;

        $card->dev_company->owner = $card->dev_company->member->where('type_id', $this->developer_type)->first();
        if ($fence = DevFence::where('dev_company_id', $card->dev_company->owner->id)->orderBy('date', 'desc')->first() ) {
            $result['date'] = $fence->date->format('d.m.Y. H:i');
            $result['number'] = $fence->number;
            $result['pass'] = $fence->pass;
        }

        return $this->sendResponse($result, "Дані по забороні на продавця");
    }

    public function update_fence($card_id, Request $r)
    {
        $result = [];

        $r['date'] = \DateTime::createFromFormat('Y.m.d. H:i', $r['date']);
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

        if (count($validator->errors()->getMessages())) {
            return $this->sendError("Карта $card_id має наступні помилки", $validator->errors());
        }

        $card = Card::find($card_id);

        $fence = new DevFence();
        $fence->date = $r['date'];
        $fence->number = $r['number'];
        $fence->save();

        return $this->sendResponse('', 'Дані по забороні на продавця оновлені');
    }

    public function spouse($card_id)
    {
        $card = Card::find($card_id);

        $card->dev_company->owner = $card->dev_company->member->where('type_id', $this->developer_type)->first();

        if ($card->dev_company->owner->spouse) {
            return $this->sendResponse('', 'Дані про подружжя не підготовлені. Розділ знаходиться на уточненні');
        } else {
            return $this->sendResponse('', 'Дані про подружжя відсутні');
        }
    }

    public function get_representative($card_id)
    {
        $result = [];

        $card = Card::find($card_id);
        $result['dev_representative'] = $this->get_dev_company_representative($card);
        $result['dev_representative_id'] = $card->dev_representative_id;

        $representative = Client::find($card->dev_representative_id);

        $result['representative']['name'] =  $this->convert->get_full_name($representative);
        $result['representative']['tax_code'] = $representative->code;
        $result['representative'] = array_merge($result['representative'], $this->collect_passport_info($representative));
        $result['representative']['address'] = $this->convert->get_client_full_address($representative);

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

    private function ceo_info($dev_company_id)
    {
        $ceo = Client::where('type_id', $this->developer_type)->where('dev_company_id', $dev_company_id)->first();

        $ceo->name = $this->convert->get_full_name($ceo);
        $ceo->address = $this->convert->get_client_full_address($ceo);

        return $ceo;
    }

    private function collect_passport_info($client)
    {
        $result = [];

        $result['passport_type'] = PassportTemplate::where('id', $client->passport_type_id)->value('title');
        $result['passport_code'] = $client->passport_code;
        $result['passport_date'] = $client->passport_date ? $client->passport_date->format('d.m.Y.') : null;
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
