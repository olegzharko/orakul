<?php

namespace App\Http\Controllers\Generator;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Helper\ToolsController;
use App\Http\Controllers\Info\StepController;
use App\Http\Controllers\Factory\ConvertController;
use App\Models\Contract;
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

        if ($contract = Contract::where('card_id', $card_id)->where('template_id', null)->first()) {
            $address = $this->convert->building_full_address_by_type($contract->immovable);
            $result['instructions'][] = ['title' => 'Відсутній шабон для', 'value' => $address];
        }

        $result['date_info'] = $date_info;
        $result['instructions'][] = ['title' => 'CONTR 1', 'value' => 'INFO 1'];
        $result['instructions'][] = ['title' => 'CONTR 2', 'value' => 'INFO 2'];
        $result['instructions'][] = ['title' => 'CONTR 3', 'value' => 'INFO 3'];
        $result['instructions'][] = ['title' => 'CONTR 4', 'value' => 'INFO 4'];

        return $this->sendResponse($result, "Дані для головної створення договору");
    }
}
