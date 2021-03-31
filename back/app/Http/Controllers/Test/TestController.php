<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\AddressType;
use App\Models\ApartmentType;
use App\Models\BankAccountPayment;
use App\Models\BankTaxesPayment;
use App\Models\BuildingType;
use App\Models\CardClient;
use App\Models\CardContract;
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
        $this->ready = rand(0, 1);
        $this->cancelled = rand(0, 1);

        $this->arr_surname = ['Жарко', 'Конріенко', 'Вознюк', 'Слободянюк', 'Гусейнов', 'Ізман', 'Кісільов'];
        $this->arr_name = ['Олег', 'Володимир', 'Дмитро', 'Петро', 'Даянат', 'Ілья', 'Вадим'];
        $this->arr_patronymic = ['Володимирович', 'Александрович', 'Сергійович', 'Андрійович', 'Алладинович', 'Вікторович', 'Михайлович'];
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

    public function test()
    {
        $card = null;
        $dev_company = null;
        $dev_representative_id = null;
        $dev_manager_id = null;
        $generator_step = null;
        $staff_generator_id	 = null;
        $ready = null;

        $cards = 50;
        while ($cards) {
            $this->arr_immovables_id = [];
            $this->arr_clients_id = [];
            $this->arr_contracts_id = [];
            $this->start_card();
            if ($this->create_card()) {
                $this->create_contacts();
                $this->create_immovable();
                $this->create_contract();
                $this->create_card_contract();
                $this->create_clients();
                $this->create_client_contract();
                $cards--;
            }
        }
    }

    public function start_card()
    {
        $this->notary_id = $this->get_rand_value($this->notaries_id);
        $this->room_id = $this->get_rand_value($this->rooms_id);
        $this->time_id = $this->get_rand_value($this->times_id);
        $this->date = date('Y-m-d', strtotime( '+'.mt_rand(0,3).' days'));
        $time = Time::where('id', $this->time_id)->where('active', true)->value('time');
        $this->date_time = $this->date . ' ' .  $time;
        $this->dev_company_id = $this->get_rand_value($this->dev_companies);
        if ($this->dev_company_id) {
            $this->dev_representative_id = $this->get_rand_value(Client::where('dev_company_id', $this->dev_company_id)->where('type', 5)->pluck('id')->toArray());
            $this->dev_manager_id = $this->get_rand_value(Client::where('dev_company_id', $this->dev_company_id)->where('type', 6)->pluck('id')->toArray());
        }
        $this->staff_generator_id = $this->get_rand_value($this->staff_generators_id);
    }

    public function create_card()
    {
        $i = 1; // количество комнат
        while($i <= 4) {
            if (!$card = Card::where('room_id', $i)->where('date_time', $this->date_time)->first()) {
                $card = new Card();
                $card->notary_id = $this->notary_id;
//                $card->room_id = $this->room_id;
                $card->room_id = $i;
                $card->date_time = $this->date_time;
                $card->city_id = $this->city_id;
                $card->dev_company_id = $this->dev_company_id;
                $card->dev_representative_id = $this->dev_representative_id;
                $card->dev_manager_id = $this->dev_manager_id;
                $card->generator_step = rand(0,1);
                $card->staff_generator_id = $this->staff_generator_id;
                $card->ready = $this->ready;
                $rand = rand(0, 5);
                $card->cancelled = $rand == 5 ? 1 : 0;
                $card->save();
                $this->card_id = $card->id;
                return true;
            }
            $i++;
        }
        return false;
    }


    public function create_immovable()
    {
        $length = rand(1, 2);


        while ($length--) {
            $immovable = new Immovable();
            $immovable->immovable_type_id = $this->get_rand_value($this->immovable_types_id);
            $immovable->proxy_id = null;
            $immovable->developer_building_id = $this->get_rand_value(DeveloperBuilding::where('dev_company_id', $this->dev_company_id)->pluck('id')->toArray());
            $immovable->immovable_number = rand(1, 1000);
            $immovable->registration_number = rand(242312311, 454455300);
            $immovable->grn = rand(1000000, 5000000);
            $immovable->dollar = null;;
            $immovable->reserve_grn = null;;
            $immovable->reserve_dollar = null;;
            $immovable->m2_grn = null;
            $immovable->m2_dollar = null;
            $immovable->roominess_id = null;
            $immovable->total_space = rand(45, 123);
            $immovable->living_space = null;
            $immovable->section = null;
            $immovable->floor = null;
            $immovable->save();

            $this->arr_immovables_id[] = $immovable->id;
        }
    }

    public function create_contacts()
    {
        $length = rand(0, 2);


        while ($length--) {
            $contacts = new Contact();
            $contacts->contact_type_id = $this->get_rand_value(ContactType::pluck('id')->toArray());
            $contacts->full_name = $this->get_rand_value($this->arr_surname) . " " . $this->get_rand_value($this->arr_name);
            $contacts->phone = "+38050" . rand(5555555, 9999999);
            $contacts->email = $this->random_string() . "@gmail.com";
            $contacts->card_id = $this->card_id;
            $contacts->save();
        }
    }

    public function create_card_contract()
    {
        foreach ($this->arr_contracts_id as $contract_id) {
            $card_contract = new CardContract();
            $card_contract->card_id = $this->card_id;
            $card_contract->contract_id = $contract_id;
            $card_contract->save();
        }
    }

    public function create_clients()
    {

        $length = rand(1, 2);

        while ($length--)
        {
            $client = new Client();
            $client->type = 1;
            $surname = $this->get_rand_value($this->arr_surname);
            $name = $this->get_rand_value($this->arr_name);
            $patronymic = $this->get_rand_value($this->arr_patronymic);
            $client->surname_n = $surname;
            $client->name_n = $name;
            $client->patronymic_n = $patronymic;
            $client->surname_r = $surname;
            $client->name_r = $name;
            $client->patronymic_r = $patronymic;
            $client->surname_d = $surname;
            $client->name_d = $name;
            $client->patronymic_d = $patronymic;
            $client->surname_o = $surname;
            $client->name_o = $name;
            $client->patronymic_o = $patronymic;
            $client->birthday = "13.04.1991";
            $client->gender = 'male';
            $client->citizenship_id = null;
            $client->spouse_id = null;
            $client->dev_company_id = null;
            $client->phone = "+38050" . rand(5555555, 9999999);
            $client->email = $this->random_string() . "@gmail.com";
            $client->tax_code = rand('2220000000', '3339999999');
            $client->passport_type_id = $this->get_rand_value(PassportTemplate::pluck('id')->toArray());
            $client->passport_code = $this->random_string(2) . rand(450000, 999999);
            $client->passport_date = "29.09.2007";
            $client->passport_finale_date = null;
            $client->passport_department = "Шевченківським РУ ГУ МВС України в місті Києві";
            $client->city_id = $this->get_rand_value(City::pluck('id')->toArray());
            $client->address_type_id = $this->get_rand_value(AddressType::pluck('id')->toArray());
            $client->address = "Ярослава Мудрого";
            $client->building_type_id = $this->get_rand_value(BuildingType::pluck('id')->toArray());
            $client->building = rand(1, 100);
            $client->apartment_type_id = $this->get_rand_value(ApartmentType::pluck('id')->toArray());
            $client->apartment_num = rand(1, 100);
            $client->save();

            $this->arr_clients_id[] = $client->id;
        }
    }

    public function create_client_contract()
    {
        foreach ($this->arr_contracts_id as $contract_id) {
            foreach($this->arr_clients_id as $client_id) {
                $card_client = new ClientContract();
                $card_client->contract_id = $contract_id;
                $card_client->client_id = $client_id;
                $card_client->save();
            }
        }
    }

    public function create_contract()
    {
        // ClientContract

        foreach ($this->arr_immovables_id as $immovable_id) {
            $contract = new Contract();
            $contract->immovable_id = $immovable_id;
            $contract->type_id = $this->get_rand_value(ContractType::pluck('id')->toArray());
            $contract->template_id = $this->get_rand_value(ContractTemplate::where('developer_id', $this->dev_company_id)->pluck('id')->toArray());
            $contract->accompanying_id = $this->get_rand_value(User::where('accompanying', true)->pluck('id')->toArray());
            $contract->reader_id = $this->get_rand_value(User::where('accompanying', true)->pluck('id')->toArray());
            $contract->bank = rand(0, 1);
            $contract->proxy = rand(0, 1);
            $contract->sign_date = $this->date_time;
            $contract->ready = rand(0, 1);
            $contract->save();

            if ($contract->ready) {
                if ($this->date ==  $this->currant_date->format('Y-m-d')) {

                    $dev_fence = new DevFence();
                    $dev_fence->dev_company_id = $this->dev_company_id;
                    $dev_fence->card_id = $this->card_id;
                    $dev_fence->pass = rand(0, 2);
                    $dev_fence->save();

                    $imm_fence = new ImmFence();
                    $imm_fence->immovable_id = $immovable_id;
                    $imm_fence->pass = rand(0, 2);
                    $imm_fence->save();
                }
            }

            $this->arr_contracts_id[] = $contract->id;
        }
    }

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

    function clear_table()
    {
        Card::truncate();
        BankAccountPayment::truncate();
        CardClient::truncate();
        CardContract::truncate();
        CheckList::truncate();
        Client::truncate();
        // client_investment_agreement
        ClientContract::truncate();
        ClientSpouseConsent::truncate();
        // client_spouse_consent_contract
        Contact::truncate();
        Contract::truncate();
        DevCompany::truncate();
        DevFence::truncate();
        DeveloperBuilding::truncate();
        Exchange::truncate();
        \App\Models\ExchangeRate::truncate();
        FinalSignDate::truncate();
        Immovable::truncate();
        ImmovableOwnership::truncate();
        ImmFence::truncate();
        PropertyValuationPrice::truncate();
        Questionnaire::truncate();
        Representative::truncate();
        SecurityPayment::truncate();
        DevFence::truncate();
    }

    public function dev_start_data()
    {
        $this->create_dev_company();
        $this->create_building();
        $this->create_developer_employer();
    }

    public function create_dev_company()
    {
        foreach ($this->arr_company as $key => $value) {

            $dev_company = new DevCompany();
            $dev_company->title = $value;
            $dev_company->color = $key;
            $dev_company->active = 1;
            $dev_company->save();

            $dev_owner = new Client();
            $dev_owner->type = 2; // owner type
            $surname = $this->get_rand_value($this->arr_surname);
            $name = $this->get_rand_value($this->arr_name);
            $patronymic = $this->get_rand_value($this->arr_patronymic);
            $dev_owner->surname_n = $surname;
            $dev_owner->name_n = $name;
            $dev_owner->patronymic_n = $patronymic;
            $dev_owner->surname_r = $surname;
            $dev_owner->name_r = $name;
            $dev_owner->patronymic_r = $patronymic;
            $dev_owner->surname_d = $surname;
            $dev_owner->name_d = $name;
            $dev_owner->patronymic_d = $patronymic;
            $dev_owner->surname_o = $surname;
            $dev_owner->name_o = $name;
            $dev_owner->patronymic_o = $patronymic;
            $dev_owner->birthday = "13.04.1991";
            $dev_owner->gender = 'male';
            $dev_owner->citizenship_id = null;
            $dev_owner->spouse_id = null;
            $dev_owner->dev_company_id = $dev_company->id;
            $dev_owner->phone = "+38050" . rand(5555555, 9999999);
            $dev_owner->email = $this->random_string() . "@gmail.com";
            $dev_owner->tax_code = rand('2220000000', '3339999999');
            $dev_owner->passport_type_id = $this->get_rand_value(PassportTemplate::pluck('id')->toArray());
            $dev_owner->passport_code = $this->random_string(2) . rand(450000, 999999);
            $dev_owner->passport_date = "29.09.2007";
            $dev_owner->passport_finale_date = null;
            $dev_owner->passport_department = "Шевченківським РУ ГУ МВС України в місті Києві";
            $dev_owner->city_id = $this->get_rand_value(City::pluck('id')->toArray());
            $dev_owner->address_type_id = $this->get_rand_value(AddressType::pluck('id')->toArray());
            $dev_owner->address = "Ярослава Мудрого";
            $dev_owner->building_type_id = $this->get_rand_value(BuildingType::pluck('id')->toArray());
            $dev_owner->building = rand(1, 100);
            $dev_owner->apartment_type_id = $this->get_rand_value(ApartmentType::pluck('id')->toArray());
            $dev_owner->apartment_num = rand(1, 100);
            $dev_owner->save();
        }
    }

    public function create_building()
    {
        $i = 0;
        while($i < 50) {
            $building = new DeveloperBuilding();
            $building->dev_company_id = $this->get_rand_value(DevCompany::where('active', true)->pluck('id')->toArray());
            $building->city_id = 1;
            $building->address_type_id = $this->get_rand_value(AddressType::pluck('id')->toArray());
            $building->title = $this->get_rand_value($this->arr_street);
            $building->number = rand(1, 50);
            $building->save();
            $i++;
        }
    }

    public function create_developer_employer()
    {
        $i = 0;
        while ($i < 50)
        {
            $dev_employer = new Client();
            $dev_employer->type = rand(5, 6);
            $surname = $this->get_rand_value($this->arr_surname);
            $name = $this->get_rand_value($this->arr_name);
            $patronymic = $this->get_rand_value($this->arr_patronymic);
            $dev_employer->surname_n = $surname;
            $dev_employer->name_n = $name;
            $dev_employer->patronymic_n = $patronymic;
            $dev_employer->surname_r = $surname;
            $dev_employer->name_r = $name;
            $dev_employer->patronymic_r = $patronymic;
            $dev_employer->surname_d = $surname;
            $dev_employer->name_d = $name;
            $dev_employer->patronymic_d = $patronymic;
            $dev_employer->surname_o = $surname;
            $dev_employer->name_o = $name;
            $dev_employer->patronymic_o = $patronymic;
            $dev_employer->birthday = "13.04.1991";
            $dev_employer->gender = 'male';
            $dev_employer->citizenship_id = null;
            $dev_employer->spouse_id = null;
            $dev_employer->dev_company_id = $this->get_rand_value(DevCompany::where('active', true)->pluck('id')->toArray());
            $dev_employer->phone = "+38050" . rand(5555555, 9999999);
            $dev_employer->email = $this->random_string() . "@gmail.com";
            $dev_employer->tax_code = rand('2220000000', '3339999999');
            $dev_employer->passport_type_id = $this->get_rand_value(PassportTemplate::pluck('id')->toArray());
            $dev_employer->passport_code = $this->random_string(2) . rand(450000, 999999);
            $dev_employer->passport_date = "29.09.2007";
            $dev_employer->passport_finale_date = null;
            $dev_employer->passport_department = "Шевченківським РУ ГУ МВС України в місті Києві";
            $dev_employer->city_id = $this->get_rand_value(City::pluck('id')->toArray());
            $dev_employer->address_type_id = $this->get_rand_value(AddressType::pluck('id')->toArray());
            $dev_employer->address = "Ярослава Мудрого";
            $dev_employer->building_type_id = $this->get_rand_value(BuildingType::pluck('id')->toArray());
            $dev_employer->building = rand(1, 100);
            $dev_employer->apartment_type_id = $this->get_rand_value(ApartmentType::pluck('id')->toArray());
            $dev_employer->apartment_num = rand(1, 100);
            $dev_employer->save();

            $i++;
        }
    }

    public function check_sql()
    {
        $cards = \DB::table('cards')->select(
                    'cards.id',
                    'cards.notary_id',
                    'cards.room_id',
                    'cards.date_time',
                    'cards.dev_company_id',
                    'cards.dev_representative_id',
                    'cards.dev_manager_id',
                    'cards.generator_step',
                    'cards.staff_generator_id',
                    'cards.ready',
                    'cards.cancelled',
                    'contracts.immovable_id',
                    'contracts.accompanying_id',
                    'contracts.reader_id',
                    'contracts.bank',
                    'contracts.proxy',
                    'contracts.sign_date',
                    'contracts.type_id',
                    'clients.surname_n',
                    'clients.name_n',
                    'clients.patronymic_n',
                )
                ->where('cards.id', 190)
                ->join('card_contract', 'card_contract.card_id', '=', 'cards.id')
                ->join('contracts', 'contracts.id', '=', 'card_contract.contract_id')
                ->join('client_contract', 'client_contract.contract_id', '=', 'contracts.id')
                ->join('clients', 'clients.id', '=', 'client_contract.client_id')
                ->toSql();
        dd($cards);
        \DB::enableQueryLog();
        dd(\DB::getQueryLog());
        dd($cards, \DB::getQueryLog());
    }
}
