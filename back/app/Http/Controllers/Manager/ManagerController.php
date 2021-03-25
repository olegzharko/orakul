<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;
use App\Http\Controllers\Factory\GeneratorController;
use App\Models\CardContract;
use App\Models\Contact;
use App\Models\Contract;
use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Notary;
use App\Models\DevCompany;
use App\Models\Client;
use App\Models\ClientType;
use App\Models\ContactType;
use App\Models\Immovable;
use App\Models\MarriageType;
use App\Models\ImmovableType;
use App\Models\DeveloperBuilding;
use Validator;

class ManagerController extends BaseController
{
    public $tools;
    public $genrator;
    public $convert;

    public function __construct()
    {
        $this->tools = new ToolsController();
        $this->generator = new GeneratorController();
        $this->convert = new ConvertController();
    }

    public function main($card_id)
    {
        $result = [];
        $result['date_info'] = null;
        $result['notary'] = null;
        $result['developer'] = null;
        $result['representative'] = null;
        $result['manager'] = null;
        $result['contact_person_type'] = null;
        $result['contact_person_info'] = null;
        $result['notary_id'] = null;
        $result['developer_id'] = null;
        $result['representative_id'] = null;
        $result['manager_id'] = null;

        if (!$card = Card::find($card_id)) {
            return $this->sendError('', "Картка по ID: $card_id не знайдена");
        }

        $date_info = $this->tools->header_info($card);

        $notary = $this->tools->get_company_notary();
        $developer = $this->tools->get_developer();

        $representative_type_id = ClientType::get_representative_type_id();
        $manager_type_id = ClientType::get_manager_type_id();

        $representative = $this->tools->developer_employer_by_type($card->dev_company_id, $representative_type_id);
        $manager = $this->tools->developer_employer_by_type($card->dev_company_id, $manager_type_id);
        $contact_person_type = ContactType::get_contact_type();
        $contact_person_info = Contact::contact_by_card($card_id);

        $result['date_info'] = $date_info;
        $result['notary'] = $notary;
        $result['developer'] = $developer;
        $result['representative'] = $representative;
        $result['manager'] = $manager;
        $result['contact_person_type'] = $contact_person_type;
        $result['contact_person_info'] = $contact_person_info;

        $result['notary_id'] = $card->notary_id;
        $result['developer_id'] = $card->dev_company_id;
        $result['representative_id'] = $card->dev_representative_id;
        $result['manager_id'] = $card->dev_manager_id;

        return $this->sendResponse($result, 'Дані по карточкці ID:' . $card_id);
    }

    public function update_notary_developer($card_id, Request $r)
    {
        if (!$card = Card::find($card_id)) {
            return $this->sendError('', 'Картка відсутня');
        }

        $validator = $this->validate_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        Card::where('id', $card_id)->update([
            'notary_id' => $r['notary_id'],
            'dev_company_id' => $r['developer_id'],
            'dev_representative_id' => $r['representative_id'],
            'dev_manager_id' => $r['manager_id'],
        ]);

        return $this->sendResponse('', 'Дані учасників угоди оновлено в карточці з ID:' . $card_id . ' оновлено.');
    }

    public function update_contact_person($card_id, Request $r)
    {
        if (!$card = Card::find($card_id)) {
            return $this->sendError('', 'Картка відсутня');
        }

        foreach ($r as $key => $value) {
            $validator = $this->validate_data($value);

            if (count($validator->errors()->getMessages())) {
                return $this->sendError('Форма передає помилкові дані', $validator->errors());
            }
        }

        $old_contact_id = Contact::where('card_id', $card_id)->pluck('id');


        foreach ($r as $key => $value) {
            Contact::updateOrCreate(
                ['id' =>  $value->id],
                [
                    'person_type' => $value->person_type,
                    'name' => $value->name,
                    'phone' => $value->phone,
                    'email' => $value->email,
                ]);
            if (($key = array_search($value->id, $old_contact_id)) !== false) {
                unset($old_contact_id[$key]);
            }
        }

        Contact::whereIn('id', $old_contact_id)->delete();

        return $this->sendResponse('', 'Дані контакних осіб по карточці з ID:' . $card_id . ' оновлено.');
    }

    public function immovable($card_id)
    {
        $result = [];

        if (!$card = Card::find($card_id)) {
            return $this->sendError('', 'Картка відсутня');
        }

        $immovables_id = Card::get_card_immovable_id($card_id);

        $immovables = Immovable::get_all_by_id($immovables_id);

        foreach ($immovables as $key => $immovable) {
            $result[$key]['id'] = $immovable->id;
            $result[$key]['address'] = $this->generator->full_ascending_address_r($immovable);
            $result[$key]['list'] = ['Тест M інформація 1', 'Тест M інформація 2', 'Тест M інформація 3'];
        }

        return $this->sendResponse($result, 'Нерухомості по карті ID:' . $card_id);
    }

    public function get_immovable($immovable_id)
    {
        $result = [];
        $result['immovable_type'] = null;
        $result['building'] = null;
        $result['reader'] = null;
        $result['accompanying'] = null;
        $result['printer'] = null;

        $result['immovable_type_id'] = null;
        $result['building_id'] = null;
        $result['immovable_number'] = null;
        $result['immovable_reg_num'] = null;

        $result['reader_id'] = null;
        $result['accompanying_id'] = null;
        $result['printer_id'] = null;

        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $immovable_type = ImmovableType::get_immovable_type();
        $developer_building = DeveloperBuilding::get_developer_building($immovable->developer_building->dev_company->id);

        $building = [];
        foreach ($developer_building as $key => $dev_building) {
            $building[$key]['id'] = $dev_building->id;
            $building[$key]['address'] = $this->convert->get_full_address($dev_building);
        }

        $reader = $this->tools->get_reader_staff();
        $accompanying = $this->tools->get_accompanying_staff();
        $printer = $this->tools->get_company_notary();

        $contract = Contract::get_contract_by_immovable($immovable_id);
        $card = CardContract::get_card_by_contract($contract->id);

        $result['immovable_type'] = $immovable_type;
        $result['building'] = $building;
        $result['reader'] = $reader;
        $result['accompanying'] = $accompanying;
        $result['printer'] = $printer;

        $result['immovable_type_id'] = $immovable->immovable_type_id;
        $result['building_id'] = $immovable->developer_building_id;
        $result['immovable_number'] = $immovable->immovable_number;
        $result['immovable_reg_num'] = $immovable->registration_number;

        $result['reader_id'] = $contract->reader_id;
        $result['accompanying_id'] = $contract->accompanying_id;
        $result['printer_id'] = $contract->printer_id;

        return $this->sendResponse($result, 'Дані по нерухомості ID:' . $immovable_id);
    }

    public function update_immovable($immovable_id, Request $r)
    {
        $result = [];
        $result['immovable_type_id'] = null;
        $result['building_id'] = null;
        $result['immovable_number'] = null;
        $result['immovable_reg_num'] = null;

        $result['reader_id'] = null;
        $result['accompanying_id'] = null;
        $result['printer_id'] = null;

        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $contract = Contract::get_contract_by_immovable($immovable_id);
        $card = CardContract::get_card_by_contract($contract->id);

        Contract::where('id', $contract->id)->update([
            'reader_id' => $r['reader_id'],
            'accompanying_id' => $r['accompanying_id'],
            'printer_id' => $r['printer_id'],
        ]);

        Immovable::updateOrCreate(
            ['id' => $immovable_id],
            [
                'immovable_type_id' => $r['immovable_type_id'],
                'developer_building_id' => $r['building_id'],
                'immovable_number' => $r['immovable_number'],
                'registration_number' => $r['immovable_reg_num'],
            ]
        );

        return $this->sendResponse('', 'Додані дані картки, контракту та нерухомості оновлено');
    }

    public function get_client($client_id = null)
    {
        $result = [];
        $client = null;
        $spouse = null;
        $confidant = null;
        $married_types = null;

        $married_types = MarriageType::select('id', 'title')->get();

        if ($client_id) {
            $client = Client::find($client_id);
            if ($client && $client->spouse_id) {
                $spouse = Client::find($client->spouse_id);
            }

            if ($client && $client->representative && $client->representative->confidant) {
                $confidant = Client::find($client->representative->confidant->id);
            }

            if ($client) {
                $phone = $client->phone;
                $email = $client->email;
                $client = $this->tools->get_id_and_full_name($client);
                $client['phone'] = $phone;
                $client['email'] = $email;
            }
            if ($spouse)
                $spouse = $this->tools->get_id_and_full_name($spouse);
            if ($confidant)
                $confidant = $this->tools->get_id_and_full_name($confidant);
        }

        $result['married_types'] = $married_types;
        $result['client'] = $client;
        $result['spouse'] = $spouse;
        $result['confidant'] = $confidant;

        return $this->sendResponse($result, 'Дані покупця під ID:' . $client_id);
    }

    public function update_client($client_id, Request $r)
    {
        if (!$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт під ID:' . $client_id . ' відсутній.');
        }

        $validator = $this->validate_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        if ($r['client']) {
            Client::update_by_manager($r['client']);
        }

        if ($r['spouse']) {
            Client::update_by_manager($r['spouse']);
        }

        if ($r['confidant']) {
            Client::update_by_manager($r['confidant']);
        }

        return $this->sendResponse('', 'Дані клієнта під ID:' . $client_id . ' оновлено.');
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
        ], [
            'notary_id' => ['numeric', 'nullable'],
            'developer_id' => ['numeric', 'nullable'],
            'representative_id' => ['numeric', 'nullable'],
            'manager_id' => ['numeric', 'nullable'],
        ], [
            'notary_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'developer_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'representative_id.numeric' => 'Необхідно передати ID в числовому форматі',
            'manager_id.numeric' => 'Необхідно передати ID в числовому форматі',
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
                        'type' => $representative_type_id,
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
                        'type' => $manager_type_id,
                    ])->first()) {
                $validator->getMessageBag()->add('manager_id', 'Менеджер з ID:' . $r['manager_id'] . " не знайдено");
            }
        }

        return $validator;
    }

    private function validate_client($r)
    {
        $validator = Validator::make([
            'id' => $r['id'],
            'surname' => $r['surname'],
            'name' => $r['name'],
            'patronymic' => $r['patronymic'],
            'phone' => $r['phone'],
            'email' => $r['email'],
        ], [
            'id' => ['numeric', 'nullable'],
            'surname' => ['string', 'nullable'],
            'name' => ['string', 'nullable'],
            'patronymic' => ['string', 'nullable'],
            'phone' => ['string', 'nullable'],
            'email' => ['string', 'nullable'],
        ], [
            'id.numeric' => 'Необхідно передати ID в числовому форматі',
            'surname.string' => 'Необхідно передати в строковому форматі',
            'name.string' => 'Необхідно передати в строковому форматі',
            'patronymic.string' => 'Необхідно передати в строковому форматі',
            'phone.string' => 'Необхідно передати в строковому форматі',
            'email.string' => 'Необхідно передати в строковому форматі',
        ]);

        $errors = $validator->errors()->messages();

        if (!isset($errors['id']) && isset($r['id']) && !empty($r['id'])) {
            if (!Client::find($r['id'])) {
                $validator->getMessageBag()->add('id', 'Клієнта з ID:' . $r['id'] . " не знайдено");
            }
        }

        return $validator;
    }
}
