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
use App\Models\ClientSpouseConsentContract;
use App\Models\Contact;
use App\Models\ContactType;
use App\Models\Contract;
use App\Models\ContractTemplate;
use App\Models\ContractType;
use App\Models\DevCompany;
use App\Models\DeveloperBuilding;
use App\Models\DeveloperStatement;
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
use App\Models\ExchangeRate;
use App\Models\PassportTemplate;
use App\Models\PropertyValuationPrice;
use App\Models\Questionnaire;
use App\Models\Representative;
use App\Models\Room;
use App\Models\SecurityPayment;
use App\Models\Spouse;
use App\Models\Time;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;

class ClearController  extends TestController
{
    public function __construct()
    {
        parent::__construct();
    }

     public function clear_table()
    {

        Card::truncate();
        BankAccountPayment::truncate();
        CheckList::truncate();
        InvestmentAgreement::truncate();
        ClientInvestmentAgreement::truncate();
        ClientContract::truncate();
        Spouse::truncate();
        Client::where('id' , '>', 30)->delete();
        ClientSpouseConsent::truncate();
        ClientSpouseConsentContract::truncate();
        ClientContract::truncate();
        Contact::truncate();
        Contract::truncate();
        DevFence::truncate();
        Exchange::truncate();
        ExchangeRate::truncate();
        FinalSignDate::truncate();
        Immovable::truncate();
        ImmovableOwnership::truncate();
        ImmFence::truncate();
        PropertyValuationPrice::truncate();
        Questionnaire::truncate();
        Representative::truncate();
        SecurityPayment::truncate();
        Spouse::truncate();
        Representative::truncate();
        DeveloperStatement::truncate();
        BankAccountPayment::truncate();
        BankTaxesPayment::truncate();
    }
}
