<?php

namespace App\Http\Controllers\Generator;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Factory\ConvertController;
use App\Models\AddressType;
use App\Models\ApartmentType;
use App\Models\BuildingType;
use App\Models\Citizenship;
use App\Models\Client;
use App\Models\City;
use App\Models\ClientSpouseConsent;
use App\Models\ConsentTemplate;
use App\Models\MarriageType;
use App\Models\Notary;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Models\Card;
use Validator;
use App\Models\PassportTemplate;

class ClientController extends BaseController
{
    public $convert;

    public function __construct()
    {
        $this->convert = new ConvertController();
    }

    public function main($card_id)
    {
        $result = null;

        if (!$card = Card::find($card_id)) {
            return $this->sendError('', 'Картка з ID: ' . $card_id . ' відсутня');
        }

        $clients = $this->get_client_by_card_id($card_id);

        return $this->sendResponse($clients, 'Клієнти по карточці ID: ' . $card_id);
    }

    public function get_name($client_id)
    {
        $result = null;

        $client = Client::select(
            'surname_n',
            'name_n',
            'patronymic_n',
            'surname_r',
            'name_r',
            'patronymic_r',
            'surname_o',
            'name_o',
            'patronymic_o',
        )->where('id', $client_id)->first();

        if (!$client) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        return $this->sendError($client, 'Дані по клієнту з ID: ' . $client_id);
    }

    public function update_name($client_id, Request $r)
    {
        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        $validator = $this->validate_client_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        Client::where('id', $client_id)->update([
            'surname_n' => $r['surname_n'],
            'name_n' => $r['name_n'],
            'patronymic_n' => $r['patronymic_n'],
            'surname_r' => $r['surname_r'],
            'name_r' => $r['name_r'],
            'patronymic_r' => $r['patronymic_r'],
            'surname_o' => $r['surname_o'],
            'name_o' => $r['name_o'],
            'patronymic_o' => $r['patronymic_o'],
        ]);

        return $this->sendResponse('', 'Дані ПІБ клієнта з ID: ' . $client_id . ' оноволено успішно.');
    }

    public function get_contacts($client_id)
    {
        $result = [];

        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        $result['phone'] = $client->phone;
        $result['email'] = $client->email;

        return  $this->sendResponse($result, 'Контакти кієнта з ID: ' . $client_id);
    }

    public function update_contacts($client_id, Request $r)
    {
        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        Client::where('id', $client_id)->update([
            'phone' => $r['phone'],
            'email' => $r['email'],
        ]);

        return $this->sendResponse('', 'Контакти кієнта з ID: ' . $client_id . ' оноволено успішно.');
    }

    public function get_citizenships($client_id)
    {
        $result = [];

        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        $citizenships = Citizenship::select('id', 'title_n')->get();

        $citizenship_id = $client->citizenship_id;

        $result['citizenships'] = $citizenships;
        $result['citizenship_id'] = $citizenship_id;

        return $this->sendResponse($result, 'Дані для вибору громадянства клієнта');
    }

    public function update_citizenships($client_id, Request $r)
    {
        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        $validator = $this->validate_client_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        Client::where('id', $client_id)->update([
           'citizenship_id' => $r['citizenship_id'],
        ]);

        return $this->sendResponse('', 'Громадянство клієнта з ID: ' . $client_id . ' оновлено');
    }

    public function get_passport($client_id)
    {
        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        $passport_type = PassportTemplate::select('id', 'title')->get();

        $result['passport_types'] = $passport_type;
        $result['gender'] = $client->gender;
        $result['date_of_birth'] = $client->birthday ?  $client->birthday->format('d.m.Y') : null;
        $result['tax_code'] = $client->tax_code;
        $result['passport_type_id'] = $client->passport_type_id;
        $result['passport_code'] = $client->passport_code        ;
        $result['passport_date'] = $client->passport_date ? $client->passport_date->format('d.m.Y') : null;
        $result['passport_department'] = $client->passport_department;
        $result['passport_demographic_code'] = $client->passport_demographic_code;
        $result['passport_finale_date'] = $client->passport_finale_date ? $client->passport_finale_date->format('d.m.Y') : null;

        return $this->sendResponse($result, 'Код, стать та паспортні дані клієнта з ID: ' . $client_id);
    }

    public function update_passport($client_id, Request $r)
    {
        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        $validator = $this->validate_client_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        Client::where('id', $client_id)->update([
            'gender' => $r['gender'],
            'birthday' => $r['date_of_birth'],
            'tax_code' => $r['tax_code'],
            'passport_type_id' => $r['passport_type_id'],
            'passport_code' => $r['passport_code'],
            'passport_date' => $r['passport_date'],
            'passport_department' => $r['passport_department'],
            'passport_demographic_code' => $r['passport_demographic_code'],
            'passport_finale_date' => $r['passport_finale_date'],
        ]);

        return $this->sendResponse('', 'Код, стать та паспортні дані клієнта з ID ' . $client_id . ' оновлено');
    }

    public function get_address($client_id)
    {
        $result = [];

        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        $regions = Region::select('id', 'title_n as title')->orderBy('title')->get();
        $address_type = AddressType::select('id', 'title_n as title')->orderBy('title')->get();
        $building_type = BuildingType::select('id', 'title_n as title')->orderBy('title')->get();
        $apartment_type = ApartmentType::select('id', 'title_n as title')->orderBy('title')->get();

        $result['regions'] = $regions;
        $result['address_type'] = $address_type;
        $result['building_type'] = $building_type;
        $result['apartment_type'] = $apartment_type;
        $result['city_id'] = $client->city_id;
        $result['address_type_id'] = $client->address_type_id;
        $result['address'] = $client->address;
        $result['building_num'] = $client->building;
        $result['apartment_type_id'] = $client->apartment_type_id;
        $result['apartment_num'] = $client->apartment_num;


        return $this->sendResponse($result, 'Дані адреси клієнта з ID ' . $client_id);
    }

    public function get_cities($region_id)
    {
        $result = [];


        if (!$region = Region::find($region_id)) {
            return $this->sendError('', 'Область з ID: ' . $region_id . ' відсутня');
        }

        $cities = City::select('id', 'title')->where('region_id', $region_id)->orderBy('title')->get();

        $result['cities'] = $cities;

        return $this->sendResponse($result, 'Міста по області ID: ' . $region_id);
    }

    public function update_address($client_id, Request $r)
    {
        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        $validator = $this->validate_client_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        Client::where('id', $client_id)->update([
            'city_id' => $r['city_id'],
            'address_type_id' => $r['address_type_id'],
            'address' => $r['address'],
            'building_type_id' => $r['building_type_id'],
            'building' => $r['building_num'],
            'apartment_type_id' => $r['apartment_type_id'],
            'apartment_num' => $r['apartment_num'],
        ]);

        return $this->sendResponse('', 'Адреса клієнта з ID ' . $client_id . ' оновлена');
    }

    public function get_consents($client_id)
    {
        $result = [];

        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        $consent_templates = ConsentTemplate::select('id', 'title')->get();
        $married_types = MarriageType::select('id', 'title')->get();
        $rakul_notary = Notary::where('rakul_company', true)->get();

        $convert_notary = [];
        $rakul_notary = Notary::select('id', 'name_n', 'patronymic_n')->where('rakul_company', true)->get();
        foreach ($rakul_notary as $key => $value) {
            $convert_notary[$key]['id'] = $value->id;
            $convert_notary[$key]['title'] = $this->convert->get_short_name($value);
        }

        $result['rakul_notary'] = $convert_notary;
        $result['consent_templates'] = $consent_templates;
        $result['married_types'] = $married_types;
        $result['consent_template_id'] = null;
        $result['marriage_type_id'] = null;
        $result['mar_series'] = null;
        $result['mar_series_num'] = null;
        $result['mar_date'] = null;
        $result['mar_depart'] = null;
        $result['mar_reg_num'] = null;
        $result['sign_date'] = null;
        $result['reg_num'] = null;

        if ($client->client_spouse_consent) {
            $result['notary_id'] = $client->client_spouse_consent->notary_id;
            $result['consent_template_id'] = $client->client_spouse_consent->template_id;
            $result['marriage_type_id'] = $client->client_spouse_consent->marriage_type_id;
            $result['mar_series'] = $client->client_spouse_consent->mar_series;
            $result['mar_series_num'] = $client->client_spouse_consent->mar_series_num;
            $result['mar_date'] = $client->client_spouse_consent->mar_date ? $client->client_spouse_consent->mar_date->format('d.m.Y') : null;
            $result['mar_depart'] = $client->client_spouse_consent->mar_depart;
            $result['mar_reg_num'] = $client->client_spouse_consent->mar_reg_num;
            $result['sign_date'] = $client->client_spouse_consent->sign_date ? $client->client_spouse_consent->sign_date->format('d.m.Y') : null;
            $result['reg_num'] = $client->client_spouse_consent->reg_num;
        }

        return $this->sendResponse($result, 'Дані по заяві-згоді клієнта з ID ' . $client_id);
    }

    public function update_consents($client_id, Request $r)
    {
        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        $validator = $this->validate_client_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        ClientSpouseConsent::where('client_id', $client_id)->update([
            'notary_id' => $r['notary_id'],
            'template_id' => $r['consent_template_id'],
            'marriage_type_id' => $r['marriage_type_id'],
            'mar_series' => $r['mar_series'],
            'mar_series_num' => $r['mar_series_num'],
            'mar_date' => $r['mar_date'],
            'mar_depart' => $r['mar_depart'],
            'mar_reg_num' => $r['mar_reg_num'],
            'sign_date' => $r['sign_date'],
            'reg_num' => $r['reg_num'],
        ]);

        return $this->sendResponse('', 'Дані для Заяви-згоди оновлено успішно.');
    }

    private function get_client_by_card_id($card_id)
    {
        $result = [];

        $clients_id = Card::where('cards.id', $card_id)
            ->join('card_contract', 'cards.id', '=', 'card_contract.card_id')
            ->join('client_contract', 'card_contract.contract_id', '=', 'client_contract.contract_id')
            ->pluck('client_contract.client_id')->toArray();

        $clients = Client::whereIn('id', $clients_id)->get();


        foreach ($clients as $key => $client) {
            $result[$key]['client'] = [];
            $result[$key]['spouse'] = null;
            $result[$key]['representative'] = null;
            $result[$key]['client']['id'] = $client->id;
            $result[$key]['client']['full_name'] = $this->convert->get_full_name($client);
            $result[$key]['client']['list'] = ['Teст 1', 'Тест 2', 'Test 3'];

            if ($client->spouse) {
                $result[$key]['spouse'] = [];
                $result[$key]['spouse']['id'] = $client->spouse->id;
                $result[$key]['spouse']['full_name'] = $client->spouse->convert->get_full_name($client);
                $result[$key]['spouse']['list'] = ['Teст 1', 'Тест 2', 'Test 3'];
            }

            if ($client->representative) {
                $result[$key]['representative'] = [];
                $result[$key]['representative']['id'] = $client->representative->id;
                $result[$key]['representative']['full_name'] = $client->representative->convert->get_full_name($client);
                $result[$key]['representative']['list'] = ['Teст 1', 'Тест 2', 'Test 3'];
            }
        }

        return $result;
    }

    private function validate_client_data($r)
    {
        if (isset($r['date_of_birth']) && !empty($r['date_of_birth']))
            $r['date_of_birth'] = \DateTime::createFromFormat('d.m.Y', $r['date_of_birth']);
        if (isset($r['passport_date']) && !empty($r['passport_date']))
            $r['passport_date'] = \DateTime::createFromFormat('d.m.Y', $r['passport_date']);
        if (isset($r['passport_finale_date']) && !empty($r['passport_finale_date']))
            $r['passport_finale_date'] = \DateTime::createFromFormat('d.m.Y', $r['passport_finale_date']);
        if (isset($r['mar_date']) && !empty($r['mar_date']))
            $r['mar_date'] = \DateTime::createFromFormat('d.m.Y', $r['mar_date']);
        if (isset($r['sign_date']) && !empty($r['sign_date']))
            $r['sign_date'] = \DateTime::createFromFormat('d.m.Y', $r['sign_date']);

        $validator = Validator::make([
            'surname_n' => $r['surname_n'],
            'name_n' => $r['name_n'],
            'patronymic_n' => $r['patronymic_n'],
            'surname_r' => $r['surname_r'],
            'name_r' => $r['name_r'],
            'patronymic_r' => $r['patronymic_r'],
            'surname_o' => $r['surname_o'],
            'name_o' => $r['name_o'],
            'patronymic_o' => $r['patronymic_o'],
            'citizenship_id' => $r['citizenship_id'],

            'gender' => $r['gender'],
            'date_of_birth' => $r['date_of_birth'] ? $r['date_of_birth']->format('Y.m.d.') : null,
            'tax_code' => $r['tax_code'],
            'passport_type_id' => $r['passport_type_id'],
            'passport_code' => $r['passport_code'],
            'passport_date' => $r['passport_date'] ? $r['passport_date']->format('Y.m.d.') : null,
            'passport_department' => $r['passport_department'],
            'passport_demographic_code' => $r['passport_demographic_code'],
            'passport_finale_date' => $r['passport_finale_date'] ? $r['passport_finale_date']->format('Y.m.d.') : null,

            'city_id' => $r['city_id'],
            'address_type_id' => $r['address_type_id'],
            'address' => $r['address'],
            'building_type_id' => $r['building_type_id'],
            'building_num' => $r['building_num'],
            'apartment_type_id' => $r['apartment_type_id'],
            'apartment_num' => $r['apartment_num'],

            'notary_id' => $r['notary_id'],
            'consent_template_id' => $r['consent_template_id'],
            'marriage_type_id' => $r['marriage_type_id'],
            'mar_series' => $r['mar_series'],
            'mar_series_num' => $r['mar_series_num'],
            'mar_date' => $r['mar_date'] ? $r['mar_date']->format('Y.m.d.') : null,
            'mar_depart' => $r['mar_depart'],
            'mar_reg_num' => $r['mar_reg_num'],
            'sign_date' => $r['sign_date'] ? $r['sign_date']->format('Y.m.d.') : null,
            'reg_num' => $r['reg_num'],
        ], [
            'surname_n' => ['string', 'nullable'],
            'name_n' => ['string', 'nullable'],
            'patronymic_n' => ['string', 'nullable'],
            'surname_r' => ['string', 'nullable'],
            'name_r' => ['string', 'nullable'],
            'patronymic_r' => ['string', 'nullable'],
            'surname_o' => ['string', 'nullable'],
            'name_o' => ['string', 'nullable'],
            'patronymic_o' => ['string', 'nullable'],
            'citizenship_id' => ['numeric', 'nullable'],

            'gender' => ['string', 'nullable'],
            'date_of_birth' => ['date_format:Y.m.d.', 'nullable'],
            'tax_code' => ['numeric', 'nullable'],
            'passport_type_id' => ['numeric', 'nullable'],
            'passport_code' => ['string', 'nullable'],
            'passport_date' => ['date_format:Y.m.d.', 'nullable'],
            'passport_department' => ['string', 'nullable'],
            'passport_demographic_code' => ['numeric', 'nullable'],
            'passport_finale_date' => ['date_format:Y.m.d.', 'nullable'],

            'city_id' => ['numeric', 'nullable'],
            'address_type_id' => ['numeric', 'nullable'],
            'address' => ['string', 'nullable'],
            'building_type_id' => ['numeric', 'nullable'],
            'building_num' => ['string', 'nullable'],
            'apartment_type_id' => ['numeric', 'nullable'],
            'apartment_num' => ['string', 'nullable'],

            'notary_id' => ['numeric', 'nullable'],
            'consent_template_id' => ['numeric', 'nullable'],
            'marriage_type_id' => ['numeric', 'nullable'],
            'mar_series' => ['string', 'nullable'],
            'mar_series_num' => ['numeric', 'nullable'],
            'mar_date' => ['date_format:Y.m.d.', 'nullable'],
            'mar_depart' => ['string', 'nullable'],
            'mar_reg_num' => ['numeric', 'nullable'],
            'sign_date' => ['date_format:Y.m.d.', 'nullable'],
            'reg_num' => ['numeric', 'nullable'],
        ], [
            'surname_n.string' => 'Необхідно передати в строковому форматі',
            'name_n.string' => 'Необхідно передати в строковому форматі',
            'patronymic_n.string' => 'Необхідно передати в строковому форматі',
            'surname_r.string' => 'Необхідно передати в строковому форматі',
            'name_r.string' => 'Необхідно передати в строковому форматі',
            'patronymic_r.string' => 'Необхідно передати в строковому форматі',
            'surname_o.string' => 'Необхідно передати в строковому форматі',
            'name_o.string' => 'Необхідно передати в строковому форматі',
            'patronymic_o.string' => 'Необхідно передати в строковому форматі',
            'citizenship_id.numeric' => 'Необхідно передати ID громадянства в числовому форматі',

            'gender.string' => 'Необхідно передати в строковому форматі',
            'date_of_birth.date_format' => 'Необхідно передати дату в форматі d.m.Y',
            'tax_code.numeric' => 'Необхідно передати в числовому форматі',
            'passport_type_id.numeric' => 'Необхідно передати в числовому форматі',
            'passport_code.string' => 'Необхідно передати в строковому форматі',
            'passport_date.date_format' => 'Необхідно передати в дату в форматі d.m.Y',
            'passport_department.string' => 'Необхідно передати в строковому форматі',
            'passport_demographic_code.numeric' => 'Необхідно передати в числовому форматі',
            'passport_finale_date.date_format' => 'Необхідно передати дату в форматі d.m.Y',

            'city_id.numeric' => 'Необхідно передати в числовому форматі',
            'address_type_id.numeric' => 'Необхідно передати в числовому форматі',
            'address.string' => 'Необхідно передати в строковому форматі',
            'building_type_id.numeric' => 'Необхідно передати в числовому форматі',
            'building_num.string' => 'Необхідно передати в строковому форматі',
            'apartment_type_id.numeric' => 'Необхідно передати в числовому форматі',
            'apartment_num.string' => 'Необхідно передати в строковому форматі',

            'notary_id.numeric' => 'Необхідно передати в числовому форматі',
            'consent_template_id.numeric' => 'Необхідно передати в числовому форматі',
            'marriage_type_id.numeric' => 'Необхідно передати в числовому форматі',
            'mar_series.string' => 'Необхідно передати в строковому форматі',
            'mar_series_num.numeric' => 'Необхідно передати в числовому форматі',
            'mar_date.date_format' => 'Необхідно передати дату в форматі d.m.Y',
            'mar_depart.string' => 'Необхідно передати в строковому форматі',
            'mar_reg_num.numeric' => 'Необхідно передати в числовому форматі',
            'sign_date.date_format' => 'Необхідно передати дату в форматі d.m.Y',
            'reg_num.numeric' => 'Необхідно передати в числовому форматі',
        ]);

        $errors = $validator->errors()->messages();

        if (!isset($errors['passport_type_id']) && isset($r['passport_type_id']) && !empty($r['passport_type_id'])) {
            if (!PassportTemplate::find($r['passport_type_id'])) {
                $validator->getMessageBag()->add('passport_type_id', 'Тип паспорту по ID:' . $r['passport_type_id'] . " не знайдено");
            }
        }

        if (!isset($errors['city_id']) && isset($r['city_id']) && !empty($r['city_id'])) {
            if (!City::find($r['city_id'])) {
                $validator->getMessageBag()->add('city_id', 'Місто по ID:' . $r['city_id'] . " не знайдено");
            }
        }

        if (!isset($errors['address_type_id']) && isset($r['address_type_id']) && !empty($r['address_type_id'])) {
            if (!AddressType::find($r['address_type_id'])) {
                $validator->getMessageBag()->add('address_type_id', 'Тип адреси по ID:' . $r['address_type_id'] . " не знайдено");
            }
        }

        if (!isset($errors['building_type_id']) && isset($r['building_type_id']) && !empty($r['building_type_id'])) {
            if (!BuildingType::find($r['building_type_id'])) {
                $validator->getMessageBag()->add('building_type_id', 'Тип будівлі по ID:' . $r['building_type_id'] . " не знайдено");
            }
        }

        if (!isset($errors['apartment_type_id']) && isset($r['apartment_type_id']) && !empty($r['apartment_type_id'])) {
            if (!ApartmentType::find($r['apartment_type_id'])) {
                $validator->getMessageBag()->add('apartment_type_id', 'Тип апартаментів по ID:' . $r['apartment_type_id'] . " не знайдено");
            }
        }


        if (!isset($errors['notary_id']) && isset($r['notary_id']) && !empty($r['notary_id'])) {
            if (!Notary::find($r['notary_id'])) {
                $validator->getMessageBag()->add('notary_id', 'Нотаріус з ID:' . $r['notary_id'] . " відсутній");
            }
        }

        if (!isset($errors['consent_template_id']) && isset($r['consent_template_id']) && !empty($r['consent_template_id'])) {
            if (!ConsentTemplate::find($r['consent_template_id'])) {
                $validator->getMessageBag()->add('consent_template_id', 'Шаблон заяви-згоди по ID:' . $r['consent_template_id'] . " відсутній");
            }
        }

        if (!isset($errors['marriage_type_id']) && isset($r['marriage_type_id']) && !empty($r['marriage_type_id'])) {
            if (!MarriageType::find($r['marriage_type_id'])) {
                $validator->getMessageBag()->add('marriage_type_id', 'Тип документу сімейного стану по ID:' . $r['marriage_type_id'] . " відсутній");
            }
        }

        return $validator;
    }
}
