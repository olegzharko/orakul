<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Exchange;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MinfinController extends BaseController
{
    public $client;
    public $api_key;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
        $this->api_key = "cbef9c587eb1110b0da451d3f8e99ac4e62b0f34";
    }

    public function get_rate_exchange()
    {
        $currency_exchage = $this->get_dollar_auction();
        $contract = $this->get_contract_buy();

        $exchange = new Exchange();
        $exchange->rate = $currency_exchage * 100;
        $exchange->contract_buy = $contract ? round($contract->buy, 2) * 100 : null;
        $exchange->contract_sell = $contract ? round($contract->sell, 2) * 100 : null;
        $exchange->save();

        $result['exchange_rate'] = number_format($currency_exchage, 2);
        $result['contract_buy'] = number_format($contract->buy, 2);
        $result['contract_sell'] = number_format($contract->sell, 2);


        return $this->sendResponse($result, 'Новий курс додано до базы даних');
    }

    public function get_contract_buy()
    {
        $response = $this->client->request('GET', 'https://api.minfin.com.ua/contracts/' . $this->api_key .'/');

        $api_data = json_decode($response->getBody());

        if (!$api_data->data || !$api_data->data->auction)
            return $this->sendError('', 'Запит не передав дані');

        return $api_data->data->auction;
    }

    public function get_dollar_auction()
    {
        $response = $this->client->request('GET', 'https://api.minfin.com.ua/auction/info/' . $this->api_key . '/');

        $api_data = json_decode($response->getBody());

        if (!$api_data->usd)
            return $this->sendError('', 'Запит не передав дані');

        $ask = $api_data->usd->ask;
        $currency_exchage = round($ask, 2);

        return $currency_exchage;
    }
}
