<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;
use App\Http\Controllers\Staff\StaffController;
use App\Models\Card;
use App\Models\CardClient;
//use App\Models\CardContract;
use App\Models\ClientType;
use App\Models\ContractType;
use App\Models\DevCompany;
use App\Models\ImmovableType;
use App\Models\DeveloperBuilding;
use App\Models\SortType;
use App\Models\Deal;
use App\Models\WorkDay;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Contract;
use App\Models\Time;
use App\Models\Room;
use App\Models\DevEmployerType;
//use App\Models\UserPositionType;
use Validator;


class CardController extends BaseController
{
    public $date;
    public $rooms;
    public $times;
    public $immovable;
    public $contract;
    public $client;
    public $convert;
    public $tools;
    public $auth_user_type;
    public $staff;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->rooms = Room::where(['rooms.active' => true, 'room_types.alias' => 'meeting_room'])->orderBy('rooms.sort_order')->leftJoin('room_types', 'room_types.id', '=', 'rooms.type_id')->pluck('rooms.id')->toArray();
        $this->times = Time::where('active', true)->pluck('time')->toArray();
        $this->immovable = new ImmovableController();
        $this->contract = new ContractController();
        $this->client = new ClientController();
        $this->convert = new ConvertController();
        $this->tools = new ToolsController();
        $this->staff = new StaffController();

        if (auth() && auth()->user())
            $this->auth_user_type = auth()->user()->type;
        else
            $this->auth_user_type = null;
    }

    /*
     * GET
     * */
    public function index($user_type = null)
    {
        if (is_numeric($user_type)) {
            $id = $user_type;
            return $this->show($id);
        }
        $result = null;

        $cards_query = Card::whereIn('room_id', $this->rooms)
                ->where('date_time', '>=', $this->date->format('Y.m.d'));

        if (!$user_type) {
            $user_type = auth()->user()->type;
        }

        if ($user_type == 'calendar' || $user_type == 'reception') {
            $cards = $cards_query->where('cancelled', false)->get();
            $result = $this->get_cards_in_reception_format($cards);
        } elseif ($user_type == 'generator') {
            // картки для генерації договору
            $cards_generator_query = clone $cards_query;
            $cards_generator_id = $cards_generator_query->where('cards.staff_generator_id', auth()->user()->id)->where('cards.generator_step', true)->pluck('cards.id');
            $cards_generator = $cards_query->where('cards.staff_generator_id', auth()->user()->id)->where('cards.generator_step', true)->get();
//
            $result['generator'] = $this->get_cards_in_generator_format($cards_generator);
            // з'єднати договори картки з договорами
            $cards_query->where('contracts.ready', true)->orderBy('cards.date_time')
                ->leftJoin('contracts', 'contracts.card_id', '=', 'cards.id');

            // картки для читки договорів
            $cards_reader_query = clone $cards_query;
            $cards_read_id = $cards_reader_query->where('contracts.reader_id', auth()->user()->id)->pluck('cards.id');
            $cards_reader = Card::whereIn('id', $cards_read_id)->get();
            $result['reader'] = $this->get_cards_in_generator_format($cards_reader);

            // картки для видачі договорів
            $cards_accompanying_query = clone $cards_query;
            $cards_accompanying_id = $cards_accompanying_query->where('contracts.accompanying_id', auth()->user()->id)->pluck('cards.id');
            $cards_accompanying = Card::whereIn('id', $cards_accompanying_id)->get();
            $result['accompanying'] = $this->get_cards_in_generator_format($cards_accompanying);

            $info['generate'] = $this->tools->count_generate_cards($cards_generator_id);
            $info['read'] = $this->tools->count_read_cards($cards_read_id);
            $info['accompanying'] = $this->tools->count_accompanying_cards($cards_accompanying_id);

            $result['info'] = $info;

            // $result = $this->get_cards_in_generator_format($cards);
        } elseif ($user_type == 'manager' || $user_type == 'assistant') {
            $cards = $cards_query->orderBy('date_time')->get();
            $result = $this->get_cards_in_manager_format($cards);
        }
        else {
            return $this->sendError("Тип сторінки " . $user_type . " не підримується");
        }

        return $this->sendResponse($result, 'Картки з договорами');
    }

    /*
     * GET with param
     * */
    public function show($card_id)
    {
        $card = Card::select(
            'id',
            'room_id',
            'date_time',
            'notary_id',
            'dev_group_id as dev_company_id',
            'dev_representative_id',
            'dev_manager_id',
            'generator_step',
            'ready',
            'in_progress',
        )->find($card_id);

        if (!$card) {
            return $this->sendError("Картка по ID $card_id відсутня");
        }

        if ($card->date_time) {
            $card->date = $card->date_time->format('d.m');
            $card->time = $card->date_time->format('H:i');
            unset($card->date_time);
        } else {
            $card->date = null;
            $card->time = null;
        }

        $contracts = $card->has_contracts;

        $result_contract_immovable = [];
        $clients_id_by_contract = [];
        if (count($contracts)) {
            foreach ($contracts as $key => $contr) {
                // в договорі може бути відсутній клієнт, так як на рецепції утворюється котороткий запис ПІБ та номер телефону
                $result_contract_immovable[$key]['contract_type_id'] = null;
                $result_contract_immovable[$key]['building_id'] = null;
                $result_contract_immovable[$key]['immovable_id'] = null;
                $result_contract_immovable[$key]['imm_type_id'] = null;
                $result_contract_immovable[$key]['imm_number'] = null;
                $result_contract_immovable[$key]['bank'] = null;
                $result_contract_immovable[$key]['proxy'] = null;
                if ($contr) {

                    if ($contr->clients) {
                        $clients_id_by_contract = array_merge($clients_id_by_contract, $contr->clients->pluck('id')->toArray());
                    }

                    $result_contract_immovable[$key]['contract_type_id'] = $contr->type_id;
                    if ($contr->immovable) {
                        $result_contract_immovable[$key]['building_id'] = $contr->immovable->developer_building_id;
                        $result_contract_immovable[$key]['immovable_id'] = $contr->immovable->id;
                        $result_contract_immovable[$key]['imm_type_id'] = $contr->immovable->immovable_type_id;
                        $result_contract_immovable[$key]['imm_number'] = $contr->immovable->immovable_number;
                    }
                    $result_contract_immovable[$key]['bank'] = $contr->bank;
                    $result_contract_immovable[$key]['proxy'] = $contr->proxy;
                }
            }
        }

        $result_clients = [];
        $clients_id_by_contract = array_unique($clients_id_by_contract);
        if ($clients_id_by_contract) {
            $clients = Client::find($clients_id_by_contract);
            if ($clients) {
                foreach ($clients as $key => $cl) {
                    $result_clients[$key]['full_name'] = $this->convert->get_full_name($cl);
                    $result_clients[$key]['phone'] = $cl->phone;
                }
            }
        } else {
            $clients = Contact::where('card_id', $card->id)->get();

            if ($clients) {
                foreach ($clients as $key => $cl) {
                    $result_clients[$key]['full_name'] = $cl->full_name;
                    $result_clients[$key]['phone'] = $cl->phone;
                }
            }
        }
        $busy_meeting_room = Deal::where(['deals.ready' => false, 'room_types.alias' => 'meeting_room']) //
            ->whereNotIn('deals.card_id', [$card_id])
            ->leftJoin('rooms', 'rooms.id', '=', 'deals.room_id')
            ->leftJoin('room_types', 'room_types.id', '=', 'rooms.type_id')
            ->pluck('deals.room_id');
        
        $rooms = Room::select('rooms.id', 'rooms.title')
                ->where(['rooms.active' => true, 'location' => 'rakul'])
                ->whereNotIn('rooms.id', $busy_meeting_room)
                ->orderBy('rooms.sort_order')
                ->leftJoin('room_types', 'room_types.id', '=', 'rooms.type_id')
                ->get();

        $visit_info = Deal::select(
            'number_of_people',
            'children',
            'room_id',
        )->where('card_id', $card_id)->first();

        unset($card['has_contracts']);

        $result = [
            'card' => $card,
            'immovables' => $result_contract_immovable,
            'clients' => $result_clients,
            'rooms' => $rooms,
            'visit_info' => $visit_info,
        ];

        return $this->sendResponse($result, 'Карта з ID:' . $card_id);
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

        $date_time = \DateTime::createFromFormat('Y.m.d. H:i', $r['date_time']);

        if (Card::where('room_id', $r['room_id'])->where('date_time', $date_time)->first()) {
            return $this->sendError('Кімната: ' . $r['room_id'] . " на " . $r['date_time'] . " зайнята.");
        }

        $card_id = Card::new_card($r);

//        $immovables_info = $this->immovable->add_immovables($r);
        $immovables_info = $this->immovable->add_immovables($r);

        $this->contract->add_contracts_on_immovabel($card_id, $immovables_info);
        $this->client->add_card_clients($card_id, $r['clients']);

        $result = $this->get_single_card_in_reception_format($card_id);

        return $this->sendResponse($result, 'Запис створено успішно');
    }

    /*
     * PUT with param
     * */
    public function update(Request $r, $card_id)
    {
        if ($card = Card::where('id', $card_id)->where('generator_step', false)->where('cancelled', false)->first()) {

            $validator = $this->validate_data($r);

            if (count($validator->errors()->getMessages())) {
                return $this->sendError('Форма передає помилкові дані', $validator->errors());
            }

//            $contracts_id = CardContract::where('card_id', $card_id)->pluck('contract_id');
//            if (count($contracts_id)) {
            if ($old_immovables_id = Contract::where('card_id', $card_id)->pluck('immovable_id')) {
                $old_immovables_id = $old_immovables_id->toArray();
                $updated_immovables_id = $this->immovable->create_or_update_immovables_with_id($r, $card_id);

                // видалити нерухомість та контракти які були утворені попередньо, до початку обрабки менеджером
                $immovables_id_for_delete = array_values(array_diff($old_immovables_id, $updated_immovables_id));
                $this->immovable->delete_immovables_by_id($immovables_id_for_delete);
                $this->contract->delete_contracts_by_immovables_id($immovables_id_for_delete);
                $this->client->update_card_client($card_id, $r['clients']);
            }


            $date_time = \DateTime::createFromFormat('Y.m.d. H:i', $r['date_time']);

            Card::where('id', $card_id)->update([
                'notary_id' => $r['notary_id'],
                'room_id' => $r['room_id'],
                'date_time' => $date_time,
//                'dev_company_id' => $r['dev_company_id'],
                'dev_group_id' => $r['dev_company_id'],
                'dev_representative_id' => $r['dev_representative_id'],
                'dev_manager_id' => $r['dev_manager_id'],
            ]);

            $result = $this->get_single_card_in_reception_format($card_id);
            return $this->sendResponse($result, 'Запис оновлено успішно');
        } elseif (Card::where('id', $card_id)->where('generator_step', true)->where('cancelled', false)->first()) {
            return $this->sendError('Картка готова до видачі. Зміни з боку рецепції неможливі');
        }  elseif (Card::where('id', $card_id)->where('cancelled', true)->first()) {
            return $this->sendError('Картка скасована. Зміни з боку рецепції неможливі');
        }else {
            return $this->sendError('Не вдалось знайки картку');
        }
    }

    /*
 * PUT after move
 * */
    public function move(Request $r, $card_id)
    {
        if ($card = Card::where('id', $card_id)->first()) {

            $r['date_time'] = \DateTime::createFromFormat('Y.m.d. H:i', $r['date_time']);

            $validator = Validator::make([
                'room_id' => $r['room_id'],
                'date_time' => $r['date_time']
            ], [
                'room_id' => ['required', 'numeric'],
                'date_time' => ['required'],
            ], [
                'room_id.required' => 'Необхідно вибрати кімнату',
                'date_time.required' => 'Дата відсутня',
                'room_id.numeric' => 'Необхідно передати ID кімнати в числовому форматі',
            ]);

            if (count($validator->errors()->getMessages())) {
                return $this->sendError('Форма передає помилкові дані', $validator->errors());
            }

            Card::where('cancelled', true)->where('room_id', $r['room_id'])->where('date_time', $r['date_time'])->update([
               'date_time' => new \DateTime(),
            ]);

            Card::where('id', $card_id)->update([
                'room_id' => $r['room_id'],
                'date_time' => $r['date_time'],
            ]);

            $result = $this->get_single_card_in_reception_format($card_id);

            return $this->sendResponse($result, 'Запис ID: ' . $card_id . ' перемістився успішно');
        } else {
            return $this->sendError('Не вдалось знайти картку з ID' . $card_id);
        }
    }

    /*
     * DELETE
     * */
    public function destroy($id)
    {
        if ($card = Card::where('id', $id)->where('generator_step', false)->first()) {
//            $contracts_id = CardContract::where('card_id', $id)->pluck('contract_id');
//            if (count($contracts_id)) {
            if ($immovables_id_for_delete = Contract::where('card_id', $card->id)->pluck('immovable_id')) {

                // видалити нерухомість та контракти які були утворені попередньо, до початку обрабки менеджером
                $this->immovable->delete_immovables_by_id($immovables_id_for_delete);
                $this->contract->delete_contracts_by_immovables_id($immovables_id_for_delete);
            }
            Card::where('id', $card->id)->delete();
            return $this->sendResponse('', 'Картка та належні дані по нерухомісті та договрам були успішно видалені');
        } else {
            if (Card::where('id', $id)->where('generator_step', true)->first()) {
                return $this->sendError('Картка неможливо видалити, картка передана в обробку менеджеру');
            }
            if (!Card::find($id)) {
                return $this->sendError('Не вдалось знайки картку');
            }
        }
    }

    public function validate_data($r)
    {
//        $r['date_time'] = implode(". ", explode(" ", $r['date_time']));
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
            'date_time' => ['required', 'date_format:Y.m.d. H:i'],
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
            'date_time.date_format' => 'Необхідно передати дату у форматі Y.m.d. H:i Приклад: ' . date('Y.m.d. H') . ":00",
            'dev_company_id.numeric' => 'Необхідно передати ID компанії забудовника в числовому форматі',
            'dev_representative_id.numeric' => 'Необхідно передати ID представника забудовника в числовому форматі',
            'dev_manager_id.numeric' => 'Необхідно передати ID менеджера забудовника в числовому форматі',
        ]);

//        $r['immovables'] = json_decode($r['immovables']);
        if ($js_error = json_last_error()) {
            $validator->getMessageBag()->add('immovables', 'JSON Помилка №' . $js_error . ' - ' . json_last_error_msg());
        }

//        $r['clients'] = json_decode($r['clients']);
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
//            $representative_type_id = ClientType::where('key', 'representative')->value('id');
            if (!Client::where('id', $r['dev_representative_id'])->first()) {
                $validator->getMessageBag()->add('dev_representative_id', 'Представника забудовника з ID:' . $r['dev_representative_id'] . " не знайдено");
            }
        }

        // Занйти менеджера забудовника по id
        if (!isset($errors['dev_manager_id']) && $r['dev_manager_id']) {
//            $manager_type_id = ClientType::where('key', 'manager')->value('id');
            if (!Client::where('id', $r['dev_manager_id'])->first()) {
                $validator->getMessageBag()->add('dev_manager_id', 'Менеджер забудовника з ID:' . $r['dev_manager_id'] . " не знайдено");
            }
        }

        // Дата та час укладання угоди

        if (!isset($errors['date_time'])) {
//            dd('in', \DateTime::createFromFormat('Y.m.d. H:i', $r['date_time']));
            $date_time = \DateTime::createFromFormat('Y.m.d. H:i', $r['date_time']);
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

                    // Добвавить проверку полей Bank and Proxy на boolean value
                    $immovalbe_validator = Validator::make([
                        'contract_type_id' => $imm['contract_type_id'],
                        'building_id' => $imm['building_id'],
//                        'immovable_id' => $imm['immovable_id'],
                        'imm_type_id' => $imm['imm_type_id'],
                        'imm_number' => $imm['imm_number'],
                    ], [
                        'contract_type_id' => ['required', 'numeric'],
                        'building_id' => ['required', 'numeric'],
//                        'immovable_id' => ['numeric', 'nullable'],
                        'imm_type_id' => ['required', 'numeric'],
                        'imm_number' => ['required', 'numeric'],
                    ], [
                        'contract_type_id.required' => 'Необхідно вибрати тип договору',
                        'building_id.required' => 'Необхідно вибрати будівлю забудовника',
                        'imm_type_id.required' => 'Необхідно вибрати тип нерухомості',
                        'imm_number.required' => 'Необхідно вказати номер нерухомості',
                        'contract_type_id.numeric' => 'ID типу договору має бути у числовому форматі',
                        'building_id.numeric' => 'ID будівлі забудовника має бути у числовому форматі',
//                        'immovable_id.numeric' => 'ID нерухомості має бути у числовому форматі',
                        'imm_type_id.numeric' => 'ID типу нерухомості має бути у числовому форматі',
                        'imm_number.numeric' => 'Номер нерухомості має бути у числовому форматі',
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
        $start = new \DateTime($date->format('d.m.Y'));
        $end = new \DateTime($card->date_time->format('d.m.Y'));
        // otherwise the  end date is excluded (bug?)
        /*
        $end->modify('+1 day');
        */

        $interval = $end->diff($start);

        // total days
        $days = $interval->days;

        // create an iterateable period of date (P1D equates to 1 day)
        $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);

        // best stored as array, so you can add more than one
        $holidays = array('2012-09-07');

        foreach($period as $dt) {
            $curr = $dt->format('D');

            // substract if Saturday or Sunday
            if ($curr == 'Sun') {
                $days--;
            }

            // (optional) for the updated question
            elseif (in_array($dt->format('Y-m-d'), $holidays)) {
                $days--;
            }
        }

        $day_height = $days;

        return $day_height;
    }

    public function get_card_title($card)
    {
        $immovables = Contract::select(
            'immovables.immovable_type_id',
            'immovables.immovable_number',
            'developer_buildings.address_type_id',
            'developer_buildings.title',
            'developer_buildings.number',
            'address_types.short as address_short',
            'immovable_types.short as imm_short',
        )
            ->where('card_id', $card->id)
            ->join('immovables', 'immovables.id', '=', 'contracts.immovable_id')
            ->join('immovable_types', 'immovable_types.id', '=', 'immovables.immovable_type_id')
            ->join('developer_buildings', 'developer_buildings.id', '=', 'immovables.developer_building_id')
            ->join('address_types', 'address_types.id', '=', 'developer_buildings.address_type_id')
            ->get();

        $title = [];
        foreach ($immovables as $imm) {
            $title[] = $imm->address_short . ' ' . $imm->title . ' ' . $imm->number . ' ' . $imm->imm_short . ' ' . $imm->immovable_number;
        }
        if (count($immovables) == 2) {
            $title[] = "";
        } elseif (count($immovables) == 1) {
            $title[] = "";
            $title[] = "";
        }

        $title = implode(" <br> ", $title);

        return $title;
    }

    public function get_card_short_info($card)
    {
        $result = [];

        $notary_short = "##";
        $reader_short = "##";
        $giver_short = "##";
        $dev_representative_short = "##";


        if ($card->notary)
            $notary_short = $this->convert->get_short_name($card->notary);

        if ($card->dev_representative) {
            $dev_representative_short = $this->convert->get_short_name($card->dev_representative);
        }

        $contracts = $card->has_contracts;
        $reader = [];
        $accompanying = [];

        foreach ($contracts as $contr) {
            if  ($contr && $contr->reader) {
                $reader[$contr->reader->id] = $this->convert->get_short_name($contr->reader);
            }

            if  ($contr && $contr->accompanying) {
                $accompanying[$contr->accompanying->id] = $this->convert->get_short_name($contr->accompanying);
            }
        }

        $result = [
            'notary' => $notary_short,
            'dev_representative_id' => $dev_representative_short,
            'notary_assistant_reader' => $reader ? implode("-", $reader) : $reader_short,
            'notary_assistant_giver' => $accompanying ? implode("-", $accompanying) : $giver_short,
        ];

        return $result;
    }

    public function get_cards_in_reception_format($cards)
    {
        $result = [];
        $time_length = count($this->times);

        foreach ($cards as $key => $card) {
            if (in_array($card->date_time->format('H:i'), $this->times) && $card->date_time->format('D') != 'Sun') {
                $time_height = array_search($card->date_time->format('H:i'), $this->times);
                $day_height = $this->count_days($card, $this->date);
                $result[$key]['i'] = strval($card->id);
                $result[$key]['x'] = array_search($card->room->id, $this->rooms);
                if ($day_height)
                    $result[$key]['y'] = $time_height + $time_length * $day_height;
                else
                    $result[$key]['y'] = $time_height;
                $result[$key]['w'] = 1;
                $result[$key]['h'] = 1;
                $result[$key]['color'] = $card->dev_group ? $card->dev_group->color : null;
                $result[$key]['title'] = $this->get_card_title($card);
                $result[$key]['generator_step'] = $card->generator_step;
                $result[$key]['ready'] = $card->ready;
                $result[$key]['short_info'] = $this->get_card_short_info($card);

            }
        }

        return $result;
    }

    public function get_single_card_in_reception_format($card_id)
    {
        $card = Card::where('id', $card_id)->first();

        $result = [];
        $time_length = count($this->times);

        if (in_array($card->date_time->format('H:i'), $this->times)) {
            $time_height = array_search($card->date_time->format('H:i'), $this->times);
            $day_height = $this->count_days($card, $this->date);
            $result['i'] = strval($card->id);
            $result['x'] = array_search($card->room->id, $this->rooms);
            if ($day_height)
                $result['y'] = $time_height + $time_length * $day_height;
            else
                $result['y'] = $time_height;
            $result['w'] = 1;
            $result['h'] = 1;
            $result['color'] = $card->dev_group ? $card->dev_group->color : null;
            $result['title'] = $this->get_card_title($card);
            $result['short_info'] = $this->get_card_short_info($card);
        }

        return $result;
    }

    public function get_cards_in_manager_format($cards, $sort_type_id = null)
    {
        $group = [];
        $result = [];
        $week = WorkDay::where('active', true)->orderBy('num')->pluck('title', 'num')->toArray();
        $i = 0;

        foreach ($cards as $key => $card) {
            $result['id'] = $card->id;
            $result['color'] = $card->dev_group ? $card->dev_group->color : null;;
            $result['title'] = $this->get_card_title($card);
//            $result['short_info'] = $this->get_card_short_info($card);
            $result['instructions'] = $this->get_card_instructions($card);
            $test[] = $result;
            if (count($group) && $group[$i]['date'] == $card->date_time->format('d.m.')) {
                $group[$i]['cards'][] = $result;
            } else {
                $i = $card->date_time->format('d.m.');

                $day_num = $card->date_time->format('w');
                $group[$i]['day'] = $day_num ? $week[$day_num] : null;
                $group[$i]['date'] = $card->date_time->format('d.m.');
                if (!isset($group[$i]['cards']))
                    $group[$i]['cards'] = [];
                $group[$i]['cards'][] = $result;
            }
        }

        if ($sort_type_id) {
            $sort_type = SortType::where('id', $sort_type_id)->value('alias');

            if ($sort_type == 'desc')
                $group = array_values(array_reverse($group));
        }

        return $group;
    }


    public function get_cards_in_generator_format($cards, $sort_type_id = null)
    {
        $group = [];
        $result = [];
        $week = WorkDay::where('active', true)->orderBy('num')->pluck('title', 'num')->toArray();
        $i = 0;

        foreach ($cards as $key => $card) {
            $result['id'] = $card->id;
            $result['color'] = $card->dev_group ? $card->dev_group->color : null;
            $result['title'] = $this->get_card_title($card);

            $result['instructions'] = $this->get_card_instructions($card);
            $test[] = $result;
            if (count($group) && $group[$i]['date'] == $card->date_time->format('d.m.')) {
                $group[$i]['cards'][] = $result;
            } else {
                $i = $card->date_time->format('d.m.');

                $day_num = $card->date_time->format('w');
                $group[$i]['day'] = $day_num ? $week[$day_num] : null;
                $group[$i]['date'] = $card->date_time->format('d.m.');
                if (!isset($group[$i]['cards']))
                    $group[$i]['cards'] = [];
                $group[$i]['cards'][] = $result;
            }
        }

        if ($sort_type_id) {
            $sort_type = SortType::where('id', $sort_type_id)->value('alias');

            if ($sort_type == 'desc')
                $group = array_values(array_reverse($group));
        }

        return $group;
    }

    public function get_card_instructions($card)
    {
        $user_type = auth()->user()->type;
        $result = [];

        $ready[] = "ID: " . $this->convert->get_id_in_pad_format($card->id);
        if ($user_type == 'generator') {
            $ready[] = 'КУРС ДОЛАРА: ' . $this->get_card_currency($card);
        }
//        $ready[] = 'Забудовник: ';
//        $ready[] = $card->dev_group->title;
        $ready = $this->get_notary($card, $ready);

        if ($user_type == 'manager' || $user_type == 'assistant') {
            $ready = $this->card_generator($card, $ready);
        }

        $ready = $this->card_reader_and_accompanying($card, $ready);
        $ready = $this->card_representative($card, $ready);
        $ready = $this->get_clients($card, $ready);
        $ready = $this->current_step($card, $ready);

        return $ready;
    }

    public function get_card_currency($card)
    {
        $result = null;

        $rate = $card->exchange_rate && $card->exchange_rate->rate ? $card->exchange_rate->rate / 100 : "00.00";
        $contract_buy = $card->exchange_rate && $card->exchange_rate->contract_buy ? number_format($card->exchange_rate->contract_buy / 100, 2) : "00.00";
        $contract_sell = $card->exchange_rate && $card->exchange_rate->contract_sell ? $card->exchange_rate->contract_sell / 100 : "00.00";
        $updated_at = $card->exchange_rate && $card->exchange_rate->updated_at ? $card->exchange_rate->updated_at->format('d.m H:i') : "-";

        if ($card->exchange_rate)
            $result = "СК: " . $rate . " | ДК: " . $contract_buy . " | ДП: " . $contract_sell  . " | Від: " . $updated_at;
        else
            $result = "Курc відсутній";

        return $result;
    }

    public function card_generator($card, $ready)
    {
        if ($card->staff_generator_id) {
            $ready[] = "НАБИРАЧ: " . $this->convert->get_full_name($card->generator);
        }
        else
            $ready[] = "НАБИРАЧ: - ";

        return $ready;
    }

    public function get_clients($card, $ready)
    {
        $contract = $card->has_contracts->first();
        if ($contract->clients && $contract->clients->count() == 0)
            $ready[] = "ПОКУПЕЦЬ: - ";
        elseif ($contract->clients && $contract->clients->count() > 1)
            $ready[] = "ПОКУПЦІ: ";

        foreach ($contract->clients as $client) {
            if ($contract->clients->count() == 1) {
                $ready[] = "ПОКУПЕЦЬ: " . $this->convert->get_full_name($client);
            } else {
                $ready[] = $this->convert->get_full_name($client);
            }
        }

        return $ready;
    }

    public function current_step($card, $ready)
    {
        if ($card->generator_step == null) {
            $ready[] = 'ЕТАП: ' .  'Збір даних';
        } elseif ($card->ready && $card->cancelled == false) {
            $ready[] = 'ЕТАП: ' . 'Готово';
        } elseif ($card->cancelled == true) {
            $ready[] = 'ЕТАП: ' . 'Cкасовано';
        } else {
            $ready[] = 'ЕТАП: ' . 'Генерується ';
        }

        return $ready;
    }

    public function card_reader_and_accompanying($card, $ready)
    {
        $contracts = $card->has_contracts;

        $accompanying = [];
        foreach ($contracts as $contr) {

            if (!$immovable = $contr->immovable && $contr->immovable->developer_building)
                continue ;

            $developer_company = $contr->immovable->developer_building->dev_company->title;
//            $ready[] = 'ЗАБУДОВНИК: ';
            $ready[] = 'ЗАБУДОВНИК: ' . $developer_company;


            $address = $this->convert->immovable_building_address($immovable);
            $ready[] = 'АДРЕСА: ' . $address;
//            $ready[] = $address;

            if  ($contr->reader) {
                $ready[] = "ЧИТАЧ: " . $this->convert->get_full_name($contr->reader);
            }
            else
                $ready[] = "ЧИТАЧ: -";

            if ($contr->accompanying)
                $accompanying = $contr->accompanying;
        }

        if  ($accompanying) {
            $ready[] = "ВИДАВАЧ: " . $this->convert->get_staff_full_name($accompanying);
        } else {
            $ready[] = "ВИДАВАЧ: -";
        }

        return $ready;
    }

    public function get_notary($card, $ready)
    {
        if ($card->notary) {
            $ready[] = "НОТАРІУС: " .  $this->convert->get_full_name($card->notary);
        }
        else
            $ready[] = "НОТАРІУС: -";

        return $ready;
    }

    public function card_representative($card, $ready)
    {
        if ($card->notary) {
            $ready[] = "ПРЕДСТАВНИК: " .  $this->convert->get_full_name($card->dev_representative);
        }
        else
            $ready[] = "ПРЕДСТАВНИК: -";

        return $ready;
    }
}
