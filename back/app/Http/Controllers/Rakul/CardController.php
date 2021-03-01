<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Models\Card;
use App\Models\CardClient;
use App\Models\ClientType;
use App\Models\ContractType;
use App\Models\DevCompany;
use App\Models\ImmovableType;
use App\Models\DeveloperBuilding;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Time;
use App\Models\Room;
use Validator;


class CardController extends BaseController
{
    public $immovable;
    public $contract;
    public $client;

    public function __construct()
    {
        $this->immovable = new ImmovableController();
        $this->contract = new ContractController();
        $this->client = new ClientController();
    }
    /*
     * GET
     * */
    public function index()
    {
        $date = new \DateTime();

        $result = [];
        $rooms = Room::where('active', true)->pluck('id')->toArray();
        $times = Time::where('active', true)->pluck('time')->toArray();
        $time_length = count($times);

        $cards = Card::whereIn('room_id', $rooms)->where('date_time', '>=', $date)->get();


        foreach ($cards as $key => $card) {
            if (in_array($card->date_time->format('H:i'), $times)) {
                $time_height = array_search($card->date_time->format('H:i'), $times);
                $day_height = $this->count_days($card, $date);
                $result[$key]['i'] = strval($card->id);
                $result[$key]['x'] = array_search($card->room->id, $rooms);
                if ($day_height)
                    $result[$key]['y'] = $time_height + $time_length * $day_height;
                else
                    $result[$key]['y'] = $time_height;
                $result[$key]['w'] = 1;
                $result[$key]['h'] = 1;
                $result[$key]['color'] = $card->dev_company->color;
                $result[$key]['title'] = $this->get_card_title($card);
                $result[$key]['short_info'] = $this->get_card_short_info($card);
            }
        }

        return $this->sendResponse($result, 'Картки з договорами');
    }

    /*
     * GET with param
     * */
    public function show($id)
    {
        $card = Card::select(
            'id',
            'room_id',
            'date_time',
            'notary_id',
            'dev_company_id',
            'dev_representative_id',
            'dev_manager_id',
        )->find($id);

        if (!$card) {
            return $this->sendError("Картка по ID $id відсутня");
        }
        $contracts = $card->has_contracts;

        $result_contract = [];
        if (count($contracts)) {
            foreach ($contracts as $key => $contr) {
                $result_contract[$key]['contract_type_id'] = $contr->contract->type_id;
                $result_contract[$key]['developer_building_id'] = $contr->contract->immovable->developer_building_id;
                $result_contract[$key]['immovable_type_id'] = $contr->contract->immovable->immovable_type_id;
                $result_contract[$key]['immovable_number'] = $contr->contract->immovable->immovable_number;
                $result_contract[$key]['bank'] = $contr->contract->bank;
                $result_contract[$key]['proxy'] = $contr->contract->proxy;
            }
        }

        $clients = CardClient::where('card_id', $card->id)->get();

        $result_clients = [];
        if ($clients) {
            foreach ($clients as $key => $cl) {
                $result_clients[$key]['full_name'] = $cl->full_name;
                $result_clients[$key]['phone'] = $cl->phone;
            }
        }

        unset($card['has_contracts']);
        $result = [
            'card' => $card,
            'contract' => $result_contract,
            'clients' => $result_clients,
        ];

        return $this->sendResponse($result, 'Карта з ID:' . $id);

    }

    /*
     * POST save new card
     * */
    public function store(Request $r)
    {
        $validator = $this->validate_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        $date_time = new \DateTime($r['date_time']);

        if (Card::where('room_id', $r['room_id'])->where('date_time', $date_time)->first()) {
            return $this->sendError('Кімната: ' . $r['room_id'] . " на " . $r['date_time'] . " зайнята.");
        }

        $card_id = Card::new_card($r);

        $immovables_id = $this->immovable->add_immovables($r);
        $this->contract->add_contracts_on_immovabel($card_id, $immovables_id);
        $this->client->add_card_clients($card_id, $r['clients']);

        return $this->sendResponse('', 'Запис створено успішно');
    }

    /*
     * PUT with param
     * */
    public function update(Request $request, $id)
    {
        dd('update');

    }

    /*
     * DELETE
     * */
    public function destroy($id)
    {

    }


    public function validate_data($r)
    {
        $validator = Validator::make([
            'notary_id' => $r['notary_id'],
            'room_id' => $r['room_id'],
            'date_time' => $r['date_time'],
            'dev_company_id' => $r['dev_company_id'],
            'dev_representative_id' => $r['dev_representative_id'],
            'dev_manager_id' => $r['dev_manager_id'],
        ], [
            'notary_id' => ['required', 'numeric'],
            'room_id' => ['required', 'numeric'],
            'date_time' => ['required', 'date_format:d.m.Y H:i'],
            'dev_company_id' => ['required', 'numeric'],
            'dev_representative_id' => ['numeric', 'nullable'],
            'dev_manager_id' => ['numeric', 'nullable'],
        ], [
            'notary_id.required' => 'Необхідно вибрати нотаріуса',
            'room_id.required' => 'Необхідно вибрати кімнату',
            'date_time.required' => 'Дата відсутня',
            'dev_company_id.required' => 'Необхідно вибрати компанію забудовника',
            'notary_id.numeric' => 'Необхідно передати ID нотаріса в числовому форматі',
            'room_id.numeric' => 'Необхідно передати ID кімнати в числовому форматі',
            'date_time.date_format' => 'Необхідно передати дату у форматі d.m.Y H:i Приклад: ' . date('d.m.Y H') . ":00",
            'dev_company_id.numeric' => 'Необхідно передати ID компанії забудовника в числовому форматі',
            'dev_representative_id.numeric' => 'Необхідно передати ID представника забудовника в числовому форматі',
            'dev_manager_id.numeric' => 'Необхідно передати ID менеджера забудовника в числовому форматі',
        ]);

        $r['immovables'] = json_decode($r['immovables']);
        if ($js_error = json_last_error()) {
            $validator->getMessageBag()->add('immovables', 'JSON Помилка №' . $js_error . ' - ' . json_last_error_msg());
        }

        $r['clients'] = json_decode($r['clients']);
        if ($js_error = json_last_error()) {
            $validator->getMessageBag()->add('clients', 'JSON Помилка №' . $js_error . ' - ' . json_last_error_msg());
        }

        $errors = $validator->errors()->messages();

        // Занйти кімнати по id
        if (!isset($errors['room_id'])) {
            if (!Room::find($r['room_id'])) {
                $validator->getMessageBag()->add('room_id', 'Кімнати з ID:' . $r['room_id'] . " не знайдено");
            }
        }

        // Занйти компнію забудовника по id
        if (!isset($errors['dev_company_id'])) {
            if (!DevCompany::find($r['dev_company_id'])) {
                $validator->getMessageBag()->add('dev_company_id', 'Компанію забудовника по ID:' . $r['dev_company_id'] . " не знайдено");
            }
        }

        // Занйти представника забудовника по id
        if (!isset($errors['dev_representative_id']) && $r['dev_representative_id']) {
            $representative_type_id = ClientType::where('key', 'representative')->value('id');
            if (!Client::where('id', $r['dev_representative_id'])->where('type', $representative_type_id)->first()) {
                $validator->getMessageBag()->add('dev_representative_id', 'Представника забудовника з ID:' . $r['dev_representative_id'] . " не знайдено");
            }
        }

        // Занйти менеджера забудовника по id
        if (!isset($errors['dev_manager_id']) && $r['dev_manager_id']) {
            $manager_type_id = ClientType::where('key', 'manager')->value('id');
            if (!Client::where('id', $r['dev_manager_id'])->where('type', $manager_type_id)->first()) {
                $validator->getMessageBag()->add('dev_manager_id', 'Менеджер забудовника з ID:' . $r['dev_manager_id'] . " не знайдено");
            }
        }

        // Дата та час укладання угоди
        if (!isset($errors['date_time'])) {
            $date_time = new \DateTime($r['date_time']);
            $time = $date_time ? $date_time->format('H:i') : null;
            $card_time = Time::where('time', $time)->where('active', true)->first();
            if (!$card_time) {
                $validator->getMessageBag()->add('date_time', 'Данні години для запису недоступні');
            }

            $current_date = strtotime(date('d.m.Y'));
            $card_date = strtotime($date_time->format('d.m.Y H:i'));

            if ($card_date < $current_date) {
                $validator->getMessageBag()->add('date_time', 'Вказана дата знаходиться у минулому');
            }
        }

        if (!empty($r['immovables']) && isset($r['immovables']) && count($r['immovables'])) {

            foreach ($r['immovables'] as $imm) {
                if (isset($imm) && !empty($imm)) {
                    $imm = json_decode(json_encode($imm), true);
                    $immovalbe_validator = Validator::make([
                        'contract_type_id' => $imm['contract_type_id'],
                        'building_id' => $imm['building_id'],
                        'imm_type_id' => $imm['imm_type_id'],
                        'imm_num' => $imm['imm_num'],
                    ], [
                        'contract_type_id' => ['required', 'numeric'],
                        'building_id' => ['required', 'numeric'],
                        'imm_type_id' => ['required', 'numeric'],
                        'imm_num' => ['required', 'numeric'],
                    ], [
                        'contract_type_id.required' => 'Необхідно вибрати тип договору',
                        'building_id.required' => 'Необхідно вибрати будівлю забудовника',
                        'imm_type_id.required' => 'Необхідно вибрати тип нерухомості',
                        'imm_num.required' => 'Необхідно вказати номер нерухомості',
                        'contract_type_id.numeric' => 'ID типу договору має бути у числовому форматі',
                        'building_id.numeric' => 'ID будівлі забудовника має бути у числовому форматі',
                        'imm_type_id.numeric' => 'ID типу нерухомості має бути у числовому форматі',
                        'imm_num.numeric' => 'Номер нерухомості має бути у числовому форматі',
                    ]);

                    $immovable_errors = $immovalbe_validator->errors()->messages();

                    // Занйти кімнати по id
                    if (!isset($immovable_errors['contract_type_id'])) {
                        if (!ContractType::find($imm['contract_type_id'])) {
                            $validator->getMessageBag()->add('contract_type_id', 'Тип договору з ID:' . $imm['contract_type_id'] . " не знайдено");
                        }
                    }

                    if (!isset($immovable_errors['building_id'])) {
                        if (!DeveloperBuilding::find($imm['building_id'])) {
                            $validator->getMessageBag()->add('building_id', 'Будинок з ID:' . $imm['building_id'] . " не знайдено");
                        }
                    }

                    if (!isset($immovable_errors['imm_type_id'])) {
                        if (!ImmovableType::find($imm['imm_type_id'])) {
                            $validator->getMessageBag()->add('imm_type_id', 'Тип нерухомості по ID:' . $imm['imm_type_id'] . " не знайдено");
                        }
                    }
                }
            }
        }

        return $validator;
    }

    public function count_days($card, $date)
    {
        $current_date = $date->getTimestamp();

        $day_height = strtotime($card->date_time->format('d.m.Y')) - $current_date;
        $day_height = intval(round($day_height / (60 * 60 * 24)));

        return $day_height;
    }

    public function get_card_title($card)
    {
        return "Тестовий заголовок з адресою та іншими данними";
    }

    public function get_card_short_info($card)
    {
        $result = [];

        $notary_short = "**";
        $reader_short = "**";
        $giver_short = "**";
        $dev_representative_short = "**";

        if ($card->notary)
            $notary_short = $this->get_short_name($card->notary);
        if ($card->notary)
            $dev_representative_short = $this->get_short_name($card->dev_representative);

        $contracts = $card->has_contracts;
        $reader = [];
        $delivery = [];
        foreach ($contracts as $contr) {
            $reader = $contr->contract->reader;
            if ($reader) {
                $reader[] = $this->get_short_name($reader);
            }

            $delivery = $contr->contract->delivery;
            if ($delivery) {
                $delivery[] = $this->get_short_name($delivery);
            }
        }

        $result = [
            'notary' => $notary_short,
            'developer_assistant' => $dev_representative_short,
            'notary_assistant_reader' => $reader ? implode("-", $reader) : $reader_short,
            'notary_assistant_giver' => $delivery ? implode("-", $delivery) : $giver_short,
        ];

        return $result;
    }

    public function get_short_name($person)
    {
        $str = null;

        if ($person)
            $str = mb_substr($person->name_n, 0, 1) . mb_substr($person->patronymic_n, 0, 1);
        return $str;
    }
}
