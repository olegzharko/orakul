<?php

namespace App\Http\Controllers;

use App\Models\Assistant;
use App\Models\Client;
use App\Models\ClientType;
use App\Models\ClientSpouse;
use App\Models\Contract;
use App\Models\Developer;
use App\Models\KeyWord;
use App\Models\Immovable;
use App\Models\ImmovableOwnership;
use App\Models\Notary;
use App\Models\PVPrice;
use App\Models\Template;
use App\Models\DayConvert;
use App\Models\MonthConvert;
use App\Models\YearConvert;
use App\Models\City;
use Doctrine\Inflector\Rules\Word;
use Illuminate\Support\Facades\Storage;

class ContractController extends GeneratorController
{
    public $word;
    public $consent;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_contract($id = null)
    {
        $this->contract_id = $id;

        $contract = $this->get_contract_by_id($id);
        $contract = $this->set_data_contract($contract);
        $contract = $this->convert_date_to_string($contract);

        return $contract;
    }


    public function get_contract_by_id($id = null)
    {
        $contract = Contract::select(
            'contracts.id',
            'contracts.template_id',
            'contracts.event_city_id',
            'contracts.immovable_id',
            'contracts.developer_id',
            'contracts.dev_sp_consents_id',
            'contracts.dev_sp_word_id',
            'contracts.assistant_id',
            'contracts.client_id',
            'contracts.notary_id',
            'contracts.pvprice_id',
            'contracts.cl_sp_consents_id',
            'contracts.cl_sp_word_id',
            'contracts.developer_statement_id',
            'contracts.questionnaire_id',
            'contracts.sign_date',
        );

        $contract = $contract->where(function ($query) use ($id) {
            if ($id)
                $query = $query->where('id', $id);
            else
                $query = $query->where('contracts.ready', 0);

            return $query;
        });

        if ( !$contract = $contract->first())
            dd('Return ERROR alert. There are no record in db');

        $contract->first();

        return $contract;
    }

    public function set_data_contract($contract)
    {
        $contract->immovable = Immovable::get_immovable($contract->immovable);
        $client_type_dev_owner =  ClientType::where('key', 'developer')->value('id');
        $contract->dev_company->owner = $contract->dev_company->member->where('type', $client_type_dev_owner)->first();
        $contract->dev_company->owner->full_address = $this->full_address($contract->dev_company->owner);
        $contract->dev_company->owner->fence = \App\Models\DevFence::where('developer_id', $contract->dev_company->owner->id)->first();
        $contract->immovable_ownership = ImmovableOwnership::get_immovable_ownership($contract->immovable->id);
        $contract->client->full_address = $this->full_address($contract->client);

        return $contract;
    }

    public function convert_date_to_string($contract)
    {
        $num_day = $contract->sign_date->format('d');
        $num_month = $contract->sign_date->format('m');
        $num_year = $contract->sign_date->format('Y');

        $contract->str_day = DayConvert::convert($num_day);
        $contract->str_month = MonthConvert::convert($num_month);
        $contract->str_year = YearConvert::convert($num_year);

        $num_day = $contract->client_spouse_consent->date->format('d');
        $num_month = $contract->client_spouse_consent->date->format('m');
        $num_year = $contract->client_spouse_consent->date->format('Y');

        $contract->client_spouse_consent->str_day = DayConvert::convert($num_day);
        $contract->client_spouse_consent->str_month = MonthConvert::convert($num_month);
        $contract->client_spouse_consent->str_year = YearConvert::convert($num_year);

        $num_day = $contract->developer_statement->date->format('d');
        $num_month = $contract->developer_statement->date->format('m');
        $num_year = $contract->developer_statement->date->format('Y');

        $contract->developer_statement->str_day = DayConvert::convert($num_day);
        $contract->developer_statement->str_month = MonthConvert::convert($num_month);
        $contract->developer_statement->str_year = YearConvert::convert($num_year);

        return $contract;
    }

    public static function full_address($c)
    {
        $region_type_short = trim(KeyWord::where('key', 'region')->value('short'));
        $region_title = trim($c->region->title_n);
        $city_type_short = trim($c->city_type->short);
        $city_title = trim($c->city->title_n);
        $address_type_short = trim($c->address_type->short);
        $address_title = trim($c->address);
        $building_type_short = trim(KeyWord::where('key', 'building')->value('short'));
        $building = trim($c->building);

        $apartment = $c->apartment ? ", " . trim(KeyWord::where('key', 'apartment')->value('short')) . " " . trim($c->apartment) : null;

        $full_address = "$region_title $region_type_short, $city_type_short $city_title $address_type_short $address_title $building_type_short $building" . "$apartment";
        $full_address = trim($full_address);

        return $full_address;
    }
}
