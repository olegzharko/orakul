<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;
use App\Http\Controllers\Factory\GeneratorController;
use App\Models\Card;
use App\Models\Contract;
use App\Models\DevGroup;
use App\Models\Immovable;
use App\Models\DevEmployerType;
use App\Models\Notary;
use App\Models\Client;
use App\Models\DevCompany;
use Illuminate\Http\Request;
use Validator;

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
        $accompanying = $this->tools->get_accompanying_staff();
        $reader = $this->tools->get_reader_staff();

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
            $imm_res[$key]['address'] = $this->convert->full_address_by_type($immovable);
            $imm_res[$key]['reader_id'] = $immovable->reader_id;
            $imm_res[$key]['accompanying_id'] = $immovable->accompanying_id;
        }

        $result['date_info'] = $date_info;
        $result['notary'] = $notary;
        $result['developer'] = $developer;
        $result['representative'] = $representative;
        $result['manager'] = $manager;
        $result['accompanying'] = $accompanying;
        $result['reader'] = $reader;
        $result['generator'] = $generator;

        $result['notary_id'] = $card->notary_id;
        $result['developer_id'] = $card->dev_group_id;
        $result['representative_id'] = $card->dev_representative_id;
        $result['manager_id'] = $card->dev_manager_id;
        $result['generator_id'] = $card->staff_generator_id;
        $result['cancelled'] = $card->cancelled ? true : false;

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
            $validator = $this->validate_data_immovable($value);

            if (count($validator->errors()->getMessages())) {
                return $this->sendError('Форма передає помилкові дані', $validator->errors());
            }
        }

        Card::where('id', $card_id)->update([
            'notary_id' => $r['notary_id'],
            'dev_group_id' => $r['developer_id'],
            'dev_representative_id' => $r['representative_id'],
            'dev_manager_id' => $r['manager_id'],
            'staff_generator_id' => $r['generator_id'],
            'cancelled' => $r['cancelled'] ? 1 : 0,
        ]);

        foreach ($r['immovables'] as $key => $value) {
            Contract::where('immovable_id', $value['immovable_id'])->update([
                'reader_id' => $value['reader_id'],
                'accompanying_id' => $value['accompanying_id'],
            ]);
        }

        return $this->sendResponse('', 'Дані контакних осіб по карточці з ID:' . $card_id . ' оновлено.');
    }

    private function validate_data($r)
    {
//        if (isset($r['date']) && !empty($r['date']))
//            $r['date'] = \DateTime::createFromFormat('d.m.Y', $r['date']);

        $validator = Validator::make([
            'cancelled' => $r['cancelled'],
            'developer_id' => $r['developer_id'],
            'generator_id' => $r['generator_id'],
            'manager_id' => $r['manager_id'],
            'notary_id' => $r['notary_id'],
            'representative_id' => $r['representative_id'],
        ], [
            'cancelled' => ['boolean', 'nullable'],
            'developer_id' => ['numeric', 'nullable'],
            'generator_id' => ['numeric', 'nullable'],
            'manager_id' => ['numeric', 'nullable'],
            'notary_id' => ['numeric', 'nullable'],
            'representative_id' => ['numeric', 'nullable'],
        ], [
            'cancelled.boolean' => 'Необхідно передати статус в boolean фомраті',
            'developer_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'generator_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'manager_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'notary_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'representative_id.numeric' => 'Необхідно передати ID в числовому форматі',
        ]);

        $errors = $validator->errors()->messages();

        if (!isset($errors['developer_id']) && isset($r['developer_id']) && !empty($r['developer_id'])) {
            if (!DevGroup::find($r['developer_id'])) {
                $validator->getMessageBag()->add('developer_id', 'Група забудовників з ID:' . $r['developer_id'] . " не знайдено");
            }
        }

        if (!isset($errors['notary_id']) && isset($r['notary_id']) && !empty($r['notary_id'])) {
            if (!Notary::find($r['notary_id'])) {
                $validator->getMessageBag()->add('notary_id', 'Нотаріус з ID:' . $r['notary_id'] . " не знайдено");
            }
        }

        return $validator;
    }


    private function validate_data_immovable($r)
    {
        $validator = Validator::make([
            'accompanying_id' => $r['accompanying_id'],
            'address' => $r['address'],
            'immovable_id' => $r['immovable_id'],
            'reader_id' => $r['reader_id'],
        ], [
            'accompanying_id' => ['numeric', 'nullable'],
            'address' => ['string', 'nullable'],
            'immovable_id' => ['numeric', 'nullable'],
            'reader_id' => ['numeric', 'nullable'],
        ], [
            'accompanying_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'address.string' => 'Необхідно передати назву в числовому форматі',
            'immovable_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'reader_id.numeric' => 'Необхідно передати ID в числовому форматі',
        ]);

        $errors = $validator->errors()->messages();

        if (!isset($errors['immovable_id']) && isset($r['immovable_id']) && !empty($r['immovable_id'])) {
            if (!Immovable::find($r['immovable_id'])) {
                $validator->getMessageBag()->add('immovable_id', 'Нерухомість з ID:' . $r['immovable_id'] . " не знайдено");
            }
        }

        return $validator;
    }
}
