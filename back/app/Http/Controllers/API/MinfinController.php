<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Exchange;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MinfinController extends BaseController
{
    public function __construct()
    {

    }

    public function get_rate_exchange()
    {
        $client = new \GuzzleHttp\Client();
//        $response = $client->request('GET', 'https://api.minfin.com.ua/nbu/7a176e1592eb3b008f05ccd42c78f9d2c81e461c/');
        $response = $client->request('GET', 'https://api.minfin.com.ua/auction/info/7a176e1592eb3b008f05ccd42c78f9d2c81e461c/');
//        $response = $client->request('GET', 'https://api.minfin.com.ua/auction/info/7a176e1592eb3b008f05ccd42c78f9d2c81e461c/');

        $api_data = json_decode($response->getBody());
        if (!$api_data->usd)
            return $this->sendError('', 'Запит не передав дані');
        $ask = $api_data->usd->ask;
        $currency_exchage = round($ask, 2);

        $exchange = new Exchange();
        $exchange->rate = $currency_exchage * 100;
        $exchange->save();

        $result['exchange_rate'] = $currency_exchage;

        return $this->sendResponse($result, 'Новий курс додано до базы даних');
    }
}
