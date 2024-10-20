<?php

namespace App\Http\Controllers\Generator;

use App\Http\Controllers\API\MinfinController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Factory\GeneratorController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helper\ToolsController;
use App\Models\BankAccountPayment;
use App\Models\BankAccountTemplate;
use App\Models\BankTaxesPayment;
use App\Models\BankTaxesTemplate;
use App\Models\Client;
use App\Models\ClientContract;
use App\Models\Communal;
use App\Models\CommunalTemplate;
use App\Models\ConsentTemplate;
use App\Models\Contract;
use App\Models\ContractTemplate;
use App\Models\ContractType;
use App\Models\DeliveryAcceptanceAct;
use App\Models\DeliveryAcceptanceActTemplate;
use App\Models\DevCompanyEmployer;
use App\Models\DevConsent;
use App\Models\DevConsentTemplate;
use App\Models\DeveloperBuilding;
use App\Models\DeveloperStatement;
use App\Models\DevEmployerType;
use App\Models\Exchange;
use App\Models\ExchangeRate;
use App\Models\FinalSignDate;
use App\Models\FullSettlementApplication;
use App\Models\FullSettlementApplicationTemplate;
use App\Models\ImmFence;
use App\Models\Immovable;
use App\Models\ImmovableOwnership;
use App\Models\ImmovableType;
use App\Models\PersonalPropertyTemplate;
use App\Models\PropertyValuation;
use App\Models\PropertyValuationPrice;
use App\Models\QuestionnaireTemplate;
use App\Models\ProcessingPersonalData;
use App\Models\ProcessingPersonalDataTemplate;
use App\Models\Room;
use App\Models\Notary;
use App\Models\RoominessType;
use App\Models\ClientSpouseConsent;
use App\Models\SecurityPayment;
use App\Models\SpouseWord;
use App\Models\StatementTemplate;
use App\Models\Questionnaire;
use App\Models\TerminationConsent;
use App\Models\TerminationContract;
use App\Models\TerminationContractTemplate;
use App\Models\TerminationInfo;
use App\Models\TerminationRefund;
use App\Models\TerminationRefundTemplate;
use App\Models\PersonalProperty;
use Illuminate\Http\Request;
use App\Models\Card;
use Laravel\Nova\Fields\DateTime;
use Tests\Unit\ExampleTest;
use Validator;
use DB;

class ImmovableController extends BaseController
{
    public $tools;
    public $generator;
    public $convert;
    public $minfin;
    public $date;

    public function __construct()
    {
        $this->tools = new ToolsController();
        $this->generator = new GeneratorController();
        $this->convert = new ConvertController();
        $this->minfin = new MinfinController();
        $this->date = new \DateTime();
    }

    public function main($card_id)
    {
        $result = null;

        if (!$card = Card::find($card_id)) {
            return $this->sendError('', 'Картка відсутня');
        }

        $result = $this->get_immovables_by_card($card_id);

        return $this->sendResponse($result, "Нерухомість по карточці ID: $card_id");
    }

    public function get_general($immovable_id)
    {
        $result = [];

        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість з ID: ' . $immovable_id .  ' відсутня ');

        $immovable_type = ImmovableType::get_immovable_type();
        $developer_building = DeveloperBuilding::get_developer_building($immovable->developer_building->dev_company->id);

        $building = [];
        foreach ($developer_building as $key => $dev_building) {
            $building[$key]['id'] = $dev_building->id;
            $building[$key]['title'] = $this->convert->building_address_type_title_number($dev_building);
        }

        $roominess = RoominessType::select('id', 'title')->where('active', true)->orderBy('sort_order')->get();

        $result['imm_type'] = $immovable_type;
        $result['building'] = $building;
        $result['roominess'] = $roominess;

        $result['imm_type_id'] = $immovable->immovable_type ? $immovable->immovable_type->id : null;
        $result['building_id'] = $immovable->developer_building ? $immovable->developer_building->id : null;
        $result['roominess_id'] = $immovable->roominess ? $immovable->roominess->id : null;

        $result['imm_number'] = $immovable->immovable_number;
        $result['registration_number'] = $immovable->registration_number;
//        $result['price_dollar'] = round($immovable->dollar / 100,2);
        $result['price_dollar'] = 0;
        $result['price_grn'] = round($immovable->grn / 100,2);
        $result['reserve_grn'] = round($immovable->reserve_grn / 100, 2);
//        $result['reserve_dollar'] = round($immovable->reserve_dollar / 100,2);
        $result['reserve_dollar'] = 0;
        $result['m2_grn'] = round($immovable->m2_grn / 100, 2);
//        $result['m2_dollar'] = round($immovable->m2_dollar / 100, 2);
        $result['m2_dollar'] = 0;
        $result['total_space'] = $immovable->total_space;
        $result['living_space'] = $immovable->living_space;
        $result['floor'] = $immovable->floor;
        $result['complex'] = $immovable->developer_building ? $immovable->developer_building->complex : null;
        $result['section'] = $immovable->section;

        return $this->sendResponse($result, 'Загальні данні по нерухомості ID' . $immovable_id);
    }

    public function update_general($immovable_id, Request $r)
    {
        $validator = $this->validate_imm_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        $immovable = Immovable::find($immovable_id);

        $currency_rate = $this->get_currency_rate($immovable);

        $price_dollar = round($r['price_grn']  / $currency_rate, 2);

        if ($immovable->contract->clients->count() == 2) {
            $reserve_dollar = round($r['reserve_grn'] / $currency_rate, 2);
            if (($reserve_dollar * 100) % 2) {
                $reserve_dollar = $reserve_dollar + 0.01;
            }
        } else {
            $reserve_dollar = round($r['reserve_grn'] / $currency_rate, 2);
        }

        $m2_dollar = round($r['m2_grn'] / $currency_rate, 2);

        $m2_grn = null;
        if (isset($r['m2_grn']) && !empty($r['m2_grn'])) {
            $m2_grn = $r['m2_grn'] * 100;
        } elseif (Immovable::find($immovable_id)->contract->type->alias == 'preliminary') {
            if (isset($r['total_space']) && !empty($r['total_space']) && isset($r['price_grn']) && !empty($r['price_grn'])) {
                $m2_grn = $r['price_grn'] / $r['total_space'] * 100;
            } else {
                $m2_grn = null;
            }
        }

        $reserve_grn = null;
        if (Immovable::find($immovable_id)->contract->type->alias == 'preliminary') {
            if (isset($r['price_grn']) && !empty($r['price_grn'])) {
                $reserve_grn = ($r['price_grn'] - 1000) * 100;
            }
        } else {
            if (isset($r['reserve_grn']) && !empty($r['reserve_grn'])) {
                $reserve_grn = $r['reserve_grn'] * 100;
            }
        }

        if ($imm = Immovable::find($immovable_id)) {
            Immovable::where('id', $immovable_id)->update([
                'immovable_type_id' => $r['imm_type_id'],
                'developer_building_id' => $r['building_id'],
                'roominess_id' => $r['roominess_id'],
                'immovable_number' => $r['imm_number'],
                'registration_number' => $r['registration_number'],
                'grn' => $r['price_grn'] * 100,
//                'dollar' => $price_dollar * 100,
                'dollar' => 0,
//                'reserve_grn' => $r['reserve_grn'] * 100,
                'reserve_grn' => $reserve_grn,
//                'reserve_dollar' => $reserve_dollar * 100,
                'reserve_dollar' => 0,
//                'm2_grn' => $r['m2_grn'] * 100,
                'm2_grn' => $m2_grn,
//                'm2_dollar' => $m2_dollar * 100,
                'm2_dollar' => 0,
                'total_space' => $r['total_space'],
                'living_space' => $r['living_space'],
                'floor' => $r['floor'],
                'section' => $r['section'],
            ]);

            return $this->sendResponse('', 'Нерухомість під ID:' . $immovable_id . ' було успішно оновлено.');
        } else {
            return $this->sendError('', "Нерухомість с ID: $immovable_id не знайдено");
        }
    }

    public function get_exchange($card_id)
    {
        $result = [];

        $exchange_rate = null;
        $contract_buy = null;
        $contract_sell = null;
        $nbu_ask = null;
        $exchange_date = null;

        if (!$card = Card::find($card_id))
            return $this->sendError('', 'Карта по ID:' . $card_id . ' не було знайдено.');

        if ($exchange = ExchangeRate::where(['card_id' => $card_id])->first()) {
            $exchange_rate = $exchange->rate;
            $contract_buy = $exchange->contract_buy;
            $contract_sell = $exchange->contract_sell;
            $nbu_ask = $exchange->nbu_ask;
            $exchange_date = $exchange->updated_at;
        } else {
            if ($minfin = Exchange::orderBy('created_at', 'desc')->where('created_at', '>=', $this->date->format('Y.m.d'))->first()) {

                ExchangeRate::updateOrCreate(
                    ['card_id' => $card_id],
                    [
                        'rate' => $minfin->rate,
                        'contract_buy' => $minfin->contract_buy,
                        'contract_sell' => $minfin->contract_sell,
                        'nbu_ask' => $minfin->nbu_ask,
                    ]);

                $exchange_rate = $minfin->rate;
                $contract_buy = $minfin->contract_buy;
                $contract_sell = $minfin->contract_sell;
                $nbu_ask = $minfin->nbu_ask;
                $exchange_date = $minfin->updated_at;
            }
            else
                $exchange_rate = null;
        }

        $result['exchange_rate'] = number_format($exchange_rate / 100, 2);
        $result['contract_buy'] = number_format($contract_buy / 100, 2);
        $result['contract_sell'] = number_format($contract_sell / 100, 2);
        $result['nbu_ask'] = number_format($nbu_ask / 100, 2);
        $result['exchange_date'] = $exchange_date ? $exchange_date->format('d.m.Y H:i') : '';

        return $this->sendResponse($result, 'Курс для картки ID:' . $card_id);
    }

    public function update_exchange($card_id, Request $r)
    {
        $result = [];

        if (!$card = Card::find($card_id))
            return $this->sendError('', 'Карта по ID:' . $card . ' не було знайдено.');

        $validator = $this->validate_imm_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        $currency_exchage = round($r->exchange_rate, 2);
        $contract_buy = round($r->contract_buy, 2);
        $contract_sell = round($r->contract_sell, 2);
        $nbu_ask = round($r->nbu_ask, 2);

        ExchangeRate::updateOrCreate(
            ['card_id' => $card_id],
            [
                'rate' => $currency_exchage * 100,
                'contract_buy' => $contract_buy * 100,
                'contract_sell' => $contract_sell * 100,
                'nbu_ask' => $nbu_ask * 100,
            ]
        );

//        $currency_rate = $currency_exchage;
//        $imm_update = [];
//        $imm_update['dollar'] = $immovable->price_grn ? round($immovable->price_grn  / $currency_rate, 2) : null;
//        $imm_update['reserve_grn'] = $immovable->reserve_grn ? round($immovable->reserve_grn / $currency_rate, 2) : null;
//        $imm_update['m2_dollar'] = $immovable->m2_grn ? round($immovable->m2_grn / $currency_rate, 2) : null;
//
//        Immovable::where('id', $immovable_id)->update($imm_update);
//
//        $security_payment = SecurityPayment::where('immovable_id', $immovable_id)->first();
//
//        $security_update = [];
//        $security_update['first_part_dollar'] = $security_payment->first_part_dollar ? round($security_payment->first_part_dollar / $currency_rate, 2) : null;
//        $security_update['last_part_dollar'] = $security_payment->last_part_dollar ? round($security_payment->last_part_dollar / $currency_rate, 2) : null;
//
//        SecurityPayment::where('immovable_id', $immovable_id)->update($security_update);

        $result['exchange_rate'] = $currency_exchage;
        $result['contract_buy'] = $contract_buy;
        $result['contract_sell'] = $contract_sell;
        $result['nbu_ask'] = $nbu_ask;

        return $this->sendResponse($result, 'Курс долара оновлено вручну.');
    }

    public function get_payment($immovable_id)
    {
        $result = [];

        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $contract_id = Contract::where('immovable_id', $immovable_id)->value('id');
        $clients_id = ClientContract::where('contract_id', $contract_id)->pluck('client_id');
        $clients = Client::select('id', 'surname_n', 'name_n', 'patronymic_n')->whereIn('id', $clients_id)->get();
        $clients_arr = [];
        foreach ($clients as $key => $value) {
            $clients_arr[$key]['id'] = $value->id;
            $clients_arr[$key]['title'] = $this->convert->get_full_name_n($value);
        }

        $result['sign_date'] = null;
        $result['reg_num'] = null;
        $result['first_part_grn'] = null;
        $result['first_part_dollar'] = null;
        $result['last_part_grn'] = null;
        $result['last_part_dollar'] = null;
        $result['final_date'] = null;
        $result['clients'] = null;
        $result['client_id'] = null;

        $payment = SecurityPayment::where('immovable_id', $immovable_id)->first();

        if ($payment) {
            $result['sign_date'] = $payment->sign_date ? $payment->sign_date->format('d.m.Y') : null;
            $result['reg_num'] = $payment->reg_num;
            $result['first_part_grn'] = round($payment->first_part_grn / 100,2);
            $result['first_part_dollar'] = round($payment->first_part_dollar / 100,2);
            $result['last_part_grn'] = round($payment->last_part_grn / 100,2);
            $result['last_part_dollar'] = round($payment->last_part_dollar / 100,2);
            $result['final_date'] = $payment->final_date ? $payment->final_date->format('d.m.Y') : null;
            $result['clients'] = $clients_arr;

            if ($payment->client_id)
                $result['client_id'] = $payment->client_id;
            elseif (count($clients_arr) == 1)
                $result['client_id'] = $clients_arr[0]['id'];
        }

        return $this->sendResponse($result, 'Забезпучвальний платіж по нерухомісті ID:' . $immovable_id);
    }

    public function update_payment($immovable_id, Request $r)
    {
        $result = [];

        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        if (!$immovable->grn) {
            return $this->sendError('Відсутня ціна за нерухомість', '');
        }

        $validator = $this->validate_imm_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

//        $r['sign_date'] = \DateTime::createFromFormat('d.m.Y', $r['sign_date']);
//        $r['final_date'] = \DateTime::createFromFormat('d.m.Y', $r['final_date']);

        $currency_rate = $this->get_currency_rate($immovable);

        $first_part_dollar = round($r['first_part_grn']  / $currency_rate, 2);
        $last_part_dollar = round($r['last_part_grn'] / $currency_rate, 2);

        if (Immovable::find($immovable_id)->contract->clients->count() > 1) {
            $last_part_dollar = round($r['last_part_grn'] / $currency_rate, 2);
            if (($last_part_dollar * 100) % 2) {
                $last_part_dollar = $last_part_dollar + 0.01;
            }
        } else {
            $last_part_dollar = round($r['last_part_grn'] / $currency_rate, 2);
        }

        // прибрати розбіжність в ціні по доларам через заокруглення до більшого
        while ($immovable->reserve_dollar && ($first_part_dollar + $last_part_dollar) > ($immovable->reserve_dollar / 100)) {
            $first_part_dollar = $first_part_dollar - 0.01;
        }

        SecurityPayment::updateOrCreate(
            ['immovable_id' => $immovable_id],
            [
                'sign_date' => $r['sign_date'] ? $r['sign_date'] : null,
                'reg_num' => $r['reg_num'],
                'first_part_grn' => $r['first_part_grn'] * 100,
//                'first_part_dollar' => $first_part_dollar * 100,
                'first_part_dollar' => 0,
                'last_part_grn' => $immovable->reserve_grn - ($r['first_part_grn'] * 100),
//                'last_part_dollar' => $immovable->reserve_dollar - ($first_part_dollar * 100),
                'last_part_dollar' => 0,
                'final_date' => $r['final_date'] ? $r['final_date'] : null,
                'client_id' => $r['client_id'],
            ]);

        return $this->sendResponse($result, 'Забезпучвальний платіж по нерухомісті ID:' . $immovable_id . ' оновлено.');
    }

//    public function new_exchange($card_id)
//    {
//        $result = [];
//
//        $this->minfin->get_rate_exchange();
//
//        $minfin = Exchange::orderBy('created_at', 'desc')->first();
//
//        ExchangeRate::updateOrCreate(['card_id' => $card_id], [
//            'rate' => $minfin->rate,
//            'contract_buy' => $minfin->contract_buy,
//            'contract_sell' => $minfin->contract_sell,
//        ]);
//
//        $result['exchange_rate'] = round($minfin->rate / 100, 2);
//
//        return $this->sendResponse($result, 'Курс долара оновлено через minfin.com.ua');
//    }

    public function get_immovables_by_card($card_id)
    {
        $result = [];
        $contract = null;

        $immovables_id = Card::get_card_immovable_id($card_id);

        $immovables = Immovable::get_all_by_id($immovables_id);

        $contracts = Card::find($card_id)->has_contracts;


        foreach ($contracts as $key => $contract) {
            $immovable = $contract->immovable;

            $address = $this->convert->immovable_building_address($contract->immovable);

            $immovable = $contract->immovable;
            $immovable_type = $contract->immovable->immovable_type->alias;
            $contract_type = $contract->type->alias;

            $result[$key]['id'] = $immovable->id;
//            $result[$key]['title'] = $this->convert->building_full_address_by_type($immovable);
            $result[$key]['title'] = $address;
//            $result[$key]['list'][] = 'Тип нерухомості: ' . $immovable->immovable_type->title_n;
//            $result[$key]['list'][] = 'Номер нерухомості: ' . $immovable->immovable_number;


            $result[$key]['list'][] = "ID нерхомості: " . $this->convert->get_id_in_pad_format($immovable->id);
            if ($contract_type == 'main' && $immovable->registration_number)
                $result[$key]['list'][] = 'Реєстраційний номер: ' . $immovable->registration_number;
            elseif ($contract_type == 'main' && !$immovable->registration_number)
                $result[$key]['list'][] = 'Реєстраційний номер: -';

            if ($immovable->grn)
                $result[$key]['list'][] = 'Ціна грн: ' . $this->convert->get_number_format_thousand($immovable->grn) . " грн";
            else
                $result[$key]['list'][] = 'Ціна грн: -';

            if ($immovable->total_space)
                $result[$key]['list'][] = 'Загальна площа: ' . $immovable->total_space . " m2";
            else
                $result[$key]['list'][] = 'Загальна площа: -';

            if (!$immovable->living_space && $contract_type == 'main' && $immovable_type == 'appartment') // preliminary
                $result[$key]['list'][] = 'Житлова площа';

            if ($contract_type == 'preliminary' && $immovable->m2_grn)
                $result[$key]['list'][] = 'Ціна за m2: ' . $this->convert->get_number_format_thousand($immovable->m2_grn) . " грн";
            else
                $result[$key]['list'][] = 'Ціна за m2: -';

            if ($immovable->roominess_id && $contract_type == 'preliminary')
                $result[$key]['list'][] = 'Кімнатність: ' . $immovable->roominess_id;
            elseif (!$immovable->roominess_id && $contract_type == 'preliminary')
                $result[$key]['list'][] = 'Кімнатність: -';

            if (!$immovable->floor && $contract_type == 'preliminary' && $immovable_type == 'appartment')
                $result[$key]['list'][] = 'Поверх';
            if (!$immovable->section && $contract_type == 'preliminary' && $immovable_type == 'appartment')
                $result[$key]['list'][] = 'Секція';

            if ($contract->template_id)
                $result[$key]['list'][] = "Договір: обрано";
            else
                $result[$key]['list'][] = "Договір: -";

            if ($contract_type == 'preliminary' && $contract->bank_account_payment)
                $result[$key]['list'][] = 'Квитанція: обрана';
            elseif ($contract_type == 'preliminary' && !$contract->bank_account_payment)
                $result[$key]['list'][] = 'Квитанція: -';

            if ($contract->reader_id)
                $result[$key]['list'][] = 'Читач: ' . $this->convert->get_full_name($contract->reader);
            else
                $result[$key]['list'][] = 'Читач: -';

            if ($contract->accompanying_id)
                $result[$key]['list'][] = 'Видавач: ' . $this->convert->get_full_name($contract->accompanying);
            else
                $result[$key]['list'][] = 'Видавач: -';
        }

        return $result;
    }

    public function get_fence($immovable_id)
    {
        $result = null;

        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $imm_fence = ImmFence::where('immovable_id', $immovable_id)->first();

        $result['date'] = null;
        $result['number'] = null;
        $result['pass'] = null;

        if ($imm_fence) {
            $result['date'] = $imm_fence->date ? $imm_fence->date->format('d.m.Y') : null;
            $result['number'] = $imm_fence->number;
            $result['pass'] = $imm_fence->pass;
        }

        return $this->sendResponse($result, 'Дані по забороні на нерухомість ID:' . $immovable_id . ' отримано.');
    }

    public function update_fence($immovable_id, Request $r)
    {
        $result = null;

        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');


        $r['date'] = \DateTime::createFromFormat('d.m.Y H:i', $r['date']);
        ImmFence::updateOrCreate(
            ['immovable_id' => $immovable_id],
            [
                'date' => $r['date'] ? $r['date']->format('d.m.Y') : null,
                'number' => $r['number'],
                'pass' => $r['pass'],
            ]);

        return $this->sendResponse('', 'Дані по забороні на нерухомість ID:' . $immovable_id . ' оноволено.');
    }

    public function get_valuation($immovable_id)
    {
        $result = null;

        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $result['property_valuation'] = PropertyValuation::select('id', 'title')->where('active', 1)->get();
        $result['property_valuation_id'] = null;
        $result['date'] = null;
        $result['price'] = null;

        $pv_price = PropertyValuationPrice::where('immovable_id', $immovable_id)->first();
        if ($pv_price) {
            $result['property_valuation_id'] = $pv_price->property_valuation_id;
            $result['date'] = $pv_price->date ? $pv_price->date->format('d.m.Y') : null;
            $result['price'] = round($pv_price->grn/ 100,2);
            $result['title'] = $pv_price->title;
        }

        return $this->sendResponse($result, 'Дані оціночної компнанії по нерухомості ID:' . $immovable_id);
    }

    public function update_valuation($immovable_id, Request $r)
    {
        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $validator = $this->validate_imm_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        PropertyValuationPrice::updateOrCreate(['immovable_id' => $immovable_id], [
            'property_valuation_id' => $r['property_valuation_id'],
            'date' => $r['date'],
            'grn' => $r['price'] * 100,
            'title' => $r['title'],
        ]);

        return $this->sendResponse('', 'Дані оціночної компнанії по нерухомості ID:' . $immovable_id . ' оноволено.');
    }

    public function get_ownership($immovable_id)
    {
        $result = null;

        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $result['reg_date'] = null;
        $result['reg_number'] = null;
        $result['discharge_date'] = null;
        $result['discharge_number'] = null;
        $result['notary'] = null;

        if (!$imm_own = ImmovableOwnership::where('immovable_id', $immovable_id)->firstOrCreate()) {
            return $this->sendResponse($result, 'Дані по перевірці на власність відсутні.');
        }

        $convert_notary = [];
        $other_notary = [];
        $rakul_notary = Notary::where('active', true)->get();
        foreach ($rakul_notary as $key => $value) {
            $convert_notary[$key]['id'] = $value->id;
            $convert_notary[$key]['title'] = $this->convert->get_surname_and_initials_n($value);
        }

        $card_id = Immovable::where('immovables.id', $immovable_id)->join('contracts', 'contracts.immovable_id', '=', 'immovables.id')->value('contracts.card_id');
        if ($card_id) {
            $separate_by_card = Notary::where('separate_by_card', $card_id)->get();
            foreach ($separate_by_card as $key => $value) {
                $other_notary[$key]['id'] = $value->id;
                $other_notary[$key]['title'] = $this->convert->get_surname_and_initials_n($value);
            }
        }

        $result['notary'] = array_merge($convert_notary, $other_notary);

        $result['reg_date'] = $imm_own->gov_reg_date ? $imm_own->gov_reg_date->format('d.m.Y') : null;
        $result['reg_number'] = $imm_own->gov_reg_number;
        $result['discharge_date'] = $imm_own->discharge_date ? $imm_own->discharge_date->format('d.m.Y') : null;
        $result['discharge_number'] = $imm_own->discharge_number;
        $result['notary_id'] = $imm_own->notary_id;

        return $this->sendResponse($result, 'Дані по перевірці на власність нерухомості ID:' . $immovable_id);
    }

    public function update_ownership($immovable_id, Request $r)
    {
        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $validator = $this->validate_imm_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        ImmovableOwnership::updateOrCreate(['immovable_id' => $immovable_id],[
            'gov_reg_number' => $r['reg_number'],
            'gov_reg_date' => $r['reg_date'],
            'discharge_number' => $r['discharge_number'],
            'discharge_date' => $r['discharge_date'],
            'notary_id' => $r['notary_id'],
        ]);

        return $this->sendResponse('', 'Дані оновлено перевірок для ннерухомості ID:' . $immovable_id . ' оноволено.');
    }

    public function get_termination($immovable_id)
    {
        $result = null;

        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $card_id = Immovable::where('immovables.id', $immovable_id)->join('contracts', 'contracts.immovable_id', '=', 'immovables.id')->value('contracts.card_id');
        $contract_id = Contract::where('immovable_id', $immovable_id)->value('id');

        $all_clients_for_card = Contract::select('clients.*')
            ->where('contracts.card_id', $card_id)
            ->join('client_contract', 'client_contract.contract_id', '=', 'contracts.id')
            ->join('clients', 'clients.id', '=', 'client_contract.client_id')
            ->distinct('clients.id')
            ->get();

        $result['clients'] = null;
        foreach ($all_clients_for_card as $key => $client) {
            $result['clients'][$key]['id'] = $client->id;
            $result['clients'][$key]['title'] = $this->convert->get_full_name($client);
        }

        $termnation_info = TerminationInfo::firstOrCreate(
            ['contract_id' => $contract_id],
        );

        $convert_notary = [];
        $other_notary = [];
        $rakul_notary = Notary::where('active', true)->get();
        foreach ($rakul_notary as $key => $value) {
            $convert_notary[$key]['id'] = $value->id;
            $convert_notary[$key]['title'] = $this->convert->get_surname_and_initials_n($value);
        }

        $card_id = Immovable::where('immovables.id', $immovable_id)->join('contracts', 'contracts.immovable_id', '=', 'immovables.id')->value('contracts.card_id');
        if ($card_id) {
            $separate_by_card = Notary::where('separate_by_card', $card_id)->get();
            foreach ($separate_by_card as $key => $value) {
                $other_notary[$key]['id'] = $value->id;
                $other_notary[$key]['title'] = $this->convert->get_surname_and_initials_n($value);
            }
        }

        $result['notary'] = array_merge($convert_notary, $other_notary);
        $result['price_grn'] = $termnation_info->price_grn / 100;
        $result['price_dollar'] = $termnation_info->price_dollar / 100;
        $result['notary_id'] = $termnation_info->notary_id;
        $result['reg_date'] = $termnation_info->reg_date ? $termnation_info->reg_date->format('d.m.Y') : null;
        $result['reg_number'] = $termnation_info->reg_num;
        $result['first_client_id'] = $termnation_info->first_client_id;
        $result['second_client_id'] = $termnation_info->second_client_id;

        return $this->sendResponse($result, 'Дані для розірвання попереднього договру');
    }

    public function update_termination($immovable_id, Request $r)
    {
        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $validator = $this->validate_imm_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        if ($r['first_client_id'] == $r['second_client_id']) {
            unset($r['second_client_id']);
        }

        if ($r['first_client_id'] == null && $r['second_client_id']) {
           $r['first_client_id'] = $r['second_client_id'];
           unset($r['second_client_id']);
        }
        if ($immovable->contract) {
            TerminationInfo::updateOrCreate(['contract_id' => $immovable->contract->id],[
                'price_grn' => $r['price_grn'] * 100,
                'price_dollar' => $r['price_dollar'] * 100,
                'notary_id' => $r['notary_id'],
                'reg_date' => $r['reg_date'],
                'reg_num' => $r['reg_number'],
                'first_client_id' => $r['first_client_id'],
                'second_client_id' => $r['second_client_id'],
            ]);
        }

        return $this->sendResponse('', 'Дані розірвання для ннерухомості по ID:' . $immovable_id . ' оноволено.');
    }

    public function get_template($immovable_id)
    {
        $result = null;

        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $dev_company_id = $immovable->developer_building->dev_company->id;

        $contract_type = ContractType::select('id', 'title')->get();
        $contract_templates = ContractTemplate::select('id', 'title', 'type_id')->where('developer_id', $dev_company_id)->get();
        $bank_templates = BankAccountTemplate::select('id', 'title')->where('dev_company_id', $dev_company_id)->get();
        $taxes_templates = BankTaxesTemplate::select('id', 'title')->get();
        $questionnaire_templates = QuestionnaireTemplate::select('id', 'title')->where('developer_id', $dev_company_id)->get();
        $statement_templates = StatementTemplate::select('id', 'title')->where('developer_id', $dev_company_id)->get();

        $communal_templates = CommunalTemplate::select('id', 'title')->where('dev_company_id', $dev_company_id)->get();
        $processing_personal_data_templates = ProcessingPersonalDataTemplate::select('id', 'title')->where('dev_company_id', $dev_company_id)->get();
        $termination_contract_templates = TerminationContractTemplate::select('id', 'title')->where('dev_company_id', $dev_company_id)->get();
        $termination_refund_templates = TerminationRefundTemplate::select('id', 'title')->where('dev_company_id', $dev_company_id)->get();

        $full_settlement_application_templates = FullSettlementApplicationTemplate::select('id', 'title')->where('dev_company_id', $dev_company_id)->get();
        $deliveryActTemplates = DeliveryAcceptanceActTemplate::select('id', 'title')->where('developer_id', $dev_company_id)->get();
        $personalPropertyTemplates = PersonalPropertyTemplate::select('id', 'title')->where('developer_id', $dev_company_id)->get();

        $contract = Contract::where('immovable_id', $immovable_id)->first();

        $bank = BankAccountPayment::where('contract_id', $contract->id)->first();
        $taxes = BankTaxesPayment::where('contract_id', $contract->id)->first();
        $questionnaire = Questionnaire::where('contract_id', $contract->id)->first();
        $statement = DeveloperStatement::where('contract_id', $contract->id)->first();
        $communal = Communal::where('contract_id', $contract->id)->first();
        $processing_personal_data = ProcessingPersonalData::where('contract_id', $contract->id)->first();
        $final_sing_date = FinalSignDate::where('contract_id', $contract->id)->first();
        $termination_contract = TerminationContract::where('contract_id', $contract->id)->first();
        $termination_refund = TerminationRefund::where('contract_id', $contract->id)->first();
        $fullSettlementApplication = FullSettlementApplication::where('contract_id', $contract->id)->first();
        $deliveryAct = DeliveryAcceptanceAct::where('contract_id', $contract->id)->first();
        $personalProperty = PersonalProperty::where('contract_id', $contract->id)->first();

        $result['contract_type'] = $contract_type;
        $result['contract_templates'] = $contract_templates;
        $result['bank_templates'] = $bank_templates;
        $result['taxes_templates'] = $taxes_templates;
        $result['questionnaire_templates'] = $questionnaire_templates;
        $result['statement_templates'] = $statement_templates;
        $result['communal_templates'] = $communal_templates;
        $result['processing_personal_data_templates'] = $processing_personal_data_templates;
        $result['termination_contracts'] = $termination_contract_templates;
        $result['termination_refunds'] = $termination_refund_templates;
        $result['full_settlement_application_templates'] = $full_settlement_application_templates;
        $result['delivery_act_templates'] = $deliveryActTemplates;
        $result['personal_property_templates'] = $personalPropertyTemplates;

        if ($final_sing_date && $final_sing_date->sign_date > $this->date)
            $final_sing_date = $final_sing_date->sign_date->format('d.m.Y');
        elseif ($immovable->developer_building->communal_date)
            $final_sing_date = $immovable->developer_building->communal_date->format('d.m.Y');
        else
            $final_sing_date = null;

        $result['sign_date'] = $contract->sign_date ? $contract->sign_date->format('d.m.Y') : $contract->card->date_time->format('d.m.Y');
        $result['final_sign_date'] = $final_sing_date;
        $result['ready'] = $contract->ready ? true : false;
        $result['translate'] = $contract->translate ? true : false;
        $result['type_id'] = $contract->type_id;
        $result['contract_template_id'] = $contract->template ? $contract->template->id : null;
        $result['bank_template_id'] = $bank->template_id ?? null;
        $result['taxes_template_id'] = $taxes->template_id ?? null;
        $result['questionnaire_template_id'] = $questionnaire->template_id ?? null;
        $result['statement_template_id'] = $statement->template_id ?? null;
        $result['communal_template_id'] = $communal->template_id ?? null;
        $result['processing_personal_data_template_id'] = $processing_personal_data->template_id ?? null;
        $result['termination_contract_id'] = null;
        $result['termination_refund_id'] = null;
        $result['termination_refund_notary_id'] = null;
        $result['termination_refund_reg_date'] = null;
        $result['termination_refund_reg_num'] = null;
        $result['delivery_act_template_id'] = $deliveryAct->template_id ?? null;
        $result['personal_property_template_id'] = $personalProperty->template_id ?? null;

        $convert_notary = [];
        $other_notary = [];
        $rakul_notary = Notary::where('rakul_company', true)->get();
        foreach ($rakul_notary as $key => $value) {
            $convert_notary[$key]['id'] = $value->id;
            $convert_notary[$key]['title'] = $this->convert->get_surname_and_initials_n($value);
        }

        $card_id = Immovable::where('immovables.id', $immovable_id)->join('contracts', 'contracts.immovable_id', '=', 'immovables.id')->value('contracts.card_id');
        if ($card_id) {
            $separate_by_card = Notary::where('separate_by_card', $card_id)->get();
            foreach ($separate_by_card as $key => $value) {
                $other_notary[$key]['id'] = $value->id;
                $other_notary[$key]['title'] = $this->convert->get_surname_and_initials_n($value);
            }
        }

        $result['notary'] = array_merge($convert_notary, $other_notary);

        if ($termination_contract) {
            $result['termination_contract_id'] = $termination_contract->template_id;
        }

        if ($termination_refund) {
            $result['termination_refund_id'] = $termination_refund->template_id;
            $result['termination_refund_notary_id'] = $termination_refund->notary_id;
            $result['termination_refund_reg_date'] = $termination_refund->reg_date ? $termination_refund->reg_date->format('d.m.Y') : null;
            $result['termination_refund_reg_number'] = $termination_refund->reg_num;
        }

        if ($fullSettlementApplication) {
            $result['full_settlement_application_date'] = $fullSettlementApplication->full_settlement_date ? $fullSettlementApplication->full_settlement_date->format('d.m.Y') : null;
            $result['full_settlement_application_template_id'] = $fullSettlementApplication->template_id;
            $result['full_settlement_application_notary_id'] = $fullSettlementApplication->notary_id;
            $result['full_settlement_application_reg_date'] = $fullSettlementApplication->reg_date ? $fullSettlementApplication->reg_date->format('d.m.Y') : null;
            $result['full_settlement_application_reg_number'] = $fullSettlementApplication->reg_number;
        }

        return  $this->sendResponse($result, 'Дані по шаблонам');
    }

    public function update_template($immovable_id, Request $r)
    {
        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $validator = $this->validate_imm_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        $contract = Contract::where('immovable_id', $immovable_id)->first();
        $contract_id = $contract->id;
        $card_id = $contract->card_id;
        $card = Card::find($card_id);
        $notary_id = $card->notary_id;

        Contract::where('immovable_id', $immovable_id)->update([
            'type_id' => $r['type_id'],
            'template_id' => $r['contract_template_id'],
            'ready' => $r['ready'],
            'translate' => $r['translate'] ? 1 : 0,
            'sign_date' => $r['sign_date'],
        ]);

        if (isset($r['final_sign_date']) && !empty($r['final_sign_date'])) {
            FinalSignDate::updateOrCreate(
                ['contract_id' => $contract_id],
                ['sign_date' => $r['final_sign_date']]);
        } else {
            FinalSignDate::where('contract_id', $contract_id)->delete();
        }

        if ($r['bank_template_id']) {
            BankAccountPayment::updateOrCreate(
                ['contract_id' => $contract_id],
                ['template_id' => $r['bank_template_id']]);
        } else {
            BankAccountPayment::where('contract_id', $contract_id)->delete();
        }

        if ($r['taxes_template_id']) {
            BankTaxesPayment::updateOrCreate(
                ['contract_id' => $contract_id],
                ['template_id' => $r['taxes_template_id']]);
        } else {
            BankTaxesPayment::where('contract_id', $contract_id)->delete();
        }

        if ($r['questionnaire_template_id']) {
            Questionnaire::updateOrCreate(
                ['contract_id' => $contract_id],
                [
                    'template_id' => $r['questionnaire_template_id'],
                    'sign_date' => $r['sign_date'],
                    'notary_id' => $notary_id,
                ]);
        } else {
            Questionnaire::where('contract_id', $contract_id)->delete();
        }

        if ($r['delivery_act_template_id']) {
            DeliveryAcceptanceAct::updateOrCreate(
                ['contract_id' => $contract_id],
                [
                    'template_id' => $r['delivery_act_template_id'],
                    'sign_date' => $r['sign_date'],
                    'notary_id' => $notary_id,
                ]);
        } else {
            DeliveryAcceptanceAct::where('contract_id', $contract_id)->delete();
        }

        if ($r['personal_property_template_id']) {
            PersonalProperty::updateOrCreate(
                ['contract_id' => $contract_id],
                [
                    'template_id' => $r['personal_property_template_id'],
                    'sign_date' => $r['sign_date'],
                    'notary_id' => $notary_id,
                ]);
        } else {
            PersonalProperty::where('contract_id', $contract_id)->delete();
        }


        if ($r['statement_template_id']) {
            DeveloperStatement::updateOrCreate(
                ['contract_id' => $contract_id],
                [
                    'template_id' => $r['statement_template_id'],
                    'sign_date' => $r['sign_date'],
                    'notary_id' => $notary_id,
                ]);
        } else {
            DeveloperStatement::where('contract_id', $contract_id)->delete();
        }


        if ($r['communal_template_id']) {
            $r['final_date'] = clone $r['sign_date'];
            $r['final_date']->modify('+3 year');
            Communal::updateOrCreate(
                ['contract_id' => $contract_id],
                [
                    'template_id' => $r['communal_template_id'],
                    'sign_date' => $r['sign_date'],
                    'final_date' => $r['final_date'],
                    'notary_id' => $notary_id,
                ]);
        } else {
            Communal::where('contract_id', $contract_id)->delete();
        }

        if ($r['processing_personal_data_template_id']) {
            ProcessingPersonalData::updateOrCreate(
                ['contract_id' => $contract_id],
                ['template_id' => $r['processing_personal_data_template_id']]);
        } else {
            ProcessingPersonalData::where('contract_id', $contract_id)->delete();
        }

        if ($r['termination_contract_id']) {
            TerminationContract::updateOrCreate(
                ['contract_id' => $contract_id],
                ['template_id' => $r['termination_contract_id']]);
        } else {
            TerminationContract::where('contract_id', $contract_id)->delete();
        }

        if ($r['termination_refund_id']) {
            TerminationRefund::updateOrCreate(
                ['contract_id' => $contract_id],
                [
                    'template_id' => $r['termination_refund_id'],
                    'notary_id' => $r['termination_refund_notary_id'],
                    'reg_date' => $r['termination_refund_reg_date'],
                    'reg_num' => $r['termination_refund_reg_number'],
                ]);
        } else {
            TerminationRefund::where('contract_id', $contract_id)->delete();
        }

        if ($r['full_settlement_application_id'] || $r['full_settlement_application_date']) {
            FullSettlementApplication::updateOrCreate(
                ['contract_id' => $contract_id],
                [
                    'template_id' => $r['full_settlement_application_template_id'] ?? null,
                    'notary_id' => $r['full_settlement_application_notary_id'] ?? null,
                    'full_settlement_date' => $r['full_settlement_application_date'],
                    'reg_date' => $r['full_settlement_application_reg_date'] ?? null,
                    'reg_number' => $r['full_settlement_application_reg_number'] ?? null,
                ]
            );
        }

        if ($immovable->developer_building->dev_company) {
            $developer_type_id = DevEmployerType::where('alias', 'developer')->value('id');
            $dev_company_id = $immovable->developer_building->dev_company->id;
            $owner_id = DevCompanyEmployer::where(['dev_company_id' => $dev_company_id, 'type_id' => $developer_type_id])->value('employer_id');
            $owner = Client::find($owner_id);

            if ($owner && !$owner->married) {
                ClientSpouseConsent::updateOrCreate(
                    ['client_id' => $owner_id],
                    [
                        'notary_id' => $notary_id,
                        'template_id' => ConsentTemplate::where(['dev_company_id' => $dev_company_id, 'developer' => true])->value('id'),
                        'contract_spouse_word_id' => SpouseWord::where(['dev_company_id' => $dev_company_id, 'developer' => true])->value('id'),
                        'sign_date' => $r['sign_date'] ? $r['sign_date']->format('Y-m-d') : null,
                    ]
                );
            }
        }

        return $this->sendResponse('', 'Дані по шаблонам успішно оновлено');
    }

    public function destroy($immovable_id, $card_id)
    {
        $result = [];

        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        Contract::where('immovable_id', $immovable_id)->delete();
        ImmovableOwnership::where('immovable_id', $immovable_id)->delete();
        ImmFence::where('immovable_id', $immovable_id)->delete();
        PropertyValuationPrice::where('immovable_id', $immovable_id)->delete();
        SecurityPayment::where('immovable_id', $immovable_id)->delete();
        Immovable::find($immovable_id)->delete();

        $result = $this->get_immovables_by_card($card_id);

        return $this->sendResponse($result, 'Нерухомысть по ID:' . $immovable_id . ' було успішно видалено.');
    }

    private function validate_imm_data($r)
    {

        if (isset($r['date']) && !empty($r['date']))
            $r['date'] = \DateTime::createFromFormat('d.m.Y H:i', $r['date']);
        if (isset($r['reg_date']) && !empty($r['reg_date']))
            $r['reg_date'] = \DateTime::createFromFormat('d.m.Y H:i', $r['reg_date']);
        if (isset($r['discharge_date']) && !empty($r['discharge_date']))
            $r['discharge_date'] = \DateTime::createFromFormat('d.m.Y H:i', $r['discharge_date']);
        if (isset($r['sign_date']) && !empty($r['sign_date']))
            $r['sign_date'] = \DateTime::createFromFormat('d.m.Y H:i', $r['sign_date']);
        if (isset($r['final_date']) && !empty($r['final_date']))
            $r['final_date'] = \DateTime::createFromFormat('d.m.Y H:i', $r['final_date']);
        if (isset($r['final_sign_date']) && !empty($r['final_sign_date']))
            $r['final_sign_date'] = \DateTime::createFromFormat('d.m.Y H:i', $r['final_sign_date']);
        if (isset($r['full_settlement_application_date']) && !empty($r['full_settlement_application_date']))
            $r['full_settlement_application_date'] = \DateTime::createFromFormat('d.m.Y H:i', $r['full_settlement_application_date']);

//        dd(isset($r['sign_date'], $r['full_settlement_application_date']);
        $r['price_grn'] = $r['price_grn'] ? floatval(str_replace(",", ".", $r['price_grn'])) : null;
        $r['price_dollar'] = $r['price_dollar'] ? floatval(str_replace(",", ".", $r['price_dollar'])) : null;
        $r['reserve_grn'] = $r['reserve_grn'] ? floatval(str_replace(",", ".", $r['reserve_grn'])) : null;
        $r['m2_grn'] = $r['m2_grn'] ? floatval(str_replace(",", ".", $r['m2_grn'])) : null;
        $r['total_space'] = $r['total_space'] ? floatval(str_replace(",", ".", $r['total_space'])) : null;
        $r['living_space'] = $r['living_space'] ? floatval(str_replace(",", ".", $r['living_space'])) : null;
        $r['first_part_grn'] = $r['first_part_grn'] ? floatval(str_replace(",", ".", $r['first_part_grn'])) : null;
        $validator = Validator::make([
            'imm_type_id' => $r['imm_type_id'],
            'building_id' => $r['building_id'],
            'roominess_id' => $r['roominess_id'],
            'imm_number' => $r['imm_number'],
            'registration_number' => $r['registration_number'],
            'price_dollar' => $r['price_dollar'],
            'price_grn' => $r['price_grn'],
            'reserve_grn' => $r['reserve_grn'],
            'reserve_dollar' => $r['reserve_dollar'],
            'm2_grn' => $r['m2_grn'],
            'm2_dollar' => $r['m2_dollar'],
            'total_space' => $r['total_space'],
            'living_space' => $r['living_space'],
            'floor' => $r['floor'],
            'section' => $r['section'],

            'property_valuation_id' => $r['property_valuation_id'],
            'price' => $r['price'],
            'date' => $r['date'] ? $r['date']->format('Y.m.d.') : null,

            'reg_number' => $r['reg_number'],
            'reg_date' => $r['reg_date'] ? $r['reg_date']->format('Y.m.d.') : null,
            'discharge_number' => $r['discharge_number'],
            'discharge_date' => $r['discharge_date'] ? $r['discharge_date']->format('Y.m.d.') : null,

            'contract_template_id' => $r['contract_template_id'],
            'bank_template_id' => $r['bank_template_id'],
            'taxes_template_id' => $r['taxes_template_id'],
            'questionnaire_template_id' => $r['questionnaire_template_id'],
            'statement_template_id' => $r['statement_template_id'],

            'exchange_rate' => $r['exchange_rate'],

            'sign_date' => $r['sign_date'] ? $r['sign_date']->format('Y.m.d') : null,
            'reg_num' => $r['reg_num'],
            'first_part_grn' => $r['first_part_grn'],
            'first_part_dollar' => $r['first_part_dollar'],
            'last_part_grn' => $r['last_part_grn'],
            'last_part_dollar' => $r['last_part_dollar'],
            'final_date' => $r['final_date'] ? $r['final_date']->format('Y.m.d') : null,
            'final_sign_date' => $r['final_sign_date'] ? $r['final_sign_date']->format('Y.m.d') : null,
            'full_settlement_application_date' => $r['full_settlement_application_date'] ? $r['full_settlement_application_date']->format('Y.m.d') : null,
        ], [
            'imm_type_id' => ['numeric', 'nullable'],
            'building_id' => ['numeric', 'nullable'],
            'roominess_id' => ['numeric', 'nullable'],
            'imm_number' => ['string', 'nullable'],
            'registration_number' => ['numeric', 'nullable'],
            'price_dollar' => ['numeric', 'nullable'],
            'price_grn' => ['numeric', 'nullable'],
            'reserve_grn' => ['numeric', 'nullable'],
            'reserve_dollar' => ['numeric', 'nullable'],
            'm2_grn' => ['numeric', 'nullable'],
            'm2_dollar' => ['numeric', 'nullable'],
            'total_space' => ['numeric', 'nullable'],
            'living_space' => ['numeric', 'nullable'],
            'floor' => ['numeric', 'nullable'],
            'section' => ['numeric', 'nullable'],

            'property_valuation_id' => ['numeric', 'nullable'],
            'price' => ['numeric', 'nullable'],
            'date' => ['date_format:Y.m.d.', 'nullable'],

            'reg_number' => ['numeric', 'nullable'],
            'reg_date' => ['date_format:Y.m.d.', 'nullable'],
            'discharge_number' => ['numeric', 'nullable'],
            'discharge_date' => ['date_format:Y.m.d.', 'nullable'],

            'contract_template_id' => ['numeric', 'nullable'],
            'bank_template_id' => ['numeric', 'nullable'],
            'taxes_template_id' => ['numeric', 'nullable'],
            'questionnaire_template_id' => ['numeric', 'nullable'],
            'statement_template_id' => ['numeric', 'nullable'],

            'exchange_rate' => ['numeric', 'nullable'],

            'sign_date' => ['date_format:Y.m.d', 'nullable'],
            'reg_num' => ['string', 'nullable'],
            'first_part_grn' => ['numeric', 'nullable'],
            'first_part_dollar' => ['numeric', 'nullable'],
            'last_part_grn' => ['numeric', 'nullable'],
            'last_part_dollar' => ['numeric', 'nullable'],
            'final_date' => ['date_format:Y.m.d', 'nullable'],
            'final_sign_date' => ['date_format:Y.m.d', 'nullable'],
            'full_settlement_application_date' => ['date_format:Y.m.d', 'nullable'],
        ], [
            'imm_type_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'building_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'roominess_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'imm_number.string' => 'Необхідно передати номер в строковому форматі',
            'registration_number.numeric' => 'Необхідно передати номер в числовому форматі',
            'price_dollar.numeric' => 'Необхідно передати ціну в числовому форматі',
            'price_grn.numeric' => 'Необхідно передати ціну в числовому форматі',
            'reserve_grn.numeric' => 'Необхідно передати ціну в числовому форматі',
            'reserve_dollar.numeric' => 'Необхідно передати ціну в числовому форматі',
            'm2_grn.numeric' => 'Необхідно передати ціну в числовому форматі',
            'm2_dollar.numeric' => 'Необхідно передати ціну в числовому форматі',
            'total_space.numeric' => 'Необхідно передати площу в числовому форматі',
            'living_space.numeric' => 'Необхідно передати площу в числовому форматі',
            'floor.numeric' => 'Необхідно передати поверх в числовому форматі',
            'section.numeric' => 'Необхідно передати секцію в числовому форматі',

            'property_valuation_id.numeric' => 'Необхідно передати ID оціночної компанії в числовому форматі',
            'date.date_format' => 'Необхідно передати дату у форматі Y.m.d. Приклад: ' . date('Y.m.d.'),

            'reg_number.numeric' => 'Необхідно передати номер перевірки в числовому форматі',
            'reg_date.date_format' => 'Необхідно передати дату у форматі Y.m.d. Приклад: ' . date('Y.m.d.'),
            'discharge_number.numeric' => 'Необхідно передати номер перевірки в числовому форматі',
            'discharge_date.date_format' => 'Необхідно передати дату у форматі Y.m.d. Приклад: ' . date('Y.m.d.'),

            'contract_template_id.numeric' => 'Необхідно передати ID шаблону кантракту в числовому форматі',
            'bank_template_id.numeric' => 'Необхідно передати ID шаблону банківського рахунку в числовому форматі',
            'taxes_template_id.numeric' => 'Необхідно передати ID шаблону оплати падтків в числовому форматі',
            'questionnaire_template_id.numeric' => 'Необхідно передати ID шаблону анкети в числовому форматі',
            'statement_template_id.numeric' => 'Необхідно передати ID шаблону заяви від забудовника в числовому форматі',

            'exchange_rate.numeric' => 'Необхідно передати курс долара в числовому форматі',
            'full_settlement_application_date.date_format' => 'Необхідно передати дату у форматі Y.m.d. Приклад: ' . date('Y.m.d.'),
        ]);

        $errors = $validator->errors()->messages();

        if (!isset($errors['imm_type_id']) && isset($r['imm_type_id']) && !empty($r['imm_type_id'])) {
            if (!ImmovableType::find($r['imm_type_id'])) {
                $validator->getMessageBag()->add('imm_type_id', 'Тип нерухомості з ID:' . $r['imm_type_id'] . " не знайдено");
            }
        }

        if (!isset($errors['building_id']) && isset($r['building_id']) && !empty($r['building_id'])) {
            if (!DeveloperBuilding::find($r['building_id'])) {
                $validator->getMessageBag()->add('building_id', 'Будівлю з ID:' . $r['building_id'] . " не знайдено");
            }
        }

        if (!isset($errors['roominess_id']) && isset($r['roominess_id']) && !empty($r['roominess_id'])) {
            if (!RoominessType::find($r['roominess_id'])) {
                $validator->getMessageBag()->add('roominess_id', 'Кінатність з ID:' . $r['roominess_id'] . " не знайдено");
            }
        }

        if (!isset($errors['property_valuation_id']) && isset($r['property_valuation_id']) && !empty($r['property_valuation_id'])) {
            if (!PropertyValuation::find($r['property_valuation_id'])) {
                $validator->getMessageBag()->add('property_valuation_id', 'Оціночну компанію з ID:' . $r['property_valuation_id'] . " не знайдено");
            }
        }

        if (!isset($errors['contract_template_id']) && isset($r['contract_template_id']) && !empty($r['contract_template_id'])) {
            if (!ContractTemplate::find($r['contract_template_id'])) {
                $validator->getMessageBag()->add('contract_template_id', 'Шаблон договору з ID:' . $r['contract_template_id'] . " не знайдено");
            }
        }

        if (!isset($errors['bank_template_id']) && isset($r['bank_template_id']) && !empty($r['bank_template_id'])) {
            if (!BankAccountTemplate::find($r['bank_template_id'])) {
                $validator->getMessageBag()->add('bank_template_id', 'Шаблон банківського рахунку з ID:' . $r['bank_template_id'] . " не знайдено");
            }
        }

        if (!isset($errors['taxes_template_id']) && isset($r['taxes_template_id']) && !empty($r['taxes_template_id'])) {
            if (!BankTaxesTemplate::find($r['taxes_template_id'])) {
                $validator->getMessageBag()->add('taxes_template_id', 'Шаблон оплати податків з ID:' . $r['taxes_template_id'] . " не знайдено");
            }
        }

        if (!isset($errors['questionnaire_template_id']) && isset($r['questionnaire_template_id']) && !empty($r['questionnaire_template_id'])) {
            if (!QuestionnaireTemplate::find($r['questionnaire_template_id'])) {
                $validator->getMessageBag()->add('questionnaire_template_id', 'Шаблон анкети з ID:' . $r['questionnaire_template_id'] . " не знайдено");
            }
        }

        if (!isset($errors['statement_template_id']) && isset($r['statement_template_id']) && !empty($r['statement_template_id'])) {
            if (!StatementTemplate::find($r['statement_template_id'])) {
                $validator->getMessageBag()->add('statement_template_id', 'Шаблон заяви від забудовника з ID:' . $r['statement_template_id'] . " не знайдено");
            }
        }

        return $validator;
    }

    public function get_currency_rate($immovable)
    {
        $rate = 1;
        $card_id = Contract::get_card_id_by_immovable_id($immovable->id);

        $exchange = ExchangeRate::where('card_id', $card_id)->first();

        if ($immovable->developer_building->dev_company->ammount_rate && $exchange->rate)
            $rate = $exchange->rate ?? 1;
        elseif ($immovable->developer_building->dev_company->contract_rate && $exchange->contract_buy)
            $rate = $exchange->contract_buy ?? 1;
        elseif ($immovable->developer_building->dev_company->nbu_rate && $exchange->nbu_ask)
            $rate = $exchange->nbu_ask ?? 1;

//        if (!$rate) {
//            $rate = Exchange::get_minfin_rate();
//
//            ExchangeRate::update_rate($card_id, $rate);
//        }

        $rate = round($rate/100, 2);

        return $rate;
    }
}
