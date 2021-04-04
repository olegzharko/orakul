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
use App\Models\ClientInvestmentAgreement;
use App\Models\ClientSpouseConsent;
use App\Models\ClientType;
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
use App\Models\PropertyValuation;
use App\Models\PropertyValuationPrice;
use App\Models\Questionnaire;
use App\Models\Representative;
use App\Models\Room;
use App\Models\SecurityPayment;
use App\Models\Spouse;
use App\Models\Time;
use App\Models\City;
use App\Models\User;
use App\Nova\ExchangeRate;
use Illuminate\Http\Request;

class ContractController extends TestController
{
    public function __construct()
    {
        parent::__construct();
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
        $this->date = date('Y-m-d', strtotime( '+'.mt_rand(0,30).' days'));
        $time = Time::where('id', $this->time_id)->where('active', true)->value('time');
        $this->date_time = $this->date . ' ' .  $time;
        $this->dev_company_id = $this->get_rand_value($this->dev_companies);
        if ($this->dev_company_id) {
            $this->dev_representative_id = $this->get_rand_value(Client::where('dev_company_id', $this->dev_company_id)->where('type_id', 5)->pluck('id')->toArray());
            $this->dev_manager_id = $this->get_rand_value(Client::where('dev_company_id', $this->dev_company_id)->where('type_id', 6)->pluck('id')->toArray());
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

    public function create_clients()
    {
        $length = rand(1, 2);

        while ($length--)
        {
            $surname = $this->get_rand_value($this->arr_surname);
            $name = $this->get_rand_value($this->arr_name);
            $patronymic = $this->get_rand_value($this->arr_patronymic);

            $client = new Client();
            $client->type_id = ClientType::where('key', 'customer')->value('id');
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
            $client->birth_date = rand(10, 30) . ".0" . rand(1, 9) . "19" . rand(70, 99);
            $client->gender = 'male';
            $client->citizenship_id = null;
            $client->spouse_id = null;
            $client->dev_company_id = null;
            $client->phone = "+38050" . rand(5555555, 9999999);
            $client->email = $this->random_string() . "@gmail.com";
            $client->tax_code = rand('2220000000', '3339999999');
            $client->passport_type_id = $this->get_rand_value(PassportTemplate::pluck('id')->toArray());
            $client->passport_code = $this->random_string(2) . rand(450000, 999999);
            $client->passport_date =  rand(10, 30) . ".0" . rand(1, 9) . "200" . rand(1, 9);
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


            $spouse_access = $client->id % 5;
            if ($spouse_access == 0) {

                $name = $this->get_rand_value($this->arr_female_name);
                $patronymic = $this->get_rand_value($this->arr_female_patronymic);

                $spouse = new Client();
                $spouse->type_id = ClientType::where('key', 'spouse')->value('id');
                $spouse->surname_n = $surname;
                $spouse->name_n = $name;
                $spouse->patronymic_n = $patronymic;
                $spouse->surname_r = $surname;
                $spouse->name_r = $name;
                $spouse->patronymic_r = $patronymic;
                $spouse->surname_d = $surname;
                $spouse->name_d = $name;
                $spouse->patronymic_d = $patronymic;
                $spouse->surname_o = $surname;
                $spouse->name_o = $name;
                $spouse->patronymic_o = $patronymic;
                $spouse->birth_date = rand(10, 30) . ".0" . rand(1, 9) . "19" . rand(70, 99);
                $spouse->gender = 'male';
                $spouse->citizenship_id = null;
                $spouse->spouse_id = $client->id;
                $spouse->dev_company_id = null;
                $spouse->phone = "+38050" . rand(5555555, 9999999);
                $spouse->email = $this->random_string() . "@gmail.com";
                $spouse->tax_code = rand('2220000000', '3339999999');
                $spouse->passport_type_id = $this->get_rand_value(PassportTemplate::pluck('id')->toArray());
                $spouse->passport_code = $this->random_string(2) . rand(450000, 999999);
                $spouse->passport_date = rand(10, 30) . ".0" . rand(1, 9) . "200" . rand(1, 9);
                $spouse->passport_finale_date = null;
                $spouse->passport_department = "Шевченківським РУ ГУ МВС України в місті Києві";
                $spouse->city_id = $this->get_rand_value(City::pluck('id')->toArray());
                $spouse->address_type_id = $this->get_rand_value(AddressType::pluck('id')->toArray());
                $spouse->address = "Ярослава Мудрого";
                $spouse->building_type_id = $this->get_rand_value(BuildingType::pluck('id')->toArray());
                $spouse->building = rand(1, 100);
                $spouse->apartment_type_id = $this->get_rand_value(ApartmentType::pluck('id')->toArray());
                $spouse->apartment_num = rand(1, 100);
                $spouse->save();

                $client_spouse = new Spouse();
                $client_spouse->client_id = $client->id;
                $client_spouse->spouse_id = $spouse->id;
                $client_spouse->save();

                Client::where('id', $client->id)->update([
                   'spouse_id' => $client->id,
                ]);
            }

            $representative_access = $client->id % 7;
            if ($representative_access == 0) {

                $surname = $this->get_rand_value($this->arr_surname);
                $name = $this->get_rand_value($this->arr_female_name);
                $patronymic = $this->get_rand_value($this->arr_female_patronymic);

                $representative = new Client();
                $representative->type_id = ClientType::where('key', 'spouse')->value('id');
                $representative->surname_n = $surname;
                $representative->name_n = $name;
                $representative->patronymic_n = $patronymic;
                $representative->surname_r = $surname;
                $representative->name_r = $name;
                $representative->patronymic_r = $patronymic;
                $representative->surname_d = $surname;
                $representative->name_d = $name;
                $representative->patronymic_d = $patronymic;
                $representative->surname_o = $surname;
                $representative->name_o = $name;
                $representative->patronymic_o = $patronymic;
                $representative->birth_date = rand(10, 30) . ".0" . rand(1, 9) . "19" . rand(70, 99);
                $representative->gender = 'male';
                $representative->citizenship_id = null;
                $representative->spouse_id = $client->id;
                $representative->dev_company_id = null;
                $representative->phone = "+38050" . rand(5555555, 9999999);
                $representative->email = $this->random_string() . "@gmail.com";
                $representative->tax_code = rand('2220000000', '3339999999');
                $representative->passport_type_id = $this->get_rand_value(PassportTemplate::pluck('id')->toArray());
                $representative->passport_code = $this->random_string(2) . rand(450000, 999999);
                $representative->passport_date = rand(10, 30) . ".0" . rand(1, 9) . "200" . rand(1, 9);
                $representative->passport_finale_date = null;
                $representative->passport_department = "Шевченківським РУ ГУ МВС України в місті Києві";
                $representative->city_id = $this->get_rand_value(City::pluck('id')->toArray());
                $representative->address_type_id = $this->get_rand_value(AddressType::pluck('id')->toArray());
                $representative->address = "Ярослава Мудрого";
                $representative->building_type_id = $this->get_rand_value(BuildingType::pluck('id')->toArray());
                $representative->building = rand(1, 100);
                $representative->apartment_type_id = $this->get_rand_value(ApartmentType::pluck('id')->toArray());
                $representative->apartment_num = rand(1, 100);
                $representative->save();

                $confidant = new Representative();
                $confidant->client_id = $client->id;
                $confidant->confidant_id = $representative->id;
                $confidant->notary_id = $this->notary_id;
                $confidant->reg_num = rand(1000, 9999);
                $confidant->reg_date = new \DateTime();
                $confidant->save();
            }


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
            $contract->card_id = $this->card_id;
            $contract->sign_date = $this->date_time;
            $contract->ready = rand(0, 1);
            $contract->save();


            $exchange = new Exchange();
            $exchange->rate = "27." . rand(20, 90);
            $exchange->save();

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

                    $immovable_ownership = new ImmovableOwnership();
                    $immovable_ownership->immovable_id = $immovable_id;
                    $immovable_ownership->gov_reg_number = rand(200000000, 500000000);
                    $immovable_ownership->gov_reg_date = rand(10, 30) . ".0" . rand(1, 9) . "2020";
                    $immovable_ownership->discharge_number = rand(200000000, 500000000);
                    $immovable_ownership->discharge_date = rand(10, 30) . ".0" . rand(1, 9) . "2020";
                    $immovable_ownership->save();

                    $exchange_rate = new \App\Models\ExchangeRate();
                    $exchange_rate->immovable_id = $immovable_id;
                    $exchange_rate->rate = $exchange->rate;
                    $exchange_rate->save();

                    $property_valuation_prices = new PropertyValuationPrice();
                    $property_valuation_prices->immovable_id = $immovable_id;
                    $property_valuation_prices->property_valuation_id = $this->get_rand_value(PropertyValuation::pluck('id')->toArray());
                    $property_valuation_prices->date = $contract->sign_date;
                    $property_valuation_prices->grn = rand(500000000, 800000000);
                    $property_valuation_prices->save();
                }
            }

            if ($contract->type_id == 2) {
                $final_sign_date = new FinalSignDate();
                $final_sign_date->contract_id = $contract->id;
                $final_sign_date->sign_date = date('Y-m-d', strtotime( '+'.mt_rand(180,270).' days'));;
                $final_sign_date->save();
            }

            $this->arr_contracts_id[] = $contract->id;
        }
    }
}
