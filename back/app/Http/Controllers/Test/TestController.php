<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\AddressType;
use App\Models\ApartmentType;
use App\Models\BankAccountPayment;
use App\Models\BankTaxesPayment;
use App\Models\BuildingType;
use App\Models\CardClient;
//use App\Models\CardContract;
use App\Models\CheckList;
use App\Models\Client;
use App\Models\ClientContract;
use App\Models\ClientSpouseConsent;
use App\Models\Contact;
use App\Models\ContactType;
use App\Models\Contract;
use App\Models\ContractTemplate;
use App\Models\ContractType;
use App\Models\DevCompany;
use App\Models\DeveloperBuilding;
use App\Models\DevFence;
use App\Models\Exchange;
use App\Models\FinalSignDate;
use App\Models\ImmFence;
use App\Models\Immovable;
use App\Models\ImmovableOwnership;
use App\Models\ImmovableType;
use App\Models\Notary;
use App\Models\Card;
use App\Models\PassportTemplate;
use App\Models\PropertyValuationPrice;
use App\Models\Questionnaire;
use App\Models\Representative;
use App\Models\Room;
use App\Models\SecurityPayment;
use App\Models\Time;
use App\Models\City;
use App\Models\User;
use App\Nova\ExchangeRate;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public $notaries_id;
    public $notary_id;
    public $rooms_id;
    public $room_id;
    public $times_id;
    public $time_id;
    public $date_time;
    public $dev_companies;
    public $dev_company;
    public $dev_representatives_id;
    public $dev_representative_id;
    public $dev_managers_id;
    public $dev_manager_id;
    public $generator_step;
    public $staff_generators_id;
    public $staff_generator_id;
    public $ready;
    public $cancelled;
    public $card_id;

    public $city;

    public $immovable_types_id;
    public $immovable_type_id;
    public $proxy_id;
    public $developer_buildings_id;
    public $developer_building_id;
    public $immovable_number;
    public $registration_number;
    public $grn;
    public $dollar;
    public $reserve_grn;
    public $reserve_dollar;
    public $m2_grn;
    public $m2_dollar;
    public $roominess_id;
    public $total_space;
    public $living_space;
    public $section;
    public $floor;
    public $immovable_id;

    public $arr_immovables_id;
    public $arr_clients_id;
    public $arr_contracts_id;
    public $exchange_rate;

    public function __construct()
    {
        $this->currant_date = new \DateTime();
        $this->notaries_id = Notary::where('rakul_company', true)->pluck('id')->toArray();
        $this->dev_companies = DevCompany::pluck('id')->toArray();
        $this->rooms_id = Room::pluck('id')->toArray();
        $this->times_id = Time::where('active', true)->pluck('id')->toArray();
        $this->city_id = 1;
        $this->generator_step = rand(0, 1);
        $this->staff_generators_id = User::where('generator', true)->pluck('id')->toArray();
//        $this->ready = rand(0, 1);
        $this->cancelled = rand(0, 1);
        $this->exchange_rate = "2787";

        $this->arr_surname = ['Жарко', 'Конріенко', 'Вознюк', 'Слободянюк', 'Гусейнов', 'Ізман', 'Кісільов'];
        $this->arr_name = ['Олег', 'Володимир', 'Дмитро', 'Петро', 'Даянат', 'Ілья', 'Вадим'];
        $this->arr_female_name = ['Ольга', 'Катерина', 'Марина', 'Оксана', 'Анастасія', 'Вікторія', 'Яна'];
        $this->arr_patronymic = ['Володимирович', 'Александрович', 'Сергійович', 'Андрійович', 'Алладинович', 'Вікторович', 'Михайлович'];
        $this->arr_female_patronymic = ['Володимирівна', 'Александрівна', 'Сергіївна', 'Андріївна', 'Алладіновна', 'Вікторівна', 'Михайлівна'];
        $this->arr_street = ['Волокова', 'Амосова', 'Шевченко', 'Южна', 'Київська', 'Перемоги', 'Лесі Українки', 'Ломоносова', 'Берза', 'Зелена', 'Шмиго'];
        $this->arr_company = [
            '#BF4040' => 'ЖК Львів',
            '#BF8240' => 'ЖК SkyPark',
            '#BBBF40' => 'УкрБуд',
            '#2D862E' => 'КАН',
            '#40B2BF' => 'КиївБуд',
            '#4041BF' => 'Taryan Comapny',
        ];

        $this->immovable_types_id = ImmovableType::pluck('id')->toArray();

        $this->arr_immovables_id = [];
        $this->arr_clients_id = [];
        $this->arr_contracts_id = [];
    }
//

    public function get_rand_value($array)
    {
        $value = null;

        if ($array) {
            $key = array_rand($array);
            $value = $array[$key];
        }

        return $value;
    }

    function random_string($length = null)
    {
        if ($length == null)
            $length = rand(5, 8);
//        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

//    function clear_table()
//    {
//        Card::truncate();
//        BankAccountPayment::truncate();
//        CardClient::truncate();
////        CardContract::truncate();
//        CheckList::truncate();
//        Client::truncate();
//        // client_investment_agreement
//        ClientContract::truncate();
//        ClientSpouseConsent::truncate();
//        // client_spouse_consent_contract
//        Contact::truncate();
//        Contract::truncate();
//        DevCompany::truncate();
//        DevFence::truncate();
//        DeveloperBuilding::truncate();
//        Exchange::truncate();
//        \App\Models\ExchangeRate::truncate();
//        FinalSignDate::truncate();
//        Immovable::truncate();
//        ImmovableOwnership::truncate();
//        ImmFence::truncate();
//        PropertyValuationPrice::truncate();
//        Questionnaire::truncate();
//        Representative::truncate();
//        SecurityPayment::truncate();
//        DevFence::truncate();
//    }

//    public function dev_start_data()
//    {
//        $this->create_dev_company();
//        $this->create_building();
//        $this->create_developer_employer();
//    }
//
//    public function create_dev_company()
//    {
//        foreach ($this->arr_company as $key => $value) {
//
//            $dev_company = new DevCompany();
//            $dev_company->title = $value;
//            $dev_company->color = $key;
//            $dev_company->active = 1;
//            $dev_company->save();
//
//            $dev_owner = new Client();
//            $dev_owner->type_id = 2; // owner type
//            $surname = $this->get_rand_value($this->arr_surname);
//            $name = $this->get_rand_value($this->arr_name);
//            $patronymic = $this->get_rand_value($this->arr_patronymic);
//            $dev_owner->surname_n = $surname;
//            $dev_owner->name_n = $name;
//            $dev_owner->patronymic_n = $patronymic;
//            $dev_owner->surname_r = $surname;
//            $dev_owner->name_r = $name;
//            $dev_owner->patronymic_r = $patronymic;
//            $dev_owner->surname_d = $surname;
//            $dev_owner->name_d = $name;
//            $dev_owner->patronymic_d = $patronymic;
//            $dev_owner->surname_o = $surname;
//            $dev_owner->name_o = $name;
//            $dev_owner->patronymic_o = $patronymic;
//            $dev_owner->birth_date = "13.04.1991";
//            $dev_owner->gender = 'male';
//            $dev_owner->citizenship_id = null;
//            $dev_owner->spouse_id = null;
//            $dev_owner->dev_company_id = $dev_company->id;
//            $dev_owner->phone = "+38050" . rand(5555555, 9999999);
//            $dev_owner->email = $this->random_string() . "@gmail.com";
//            $dev_owner->tax_code = rand('2220000000', '3339999999');
//            $dev_owner->passport_type_id = $this->get_rand_value(PassportTemplate::pluck('id')->toArray());
//            $dev_owner->passport_code = $this->random_string(2) . rand(450000, 999999);
//            $dev_owner->passport_date = "29.09.2007";
//            $dev_owner->passport_finale_date = null;
//            $dev_owner->passport_department = "Шевченківським РУ ГУ МВС України в місті Києві";
//            $dev_owner->city_id = $this->get_rand_value(City::pluck('id')->toArray());
//            $dev_owner->address_type_id = $this->get_rand_value(AddressType::pluck('id')->toArray());
//            $dev_owner->address = "Ярослава Мудрого";
//            $dev_owner->building_type_id = $this->get_rand_value(BuildingType::pluck('id')->toArray());
//            $dev_owner->building = rand(1, 100);
//            $dev_owner->apartment_type_id = $this->get_rand_value(ApartmentType::pluck('id')->toArray());
//            $dev_owner->apartment_num = rand(1, 100);
//            $dev_owner->save();
//        }
//    }
//
//    public function create_building()
//    {
//        $i = 0;
//        while($i < 50) {
//            $building = new DeveloperBuilding();
//            $building->dev_company_id = $this->get_rand_value(DevCompany::where('active', true)->pluck('id')->toArray());
//            $building->city_id = 1;
//            $building->address_type_id = $this->get_rand_value(AddressType::pluck('id')->toArray());
//            $building->title = $this->get_rand_value($this->arr_street);
//            $building->number = rand(1, 50);
//            $building->save();
//            $i++;
//        }
//    }
//
//    public function create_developer_employer()
//    {
//        $i = 0;
//        while ($i < 50)
//        {
//            $dev_employer = new Client();
//            $dev_employer->type_id = rand(5, 6);
//            $surname = $this->get_rand_value($this->arr_surname);
//            $name = $this->get_rand_value($this->arr_name);
//            $patronymic = $this->get_rand_value($this->arr_patronymic);
//            $dev_employer->surname_n = $surname;
//            $dev_employer->name_n = $name;
//            $dev_employer->patronymic_n = $patronymic;
//            $dev_employer->surname_r = $surname;
//            $dev_employer->name_r = $name;
//            $dev_employer->patronymic_r = $patronymic;
//            $dev_employer->surname_d = $surname;
//            $dev_employer->name_d = $name;
//            $dev_employer->patronymic_d = $patronymic;
//            $dev_employer->surname_o = $surname;
//            $dev_employer->name_o = $name;
//            $dev_employer->patronymic_o = $patronymic;
//            $dev_employer->birth_date = "13.04.1991";
//            $dev_employer->gender = 'male';
//            $dev_employer->citizenship_id = null;
//            $dev_employer->spouse_id = null;
//            $dev_employer->dev_company_id = $this->get_rand_value(DevCompany::where('active', true)->pluck('id')->toArray());
//            $dev_employer->phone = "+38050" . rand(5555555, 9999999);
//            $dev_employer->email = $this->random_string() . "@gmail.com";
//            $dev_employer->tax_code = rand('2220000000', '3339999999');
//            $dev_employer->passport_type_id = $this->get_rand_value(PassportTemplate::pluck('id')->toArray());
//            $dev_employer->passport_code = $this->random_string(2) . rand(450000, 999999);
//            $dev_employer->passport_date = "29.09.2007";
//            $dev_employer->passport_finale_date = null;
//            $dev_employer->passport_department = "Шевченківським РУ ГУ МВС України в місті Києві";
//            $dev_employer->city_id = $this->get_rand_value(City::pluck('id')->toArray());
//            $dev_employer->address_type_id = $this->get_rand_value(AddressType::pluck('id')->toArray());
//            $dev_employer->address = "Ярослава Мудрого";
//            $dev_employer->building_type_id = $this->get_rand_value(BuildingType::pluck('id')->toArray());
//            $dev_employer->building = rand(1, 100);
//            $dev_employer->apartment_type_id = $this->get_rand_value(ApartmentType::pluck('id')->toArray());
//            $dev_employer->apartment_num = rand(1, 100);
//            $dev_employer->save();
//
//            $i++;
//        }
//    }
}
