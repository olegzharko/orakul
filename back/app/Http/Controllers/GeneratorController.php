<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientType;
use App\Models\Contract;
use App\Models\DayConvert;
use App\Models\Immovable;
use App\Models\ImmovableOwnership;
use App\Models\KeyWord;
use App\Models\MonthConvert;
use App\Models\YearConvert;
use Illuminate\Http\Request;

class GeneratorController extends Controller
{
    public $word;
    public $client;
    public $contract;
    public $pack_contract;
    public $consents_id;

    public function __construct()
    {
        $this->word = null;
        $this->client = null;
        $this->contract = null;
        $this->pack_contract = null;
        $this->consents_id = [];
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
                dd("Warning: There are no new deal for user: $user_id!");
            }
        } else {
            dd("Warning: There are no user_id: $user_id!");
        }
    }

    public function get_contract_by_client_id($client_id = null)
    {
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

        $contract = $contract->where(function ($query) use ($client_id) {
            if ($client_id)
                $query = $query->where('client_id', $client_id);
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
            $city_title = trim($c->city->title_n);
            $city = "$city_type_short $city_title, ";
        }

        if ($c->address && $c->address_type->short && $c->building ) {
            $address_title = trim($c->address);
            $address_type_short = trim($c->address_type->short);
            $address = "$address_type_short $address_title, ";

            $building_type_short = trim(KeyWord::where('key', 'building')->value('short'));
            $building_num = trim($c->building);
            $apartment = $c->apartment ? ", " . trim(KeyWord::where('key', 'apartment')->value('short')) . " " . trim($c->apartment) : null;

            $building = "$building_type_short $building_num" . "$apartment";
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

    public function get_number_format_thousand($price)
    {
        $price_thousand = null;
        $price_thousand = number_format(floor($price / 100), 0, ".",  " " );

        return $price_thousand;
    }

    public function get_number_format_decimal($price)
    {
        $price_decimal = null;
        $price_decimal = sprintf("%02d", number_format($price % 100));

        return $price_decimal;
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

        $this->contract->immovable = Immovable::get_immovable($this->contract->immovable);
        $this->contract->dev_company->owner = $this->contract->dev_company->member->where('type', $client_type_dev_owner)->first();

        // для перевірки заборони на продавця використовується орієнтир через нерухомість, а не на пряму через власника
        $this->contract->dev_company->owner->fence = \App\Models\DevFence::where('immovable_id', $this->contract->immovable->id)->first();
        $this->contract->immovable_ownership = ImmovableOwnership::get_immovable_ownership($this->contract->immovable->id);
    }

    public function convert_date_to_string($document, $date)
    {
        $document->str_day = null;
        $document->str_month = null;
        $document->str_year = null;

        if ($date) {
            $num_day = $date->format('d');
            $num_month = $date->format('m');
            $num_year = $date->format('Y');

            $document->str_day = DayConvert::convert($num_day);
            $document->str_month = MonthConvert::convert($num_month);
            $document->str_year = YearConvert::convert($num_year);
        }
    }
}
