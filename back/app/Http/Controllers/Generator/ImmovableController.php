<?php

namespace App\Http\Controllers\Generator;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Factory\GeneratorController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helper\ToolsController;
use App\Models\BankAccountPayment;
use App\Models\BankAccountTemplate;
use App\Models\BankTaxesPayment;
use App\Models\BankTaxesTemplate;
use App\Models\ConsentTemplate;
use App\Models\Contract;
use App\Models\ContractTemplate;
use App\Models\DeveloperBuilding;
use App\Models\DeveloperStatement;
use App\Models\Exchange;
use App\Models\ExchangeRate;
use App\Models\ImmFence;
use App\Models\Immovable;
use App\Models\ImmovableOwnership;
use App\Models\ImmovableType;
use App\Models\PropertyValuation;
use App\Models\PropertyValuationPrice;
use App\Models\QuestionnaireTemplate;
use App\Models\Room;
use App\Models\RoominessType;
use App\Models\StatementTemplate;
use App\Models\Questionnaire;
use Illuminate\Http\Request;
use App\Models\Card;
use Tests\Unit\ExampleTest;
use Validator;
use DB;

class ImmovableController extends BaseController
{
    public $tools;
    public $generator;
    public $convert;

    public function __construct()
    {
        $this->tools = new ToolsController();
        $this->generator = new GeneratorController();
        $this->convert = new ConvertController();
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

        $immovable = Immovable::find($immovable_id);
        $immovable_type = ImmovableType::select('id', 'title_n')->get();
        $developer_building = DeveloperBuilding::where([
            'dev_company_id' => $immovable->developer_building->dev_company->id,
            'active' => true,
        ])->get();

        $building = [];
        foreach ($developer_building as $key => $dev_building) {
            $building[$key]['id'] = $dev_building->id;
            $building[$key]['address'] = $this->convert->get_full_address($dev_building);
        }

        $roominess = RoominessType::select('id', 'title')->where('active', true)->orderBy('sort_order')->get();

        $result['imm_type'] = $immovable_type;
        $result['building'] = $building;
        $result['roominess'] = $roominess;

        $result['imm_type_id'] = $immovable->immovable_type->id;
        $result['building_id'] = $immovable->developer_building->id;
        $result['roominess_id'] = $immovable->roominess->id;

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
        $result['complex'] = $immovable->developer_building->complex;

        return $this->sendResponse($result, 'Загальні данні по нерухомості ID' . $immovable_id);
    }

    public function update_general($immovable_id, Request $r)
    {
        $validator = $this->validate_imm_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }


        if ($imm = Immovable::find($immovable_id)) {
            Immovable::where('id', $immovable_id)->update([
                'immovable_type_id' => $r['imm_type_id'],
                'developer_building_id' => $r['building_id'],
                'roominess_id' => $r['roominess_id'],
                'immovable_number' => $r['imm_number'],
                'registration_number' => $r['registration_number'],
                'dollar' => $r['price_dollar'] * 100,
                'grn' => $r['price_grn'] * 100,
                'reserve_grn' => $r['reserve_grn'] * 100,
                'reserve_dollar' => $r['reserve_dollar'] * 100,
                'm2_grn' => $r['m2_grn'] * 100,
                'm2_dollar' => $r['m2_dollar'] * 100,
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

    public function get_exchange($immovable_id)
    {
        $result = [];

        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $minfin = Exchange::orderBy('created_at', 'desc')->first();

        $exchange = ExchangeRate::firstOrCreate(
            ['immovable_id' => $immovable_id],
            ['rate' => $minfin->rate],
        );

        $result['rate'] = round($minfin->rate / 100, 2);

        return $this->sendResponse($result, 'Курс для нерухомості ID:' . $immovable_id);
    }

    public function update_exchange($immovable_id, Request $r)
    {
        $result = [];

        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $validator = $this->validate_imm_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        return $this->sendResponse($result, 'Курс долара оновлено вручну.');
    }

    private function get_immovables_by_card($card_id)
    {
        $result = [];
        $contract = null;

        $immovables_id = Card::where('cards.id', $card_id)
            ->leftJoin('card_contract', 'cards.id', '=', 'card_contract.card_id')
            ->leftJoin('contracts', 'contracts.id', '=', 'card_contract.contract_id')
            ->leftJoin('immovables', 'contracts.immovable_id', '=', 'immovables.id')
            ->pluck('immovables.id');

        $immovables = Immovable::whereIn('id', $immovables_id)->get();

        foreach ($immovables as $key => $immovable) {
            $result[$key]['id'] = $immovable->id;
            $result[$key]['address'] = $this->generator->full_ascending_address_r($immovable);
            $result[$key]['list'] = ['Тестова інформація 1', 'Тестова інформація 2', 'Тестова інформація 3'];
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

        if ($imm_fence) {
            $result['date'] = $imm_fence->date ? $imm_fence->date->format('d.m.Y') : null;
            $result['number'] = $imm_fence->number;
        }

        return $this->sendResponse($result, 'Дані по забороні на нерухомість ID:' . $immovable_id . ' отримано.');
    }

    public function update_fence($immovable_id, Request $r)
    {
        $result = null;

        if (!$immovable = ImmFence::where('immovable_id', $immovable_id)->first())
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $r['date'] = \DateTime::createFromFormat('d.m.Y', $r['date']);

        ImmFence::where('immovable_id', $immovable_id)->update([
            'date' => $r['date'],
            'number' => $r['number'],
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

        PropertyValuationPrice::where('immovable_id', $immovable_id)->update([
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

        if (!$imm_own = ImmovableOwnership::where('immovable_id', $immovable_id)->first()) {
            $this->sendResponse($result, 'Дані по перевірці на власність відсутні.');
        }

        $result['reg_date'] = $imm_own->gov_reg_date ? $imm_own->gov_reg_date->format('d.m.Y') : null;
        $result['reg_number'] = $imm_own->gov_reg_number;
        $result['discharge_date'] = $imm_own->discharge_date ? $imm_own->discharge_date->format('d.m.Y') : null;
        $result['discharge_number'] = $imm_own->discharge_number;

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

        ImmovableOwnership::where('immovable_id', $immovable_id)->update([
            'gov_reg_number' => $r['reg_number'],
            'gov_reg_date' => $r['reg_date'],
            'discharge_number' => $r['discharge_number'],
            'discharge_date' => $r['discharge_date'],
        ]);

        return $this->sendResponse('', 'Дані оновлено перевірок для ннерухомості ID:' . $immovable_id . ' оноволено.');
    }

    public function get_template($immovable_id)
    {
        $result = null;

        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $contract_templates = ContractTemplate::select('id', 'title')->where('developer_id', $immovable->developer_building->dev_company->id)->get();
        $bank_templates = BankAccountTemplate::select('id', 'title')->get();
        $taxes_templates = BankTaxesTemplate::select('id', 'title')->get();
        $questionnaire_templates = QuestionnaireTemplate::select('id', 'title')->where('developer_id', $immovable->developer_building->dev_company->id)->get();
        $statement_templates = StatementTemplate::select('id', 'title')->where('developer_id', $immovable->developer_building->dev_company->id)->get();

        $contract = Contract::where('immovable_id', $immovable_id)->first();
        $bank = BankAccountPayment::where('contract_id', $contract->id)->first();
        $taxes = BankTaxesPayment::where('contract_id', $contract->id)->first();
        $questionnaire = Questionnaire::where('contract_id', $contract->id)->first();
        $statement = DeveloperStatement::where('contract_id', $contract->id)->first();

        $result['contract_templates'] = $contract_templates;
        $result['bank_templates'] = $bank_templates;
        $result['taxes_templates'] = $taxes_templates;
        $result['questionnaire_templates'] = $questionnaire_templates;
        $result['statement_templates'] = $statement_templates;

        $result['contract_template_id'] = $contract->contract_template_id;
        $result['bank_template_id'] = $bank->template_id ?? null;
        $result['taxes_template_id'] = $taxes->template_id ?? null;
        $result['questionnaire_template_id'] = $questionnaire->template_id ?? null;
        $result['statement_template_id'] = $statement->template_id ?? null;

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

        $contract_id = Contract::where('immovable_id', $immovable_id)->value('id');

        Contract::where('immovable_id', $immovable_id)->update([
           'contract_template_id' => $r['contract_template_id'],
        ]);

        BankAccountPayment::updateOrCreate(
            ['contract_id' => $contract_id],
            ['template_id' => $r['bank_template_id']]);

        BankTaxesPayment::updateOrCreate(
            ['contract_id' => $contract_id],
            ['template_id' => $r['taxes_template_id']]);

        Questionnaire::updateOrCreate(
            ['contract_id' => $contract_id],
            ['template_id' => $r['questionnaire_template_id']]);

        DeveloperStatement::updateOrCreate(
            ['contract_id' => $contract_id],
            ['template_id' => $r['statement_template_id']]);

        return $this->sendResponse('', 'Дані по шаблонам успішно оновлено');
    }

    private function validate_imm_data($r)
    {
        if (isset($r['date']) && !empty($r['date']))
            $r['date'] = \DateTime::createFromFormat('d.m.Y', $r['date']);
        if (isset($r['reg_date']) && !empty($r['reg_date']))
            $r['reg_date'] = \DateTime::createFromFormat('d.m.Y', $r['reg_date']);
        if (isset($r['discharge_date']) && !empty($r['discharge_date']))
            $r['discharge_date'] = \DateTime::createFromFormat('d.m.Y', $r['discharge_date']);

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

//            'rate' => $r['rate'],
        ], [
            'imm_type_id' => ['numeric', 'nullable'],
            'building_id' => ['numeric', 'nullable'],
            'roominess_id' => ['numeric', 'nullable'],
            'imm_number' => ['numeric', 'nullable'],
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
        ], [
            'imm_type_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'building_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'roominess_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'imm_number.numeric' => 'Необхідно передати номер в числовому форматі',
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
        ]);

        $errors = $validator->errors()->messages();

        if (!isset($errors['imm_type_id']) && isset($r['imm_type_id'])) {
            if (!ImmovableType::find($r['imm_type_id'])) {
                $validator->getMessageBag()->add('imm_type_id', 'Тип нерухомості з ID:' . $r['imm_type_id'] . " не знайдено");
            }
        }

        if (!isset($errors['building_id']) && isset($r['building_id'])) {
            if (!DeveloperBuilding::find($r['building_id'])) {
                $validator->getMessageBag()->add('building_id', 'Будівлю з ID:' . $r['building_id'] . " не знайдено");
            }
        }

        if (!isset($errors['roominess_id']) && isset($r['roominess_id'])) {
            if (!RoominessType::find($r['roominess_id'])) {
                $validator->getMessageBag()->add('roominess_id', 'Кінатність з ID:' . $r['roominess_id'] . " не знайдено");
            }
        }

        if (!isset($errors['property_valuation_id']) && isset($r['property_valuation_id'])) {
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
}
