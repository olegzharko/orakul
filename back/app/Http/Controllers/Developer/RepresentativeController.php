<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;
use App\Models\Card;
use App\Models\Client;
use App\Models\ClientContract;
use App\Models\DocumentLink;

class RepresentativeController extends BaseController
{
    public $convert;
    public $tools;

    public function __construct()
    {
        $this->convert = new ConvertController();
        $this->tools = new ToolsController();
    }

    public function get_data_for_developer()
    {
        $result = [];

        $today = new \DateTime('today');
        $tomorrow = new \DateTime('tomorrow');

        $cards = Card::where('date_time', '>', $today)->where('date_time', '<', $tomorrow)->get();
//        $documents_link = DocumentLink::whereIn('card_id', $cards_id)->whereIn('type', ['bank_account', 'bank_taxes'])->get();

        foreach ($cards as $key => $card){
            $time = $card->date_time->format('H:i');
            $documents_link = DocumentLink::where('card_id', $card->id)->whereIn('type', ['bank_account', 'bank_taxes'])->get();
            $info = [];

            $info['id'] = $card->id;
            foreach ($documents_link as $dl => $document) {
                $info['immovables'][] = $this->convert->building_city_address_number_immovable($document->contract->immovable);
            }

            $info['clients'] = $this->get_buyer_info($card);

            $result[$time][] = $info;
        }

        return $this->sendResponse($result, 'Дані для колонок архіву');
    }

    public function get_buyer_info($card)
    {
        $result = [];
        $contract = $card->has_contracts->first();
        $clients_id = ClientContract::where('contract_id', $contract->id)->pluck('client_id');
        $clients = Client::whereIn('id', $clients_id)->get();

        foreach ($clients as $key => $client) {
            $result[$key] = $this->convert->get_full_name_n($client);
        }

        return $result;
    }
}
