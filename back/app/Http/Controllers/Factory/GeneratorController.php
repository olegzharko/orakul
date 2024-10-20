<?php

namespace App\Http\Controllers\Factory;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\BuildingRepresentativeProxy;
use App\Models\DevCompanyEmployer;
use App\Models\DevEmployerType;
use Illuminate\Http\Request;
use App\Models\ApartmentType;
use App\Models\Card;
use App\Models\Client;
use App\Models\ClientContract;
use App\Models\ClientType;
use App\Models\Contract;
use App\Models\ImmFence;
use App\Models\ImmovableOwnership;
use App\Models\KeyWord;
use App\Models\Proxy;
use App\Models\DevFence;
use Validator;
use URL;

class GeneratorController extends BaseController
{
    public $word;
    public $client;
    public $contract;
    public $pack_contract;
    public $consents_id;
    public $convert;
    public $card;
    public $card_id;

    public function __construct()
    {
        $this->word = null;
        $this->client = null;
        $this->contract = null;
        $this->pack_contract = null;
        $this->consents_id = [];
        $this->convert = new ConvertController();
        $this->card = null;
        $this->card_id = null;
    }

    public function create_contract_by_card_id($card_id)
    {
        $result = [];

        if ($this->get_contracts_id_by_card_id($card_id)) {
            Card::where('id', $card_id)->update(['ready' => true]);
            $this->card_id = $card_id;
            $fileName = $this->start_generate_contract();
            $result = $this->save_file($fileName);
        }

        return $this->sendResponse($result, 'Договір створено');
    }

    public function create_all_contracts()
    {
        $cards_id = Card::where('ready', true)->pluck('id');

        foreach ($cards_id as $card_id) {
//            echo "CARD_ID $card_id <br>";
            if ($this->get_contracts_id_by_card_id($card_id)) {
                $this->start_generate_contract();
            }
        }
    }

    public function create_contracts_by_cards()
    {
        $cards_id = Card::where('ready', true)->pluck('id');
        foreach ($cards_id as $card_id) {
            $this->get_contracts_id_by_card_id($card_id);
            $this->start_generate_contract();
        }
    }

    public function get_contracts_id_by_card_id($card_id)
    {
        $contracts_id = null;
        $contracts = null;

        $validator = Validator::make([
            'card_id' => $card_id,
        ], [
            'card_id' => ['required', 'numeric'],
        ], [
            'card_id.required' => 'Необхідно передати CARD_ID',
            'card_id.numeric' => 'Необхідно передати CARD_ID у числовому форматі',
        ]);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError("Карта $card_id має наступні помилки", $validator->errors());
        }

//        $contracts_fale = Contract::where('card_id', $card_id)->where('ready', false)->pluck('id');
//        if (count($contracts_fale)) {
//            $title = "Картка $card_id <br>";
//            foreach ($contracts_fale as $item) {
//                $title .= "Контракт під ID:" . $item . " не готові до обробки<br>";
//            }
//            echo $title . "<br>";
//            return false;
//        }

        $contracts_id = Contract::where('card_id', $card_id)->pluck('id')->toArray();

        $this->get_contract_by_id($contracts_id);
        return true;
    }

    public function get_contract_by_id($contracts_id)
    {
        $this->pack_contract = Contract::select(
                'contracts.id',
                'contracts.template_id',
                'contracts.immovable_id',
                'contracts.type_id',
                'contracts.sign_date',
                'cards.date_time as event_datetime',
                'cards.city_id as event_city_id',
                'cards.id as card_id',
                'cards.dev_group_id as dev_group_id',
                'cards.dev_representative_id as dev_representative_id',
                'cards.notary_id as notary_id',
            )->whereIn('contracts.id', $contracts_id)
            ->join('cards', 'cards.id', '=', 'contracts.card_id')
            ->get();
    }

    public function start_generate_contract()
    {
        if (isset($this->pack_contract) && count($this->pack_contract)) {
            // Підготувати данні до обробки
            foreach ($this->pack_contract as $key => $this->contract) {

                if (count($this->contract->client_spouse_consent)) {
                    $this->consents_id = array_unique(array_merge($this->consents_id, $this->contract->client_spouse_consent->pluck('id')->toArray()));
                }
//                $this->pack_contract[$key]->contract = $this->set_data_contract();
                $this->set_data_contract();

            }

            $this->client = $this->contract->client_contract;

            $this->word = new DocumentController($this->client, $this->pack_contract, $this->consents_id, $this->card_id);
            $result = $this->word->creat_files();
        } else {
            dd("Увага: Угоди відсутні або не готові не генерації!");
        }

        unset($this->pack_contract);
        $this->pack_contract = null;

        return $result;
    }

    public function notification($type, $message)
    {

    }

    public function set_data_contract()
    {
        $this->contract->immovable = $this->get_immovable($this->contract->immovable);

        $this->contract->dev_company = $this->contract->immovable->developer_building->dev_company;

        $owner = Client::select('clients.*')
            ->where('dev_company_employers.dev_company_id', $this->contract->dev_company->id)
            ->where('dev_employer_types.alias', 'developer')
            ->where('dev_company_employers.deleted_at', null)
            ->join('dev_company_employers', 'dev_company_employers.employer_id', '=', 'clients.id')
            ->join('dev_employer_types', 'dev_employer_types.id', '=', 'dev_company_employers.type_id')
            ->first();

        $this->contract->dev_company->owner = $owner;

        // для перевірки заборони на продавця використовується орієнтир через нерухомість, а не на пряму через власника
//        $this->contract->dev_company->owner->fence = DevFence::where('card_id', $this->contract->card_id)->orderBy('date', 'desc')->first();
        $this->contract->dev_company->fence = DevFence::where('card_id', $this->contract->card_id)->orderBy('date', 'desc')->first();
        $this->contract->immovable_ownership = ImmovableOwnership::get_immovable_ownership($this->contract->immovable->id);

        // повернути дані до массиву
//        return $this->contract;
    }

    public function get_immovable($immovable)
    {
        $immovable->fence = ImmFence::where('immovable_id', $immovable->id)->first();
        $immovable->address = $this->convert->building_full_address_by_type($immovable);
        $immovable->proxy = $this->get_proxy($immovable);

        return $immovable;
    }

    public function get_proxy($immovable)
    {
        $building_id = $immovable->developer_building->id;
        $dev_representative_id = Card::where('id', $this->card_id)->value('dev_representative_id');

        $proxy_id = BuildingRepresentativeProxy::where('building_id', $building_id)->where('dev_representative_id', $dev_representative_id)->value('proxy_id');
        $proxy = Proxy::find($proxy_id);

        return $proxy;
    }

    public function save_file($fileName)
    {
        $result['path'] = $fileName;
        foreach ($fileName as $value) {
            $result['link'][] = URL::to('/') . "/" . $value;
        }

        return $result;
    }
}

