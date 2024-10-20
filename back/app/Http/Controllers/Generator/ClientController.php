<?php

namespace App\Http\Controllers\Generator;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Factory\ConvertController;
use App\Models\AddressType;
use App\Models\ApartmentType;
use App\Models\BuildingPart;
use App\Models\BuildingType;
use App\Models\ClientCheckList;
use App\Models\Citizenship;
use App\Models\CityType;
use App\Models\Client;
use App\Models\City;
use App\Models\ClientContract;
use App\Models\ClientSpouseConsent;
use App\Models\ClientSpouseConsentContract;
use App\Models\ClientWork;
use App\Models\ConsentTemplate;
use App\Models\District;
use App\Models\KeyWord;
use App\Models\MarriageType;
use App\Models\NativeAddress;
use App\Models\Notary;
use App\Models\Region;
use App\Models\Representative;
use App\Models\SpouseWord;
use App\Models\Spouse;
use App\Models\Contract;
use App\Models\TerminationConsent;
use App\Models\TerminationConsentTemplate;
use App\Models\ActualAddress;
use App\Models\DevCompany;
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

    public function destroy($client_id, $card_id)
    {
        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнти з ID: ' . $client . ' відсутній');
        }

        if ($buyer = ClientContract::where('client_id', $client->id)->first()) {
            if ($client->married) {
                Client::find($client->married->spouse_id)->delete();
                $client->married->delete();
            }
            if ($client->client_spouse_consent) {
                $client->client_spouse_consent->delete();
            }
            if ($client->representative) {
                Client::find($client->representative->confidant_id)->delete();
                if ($client->representative)
                    $client->representative->delete();
            }
//            if ($client->contracts) {
//                foreach ($client->contracts as $contract) {
//                    $contract->delete();
//                }
//            }
        } elseif ($spouse = Spouse::where('spouse_id', $client->id)->first() && $client->married) {
                $client->married->delete();
        } elseif ($confidant = Representative::where('confidant_id', $client->id)->first()) {
            $client->representative->delete();
        }

        ClientContract::where('client_id', $client->id)->delete();
        ClientCheckList::where('client_id', $client->id)->delete();
        Client::where('id', $client->id)->delete();

//        $result = $this->get_client_by_card_id($card_id);

        $result = [];

        $clients_id = Card::where('cards.id', $card_id)
            ->join('contracts',  'contracts.card_id', '=', 'cards.id')
            ->join('client_contract','client_contract.contract_id', '=', 'contracts.id' )
            ->pluck('client_contract.client_id')->toArray();

        $clients = Client::whereIn('id', $clients_id)->get();

        foreach ($clients as $key => $client) {
            $result[$key] = [];
            $result[$key]['id'] = $client->id;
            $result[$key]['full_name'] = $this->convert->get_full_name($client);
            $result[$key]['list'] = $this->get_list($client);
        }

        return $this->sendResponse($result, 'Клієнта по ID: ' . $client_id. ' видалено');
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
            'surname_d',
            'name_d',
            'patronymic_d',
            'surname_o',
            'name_o',
            'patronymic_o',
        )->where('id', $client_id)->first();

        if (!$client) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        $client = $client->toArray();

        foreach ($client as $key => $value) {
            if ($client['surname_r'] == null) {
                $client['surname_r'] = $client['surname_n'];
            }
            if ($client['name_r'] == null) {
                $client['name_r'] = $client['name_n'];
            }
            if ($client['patronymic_r'] == null) {
                $client['patronymic_r'] = $client['patronymic_n'];
            }
            if ($client['surname_o'] == null) {
                $client['surname_o'] = $client['surname_n'];
            }
            if ($client['name_o'] == null) {
                $client['name_o'] = $client['name_n'];
            }
            if ($client['patronymic_o'] == null) {
                $client['patronymic_o'] = $client['patronymic_n'];
            }
            if ($client['surname_d'] == null) {
                $client['surname_d'] = $client['surname_n'];
            }
            if ($client['name_d'] == null) {
                $client['name_d'] = $client['name_n'];
            }
            if ($client['patronymic_d'] == null) {
                $client['patronymic_d'] = $client['patronymic_n'];
            }
        }

        if (ClientContract::where('client_id', $client_id)->first()) {
            $client['type'] = 'client';
        } else {
            $client['type'] = 'other';
        }
        return $this->sendResponse($client, 'Дані по клієнту з ID: ' . $client_id);
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
            'surname_d' => $r['surname_d'],
            'name_d' => $r['name_d'],
            'patronymic_d' => $r['patronymic_d'],
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

    public function get_work($client_id)
    {
        $result = [];

        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        $result['company'] = null;
        $result['position'] = null;

        if ($client->client_work) {
            $result['company'] = $client->client_work->company;
            $result['position'] = $client->client_work->position;
        }

        return  $this->sendResponse($result, 'Робота кієнта з ID: ' . $client_id);
    }

    public function update_work($client_id, Request $r)
    {
        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        ClientWork::updateOrCreate([
            'client_id' => $client_id
        ], [
            'company' => $r['company'],
            'position' => $r['position'],
        ]);

        return $this->sendResponse('', 'Робота кієнта з ID: ' . $client_id . ' оноволено успішно.');
    }

    public function get_citizenships($client_id)
    {
        $result = [];


        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        $citizenships = Citizenship::select('id', 'title_n as title')->orderBy('title_n')->get();

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
        $result['date_of_birth'] = $client->birth_date ?  $client->birth_date->format('d.m.Y') : null;
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
            'birth_date' => $r['date_of_birth'],
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
        $building_part = BuildingPart::select('id', 'title_n as title')->orderBy('title')->get();
        $apartment_type = ApartmentType::select('id', 'title_n as title')->orderBy('title')->get();

        $result['regions'] = $regions;

        $result['address_type'] = $address_type;
        $result['building_type'] = $building_type;
        $result['building_part'] = $building_part;
        $result['apartment_type'] = $apartment_type;
        $result['registration'] = $client->registration ? true : false;
        $result['region_id'] = $client->city ? $client->city->region_id : null;
        $result['district_id'] = $client->district_id;
        $result['city_id'] = $client->city_id;
        $result['address_type_id'] = $client->address_type_id;
        $result['address'] = $client->address;
        $result['building_type_id'] = $client->building_type_id;
        $result['building_num'] = $client->building;
        $result['building_part_id'] = $client->building_part_id;
        $result['building_part_num'] = $client->building_part_num;
        $result['apartment_type_id'] = $client->apartment_type_id;
        $result['apartment_num'] = $client->apartment_num;

        $result['actual'] = null;
        $result['actual_region_id'] = null;
        $result['actual_city_id'] = null;
        $result['actual_address_type_id'] = null;
        $result['actual_address'] = null;
        $result['actual_building_type_id'] = null;
        $result['actual_building_num'] = null;
        $result['actual_apartment_type_id'] = null;
        $result['actual_apartment_num'] = null;

        if ($client->actual_address) {
            $result['actual'] = true;
            $result['actual_region_id'] = $client->actual_address->city ? $client->actual_address->city->region_id : null;
            $result['actual_city_id'] = $client->actual_address->city_id;
            $result['actual_district_id'] = $client->actual_address->district_id;
            $result['actual_address_type_id'] = $client->actual_address->address_type_id;
            $result['actual_address'] = $client->actual_address->address;
            $result['actual_building_type_id'] = $client->actual_address->building_type_id;
            $result['actual_building_num'] = $client->actual_address->building;
            $result['actual_building_part_id'] = $client->actual_address->building_part_id;
            $result['actual_building_part_num'] = $client->actual_address->building_part_num;
            $result['actual_apartment_type_id'] = $client->actual_address->apartment_type_id;
            $result['actual_apartment_num'] = $client->actual_address->apartment_num;
        } else {
            $result['actual'] = false;
        }

        return $this->sendResponse($result, 'Дані адреси клієнта з ID ' . $client_id);
    }

    public function get_native_address($client_id)
    {
        $result = [];

        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        $regions = Region::select('id', 'title_n as title')->orderBy('title')->get();
        $address_type = AddressType::select('id', 'title_n as title')->orderBy('title')->get();
        $building_type = BuildingType::select('id', 'title_n as title')->orderBy('title')->get();
        $building_part = BuildingPart::select('id', 'title_n as title')->orderBy('title')->get();
        $apartment_type = ApartmentType::select('id', 'title_n as title')->orderBy('title')->get();

        $result['regions'] = $regions;

        $result['address_type'] = $address_type;
        $result['building_type'] = $building_type;
        $result['building_part'] = $building_part;
        $result['apartment_type'] = $apartment_type;

        $result['native_region_id'] = null;
        $result['native_city_id'] = null;
        $result['native_district_id'] = null;
        $result['native_address_type_id'] = null;
        $result['native_address'] = null;
        $result['native_building_type_id'] = null;
        $result['native_building_num'] = null;
        $result['native_building_part_id'] = null;
        $result['native_building_part_num'] = null;
        $result['native_apartment_type_id'] = null;
        $result['native_apartment_num'] = null;
        
        if ($client->native_address) {
            $result['native_region_id'] = $client->native_address->city ? $client->native_address->city->region_id : null;
            $result['native_city_id'] = $client->native_address->city_id;
            $result['native_district_id'] = $client->native_address->district_id;
            $result['native_address_type_id'] = $client->native_address->address_type_id;
            $result['native_address'] = $client->native_address->address;
            $result['native_building_type_id'] = $client->native_address->building_type_id;
            $result['native_building_num'] = $client->native_address->building;
            $result['native_building_part_id'] = $client->native_address->building_part_id;
            $result['native_building_part_num'] = $client->native_address->building_part_num;
            $result['native_apartment_type_id'] = $client->native_address->apartment_type_id;
            $result['native_apartment_num'] = $client->native_address->apartment_num;
        }

        return $this->sendResponse($result, 'Дані адреси клієнта з ID ' . $client_id);
    }

    public function get_districts($region_id)
    {
        $result = [];

        if (!$region = Region::find($region_id)) {
            return $this->sendError('', 'Область з ID: ' . $region_id . ' відсутня');
        }

        $districts = District::select('id', 'title_n as title')->where('region_id', $region_id)->orderBy('title_n')->get();

        $result = $districts;

        return $this->sendResponse($result, 'Міста по області ID: ' . $region_id);
    }

//    public function get_root_city($region_id)
//    {
//        $result = [];
//
//        if (!$region = Region::find($region_id)) {
//            return $this->sendError('', 'Область з ID: ' . $region_id . ' відсутня');
//        }
//
//        $city = City::select('id', 'title')->where('region_id', $region_id)->where('region_root', true)->orderBy('title')->get();
//
//        $result = $city;
//
//        return $this->sendResponse($result, 'Міста по області ID: ' . $region_id);
//    }

    public function get_cities($region_id, $district_id = null)
    {
        $result = [];

        if ($region_id && !$region = Region::find($region_id)) {
            return $this->sendError('', 'Область з ID: ' . $region_id . ' відсутня');
        }

        if ($district_id && !$district = District::find($district_id)) {
            return $this->sendError('', 'Район з ID: ' . $district_id . ' відсутній');
        }

        if ($region_id && $district_id == null) {

            $city = City::select('id', 'title')->where('region_id', $region_id)->where('region_root', true)->orderBy('title')->get();

            $result = $city;

        } elseif ($region_id && $district_id) {

            $cities = City::select('id', 'title')->where('district_id', $district_id)->orWhere('district_new_id', $district_id)->orderBy('title')->get();

            $result = $cities;
        }

        return $this->sendResponse($result, 'Міста по області ID: ' . $district_id);
    }

    public function start_data_create_city()
    {
        $result = [];

        $result['regions'] = Region::select('id', 'title_n as title')->orderBy('title')->get();
        $result['city_type'] = CityType::select('id', 'title_n as title')->orderBy('title')->get();

        return $this->sendResponse($result, 'Дані для створення населеного пункту');
    }

    public function district_by_region($region_id)
    {
        $result = [];

        if (!$region = Region::find($region_id)) {
            return $this->sendError('', 'Область з ID: ' . $region_id . ' відсутня');
        }

        $result['district'] = District::select('id', 'title_n as title')->where('region_id', $region_id)->orderBy('title')->get();

        return $this->sendResponse($result, 'Райони та територіальні громади ' . $region->title_r . ' обл.' );
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
            'registration' => $r['registration'] ? 1 : 0,
            'district_id' => $r['district_id'],
            'city_id' => $r['city_id'],
            'address_type_id' => $r['address_type_id'],
            'address' => $r['address'],
            'building_type_id' => $r['building_type_id'],
            'building' => $r['building_num'],
            'building_part_id' => $r['building_part_id'],
            'building_part_num' => $r['building_part_num'],
            'apartment_type_id' => $r['apartment_type_id'],
            'apartment_num' => $r['apartment_num'],
        ]);

        if ($r['actual']) {
            ActualAddress::updateOrCreate(
                ['client_id' => $client_id],
                [
                    'actual' => $r['actual'],
                    'district_id' => $r['actual_district_id'],
                    'city_id' => $r['actual_city_id'],
                    'address_type_id' => $r['actual_address_type_id'],
                    'address' => $r['actual_address'],
                    'building_type_id' => $r['actual_building_type_id'],
                    'building' => $r['actual_building_num'],
                    'building_part_id' => $r['actual_building_part_id'],
                    'building_part_num' => $r['actual_building_part_num'],
                    'apartment_type_id' => $r['actual_apartment_type_id'],
                    'apartment_num' => $r['actual_apartment_num'],
                ]);
        } else {
            ActualAddress::where('client_id', $client_id)->delete();
        }

        return $this->sendResponse('', 'Адреса клієнта з ID ' . $client_id . ' оновлена');
    }

    public function update_native_address($client_id, Request $r)
    {
        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        $validator = $this->validate_client_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        NativeAddress::updateOrCreate(
            ['client_id' => $client_id],
            [
                'district_id' => $r['native_district_id'],
                'city_id' => $r['native_city_id'],
                'address_type_id' => $r['native_address_type_id'],
                'address' => $r['native_address'],
                'building_type_id' => $r['native_building_type_id'],
                'building' => $r['native_building_num'],
                'building_part_id' => $r['native_building_part_id'],
                'building_part_num' => $r['native_building_part_num'],
                'apartment_type_id' => $r['native_apartment_type_id'],
                'apartment_num' => $r['native_apartment_num'],
            ]);

        return $this->sendResponse('', 'Адреса клієнта з ID ' . $client_id . ' оновлена');
    }

    public function create_city(Request $r)
    {
        $validator = $this->validate_client_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        if ($city = City::where([
                'region_id' => $r->region_id,
                'district_id' =>  $r->district_id,
                'city_type_id' =>  $r->city_type_id,
                'title' =>  $r->title,
            ])->first()) {
            return $this->sendError('', 'Населений пункт існує');
        }

        $city = new City();
        $city->region_id = $r->region_id;
        $city->district_id = $r->district_id;
        $city->city_type_id = $r->city_type_id;
        $city->title = $r->title;
        $city->save();

        return $this->sendResponse('', 'Населений пункт ' . $r->title . ' створено');
    }

    public function get_consents($card_id, $client_id)
    {
        $result = [];

        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        $dev_group_id = Card::find($card_id)->value('dev_group_id');

        $dev_companies_id = Contract::where('card_id', $card_id)
            ->join('immovables', 'immovables.id', '=', 'contracts.immovable_id')
            ->join('developer_buildings', 'developer_buildings.id', '=', 'immovables.developer_building_id')
            ->join('dev_companies', 'dev_companies.id', '=', 'developer_buildings.dev_company_id')
            ->pluck('dev_companies.id');

        $consent_templates = ConsentTemplate::select('id', 'title')->whereIn('dev_company_id', $dev_companies_id)->where('developer', false)->get();

        $married_types = MarriageType::select('id', 'title')->get();
        $rakul_notary = Notary::where('rakul_company', true)->get();

        $convert_notary = [];
        $rakul_notary = Notary::where('rakul_company', true)->get();
        foreach ($rakul_notary as $key => $value) {
            $convert_notary[$key]['id'] = $value->id;
            $convert_notary[$key]['title'] = $this->convert->get_surname_and_initials_n($value);
        }

        $other_notary = [];
        $separate_by_card = Notary::where('separate_by_card', $card_id)->get();
        foreach ($separate_by_card as $key => $value) {
            $other_notary[$key]['id'] = $value->id;
            $other_notary[$key]['title'] = $this->convert->get_surname_and_initials_n($value);
        }

        $consent_spouse_words = SpouseWord::select('id', 'title')->where('dev_company_id', $dev_companies_id)->where('developer', null)->where('termination', null)->orderBy('title')->get();

        $result['notary'] = array_merge($convert_notary, $other_notary);
        $result['consent_templates'] = $consent_templates;
        $result['consent_spouse_words'] = $consent_spouse_words;
        $result['married_types'] = $married_types;
        $result['consent_template_id'] = null;
        $result['consent_spouse_word_id'] = null;
        $result['married_type_id'] = null;
        $result['mar_series'] = null;
        $result['mar_series_num'] = null;
        $result['mar_date'] = null;
        $result['mar_depart'] = null;
        $result['mar_reg_num'] = null;
        $result['sign_date'] = null;
        $result['reg_num'] = null;
        $result['duplicate'] = null;
        $result['duplicate_date'] = null;
        $result['widow'] = null;
        $result['widow_date'] = null;

        if ($client->client_spouse_consent) {
            $result['notary_id'] = $client->client_spouse_consent->notary_id;
            $result['consent_template_id'] = $client->client_spouse_consent->template_id;
            $result['consent_spouse_word_id'] = $client->client_spouse_consent->contract_spouse_word_id;
            $result['married_type_id'] = $client->client_spouse_consent->marriage_type_id;
            $result['mar_series'] = $client->client_spouse_consent->mar_series;
            $result['mar_series_num'] = $client->client_spouse_consent->mar_series_num;
            $result['mar_date'] = $client->client_spouse_consent->mar_date ? $client->client_spouse_consent->mar_date->format('d.m.Y') : null;
            $result['mar_depart'] = $client->client_spouse_consent->mar_depart;
            $result['mar_reg_num'] = $client->client_spouse_consent->mar_reg_num;
            $result['sign_date'] = $client->client_spouse_consent->sign_date ? $client->client_spouse_consent->sign_date->format('d.m.Y') : null;
            $result['reg_num'] = $client->client_spouse_consent->reg_num;
//<<<<<<< HEAD
            $result['duplicate'] = $client->client_spouse_consent->duplicate ? true : false;
            $result['duplicate_date'] = $client->client_spouse_consent->duplicate_date ? $client->client_spouse_consent->duplicate_date->format('d.m.Y') : null;
//=======
//            $result['original'] = $client->client_spouse_consent->duplicate ? true : false;
//>>>>>>> e92117ae8db7afe64f74c17215438e553e38a50e
            $result['widow'] = $client->client_spouse_consent->widow ? true : false;
            $result['widow_date'] = $client->client_spouse_consent->widow_date ? $client->client_spouse_consent->widow_date->format('d.m.Y') : null;
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

//        $r['mar_date'] = \DateTime::createFromFormat('d.m.Y', $r['mar_date']);
//        $r['sign_date'] = \DateTime::createFromFormat('d.m.Y', $r['sign_date']);

        ClientSpouseConsent::updateOrCreate(
            ['client_id' => $client_id],
            [
                'notary_id' => $r['notary_id'],
                'template_id' => $r['consent_template_id'],
                'contract_spouse_word_id' => $r['consent_spouse_word_id'],
                'marriage_type_id' => $r['married_type_id'],
                'mar_series' => $r['mar_series'],
                'mar_series_num' => $r['mar_series_num'],
                'mar_date' => $r['mar_date'] ? $r['mar_date']->format('Y-m-d') : null,
                'mar_depart' => $r['mar_depart'],
                'mar_reg_num' => $r['mar_reg_num'],
                'sign_date' => $r['sign_date'] ? $r['sign_date']->format('Y-m-d') : null,
                'reg_num' => $r['reg_num'],
//<<<<<<< HEAD
                'duplicate' => $r['duplicate'],
                'duplicate_date' => $r['duplicate_date'],
//=======
//                'duplicate' => $r['original'],
//>>>>>>> e92117ae8db7afe64f74c17215438e553e38a50e
                'widow' => $r['widow'],
                'widow_date' => $r['widow_date'] ? $r['widow_date']->format('Y-m-d') : null,
            ]
        );

        $client_spouse_consent_id = ClientSpouseConsent::where('client_id', $client_id)->value('id');

        $contracts_id = ClientContract::where('client_id', $client_id)->pluck('contract_id');


        if (count($contracts_id)) {
            foreach ($contracts_id as $contr_id) {
                if ($contr_id) {
//                    if (!$clc = ClientSpouseConsentContract::where(['contract_id' => $contr_id, 'client_spouse_consent_id' => $client_spouse_consent_id])->first()) {
//                        $clc = new ClientSpouseConsentContract();
//                        $clc->contract_id = $contr_id;
//                        $clc->client_spouse_consent_id = $client_spouse_consent_id;
//                        $clc->save();
//                    }

                    ClientSpouseConsentContract::updateOrCreate(
                        ['contract_id' => $contr_id, 'client_spouse_consent_id' => $client_spouse_consent_id],
                        ['contract_id' => $contr_id, 'client_spouse_consent_id' => $client_spouse_consent_id]
                    );
                }
            }
        }

        return $this->sendResponse('', 'Дані для Заяви-згоди оновлено успішно.');
    }

    public function get_termination($card_id, $client_id)
    {
        $hide = true;
        $result = [];

        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        //  приховати блок заяви-згоди про розірвання договору у подружжя та представника
        if (ClientContract::where('client_id', $client_id)->first()) {
            $hide = false;
        }

        if (!$card = Card::find($card_id)) {
            return $this->sendError('', 'Карта з ID: ' . $client_id . ' відсутня');
        }

        $dev_group_company_id = DevCompany::where('dev_group_id', $card->dev_group_id)->pluck('id');
        $consent_templates = TerminationConsentTemplate::select('id', 'title')->whereIn('dev_company_id', $dev_group_company_id)->get();

        $convert_notary = [];
        $other_notary = [];

        $rakul_notary = Notary::where('rakul_company', true)->get();
        foreach ($rakul_notary as $key => $value) {
            $convert_notary[$key]['id'] = $value->id;
            $convert_notary[$key]['title'] = $this->convert->get_surname_and_initials_n($value);
        }

        $separate_by_card = Notary::where('separate_by_card', $card_id)->get();
        foreach ($separate_by_card as $key => $value) {
            $other_notary[$key]['id'] = $value->id;
            $other_notary[$key]['title'] = $this->convert->get_surname_and_initials_n($value);
        }


        $dev_companies_id = DevCompany::select(
                'dev_companies.*'
            )
            ->where('contracts.card_id', $card_id)
            ->where('contracts.deleted_at', null)
            ->join('developer_buildings', 'developer_buildings.dev_company_id', 'dev_companies.id')
            ->join('immovables', 'immovables.developer_building_id', 'developer_buildings.id')
            ->join('contracts', 'contracts.immovable_id', 'immovables.id')
            ->distinct('dev_companies.id')->pluck('dev_companies.id')->toArray();

        $result['notary'] = array_merge($convert_notary, $other_notary);
        $result['consent_templates'] = $consent_templates;
        $result['notary_id'] = null;
        $result['consent_template_id'] = null;
//        $result['spouse_words'] = SpouseWord::select('id', 'title')->where('termination', true)->whereIn('dev_company_id', $dev_group_company_id)->get();
        $result['spouse_words'] = SpouseWord::select('id', 'title')->where('termination', true)->whereIn('dev_company_id', $dev_companies_id)->get();
        $result['spouse_word_id'] = null;
        $result['reg_date'] = null;
        $result['reg_num'] = null;
        $result['hide'] = $hide;

        if ($client->termination_consent) {
            $result['notary_id'] = $client->termination_consent->notary_id;
            $result['consent_template_id'] = $client->termination_consent->template_id;
            $result['reg_date'] = $client->termination_consent->sign_date ? $client->termination_consent->sign_date->format('d.m.Y') : null;
            $result['reg_number'] = $client->termination_consent->reg_num;
            $result['spouse_word_id'] = $client->termination_consent->spouse_word_id;
        }

        return $this->sendResponse($result, 'Дані по заяві-згоді на розірвання з боку клієнта з ID ' . $client_id);
    }

    public function update_termination($card_id, $client_id = null, Request $r)
    {
        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        $r['termination_consent_template_id'] = $r['consent_template_id'];
        unset($r['consent_template_id']);

        $validator = $this->validate_client_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        TerminationConsent::updateOrCreate(
            ['client_id' => $client_id],
            [
                'notary_id' => $r['notary_id'],
                'template_id' => $r['termination_consent_template_id'],
                'spouse_word_id' => $r['spouse_word_id'],
                'sign_date' => $r['reg_date'] ? $r['reg_date']->format('Y-m-d') : null,
                'reg_num' => $r['reg_number'],
            ]
        );

        return $this->sendResponse('', 'Дані для Заяви-згоди оновлено успішно.');
    }

    public function get_representative($card_id, $client_id)
    {
        $result = [];

        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }


        $convert_notary = [];
        $rakul_notary = Notary::where('rakul_company', true)->get();
        foreach ($rakul_notary as $key => $value) {
            $convert_notary[$key]['id'] = $value->id;
            $convert_notary[$key]['title'] = $this->convert->get_surname_and_initials_n($value);
        }

        $other_notary = [];
        $separate_by_card = Notary::where('separate_by_card', $card_id)->get();
        foreach ($separate_by_card as $key => $value) {
            $other_notary[$key]['id'] = $value->id;
            $other_notary[$key]['title'] = $this->convert->get_surname_and_initials_n($value);
        }

        $result['notary'] = array_merge($convert_notary, $other_notary);
        $result['notary_id'] = null;
        $result['reg_num'] = null;
        $result['reg_date'] = null;

        $representative = Representative::where('client_id', $client_id)->first();

        if ($representative) {
            $result['notary_id'] = $representative->notary_id;
            $result['reg_num'] = $representative->reg_num;
            $reg_date = \DateTime::createFromFormat('Y-m-d H:i:s', $representative->reg_date);
            $result['reg_date'] = $reg_date ? $reg_date->format('d.m.Y') : $reg_date;
        }

        return $this->sendResponse($result, 'Дані по довіреності клієнта з ID ' . $client_id);
    }

    public function update_representative($client_id, Request $r)
    {
        $result = [];

        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client_id . ' відсутній');
        }

        $validator = $this->validate_client_data($r);

        Representative::updateOrCreate(
            ['client_id' => $client_id],
            [
                'notary_id' => $r['notary_id'],
                'reg_num' => $r['reg_num'],
                'reg_date' => $r['reg_date']
            ]);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        return $this->sendResponse($result, 'Дані по довіреності клієнта з ID:' . $client_id . ' оновлено');
    }

    public function get_notaries($card_id)
    {
        $result = [];
        $separate_notary = [];

        $notary = Notary::where('separate_by_card', $card_id)->get();

        foreach ($notary as $key => $value) {
            $separate_notary[$key]['id'] = $value->id;
            $separate_notary[$key]['title'] = $this->convert->get_surname_and_initials_n($value);
            $separate_notary[$key]['list'] = $this->get_notary_list_info($value);
        }

        $result['notary'] = $separate_notary;

        return $this->sendResponse($result, 'Сторонні нотаріуси для картки з ID:' . $card_id);
    }

    public function get_notary($notary_id)
    {
        $result = [];
        $separate_notary = [];

        $notary = Notary::select(
            'surname_n',
            'name_n',
            'short_name',
            'patronymic_n',
            'short_patronymic',
            'surname_o',
            'name_o',
            'patronymic_o',
            'activity_n',
            'activity_o',
        )->where('id', $notary_id)->first();


        $result = $notary;

        return $this->sendResponse($result, 'Сторонні нотаріус з ID:' . $notary_id);
    }

    public function update_notary($card_id, $notary_id = null, Request $r)
    {
        $result = [];
        $validator = $this->validate_client_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        if ($notary_id) {
            Notary::where('id', $notary_id)->update(
                [
                    'surname_n' => $r['surname_n'],
                    'name_n' => $r['name_n'],
                    'short_name' => $r['short_name'],
                    'patronymic_n' => $r['patronymic_n'],
                    'short_patronymic' => $r['short_patronymic'],
                    'surname_o' => $r['surname_o'],
                    'name_o' => $r['name_o'],
                    'patronymic_o' => $r['patronymic_o'],
                    'activity_n' => $r['activity_n'],
                    'activity_o' => $r['activity_o'],
                    'separate_by_card' => $card_id,
                ]);

            $result['notary_id'] = $notary_id;
            return $this->sendResponse($result, 'Нотаріус з ID: ' . $notary_id . ' оноволено');
        } else {
            $notary = new Notary();
            $notary->surname_n = $r['surname_n'];
            $notary->name_n = $r['name_n'];
            $notary->short_name = $r['short_name'];
            $notary->patronymic_n = $r['patronymic_n'];
            $notary->short_patronymic = $r['short_patronymic'];
            $notary->surname_o = $r['surname_o'];
            $notary->name_o = $r['name_o'];
            $notary->patronymic_o = $r['patronymic_o'];
            $notary->activity_n = $r['activity_n'];
            $notary->activity_o = $r['activity_o'];
            $notary->separate_by_card = $card_id;
            $notary->save();

            $result['notary_id'] = $notary->id;
            return $this->sendResponse($result, 'Нотаріус з ID: ' . $notary->id . ' створено');
        }
    }

    private function get_client_by_card_id($card_id)
    {
        $result = [];

        $clients_id = Card::where('cards.id', $card_id)->where('clients.deleted_at', null)
            ->join('contracts',  'contracts.card_id', '=', 'cards.id')
            ->join('client_contract','client_contract.contract_id', '=', 'contracts.id' )
            ->join('clients','clients.id', '=', 'client_contract.client_id' )
            ->pluck('clients.id')->toArray();

        $clients = Client::whereIn('id', $clients_id)->get();

        foreach ($clients as $key => $client) {

            $result[$key]['client'] = [];
            $result[$key]['spouse'] = null;
            $result[$key]['representative'] = null;

            $result[$key]['client']['id'] = $client->id;
            $result[$key]['client']['full_name'] = $this->convert->get_full_name($client);
            $result[$key]['client']['list'] = $this->get_list($client);

            if ($client->married) {
                $result[$key]['spouse'] = [];
                $result[$key]['spouse']['id'] = $client->married->spouse->id;
                $result[$key]['spouse']['full_name'] = $this->convert->get_full_name($client->married->spouse);
                $result[$key]['spouse']['list'] = $this->get_list($client->married->spouse);
            }

            if ($client->representative && $client->representative->confidant) {
                $result[$key]['representative'] = [];
                $result[$key]['representative']['id'] = $client->representative->confidant_id;
                $result[$key]['representative']['full_name'] = $this->convert->get_full_name($client->representative->confidant);
                $result[$key]['representative']['list'] = $this->get_list($client->representative->confidant);
            }
        }

        return $result;
    }

    private function validate_client_data($r)
    {
        if (isset($r['date_of_birth']) && !empty($r['date_of_birth']))
            $r['date_of_birth'] = \DateTime::createFromFormat('d.m.Y H:i', $r['date_of_birth']);
        if (isset($r['passport_date']) && !empty($r['passport_date']))
            $r['passport_date'] = \DateTime::createFromFormat('d.m.Y H:i', $r['passport_date']);
        if (isset($r['passport_finale_date']) && !empty($r['passport_finale_date']))
            $r['passport_finale_date'] = \DateTime::createFromFormat('d.m.Y H:i', $r['passport_finale_date']);
        if (isset($r['mar_date']) && !empty($r['mar_date']))
            $r['mar_date'] = \DateTime::createFromFormat('d.m.Y H:i', $r['mar_date']);
        if (isset($r['sign_date']) && !empty($r['sign_date']))
            $r['sign_date'] = \DateTime::createFromFormat('d.m.Y H:i', $r['sign_date']);
        if (isset($r['reg_date']) && !empty($r['reg_date']))
            $r['reg_date'] = \DateTime::createFromFormat('d.m.Y H:i', $r['reg_date']);
        if (isset($r['widow_date']) && !empty($r['widow_date']))
            $r['widow_date'] = \DateTime::createFromFormat('d.m.Y H:i', $r['widow_date']);

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

            'region_id' => $r['region_id'],
            'district_id' =>  $r['district_id'],
            'city_type_id' =>  $r['city_type_id'],
            'title' =>  $r['title'],

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
            'reg_date' => $r['reg_date'] ? $r['reg_date']->format('Y.m.d.') : null,
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
            'passport_demographic_code' => ['string', 'nullable'],
            'passport_finale_date' => ['date_format:Y.m.d.', 'nullable'],

            'region_id' => ['numeric', 'nullable'],
            'district_id' => ['numeric', 'nullable'],
            'city_type_id' => ['numeric', 'nullable'],
            'title' => ['string', 'nullable'],

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
            'mar_reg_num' => ['string', 'nullable'],
            'sign_date' => ['date_format:Y.m.d.', 'nullable'],
            'reg_num' => ['numeric', 'nullable'],
            'reg_date' => ['date_format:Y.m.d.', 'nullable'],
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
            'sign_date.date_format' => 'Необхідно передати дату в форматі d.m.Y',
            'reg_num.numeric' => 'Необхідно передати в числовому форматі',
            'reg_date.date_format' => 'Необхідно передати дату в форматі d.m.Y',
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

        if (!isset($errors['termination_consent_template_id']) && isset($r['termination_consent_template_id']) && !empty($r['termination_consent_template_id'])) {
            if (!TerminationConsent::find($r['termination_consent_template_id'])) {
                $validator->getMessageBag()->add('termination_consent_template_id', 'Шаблон заяви-згоди розірвання по ID:' . $r['termination_consent_template_id'] . " відсутній");
            }
        }

        if (!isset($errors['marriage_type_id']) && isset($r['marriage_type_id']) && !empty($r['marriage_type_id'])) {
            if (!MarriageType::find($r['marriage_type_id'])) {
                $validator->getMessageBag()->add('marriage_type_id', 'Тип документу сімейного стану по ID:' . $r['marriage_type_id'] . " відсутній");
            }
        }

        return $validator;
    }

    public function get_notary_list_info($notary)
    {
        $list = [];

        $list[0] = 'Активність: ' . $notary->activity_n;

        return $list;
    }

    public function get_list($client)
    {
        if ($client->gender)
            $gender = KeyWord::where('key', 'gender_' . $client->gender)->value('title_n');
        else
            $gender = "-";
        $result = null;
        $result[] = "ID клієнта: " . $this->convert->get_id_in_pad_format($client->id);
        $result[] = 'Паспорт: ' . $client->passport_code;
        $result[] = 'ІПН: ' . $client->tax_code;
        $result[] = 'Cтать: ' . $gender;
        $result[] = $client->birth_date ? "Дата народження: " . $client->birth_date->format('d.m.Y') : null;
        $result[] = 'Телефон: ' . $client->phone;
        return $result;
    }
}
