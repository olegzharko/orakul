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
use App\Models\Communal;
use App\Models\CommunalTemplate;
use App\Models\ConsentTemplate;
use App\Models\Contract;
use App\Models\ContractTemplate;
use App\Models\ContractType;
use App\Models\DevCompanyEmployer;
use App\Models\DevConsent;
use App\Models\DevConsentTemplate;
use App\Models\DeveloperBuilding;
use App\Models\DeveloperStatement;
use App\Models\DevEmployerType;
use App\Models\Exchange;
use App\Models\ExchangeRate;
use App\Models\FinalSignDate;
use App\Models\ImmFence;
use App\Models\Immovable;
use App\Models\ImmovableOwnership;
use App\Models\ImmovableType;
use App\Models\PropertyValuation;
use App\Models\PropertyValuationPrice;
use App\Models\QuestionnaireTemplate;
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
        $result['price_dollar'] = round($immovable->dollar / 100,2);
        $result['price_grn'] = round($immovable->grn / 100,2);
        $result['reserve_grn'] = round($immovable->reserve_grn / 100, 2);
        $result['reserve_dollar'] = round($immovable->reserve_dollar / 100,2);
        $result['m2_grn'] = round($immovable->m2_grn / 100, 2);
        $result['m2_dollar'] = round($immovable->m2_dollar / 100, 2);
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

        $currency_rate = $this->get_currency_rate($immovable_id);
        $price_dollar = round($r['price_grn']  / $currency_rate, 2);

        if (Immovable::find($immovable_id)->contract->clients->count()) {
            $reserve_dollar = round($r['reserve_grn'] / $currency_rate, 2);
            if (($reserve_dollar * 100) % 2) {
                $reserve_dollar = $reserve_dollar + 0.01;
            }
        } else {
            $reserve_dollar = round($r['reserve_grn'] / $currency_rate, 2);
        }

        $m2_dollar = round($r['m2_grn'] / $currency_rate, 2);

        if ($imm = Immovable::find($immovable_id)) {
            Immovable::where('id', $immovable_id)->update([
                'immovable_type_id' => $r['imm_type_id'],
                'developer_building_id' => $r['building_id'],
                'roominess_id' => $r['roominess_id'],
                'immovable_number' => $r['imm_number'],
                'registration_number' => $r['registration_number'],
                'grn' => $r['price_grn'] * 100,
                'dollar' => $price_dollar * 100,
                'reserve_grn' => $r['reserve_grn'] * 100,
                'reserve_dollar' => $reserve_dollar * 100,
                'm2_grn' => $r['m2_grn'] * 100,
                'm2_dollar' => $m2_dollar * 100,
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

        if (!$card = Card::find($card_id))
            return $this->sendError('', 'Карта по ID:' . $card_id . ' не було знайдено.');

        if ($exchange = ExchangeRate::where(['card_id' => $card_id])->first()) {
            $exchange_rate = $exchange->rate;
        } else {
            if ($minfin = Exchange::orderBy('created_at', 'desc')->where('created_at', '>=', $this->date->format('Y.m.d'))->first()) {

                ExchangeRate::updateOrCreate(
                    ['card_id' => $card_id],
                    ['rate' => $minfin->rate]);
//                $new_exchange_rate = new ExchangeRate();
//                $new_exchange_rate->card_id = $card_id;
//                $new_exchange_rate->rate = $minfin->rate;
//                $new_exchange_rate->save();

                $exchange_rate = $minfin->rate;
            }
            else
                $exchange_rate = null;
        }

//        $result['exchange_rate'] = round($exchange_rate / 100, 2);
        $result['exchange_rate'] = number_format($exchange_rate / 100, 2);;

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

        ExchangeRate::updateOrCreate(
            ['card_id' => $card_id],
            ['rate' => $currency_exchage * 100]
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

        return $this->sendResponse($result, 'Курс долара оновлено вручну.');
    }

    public function get_payment($immovable_id)
    {
        $result = [];

        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $payment = SecurityPayment::firstOrCreate(
            ['immovable_id' => $immovable_id],
            ['first_part_grn' => 1000000],
        );

        $result['sign_date'] = $payment->sign_date ? $payment->sign_date->format('d.m.Y') : null;
        $result['reg_num'] = $payment->reg_num;
        $result['first_part_grn'] = round($payment->first_part_grn / 100,2);
        $result['first_part_dollar'] = round($payment->first_part_dollar / 100,2);
        $result['last_part_grn'] = round($payment->last_part_grn / 100,2);
        $result['last_part_dollar'] = round($payment->last_part_dollar / 100,2);
        $result['final_date'] = $payment->final_date ? $payment->final_date->format('d.m.Y') : null;

        return $this->sendResponse($result, 'Забезпучвальний платіж по нерухомісті ID:' . $immovable_id);
    }

    public function update_payment($immovable_id, Request $r)
    {
        $result = [];

        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $validator = $this->validate_imm_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

//        $r['sign_date'] = \DateTime::createFromFormat('d.m.Y', $r['sign_date']);
//        $r['final_date'] = \DateTime::createFromFormat('d.m.Y', $r['final_date']);

        $currency_rate = $this->get_currency_rate($immovable_id);
        $first_part_dollar = round($r['first_part_grn']  / $currency_rate, 2);
        $last_part_dollar = round($r['last_part_grn'] / $currency_rate, 2);

        // прибрати розбіжність в ціні по доларам через заокруглення до більшого
        while (($first_part_dollar + $last_part_dollar) > $immovable->reserve_dollar / 100) {
            $first_part_dollar = $first_part_dollar - 0.01;
        }

        SecurityPayment::where('immovable_id', $immovable_id)->update([
            'sign_date' => $r['sign_date'] ? $r['sign_date']->format('Y.m.d.') : null,
            'reg_num' => $r['reg_num'],
            'first_part_grn' => $r['first_part_grn'] * 100,
            'first_part_dollar' => $first_part_dollar * 100,
            'last_part_grn' => $r['last_part_grn'] * 100,
            'last_part_dollar' => $last_part_dollar * 100,
            'final_date' => $r['final_date'] ? $r['final_date']->format('Y.m.d.') : null,
        ]);

        return $this->sendResponse($result, 'Забезпучвальний платіж по нерухомісті ID:' . $immovable_id . ' оновлено.');
    }

    public function new_exchange($card_id)
    {
        $result = [];

        $this->minfin->get_rate_exchange();

        $minfin = Exchange::orderBy('created_at', 'desc')->first();

        ExchangeRate::updateOrCreate(['card_id' => $card_id], ['rate' => $minfin->rate]);

        $result['exchange_rate'] = round($minfin->rate / 100, 2);

        return $this->sendResponse($result, 'Курс долара оновлено через minfin.com.ua');
    }

    private function get_immovables_by_card($card_id)
    {
        $result = [];
        $contract = null;

        $immovables_id = Card::get_card_immovable_id($card_id);

        $immovables = Immovable::get_all_by_id($immovables_id);

        foreach ($immovables as $key => $immovable) {
            $result[$key]['id'] = $immovable->id;
            $result[$key]['title'] = $this->convert->building_full_address_by_type($immovable);
            $result[$key]['list'] = ['Тест G інформація 1', 'Тест G інформація 2', 'Тест G інформація 3'];
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
        $result['price'] = $termnation_info->price;
        $result['notary_id'] = $termnation_info->notary_id;
        $result['reg_date'] = $termnation_info->reg_date ? $termnation_info->reg_date->format('d.m.Y') : null;
        $result['reg_number'] = $termnation_info->reg_num;

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

        if ($immovable->contract) {
            TerminationInfo::updateOrCreate(['contract_id' => $immovable->contract->id],[
                'price' => $r['price'],
                'notary_id' => $r['notary_id'],
                'reg_date' => $r['reg_date'],
                'reg_num' => $r['reg_number'],
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
        $termination_contract_templates = TerminationContractTemplate::select('id', 'title')->where('dev_company_id', $dev_company_id)->get();
        $termination_refund_templates = TerminationRefundTemplate::select('id', 'title')->where('dev_company_id', $dev_company_id)->get();

        $contract = Contract::where('immovable_id', $immovable_id)->first();

        $bank = BankAccountPayment::where('contract_id', $contract->id)->first();
        $taxes = BankTaxesPayment::where('contract_id', $contract->id)->first();
        $questionnaire = Questionnaire::where('contract_id', $contract->id)->first();
        $statement = DeveloperStatement::where('contract_id', $contract->id)->first();
        $communal = Communal::where('contract_id', $contract->id)->first();
        $final_sing_date = FinalSignDate::where('contract_id', $contract->id)->first();
        $termination_contract = TerminationContract::where('contract_id', $contract->id)->first();
        $termination_refund = TerminationRefund::where('contract_id', $contract->id)->first();

        $result['contract_type'] = $contract_type;
        $result['contract_templates'] = $contract_templates;
        $result['bank_templates'] = $bank_templates;
        $result['taxes_templates'] = $taxes_templates;
        $result['questionnaire_templates'] = $questionnaire_templates;
        $result['statement_templates'] = $statement_templates;
        $result['communal_templates'] = $communal_templates;
        $result['termination_contracts'] = $termination_contract_templates;
        $result['termination_refunds'] = $termination_refund_templates;

        $result['sign_date'] = $contract->sign_date ? $contract->sign_date->format('d.m.Y') : null;
        $result['final_sign_date'] = $final_sing_date && $final_sing_date->sign_date > $this->date ? $final_sing_date->sign_date->format('d.m.Y') : null;
        $result['ready'] = $contract->ready ? true : false;
        $result['type_id'] = $contract->type_id;
        $result['contract_template_id'] = $contract->template ? $contract->template->id : null;
        $result['bank_template_id'] = $bank->template_id ?? null;
        $result['taxes_template_id'] = $taxes->template_id ?? null;
        $result['questionnaire_template_id'] = $questionnaire->template_id ?? null;
        $result['statement_template_id'] = $statement->template_id ?? null;
        $result['communal_template_id'] = $communal->template_id ?? null;
        $result['termination_contract_id'] = null;
        $result['termination_refund_id'] = null;
        $result['termination_refund_notary_id'] = null;
        $result['termination_refund_reg_date'] = null;
        $result['termination_refund_reg_num'] = null;

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

        if ($termination_refund) {
            $result['termination_contract_id'] = $termination_contract->template_id;
            $result['termination_refund_id'] = $termination_refund->template_id;
            $result['termination_refund_notary_id'] = $termination_refund->notary_id;
            $result['termination_refund_reg_date'] = $termination_refund->reg_date ? $termination_refund->reg_date->format('d.m.Y') : null;
            $result['termination_refund_reg_number'] = $termination_refund->reg_num;
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
           'template_id' => $r['contract_template_id'],
           'ready' => $r['ready'],
           'sign_date' => $r['sign_date'],
        ]);

        FinalSignDate::updateOrCreate(
            ['contract_id' => $contract_id],
            ['sign_date' => $r['final_sign_date']]);

        BankAccountPayment::updateOrCreate(
            ['contract_id' => $contract_id],
            ['template_id' => $r['bank_template_id']]);

        BankTaxesPayment::updateOrCreate(
            ['contract_id' => $contract_id],
            ['template_id' => $r['taxes_template_id']]);

        Questionnaire::updateOrCreate(
            ['contract_id' => $contract_id],
            [
                'template_id' => $r['questionnaire_template_id'],
                'sign_date' => $r['sign_date'],
                'notary_id' => $notary_id,
            ]);

        DeveloperStatement::updateOrCreate(
            ['contract_id' => $contract_id],
            [
                'template_id' => $r['statement_template_id'],
                'sign_date' => $r['sign_date'],
                'notary_id' => $notary_id,
            ]);


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

        TerminationContract::updateOrCreate(
            ['contract_id' => $contract_id],
            [
                'template_id' => $r['termination_contract_id'],
            ]);

        TerminationRefund::updateOrCreate(
            ['contract_id' => $contract_id],
            [
                'template_id' => $r['termination_refund_id'],
                'notary_id' => $r['termination_refund_notary_id'],
                'reg_date' => $r['termination_refund_reg_date'],
                'reg_num' => $r['termination_refund_reg_number'],
            ]);

        if ($immovable->developer_building->dev_company) {
            $developer_type_id = DevEmployerType::where('alias', 'developer')->value('id');
            $dev_company_id = $immovable->developer_building->dev_company->id;
            $owner_id = DevCompanyEmployer::where(['dev_company_id' => $dev_company_id, 'type_id' => $developer_type_id])->value('employer_id');
            $owner = Client::find($owner_id);

            if ($owner && !$owner->married) {
//                DevConsent::updateOrCreate(
//                    ['contract_id' => $contract_id],
//                    [
//                        'template_id' => DevConsentTemplate::where('dev_company_id', $dev_company_id)->value('id'),
//                        'contract_spouse_word_id' => SpouseWord::where(['dev_company_id' => $dev_company_id, 'developer' => true])->value('id'),
//                        'notary_id' => $notary_id,
//                        'reg_date' => $r['sign_date'],
//                    ]);

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
//        ExchangeRate::where('immovable_id', $immovable_id)->delete();
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
            'reg_num' => ['numeric', 'nullable'],
            'first_part_grn' => ['numeric', 'nullable'],
            'first_part_dollar' => ['numeric', 'nullable'],
            'last_part_grn' => ['numeric', 'nullable'],
            'last_part_dollar' => ['numeric', 'nullable'],
            'final_date' => ['date_format:Y.m.d', 'nullable'],
            'final_sign_date' => ['date_format:Y.m.d', 'nullable'],
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

    public function get_currency_rate($immovable_id)
    {
        $card_id = Contract::get_card_id_by_immovable_id($immovable_id);

        $rate = ExchangeRate::get_rate_by_imm_id($card_id);

        if (!$rate) {
            $rate = Exchange::get_minfin_rate();

            ExchangeRate::update_rate($card_id, $rate);
        }

        $rate = round($rate/100, 2);

        return $rate;
    }
}
