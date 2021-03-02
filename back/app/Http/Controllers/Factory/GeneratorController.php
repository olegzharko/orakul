<?php

namespace App\Http\Controllers\Factory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ApartmentType;
use App\Models\Client;
use App\Models\ClientContract;
use App\Models\ClientType;
use App\Models\Contract;
use App\Models\DayConvert;
use App\Models\GenderWord;
use App\Models\ImmFence;
use App\Models\Immovable;
use App\Models\ImmovableOwnership;
use App\Models\KeyWord;
use App\Models\MonthConvert;
use App\Models\NumericConvert;
use App\Models\YearConvert;

class GeneratorController extends Controller
{
    public $word;
    public $client;
    public $contract;
    public $pack_contract;
    public $consents_id;
    public $convert;

    public function __construct()
    {
        $this->word = null;
        $this->client = null;
        $this->contract = null;
        $this->pack_contract = null;
        $this->consents_id = [];
        $this->convert = new ConvertController();
    }

    public function creat_contract(Request $request)
    {
        $client_id = $request->get('user_id');

        $this->client = Client::find($client_id);
        if ($this->client) {
            $this->pack_contract = $this->get_contract_by_client_id($client_id);

            if ($this->pack_contract) {

                // Підготувати данні до обробки
                foreach ($this->pack_contract as $key => $this->contract) {
                    if (count($this->contract->client_spouse_consent)) {
                        $this->consents_id = array_unique(array_merge($this->consents_id, $this->contract->client_spouse_consent->pluck('id')->toArray()));
                    }
                    $this->pack_contract[$key]->contract = $this->set_data_contract();
                }

                $this->word = new DocumentController($this->client, $this->pack_contract, $this->consents_id);
                $this->word->creat_files();
            } else {
                dd("Warning: There are no new deal for user: $client_id!");
            }
        } else {
            dd("Warning: There are no user_id: $client_id!");
        }
    }

    public function get_contract_by_client_id($client_id = null)
    {
        $contracts_id = ClientContract::where('client_id', $client_id)->pluck('contract_id');
        $contract = Contract::select(
            'contracts.id',
            'contracts.event_datetime',
            'contracts.contract_template_id',
            'contracts.event_city_id',
            'contracts.immovable_id',
            'contracts.dev_company_id',
            'contracts.dev_representative_id',
//            'contracts.client_id',
            'contracts.notary_id',
            'contracts.sign_date',
        );

        $contract = $contract->where(function ($query) use ($client_id, $contracts_id) {
            if ($client_id)
                $query = $query->whereIn('id', $contracts_id);
            else
                $query = $query->where('contracts.ready', false); // 0

            return $query;
        });

        $contract = $contract->get();
        if ( !$contract)
            dd('Return ERROR alert. There are no record in db');

        $contract->sortBy('id');

        return $contract;
    }

    public static function full_address($c)
    {
        $region = null;
        $region_type_short = null;
        $region_title = null;

        $district = null;
        $district_type_short = null;
        $district_title = null;

        $city = null;
        $city_type_short = null;
        $city_title = null;

        $address = null;
        $address_type_short = null;
        $address_title = null;

        $building_type_short = null;
        $building_num = null;
        $building = null;


        if ($c->city->region) {
            $region_type_short = trim(KeyWord::where('key', 'region')->value('title_n'));
            $region_title = trim($c->city->region->title_n);
            $region = "$region_title $region_type_short, ";
        }

        if ($c->city->district) {
            $district_type_short = trim(KeyWord::where('key', 'district')->value('title_n'));
            $district_title = trim($c->city->district->title_n);
            $district = "$district_title $district_type_short, ";
        }



        if ($c->city && $c->city->city_type) {
            $city_type_short = trim($c->city->city_type->short);
            $city_title = trim($c->city->title);
            $city = "$city_type_short $city_title, ";
        }

        if ($c->address && $c->address_type->short && $c->building ) {
            $address_title = trim($c->address);
            $address_type_short = trim($c->address_type->short);
            $address = "$address_type_short $address_title, ";

            $building_type_short = trim(KeyWord::where('key', 'building')->value('short'));
            $building_num = trim($c->building);

            $apartment_full = $c->apartment_num ? ", " . trim(ApartmentType::where('id', $c->apartment_type_id)->value('short')) . " " . trim($c->apartment_num) : null;

            $building = "$building_type_short $building_num" . "$apartment_full";
        }


        $full_address = ""
            . "$region"
            . "$district"
            . "$city"
            . "$address"
            . "$building";
        $full_address = trim($full_address);

        return $full_address;
    }

    public function notification($type, $message)
    {
        if ($type == "Warning") {
            echo "{$message}<br>";
        }
    }

    public function set_data_contract()
    {
        // Отримати тип клієнта - забудовник
        $client_type_dev_owner = ClientType::where('key', 'developer')->value('id');

        $this->contract->immovable = $this->get_immovable($this->contract->immovable);
        $this->contract->dev_company->owner = $this->contract->dev_company->member->where('type', $client_type_dev_owner)->first();

        // для перевірки заборони на продавця використовується орієнтир через нерухомість, а не на пряму через власника
        $this->contract->dev_company->owner->fence = \App\Models\DevFence::where('immovable_id', $this->contract->immovable->id)->first();
        $this->contract->immovable_ownership = ImmovableOwnership::get_immovable_ownership($this->contract->immovable->id);
    }

    public function get_immovable($immovable)
    {
        $immovable->fence = ImmFence::where('immovable_id', $immovable->id)->first();
        $immovable->address = $this->full_ascending_address_r($immovable);

        return $immovable;
    }

    public function full_ascending_address_r($immovable)
    {
        $imm_num = $immovable->immovable_number;
        $imm_num_str = $this->convert->number_to_string($immovable->immovable_number);
        $imm_build_num = $immovable->developer_building->number;
        $imm_build_num_str = $this->convert->number_to_string($immovable->developer_building->number);
        $imm_addr_type_r = $immovable->developer_building->address_type->title_n;
        $imm_addr_title = $immovable->developer_building->title;
        $imm_city_type_m = $immovable->developer_building->city->city_type->title_n;
        $imm_city_title_n = $immovable->developer_building->city->title;
        $imm_dis_title_r = $immovable->developer_building->city->district->title_n;
        $imm_reg_title_r = $immovable->developer_building->city->region->title_n;

        $address = "$imm_addr_type_r $imm_addr_title "
            . "$imm_build_num ($imm_build_num_str), "
            . "$imm_city_type_m $imm_city_title_n, "
            . "$imm_dis_title_r " . trim(KeyWord::where('key', 'district')->value('title_n')) . ", "
            . "$imm_reg_title_r " . trim(KeyWord::where('key', 'region')->value('title_n')) . " "
            . "";

        return $address;
    }
}

