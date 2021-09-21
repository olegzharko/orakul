<?php

namespace App\Http\Controllers\Generator;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Helper\ToolsController;
use App\Http\Controllers\Info\StepController;
use App\Http\Controllers\Factory\ConvertController;
use App\Models\Contract;
use App\Models\CurrentTask;
use App\Models\ExchangeRate;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Models\Card;
use Illuminate\Support\Facades\Auth;

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

        CurrentTask::set_current_task($card);

        $date_info = $this->tools->header_info($card);
        $instructions = $this->step->todo_list($card);

        $result['instructions'] = [];
        $contracts = Contract::where('card_id', $card_id)->get();
        foreach ($contracts as $contract) {
            $address = $this->convert->immovable_building_address($contract->immovable);

            $immovable = $contract->immovable;
            $immovable_type = $contract->immovable->immovable_type->alias;
            $contract_type = $contract->type->alias;
            $result['instructions'][] = ['title' => $address, 'value' => $contract->ready ? 'Готово до генерації' : ''];
            $result['instructions'][] = ['title' => '', 'value' => ''];
            $result['instructions'][] = ['title' => '', 'value' => ''];
            if (!$contract->template_id)
                $result['instructions'][] = ['title' => '', 'value' => 'Шаблон договору'];
            if (!$contract->bank_account_payment && $contract_type == 'preliminary')
                $result['instructions'][] = ['title' => '', 'value' => 'Квитанція для банку'];
            if (!$immovable->grn)
                $result['instructions'][] = ['title' => '', 'value' => 'Ціна за нерухомість'];
            if (!$immovable->registration_number && $contract_type == 'main')
                $result['instructions'][] = ['title' => '', 'value' => 'Реєстраційний номер'];
            if (!$immovable->total_space)
                $result['instructions'][] = ['title' => '', 'value' => 'Загальна площа'];
            if (!$immovable->living_space && $contract_type == 'main' && $immovable_type == 'appartment') // preliminary
                $result['instructions'][] = ['title' => '', 'value' => 'Житлова площа'];
            if (!$immovable->m2_grn)
                $result['instructions'][] = ['title' => '', 'value' => 'Ціна за М2'];
            if (!$immovable->roominess_id && $contract_type == 'preliminary')
                $result['instructions'][] = ['title' => '', 'value' => 'Кімнатність'];
            if (!$immovable->floor && $contract_type == 'preliminary' && $immovable_type == 'appartment')
                $result['instructions'][] = ['title' => '', 'value' => 'Поверх'];
            if (!$immovable->section && $contract_type == 'preliminary' && $immovable_type == 'appartment')
                $result['instructions'][] = ['title' => '', 'value' => 'Секція'];
            if ($contract_type == 'preliminary' && !$immovable->developer_building->investment_agreement)
                $result['instructions'][] = ['title' => '', 'value' => 'Інвестиційний договір відсутній'];
            if ($contract_type == 'preliminary' && !$immovable->developer_building->building_permit)
                $result['instructions'][] = ['title' => '', 'value' => 'Дозвіл на будівництво відсутній'];

            // изменить логину обработки на стороне фронта
            if (count($result['instructions']) % 3 == 1) {
                $result['instructions'][] = ['title' => '', 'value' => ''];
                $result['instructions'][] = ['title' => '', 'value' => ''];
            }

            if (count($result['instructions']) % 3 == 2) {
                $result['instructions'][] = ['title' => '', 'value' => ''];
            }
        }


        $result['date_info'] = $date_info;
        $result['card_id'] = str_pad($card_id, 8, '0', STR_PAD_LEFT);
;
        return $this->sendResponse($result, "Дані для головної створення договору");
    }
}
