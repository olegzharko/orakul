<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;
use App\Http\Controllers\Factory\GeneratorController;
use App\Models\ClientCheckList;
use App\Models\ClientType;
use App\Models\Contact;
use App\Models\Contract;
use App\Models\DevCompanyEmployer;
use App\Models\DevEmployerType;
use App\Models\DevGroup;
use App\Models\ImmovableCheckList;
use App\Models\Representative;
use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Notary;
use App\Models\DevCompany;
use App\Models\Client;
//use App\Models\ClientType;
use App\Models\ContactType;
use App\Models\Immovable;
use App\Models\MarriageType;
use App\Models\ImmovableType;
use App\Models\DeveloperBuilding;
use App\Models\ContractType;
use App\Models\Spouse;
use App\Models\Text;
use Validator;

class ManagerController extends BaseController
{
    public $tools;
    public $genrator;
    public $convert;
    public $developer_type;
    public $representative_type;
    public $manager_type;

    public function __construct()
    {
        $this->tools = new ToolsController();
        $this->generator = new GeneratorController();
        $this->convert = new ConvertController();
        $this->developer_type = DevEmployerType::where('alias', 'developer')->value('id');
        $this->representative_type = DevEmployerType::where('alias', 'representative')->value('id');
        $this->manager_type = DevEmployerType::where('alias', 'manager')->value('id');
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

        if (!$card->generator_step) {
            Card::where('id', $card_id)->update(['generator_step' => true]);
        }

        $date_info = $this->tools->header_info($card);

        $notary = $this->tools->get_company_notary();
        $developer = $this->tools->get_developer();
        $representative_type_id = DevEmployerType::get_representative_type_id();
        $manager_type_id = DevEmployerType::get_manager_type_id();

        $representative = $this->tools->dev_group_employer_by_type($card->dev_group_id, $representative_type_id);
        $manager = $this->tools->developer_employer_by_type($card->dev_group_id, $manager_type_id);

        $generator = $this->tools->get_generator_staff();

        $contact_person_type = ContactType::get_contact_type();
        $contact_person_info = Contact::contact_by_card($card_id);

        $result['date_info'] = $date_info;
        $result['notary'] = $notary;
        $result['developer'] = $developer;
        $result['representative'] = $representative;
        $result['manager'] = $manager;
        $result['generator'] = $generator;
        $result['contact_person_type'] = $contact_person_type;
        $result['contact_person_info'] = $contact_person_info;

        $result['notary_id'] = $card->notary_id;
        $result['developer_id'] = $card->dev_group_id;
        $result['representative_id'] = $card->dev_representative_id;
        $result['manager_id'] = $card->dev_manager_id;
        $result['generator_id'] = $card->staff_generator_id;

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
            'dev_group_id' => $r['developer_id'],
            'dev_representative_id' => $r['representative_id'],
            'dev_manager_id' => $r['manager_id'],
            'staff_generator_id' => $r['generator_id'],
        ]);

        return $this->sendResponse('', 'Дані учасників угоди оновлено в карточці з ID:' . $card_id . ' оновлено.');
    }

    public function update_contact_person($card_id, Request $r)
    {
        if (!$card = Card::find($card_id)) {
            return $this->sendError('', 'Картка відсутня');
        }

        $data = $r->toArray();

        foreach ($data as $key => $value) {
            $validator = $this->validate_contract_data($value);

            if (count($validator->errors()->getMessages())) {
                return $this->sendError('Форма передає помилкові дані', $validator->errors());
            }
        }

        $old_contact_id = Contact::where('card_id', $card_id)->pluck('id');

        foreach ($data as $key => $value) {

            $contact = new Contact();
            $contact->contact_type_id = $value['person_type'];
            $contact->full_name = $value['name'];
            $contact->phone = $value['phone'];
            $contact->email = $value['email'];
            $contact->card_id = $card_id;
            $contact->save();
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
            $result[$key]['title'] = $this->generator->full_ascending_address($immovable);
            $result[$key]['list'] = ['Тест M інформація 1', 'Тест M інформація 2', 'Тест M інформація 3'];
        }

        return $this->sendResponse($result, 'Нерухомості по карті ID:' . $card_id);
    }

    public function get_immovable($immovable_id)
    {
        $result = [];
        $result['title'] = '';
        $result['immovable_type'] = null;
        $result['building'] = null;
        $result['reader'] = null;
        $result['accompanying'] = null;
        $result['contract_type'] = null;

        $result['immovable_type_id'] = null;
        $result['building_id'] = null;
        $result['immovable_number'] = null;
        $result['immovable_reg_num'] = null;

        $result['reader_id'] = null;
        $result['accompanying_id'] = null;
        $result['contract_type_id'] = null;

        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $immovable_type = ImmovableType::get_immovable_type();
        $developer_building = DeveloperBuilding::get_developer_building($immovable->developer_building->dev_company->id);

        $building = [];
        foreach ($developer_building as $key => $dev_building) {
            $building[$key]['id'] = $dev_building->id;
            $building[$key]['title'] = $this->convert->get_full_address($dev_building);
        }

        $reader = $this->tools->get_reader_staff();
        $accompanying = $this->tools->get_accompanying_staff();

        $contract = Contract::get_contract_by_immovable($immovable_id);
        $card = Card::get_card_by_contract($contract->id);

        $result['title'] = $this->generator->full_ascending_address($immovable);

        $result['contract_type'] = ContractType::select('id', 'title')->get();
        $result['immovable_type'] = $immovable_type;
        $result['building'] = $building;
        $result['reader'] = $reader;
        $result['accompanying'] = $accompanying;
        $result['check_list'] = ImmovableCheckList::get_check_list($immovable_id);

        $result['building_id'] = $immovable->developer_building_id;
        $result['immovable_type_id'] = $immovable->immovable_type_id;
        $result['immovable_number'] = $immovable->immovable_number;
        $result['immovable_reg_num'] = $immovable->registration_number;

        $result['contract_type_id'] = Contract::where('immovable_id', $immovable->id)->value('type_id');
        $result['reader_id'] = $contract->reader_id;
        $result['accompanying_id'] = $contract->accompanying_id;

        return $this->sendResponse($result, 'Дані по нерухомості ID:' . $immovable_id);
    }

    public function update_immovable($immovable_id, Request $r)
    {
        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $contract = Contract::get_contract_by_immovable($immovable_id);
        $card = Card::get_card_by_contract($contract->id);

        Contract::where('id', $contract->id)->update([
            'reader_id' => $r['reader_id'],
            'accompanying_id' => $r['accompanying_id'],
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

        ImmovableCheckList::where('immovable_id', $immovable_id)->update([
            'right_establishing' => $r['right_establishing'],
            'technical_passport' => $r['technical_passport'],
            'pv_price' => $r['pv_price'],
            'fund_evaluation' => $r['fund_evaluation'],
        ]);

        return $this->sendResponse('', 'Додані дані картки, контракту та нерухомості оновлено');
    }

    public function get_client($client_id = null)
    {
        $result = [];
        $client = null;
        $spouse = null;
        $confidant = null;
        $married_types = null;
        $check_list = null;

        $married_types = MarriageType::select('id', 'title')->get();

        if ($client_id) {
            $client = Client::find($client_id);
            if ($client && $client->spouse_id) {
                $spouse = Client::find($client->married->spouse->id);
            }

            if ($client && $client->representative && $client->representative->confidant) {
                $confidant = Client::find($client->representative->confidant->id);
            }

            if ($client) {
                $phone = $client->phone;
                $email = $client->email;
                $client = $this->tools->get_client_data_for_manager($client);
                $client['phone'] = $phone;
                $client['email'] = $email;
            }
            if ($spouse)
                $spouse = $this->tools->get_client_data_for_manager($spouse);
            if ($confidant)
                $confidant = $this->tools->get_client_data_for_manager($confidant);

        } else {
            $result['client']['info'] =  $this->start_quesetionnaire_info();
            $result['spouse']['info'] =  $this->start_quesetionnaire_info();
            $result['confidant']['info'] =  $this->start_quesetionnaire_info();
        }

        $result['married_types'] = $married_types;
        $result['client']['data'] = $client;
        $result['spouse']['data'] = $spouse;
        $result['confidant']['data'] = $confidant;

        return $this->sendResponse($result, 'Дані покупця під ID:' . $client_id);
    }

    public function update_client($card_id, $client_id = null, Request $r)
    {
        if ($client_id && !$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт під ID:' . $client_id . ' відсутній.');
        }

        $validator = $this->validate_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        if ($r['client']) {
            $client_id = $this->create_or_update_client($card_id, $client_id, $r['client']);
            $this->card_client($client_id, $card_id);
        }

        if ($r['spouse']) {
            $spouse_id = $this->create_or_update_client($card_id, $client_id, $r['spouse']);
            $this->client_spouse($client_id, $spouse_id);
        }

        if ($r['confidant']) {
            $representative_id = $this->create_or_update_client($card_id, $client_id, $r['confidant']);
            $this->client_representative($client_id, $representative_id);
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
            if (!DevGroup::find($r['developer_id'])) {
                $validator->getMessageBag()->add('developer_id', 'Група забудовника з ID:' . $r['developer_id'] . " не знайдено");
            }
        }

        if (!isset($errors['representative_id']) && isset($r['representative_id']) && !empty($r['representative_id']) &&
            !isset($errors['developer_id']) && isset($r['developer_id'])) {
            if (!$dev_representative = DevCompanyEmployer::get_dev_employers_by_type($r['developer_id'], $this->representative_type)) {
                $validator->getMessageBag()->add('representative_id', 'Представник з ID:' . $r['representative_id'] . " не знайдено");
            }
        }

        if (!isset($errors['manager_id']) && isset($r['manager_id']) && !empty($r['manager_id']) &&
            !isset($errors['developer_id']) && isset($r['developer_id'])) {
            if (!$dev_manager = DevCompanyEmployer::get_dev_employers_by_type($r['developer_id'], $this->manager_type)) {
                $validator->getMessageBag()->add('manager_id', 'Менеджер з ID:' . $r['manager_id'] . " не знайдено");
            }
        }

        return $validator;
    }

    private function validate_contract_data($r)
    {
        $validator = Validator::make([
            'name' => $r['name'],
            'phone' => $r['phone'],
            'email' => $r['email'],
            'person_type' => $r['person_type'],
        ], [
            'name' => ['string', 'nullable'],
            'phone' => ['string', 'nullable'],
            'email' => ['string', 'nullable'],
            'person_type' => ['numeric', 'nullable'],
        ], [
            'name.string' => 'Необхідно передати в строковому форматі',
            'phone.string' => 'Необхідно передати в строковому форматі',
            'email.string' => 'Необхідно передати в строковому форматі',
            'person_type.string' => 'Необхідно передати ID в числовому форматі',
        ]);

        $errors = $validator->errors()->messages();

        if (!isset($errors['person_type']) && isset($r['person_type']) && !empty($r['person_type'])) {
            if (!ContactType::find($r['person_type'])) {
                $validator->getMessageBag()->add('person_type', 'Клієнта з ID:' . $r['person_type'] . " не знайдено");
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

    public function create_or_update_client($card_id, $client_id, $data)
    {
        if ($client_id) {
            Client::where('id', $client_id)->udpate([
                'id' => $data['id'],
                'surname' => $data['surname'],
                'name' => $data['name'],
                'patronymic' => $data['patronymic'],
                'phone' => $data['phone'],
                'email' => $data['email'],
            ]);
        } else {
            $client = new Client();
            $client->surname = $data['surname'];
            $client->name = $data['name'];
            $client->patronymic = $data['patronymic'];
            $client->phone = $data['phone'];
            $client->email = $data['email'];
            $client->save();
        }

        return $client->id;
    }

    public function card_client($client_id, $card_id)
    {
        CardClient::updateOrCreate(
            ['client_id' => $client_id],
            ['card_id' => $card_id]);
    }

    public function client_spouse($client_id, $spouse_id)
    {
        Spouse::updateOrCreate(
            ['client_id' => $client_id],
            ['spouse_id' => $spouse_id]);
    }

    public function client_representative($client_id, $representative_id)
    {
        Representative::updateOrCreate(
            ['client_id' => $client_id],
            ['representative_id' => $representative_id]);
    }

    public function start_quesetionnaire_info()
    {
        $result = [];

        $check_list = [
            "spouse_consent",
            "current_place_of_residence",
            "photo_in_the_passport",
            "immigrant_help",
            "passport",
            "tax_code",
            "evaluation_in_the_fund",
            "check_fop",
            "document_scans",
            "unified_register_of_court_decisions",
            "sanctions",
            "financial_monitoring",
            "unified_register_of_debtors",
        ];

        foreach ($check_list as $key => $value) {
            $result[$key]['title'] = Text::where('alias', $value)->value('value');
            $result[$key]['key'] = $value;
            $result[$key]['value'] = false;
        }

        return $result;
    }
}
