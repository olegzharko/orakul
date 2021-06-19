<?php

namespace App\Http\Controllers\Generator;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Helper\ToolsController;
use App\Http\Controllers\Info\StepController;
use App\Http\Controllers\Factory\ConvertController;
use App\Models\Contract;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;
use App\Models\Card;

class MainController extends BaseController
{
    public $tools;
    public $step;
    public $convert;

    public function __construct()
    {
        $this->tools = new ToolsController();
        $this->step = new StepController();
        $this->convert = new ConvertController();
    }

    public function main($card_id)
    {
        $card = null;
        $date_info = null;
        $instructions = null;
        $result = [];

        if (!$card = Card::find($card_id)) {
            return $this->sendError('', "Картка по ID: $card_id не знайдена");
        }

        $date_info = $this->tools->header_info($card);
        $instructions = $this->step->todo_list($card);

        $result['instructions'] = [];
        if ($contract = Contract::where('card_id', $card_id)->where('template_id', null)->first()) {
            $address = $this->convert->building_full_address_by_type($contract->immovable);
            $result['instructions'][] = ['title' => 'Відсутній шаблон для', 'value' => $address];
        }

        $result['date_info'] = $date_info;
        $result['card_id'] = str_pad($card_id, 8, '0', STR_PAD_LEFT);
;
        return $this->sendResponse($result, "Дані для головної створення договору");
    }
}
