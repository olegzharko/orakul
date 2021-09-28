<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\DocumentLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;
use App\Models\Card;

class BankController extends BaseController
{
    public $convert;
    public $tools;

    public function __construct()
    {
        $this->convert = new ConvertController();
        $this->tools = new ToolsController();
    }

    public function get_bank_data()
    {
        $data = [];

        $today = new \DateTime('today');
        $tomorrow = new \DateTime('tomorrow');

        $cards = Card::where('date_time', '>', $today)->where('date_time', '<', $tomorrow)->get();
//        $documents_link = DocumentLink::whereIn('card_id', $cards_id)->whereIn('type', ['bank_account', 'bank_taxes'])->get();

        foreach ($cards as $key => $card){
            $time = $card->date_time->format('H:i');
            $documents_link = DocumentLink::where('card_id', $card->id)->whereIn('type', ['bank_account', 'bank_taxes'])->get();
            $info = [];

            foreach ($documents_link as $dl => $document) {
                $path = explode('/', $document->link);
                $title = end($path);
                $info['id'] = $document->id;
                $info['title'] = $title;
                $info['link'] = $document->link;
            }

            $data[$time][] = $info;
        }

        $result = [];
        foreach ($data as $key => $value) {
            $current_time['title'] = $key;
            $current_time['info'] = $value;
            $result[] = $current_time;
        }


        return $this->sendResponse($result, 'Дані для колонок архіву');
    }
}
