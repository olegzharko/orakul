<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;
use App\Http\Controllers\Factory\GeneratorController;
use App\Models\Card;
use App\Models\Contract;
use App\Models\Immovable;
use App\Models\DevEmployerType;
use App\Models\Staff;
use Illuminate\Http\Request;

class AssistantController extends BaseController
{
    public $tools;
    public $genrator;
    public $convert;
    public $developer_type;
    public $representative_type;

    public function __construct()
    {
        $this->tools = new ToolsController();
        $this->generator = new GeneratorController();
        $this->convert = new ConvertController();
        $this->developer_type = DevEmployerType::where('alias', 'developer')->value('id');
        $this->representative_type = DevEmployerType::where('alias', 'representative')->value('id');
        $this->manager_type = DevEmployerType::where('alias', 'manager')->value('id');
    }

    public function get_card_settings($card_id)
    {
        $result = [];

        $result['date_info'] = null;
        $result['notary'] = null;
        $result['developer'] = null;
        $result['representative'] = null;
        $result['manager'] = null;
        $result['notary_id'] = null;
        $result['developer_id'] = null;
        $result['representative_id'] = null;
        $result['manager_id'] = null;
        $result['generator'] = null;

        if (!$card = Card::find($card_id)) {
            return $this->sendError('', "Картка по ID: $card_id не знайдена");
        }

        $date_info = $this->tools->header_info($card);

        $notary = $this->tools->get_company_notary();
        $developer = $this->tools->get_dev_group();

        $representative = $this->tools->dev_group_employer_by_type($card->dev_group_id, $this->representative_type);
        $manager = $this->tools->dev_group_employer_by_type($card->dev_group_id, $this->manager_type);
        $generator = $this->tools->get_generator_staff();

        $immovables_id = Contract::where('card_id', $card_id)->pluck('immovable_id');

        $immovables = Immovable::whereIn('immovables.id', $immovables_id)->select(
            'immovables.*',
            'contracts.reader_id',
            'contracts.accompanying_id',
            'cards.staff_generator_id'
        )
        ->join('contracts', 'contracts.immovable_id', '=', 'immovables.id')
        ->join('cards', 'cards.id', '=', 'contracts.card_id')
        ->get();

        $imm_res = [];
        foreach ($immovables as $key => $immovable) {
            $imm_res[$key]['immovable_id'] = $immovable->id;
            $imm_res[$key]['address'] = $this->generator->full_ascending_address($immovable);
            $imm_res[$key]['reader_id'] = $immovable->reader_id;
            $imm_res[$key]['accompanying_id'] = $immovable->accompanying_id;
            $imm_res[$key]['printer_id'] = $immovable->printer_id;
        }

        $result['date_info'] = $date_info;
        $result['notary'] = $notary;
        $result['developer'] = $developer;
        $result['representative'] = $representative;
        $result['manager'] = $manager;
        $result['generator'] = $generator;

        $result['notary_id'] = $card->notary_id;
        $result['developer_id'] = $card->dev_company_id;
        $result['representative_id'] = $card->dev_representative_id;
        $result['manager_id'] = $card->dev_manager_id;

        $result['immovables'] = $imm_res;

        return $this->sendResponse($result, 'Дані для управління ролями по картці');
    }

    public function update_card_settings($card_id, Request $r)
    {
        if (!$card = Card::find($card_id)) {
            return $this->sendError('', "Картка по ID: $card_id не знайдена");
        }

        $validator = $this->validate_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        foreach ($r['immovables'] as $key => $value) {
            $validator = $this->validate_data($value);

            if (count($validator->errors()->getMessages())) {
                return $this->sendError('Форма передає помилкові дані', $validator->errors());
            }
        }

        Card::where('id', $card_id)->update([
            'notary_id' => $r['notary_id'],
            'dev_company_id' => $r['developer_id'],
            'dev_representative_id' => $r['representative_id'],
            'dev_manager_id' => $r['manager_id'],
        ]);

        foreach ($r['immovables'] as $key => $value) {
            Contract::where('immovable_id', $value['immovable_id'])->update([
                'reader_id' => $value['reader_id'],
                'accompanying_id' => $value['accompanying_id'],
                'printer_id' => $value['printer_id'],
            ]);
        }

        return $this->sendResponse('', 'Дані контакних осіб по карточці з ID:' . $card_id . ' оновлено.');
    }

    private function validate_data($r)
    {
//        if (isset($r['date']) && !empty($r['date']))
//            $r['date'] = \DateTime::createFromFormat('d.m.Y', $r['date']);

        $validator = Validator::make([
            'notary_id' => $r['notary_id'],
            'developer_id' => $r['developer_id'],
            'representative_id' => $r['representative_id'],
            'manager_id' => $r['manager_id'],

            'building_id' => $r['building_id'],
            'reader_id' => $r['reader_id'],
            'accompanying_id' => $r['accompanying_id'],
            'printer_id' => $r['printer_id'],
        ], [
            'notary_id' => ['numeric', 'nullable'],
            'developer_id' => ['numeric', 'nullable'],
            'representative_id' => ['numeric', 'nullable'],
            'manager_id' => ['numeric', 'nullable'],

            'building_id' => ['numeric', 'nullable'],
            'reader_id' => ['numeric', 'nullable'],
            'accompanying_id' => ['numeric', 'nullable'],
            'printer_id' => ['numeric', 'nullable'],
        ], [
            'notary_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'developer_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'representative_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'manager_id.numeric' => 'Необхідно передати ID в числовому форматі',

            'building_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'reader_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'accompanying_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'printer_id.numeric' => 'Необхідно передати ID в числовому форматі',
        ]);

        $errors = $validator->errors()->messages();

        if (!isset($errors['notary_id']) && isset($r['notary_id']) && !empty($r['notary_id'])) {
            if (!Notary::find($r['notary_id'])) {
                $validator->getMessageBag()->add('notary_id', 'Нотаріус з ID:' . $r['notary_id'] . " не знайдено");
            }
        }

        if (!isset($errors['developer_id']) && isset($r['developer_id']) && !empty($r['developer_id'])) {
            if (!DevCompany::find($r['developer_id'])) {
                $validator->getMessageBag()->add('developer_id', 'Забудовник з ID:' . $r['developer_id'] . " не знайдено");
            }
        }

        if (!isset($errors['representative_id']) && isset($r['representative_id']) && !empty($r['representative_id']) &&
            !isset($errors['developer_id']) && isset($r['developer_id'])) {
            $representative_type_id = ClientType::get_representative_type_id();
            if (!Client::where([
                        'id' => $r['representative_id'],
                        'dev_company_id' => $r['developer_id'],
                        'type_id' => $representative_type_id,
                    ])->first()) {
                $validator->getMessageBag()->add('representative_id', 'Представник з ID:' . $r['representative_id'] . " не знайдено");
            }
        }

        if (!isset($errors['manager_id']) && isset($r['manager_id']) && !empty($r['manager_id']) &&
            !isset($errors['developer_id']) && isset($r['developer_id'])) {
            $manager_type_id = ClientType::get_manager_type_id();
            if (!Client::where([
                        'id' => $r['manager_id'],
                        'dev_company_id' => $r['developer_id'],
                        'type_id' => $manager_type_id,
                    ])->first()) {
                $validator->getMessageBag()->add('manager_id', 'Менеджер з ID:' . $r['manager_id'] . " не знайдено");
            }
        }

        if (!isset($errors['immovable_id']) && isset($r['immovable_id']) && !empty($r['immovable_id'])) {
            if (!Immovable::find($r['immovable_id'])) {
                $validator->getMessageBag()->add('immovable_id', 'Нерухомість з ID:' . $r['immovable_id'] . " не знайдено");
            }
        }

        if (!isset($errors['reader_id']) && isset($r['reader_id']) && !empty($r['reader_id'])) {
            if (!Staff::where('id', $r['reader_id'])->where('reader', true)->first()) {
                $validator->getMessageBag()->add('reader_id', 'Читач з ID:' . $r['reader_id'] . " не знайдено");
            }
        }

        if (!isset($errors['accompanying_id']) && isset($r['accompanying_id']) && !empty($r['accompanying_id'])) {
            if (!Staff::where('id', $r['accompanying_id'])->where('accompanying', true)->first()) {
                $validator->getMessageBag()->add('accompanying_id', 'Видавач з ID:' . $r['accompanying_id'] . " не знайдено");
            }
        }

        if (!isset($errors['printer_id']) && isset($r['printer_id']) && !empty($r['printer_id'])) {
            if (!Staff::where('id', $r['printer_id'])->where('printer', true)->first()) {
                $validator->getMessageBag()->add('printer_id', 'Набирач з ID:' . $r['printer_id'] . " не знайдено");
            }
        }

        return $validator;
    }
}
