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
use App\Models\DevCompany;
use App\Models\DeveloperBuilding;
use App\Models\DevFence;
use App\Models\Exchange;
use App\Models\FinalSignDate;
use App\Models\ImmFence;
use App\Models\Immovable;
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

        $cards = 10;
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
        $date = date('Y-m-d', strtotime( '+'.mt_rand(0,30).' days'));
        $time = Time::where('id', $this->time_id)->where('active', true)->value('time');
        $this->date_time = $date . ' ' .  $time;
        $this->dev_company_id = $this->get_rand_value($this->dev_companies);
        if ($this->dev_company_id) {
            $this->dev_representative_id = $this->get_rand_value(Client::where('dev_company_id', $this->dev_company_id)->where('type', 5)->pluck('id')->toArray());
            $this->dev_manager_id = $this->get_rand_value(Client::where('dev_company_id', $this->dev_company_id)->where('type', 6)->pluck('id')->toArray());
        }
        $this->staff_generator_id = $this->get_rand_value($this->staff_generators_id);
    }

    public function create_card()
    {
        if (!$card = Card::where('room_id', $this->room_id)->where('date_time', $this->date_time)->first()) {
            $card = new Card();
            $card->notary_id = $this->notary_id;
            $card->room_id = $this->room_id;
            $card->date_time = $this->date_time;
            $card->city_id = $this->city_id;
            $card->dev_company_id = $this->dev_company_id;
            $card->dev_representative_id = $this->dev_representative_id;
            $card->dev_manager_id = $this->dev_manager_id;
            $card->generator_step = rand(0,1);
            $card->staff_generator_id = $this->staff_generator_id;
            $card->ready = $this->ready;
            $card->cancelled = $this->cancelled;
            $card->save();
            $this->card_id = $card->id;
            return true;
        } else {
            return false;
        }

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
            $contract->template_id = $this->get_rand_value(ContractTemplate::where('developer_id', $this->dev_company_id)->pluck('id')->toArray());
            $contract->accompanying_id = $this->get_rand_value(User::where('accompanying', true)->pluck('id')->toArray());
            $contract->reader_id = $this->get_rand_value(User::where('accompanying', true)->pluck('id')->toArray());
            $contract->bank = rand(0, 1);
            $contract->proxy = rand(0, 1);
            $contract->sign_date = $this->date_time;
            $contract->ready = rand(0, 1);
            $contract->save();

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
        Client::where('dev_company_id', null)->delete();
        // client_investment_agreement
        ClientContract::truncate();
        ClientSpouseConsent::truncate();
        // client_spouse_consent_contract
        Contact::truncate();
        Contract::truncate();
        DevFence::truncate();
        Exchange::truncate();
        \App\Models\ExchangeRate::truncate();
        FinalSignDate::truncate();
        Immovable::truncate();
        ImmFence::truncate();
        PropertyValuationPrice::truncate();
        Questionnaire::truncate();
        Representative::truncate();
        SecurityPayment::truncate();
        DevFence::truncate();
    }
}