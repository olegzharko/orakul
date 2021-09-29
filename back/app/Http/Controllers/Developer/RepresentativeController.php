<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\UserDeveloper;
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
        $data = [];

        $user_id = auth()->user()->id;
        $dev_representative_id = UserDeveloper::where('user_id', $user_id)->value('client_id');

        $today = new \DateTime('today');
        $tomorrow = new \DateTime('tomorrow');

        $cards = Card::where('date_time', '>', $today)->where('date_time', '<', $tomorrow)->where('dev_representative_id', $dev_representative_id)->orderBy('date_time')->get();
//        $documents_link = DocumentLink::whereIn('card_id', $cards_id)->whereIn('type', ['bank_account', 'bank_taxes'])->get();

        foreach ($cards as $key => $card){
            $time = $card->date_time->format('H:i');
            $info = [];
            $contracts = $card->has_contracts;

            $info['id'] = $card->id;
            $info['immovables'] = [];

            foreach ($contracts as $dl => $contract) {
                $info['immovables'][] = $contract ? $this->convert->building_city_address_number_immovable($contract->immovable) : null;
            }

            $info['clients'] = $this->get_buyer_info($card);

            $data[$time][] = $info;
        }

        $result = [];
        foreach ($data as $key => $value) {
            $current_time['title'] = $key;
            $current_time['info'] = $value;
            $result[] = $current_time;
        }

        return $this->sendResponse($result, 'Дані для забудовника');
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
