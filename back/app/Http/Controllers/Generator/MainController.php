<?php

namespace App\Http\Controllers\Generator;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Helper\ToolsController;
use App\Http\Controllers\Info\StepController;
use Illuminate\Http\Request;
use App\Models\Card;

class MainController extends BaseController
{
    public $tools;
    public $step;

    public function __construct()
    {
        $this->tools = new ToolsController();
        $this->step = new StepController();
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

        $result['date_info'] = $date_info;
        $result['instructions'] = $instructions;

        return $this->sendResponse($result, "Дані для головної");
    }
}
