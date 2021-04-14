<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\AddressType;
use App\Models\ApartmentType;
use App\Models\BankAccountPayment;
use App\Models\BankTaxesPayment;
use App\Models\BuildingPermit;
use App\Models\BuildingType;
use App\Models\CardClient;
//use App\Models\CardContract;
use App\Models\ClientCheckList;
use App\Models\Client;
use App\Models\ClientContract;
use App\Models\ClientSpouseConsent;
use App\Models\Contact;
use App\Models\ContactType;
use App\Models\Contract;
use App\Models\ContractTemplate;
use App\Models\ContractType;
use App\Models\DevCompany;
use App\Models\DevCompanyEmployer;
use App\Models\DeveloperBuilding;
use App\Models\DevEmployerType;
use App\Models\DevFence;
use App\Models\Exchange;
use App\Models\FinalSignDate;
use App\Models\ImmFence;
use App\Models\Immovable;
use App\Models\ImmovableOwnership;
use App\Models\ImmovableType;
use App\Models\InvestmentAgreement;
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

class DeveloperController extends TestController
{
    public function __construct()
    {
        parent::__construct();
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
            $dev_owner->birth_date = rand(10, 30) . ".0" . rand(1, 9) . "19" . rand(70, 99);
            $dev_owner->gender = 'male';
            $dev_owner->citizenship_id = null;
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

            $dev_company_employer = new DevCompanyEmployer();
            $dev_company_employer->dev_company_id = $dev_company->id;
            $dev_company_employer->employer_id = $dev_owner->id;
            $dev_company_employer->type_id = DevEmployerType::where('type', 'developer')->value('id');
            $dev_company_employer->save();
        }
    }

    public function create_building()
    {
        $i = 0;
        while($i < 50) {

            $dev_company_id = $this->get_rand_value(DevCompany::where('active', true)->pluck('id')->toArray());
            $employer_type_dev = DevEmployerType::where('alias', 'developer')->value('id');
            $dev_company_owner_id = DevCompanyEmployer::where('dev_company_id', $dev_company_id)->where('type_id', $employer_type_dev)->value('employer_id');

            $investment_agrement = new InvestmentAgreement();
            $investment_agrement->dev_company_id = $dev_company_id;
            $investment_agrement->investor_id = $dev_company_owner_id;
            $investment_agrement->number = rand(2223344, 4445566);
            $investment_agrement->date = rand(10, 30) . ".0" . rand(1, 9) . "2020";;
            $investment_agrement->save();

            $client_investment_agrement = new ClientInvestmentAgreement();
            $client_investment_agrement->client_id = null;
            $client_investment_agrement->investment_agreement_id = $investment_agrement->id;
            $client_investment_agrement->save();

            $building = new DeveloperBuilding();
            $building->dev_company_id = $dev_company_id;
            $building->investment_agreement_id = $investment_agrement->id;
            $building->city_id = 1;
            $building->address_type_id = $this->get_rand_value(AddressType::pluck('id')->toArray());
            $building->title = $this->get_rand_value($this->arr_street);
            $building->number = rand(1, 50);
            $building->exploitation_date = "07.12.2021";
            $building->communal_date = "30.12.2021";
            $building->save();

            $building_permit = new BuildingPermit();
            $building_permit->developer_building_id = $building->id;
            $building_permit->resolution = "КЛ423344223";
            $building_permit->sign_date = "02.02.2020";
            $building_permit->organization = "Державною архітектурно-будівельною інспекцією України";
            $building_permit->save();

            $i++;
        }
    }

    public function create_developer_employer()
    {
        $i = 0;
        while ($i < 50)
        {
            $surname = $this->get_rand_value($this->arr_surname);
            $name = $this->get_rand_value($this->arr_name);
            $patronymic = $this->get_rand_value($this->arr_patronymic);

            $dev_employer = new Client();
            $dev_employer->type_id = rand(5, 6);
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
            $dev_employer->birth_date = rand(10, 30) . ".0" . rand(1, 9) . "19" . rand(70, 99);
            $dev_employer->gender = 'male';
            $dev_employer->citizenship_id = null;
            $dev_employer->spouse_id = null;
            $dev_employer->dev_company_id = $this->get_rand_value(DevCompany::where('active', true)->pluck('id')->toArray());
            $dev_employer->phone = "+38050" . rand(5555555, 9999999);
            $dev_employer->email = $this->random_string() . "@gmail.com";
            $dev_employer->tax_code = rand('2220000000', '3339999999');
            $dev_employer->passport_type_id = $this->get_rand_value(PassportTemplate::pluck('id')->toArray());
            $dev_employer->passport_code = $this->random_string(2) . rand(450000, 999999);
            $dev_employer->passport_date = rand(10, 30) . ".0" . rand(1, 9) . "200" . rand(1, 9);
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
}
