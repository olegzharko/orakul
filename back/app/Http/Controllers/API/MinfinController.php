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
//        $this->api_key = "d0624fa95581282989b572beaf26ea7eeb6323d1";
        $this->api_key = "cfe70aa913f63a82fee327cbe8672ba7e7a79049";
    }

    public function get_rate_exchange()
    {
        $currency_exchage = $this->get_dollar_auction();
        $contract = $this->get_contract_buy();
        $nbu_ask = $this->get_nbu_ask();

        $exchange = new Exchange();
        $exchange->rate = $currency_exchage * 100;
        $exchange->contract_buy = $contract ? round($contract->buy, 2) * 100 : null;
        $exchange->contract_sell = $contract ? round($contract->sell, 2) * 100 : null;
        $exchange->nbu_ask = $nbu_ask * 100;
        $exchange->save();

        $result['exchange_rate'] = number_format($currency_exchage, 2);
        if ($contract) {
            $result['contract_buy'] = number_format($contract->buy, 2);
            $result['contract_sell'] = number_format($contract->sell, 2);
        } else {
            $result['contract_buy'] = number_format(0, 2);
            $result['contract_sell'] = number_format(0, 2);
        }
        $result['nbu_ask'] = number_format($nbu_ask, 2);

        return $this->sendResponse($result, 'Новий курс додано до базы даних');
    }

    public function get_contract_buy()
    {
        try {
            $response = $this->client->request('GET', 'https://api.minfin.com.ua/contracts/' . $this->api_key .'/');
        } catch (\Exception $e) {
            return null;
        }

        $api_data = json_decode($response->getBody());

        if (!$api_data->data || !$api_data->data->auction)
            return $this->sendError('', 'Запит не передав дані');

        return $api_data->data->auction;
    }

    public function get_dollar_auction()
    {
        try {
            $response = $this->client->request('GET', 'https://api.minfin.com.ua/auction/info/' . $this->api_key . '/');
        } catch (\Exception $e) {
            return null;
        }

        $api_data = json_decode($response->getBody());

        if (!$api_data->usd)
            return $this->sendError('', 'Запит не передав дані');

        $ask = $api_data->usd->ask;
        $currency_exchage = round($ask, 2);

        return $currency_exchage;
    }

    public function get_nbu_ask()
    {

//        try {
            $response = $this->client->request('GET', 'https://api.minfin.com.ua/nbu/' . $this->api_key . '/');
//            $response = $this->client->request('GET', 'https://api.minfin.com.ua/nbu/cfe70aa913f63a82fee327cbe8672ba7e7a79049/');
//        } catch (\Exception $e) {
//            return null;
//        }
        $api_data = json_decode($response->getBody());

        if (!$api_data->usd)
            return $this->sendError('', 'Запит не передав дані');

        $ask = $api_data->usd->ask;
        $currency_exchage = round($ask, 2);

        return $currency_exchage;
    }
}
