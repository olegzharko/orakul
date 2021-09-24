<?php

namespace App\Http\Controllers\Deal;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Room;
use App\Models\Deal;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;

class DealController extends BaseController
{
    public $convert;
    public $tools;

    public function __construct()
    {
        $this->convert = new ConvertController();
        $this->tools = new ToolsController();
    }

    public function get_deal_detail($deal_id)
    {
        $result = [];

        if (!$deal = Deal::find($deal_id)) {
            return $this->sendError('', "Картка по ID: $deal_id не знайдена");
        }

        $result['time'] = $this->tools->get_deal_time($deal);
        $result['dev_representative'] = $this->tools->get_dev_representative_info($deal);
        $result['steps_list'] = $this->tools->get_deal_step_list($deal);
        $result['payment'] = $this->tools->get_deal_payment($deal);
        $result['immovable'] = $this->tools->get_deal_immovable($deal);
//        $result['help'] = '';
        $result['info'] = $this->tools->get_deal_info($deal);

        return $this->sendResponse($result, 'Дані угоди');
    }

    public function create_deal_info(Request $r)
    {
        if (!$card = Card::find($r['card_id'])) {
            return $this->sendError('', "Картка по ID: " . $r['card_id'] . " не знайдена");
        }

        $validator = $this->validate_imm_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        $date = new \DateTime();


        if (!$room = Room::find($r['room_id'])) {
            return $this->sendError('', "Кімната по ID: " . $r['room_id'] . " не знайдена");
        }

        if ($room->type->alias != 'reception' && Deal::where(['room_id' => $r['room_id'], 'ready' => false])->where('card_id', '!=', $r['card_id'])->first())
            return $this->sendResponse('', "В '" . $room->title . "' зайнято");

        Card::where('id', $r['card_id'])->update(['in_progress' => true]);

        Deal::firstOrNew(
            ['card_id' => $r['card_id']],
            [
                'number_of_people' => $r['number_of_people'],
                'children' => $r['children'],
                'room_id' => $r['room_id'],
                'arrival_time' => $date,
            ]
        );

        return $this->sendResponse('', 'Запрошення на угоду оновлено');
    }

    public function update_deal_info(Request $r)
    {
        if (!$card = Card::find($r['card_id'])) {
            return $this->sendError('', "Картка по ID: " . $r['card_id'] . " не знайдена");
        }

        $validator = $this->validate_imm_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        $date = new \DateTime();

        Deal::where('card_id', $r['card_id'])->update([
            'number_of_people' => $r['number_of_people'],
            'children' => $r['children'],
        ]);

        return $this->sendResponse('', 'Запрошення на угоду оновлено');
    }

    private function validate_imm_data($r)
    {
        $validator = Validator::make([
            'room_id' => $r['room_id'],
        ], [
            'room_id' => ['numeric', 'nullable'],
        ], [
            'room_id.numeric' => 'Необхідно передати ID в числовому форматі',
        ]);

        $errors = $validator->errors()->messages();

        if (!isset($errors['room_id']) && isset($r['room_id']) && !empty($r['room_id'])) {
            if (!Room::find($r['room_id'])) {
                $validator->getMessageBag()->add('room_id', 'Кімната з ID:' . $r['room_id'] . " відсутня");
            }
        }

        return $validator;
    }
}
