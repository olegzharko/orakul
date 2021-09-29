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
use App\Models\WorkDay;
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
        $group = [];
        $result = [];
        $week = WorkDay::where('active', true)->orderBy('num')->pluck('title', 'num')->toArray();
        $i = 0;

        $user_id = auth()->user()->id;
        $dev_representative_id = UserDeveloper::where('user_id', $user_id)->value('client_id');

        $today = new \DateTime('today');
        $tomorrow = new \DateTime('tomorrow');

//        $cards = Card::where('date_time', '>', $today)->where('date_time', '<', $tomorrow)->where('dev_representative_id', $dev_representative_id)->orderBy('date_time')->get();
        $cards = Card::where('dev_representative_id', $dev_representative_id)->orderBy('date_time')->get();
//        $documents_link = DocumentLink::whereIn('card_id', $cards_id)->whereIn('type', ['bank_account', 'bank_taxes'])->get();

        foreach ($cards as $key => $card){
            $contracts = $card->has_contracts;

            $result['id'] = $card->id;
            $result['time'] = $card->date_time->format('H.i');
            $result['immovables'] = $this->get_card_contracts($contracts);
            $result['clients'] = $this->get_buyer_info($card);

            if (count($group) && $group[$i]['date'] == $card->date_time->format('d.m.')) {
                $group[$i]['cards'][] = $result;
            } else {
                $i = $card->date_time->format('d.m.');

                $day_num = $card->date_time->format('w');
                $group[$i]['day'] = $day_num ? $week[$day_num] : null;
                $group[$i]['date'] = $card->date_time->format('d.m.');
                if (!isset($group[$i]['cards']))
                    $group[$i]['cards'] = [];
                $group[$i]['cards'][] = $result;
            }
        }

//        $result = [];
//        foreach ($data as $key => $value) {
//            $current_time['title'] = $key;
//            $current_time['info'] = $value;
//            $result[] = $current_time;
//        }

        return $this->sendResponse($group, 'Дані для забудовника');
    }

    public function get_card_contracts($contracts)
    {
        $result = [];

        foreach ($contracts as $dl => $contract) {
            if ($contract)
                $result[] = $this->convert->building_city_address_number_immovable($contract->immovable);
        }

        return $result;
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
