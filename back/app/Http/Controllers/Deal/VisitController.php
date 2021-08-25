<?php

namespace App\Http\Controllers\Deal;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Room;
use App\Models\Visit;
use Illuminate\Http\Request;
use Validator;

class VisitController extends BaseController
{
    public function update_deal_info($card_id, Request $r)
    {
        if (!$card = Card::find($card_id)) {
            return $this->sendError('', "Картка по ID: $card_id не знайдена");
        }

        $validator = $this->validate_imm_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        if (!$card = Room::find($r['room_id'])) {
            return $this->sendError('', "Картка по ID: $card_id не знайдена");
        }

        if (Visit::where(['room_id' => $r['room_id'], 'ready' => false])->where('card_id', '!=', $card_id)->first())
            return $this->sendResponse('', "Кімната зайнята");

        Visit::updateOrCreate(
            ['card_id' => $card_id],
            [
                'number_of_people' => $r['number_of_people'],
                'children' => $r['children'],
                'room_id' => $r['room_id'],
                'arrival_time' => date('Y-m-d H:i:s'),
            ]
        );

        return $this->sendResponse('', 'Дані запрошення оновлено');
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
