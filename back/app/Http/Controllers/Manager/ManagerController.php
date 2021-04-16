<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;
use App\Http\Controllers\Factory\GeneratorController;
use App\Models\ClientCheckList;
use App\Models\ClientContract;
use App\Models\ClientSpouseConsent;
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
use App\Models\PassportTemplate;
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
        $this->developer_type = DevEmployerType::get_developer_type_id();
        $this->representative_type = DevEmployerType::get_representative_type_id();
        $this->manager_type = DevEmployerType::get_manager_type_id();;
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

        /*
         * Якщо менеджер почав передивлятись картку
         * то вона переходить в режим редагування лише
         * відділом обробки данних
         * */
        if (!$card->generator_step) {
            Card::where('id', $card_id)->update(['generator_step' => true]);
        }

        $date_info = $this->tools->header_info($card);

        $notary = $this->tools->get_company_notary();
        $developer = $this->tools->get_dev_group();

        $representative = $this->tools->dev_group_employer_by_type($card->dev_group_id, $this->representative_type);
        $manager = $this->tools->developer_employer_by_type($card->dev_group_id, $this->manager_type);

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
        $result['generation_ready'] = $card->generator_step ? true : false;

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
            'generator_step' => $r['generation_ready'] ? 0 : 1,
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

    public function get_immovable($card_id, $immovable_id = null)
    {
        $result = [];
        $result['title'] = '';
        $result['immovable_type'] = null;
        $result['building'] = null;

        $result['immovable_type_id'] = null;
        $result['building_id'] = null;
        $result['immovable_number'] = null;
        $result['immovable_reg_num'] = null;

        $result['contract_type'] = null;
        $result['contract_type_id'] = null;

        $result['reader'] = null;
        $result['accompanying'] = null;

        $result['reader_id'] = null;
        $result['accompanying_id'] = null;

        if (!$card = Card::find($card_id)) {
            return $this->sendError('', 'Картка відсутня');
        }

        $immovable_type = ImmovableType::get_immovable_type();
        $contract_type = ContractType::select('id', 'title')->get();

        $reader = $this->tools->get_reader_staff();
        $accompanying = $this->tools->get_accompanying_staff();

        if ($immovable_id) {
            if (!$immovable = Immovable::find($immovable_id))
                return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');


            $developer_building = DeveloperBuilding::get_developer_building($immovable->developer_building->dev_company->id);

            $building = [];
            foreach ($developer_building as $key => $dev_building) {
                $building[$key]['id'] = $dev_building->id;
                $building[$key]['title'] = $this->convert->get_full_address($dev_building);
            }

            $contract = Contract::get_contract_by_immovable($immovable_id);

            $result['title'] = $this->generator->full_ascending_address($immovable);
            $result['building'] = $building;
            $result['building_id'] = $immovable->developer_building_id;
            $result['immovable_type_id'] = $immovable->immovable_type_id;
            $result['immovable_number'] = $immovable->immovable_number;
            $result['immovable_reg_num'] = $immovable->registration_number;

            $result['contract_type_id'] = Contract::where('immovable_id', $immovable->id)->value('type_id');
            $result['reader_id'] = $contract->reader_id;
            $result['accompanying_id'] = $contract->accompanying_id;

            $result['check_list'] = ImmovableCheckList::get_check_list($immovable_id);
        } else {
            $building = $this->tools->dev_group_buildings($card->dev_group_id);
            $result['building'] = $building;
            $result['check_list'] = ImmovableCheckList::start_data_check_list();
        }

        $result['contract_type'] = $contract_type;
        $result['immovable_type'] = $immovable_type;
        $result['reader'] = $reader;
        $result['accompanying'] = $accompanying;

        return $this->sendResponse($result, 'Дані по нерухомості ID:' . $immovable_id);
    }

    public function update_immovable($card_id, $immovable_id = null, Request $r)
    {
        if (!$card = Card::find($card_id)) {
            return $this->sendError('', 'Картка відсутня');
        }

        if ($immovable_id) {
            if (!$immovable = Immovable::find($immovable_id))
                return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

            $contract = Contract::get_contract_by_immovable($immovable_id);

            Contract::where('id', $contract->id)->update([
                'type_id' => $r['contract_type_id'],
                'reader_id' => $r['reader_id'],
                'accompanying_id' => $r['accompanying_id'],
            ]);

            Immovable::where('id', $immovable_id)->update([
                'immovable_type_id' => $r['immovable_type_id'],
                'developer_building_id' => $r['building_id'],
                'immovable_number' => $r['immovable_number'],
                'registration_number' => $r['immovable_reg_num'],
            ]);

            ImmovableCheckList::where('immovable_id', $immovable_id)->update([
                'right_establishing' => $r['right_establishing'],
                'technical_passport' => $r['technical_passport'],
                'pv_price' => $r['pv_price'],
                'fund_evaluation' => $r['fund_evaluation'],
            ]);

            return $this->sendResponse('', 'Нерухомість оновлено');

        } else {
            $immovable = new Immovable();
            $immovable->immovable_type_id = $r['immovable_type_id'];
            $immovable->developer_building_id = $r['building_id'];
            $immovable->immovable_number = $r['immovable_number'];
            $immovable->registration_number = $r['immovable_reg_num'];
            $immovable->save();

            $immovable_check_list = new ImmovableCheckList();
            $immovable_check_list->immovable_id = $immovable->id;
            $immovable_check_list->right_establishing = $r['right_establishing'];
            $immovable_check_list->technical_passport = $r['technical_passport'];
            $immovable_check_list->pv_price = $r['pv_price'];
            $immovable_check_list->fund_evaluation = $r['fund_evaluation'];
            $immovable_check_list->save();

            $contract = new Contract();
            $contract->immovable_id = $immovable->id;
            $contract->reader_id = $r['reader_id'];
            $contract->accompanying_id = $r['accompanying_id'];
            $contract->type_id = $r['contract_type_id'];
            $contract->card_id = $card_id;
            $contract->save();

            $result = [];
            $result['immovable_id'] = $immovable->id;

            return $this->sendResponse($result, 'Додано нерухомість оновлено');
        }
    }

    public function get_card_client($card_id)
    {
        $result = [];

        $clients_id = Card::where('cards.id', $card_id)
            ->join('contracts', 'contracts.card_id', '=', 'cards.id')
            ->join('client_contract', 'client_contract.contract_id', '=', 'contracts.id')
            ->pluck('client_contract.client_id');

        $clients = Client::whereIn('id', $clients_id)->get();

        foreach ($clients as $key => $client) {
            $result[$key] = [];
            $result[$key]['id'] = $client->id;
            $result[$key]['full_name'] = $this->convert->get_full_name($client);
            $result[$key]['list'] = ['Teст 1', 'Тест 2', 'Test 3'];
        }

        return $this->sendResponse($result, 'Клієнти по карточці ID' . $card_id);
    }

    public function get_client($client_id = null)
    {
        $result = [];

        $client = null;
        $buyer = null;
        $spouse = null;
        $confidant = null;
        $married_types = null;
        $check_list = null;
        $buyer_data = null;
        $buyer_info = null;
        $spouse_data = null;
        $spouse_info = null;
        $confidant_data = null;
        $confidant_info = null;

        $start_info = $this->start_quesetionnaire_info();

        $married_types = MarriageType::select('id', 'title')->get();
        $passport_type = PassportTemplate::select('id', 'title')->get();

        $result['married_types'] = $married_types;
        $result['passport_type'] = $passport_type;

        $result['client']['data'] = null;
        $result['client']['info'] = $start_info;

        $result['spouse']['data'] = null;
        $result['spouse']['info'] = $start_info;

        $result['confidant']['data'] = null;
        $result['confidant']['info'] = $start_info;

        if ($client_id) {
            $client = Client::find($client_id);

            if ($client) {
                $phone = $client->phone;
                $email = $client->email;

                $buyer_data = $this->tools->get_client_data_for_manager($client);
                $buyer_data['phone'] = $phone;
                $buyer_data['email'] = $email;
                $buyer_info = $this->tools->clinet_quesetionnaire_info($client->id);

                $result['client']['data'] = $buyer_data;
                $result['client']['info'] = $buyer_info;
            }

            if ($client && $client->married && $client->married->spouse) {
                if ($spouse = Client::find($client->married->spouse->id)) {
                    $spouse_data = $this->tools->get_client_data_for_manager($spouse);
                    $spouse_info = $this->tools->clinet_quesetionnaire_info($spouse->id);

                    $result['spouse']['data'] = $spouse_data;
                    $result['spouse']['info'] = $spouse_info;
                }
            }

            if ($client && $client->representative && $client->representative->confidant) {
                if ($confidant = Client::find($client->representative->confidant->id)) {
                    $confidant_data = $this->tools->get_client_data_for_manager($confidant);
                    $confidant_info = $this->tools->clinet_quesetionnaire_info($confidant->id);

                    $result['confidant']['data'] = $confidant_data;
                    $result['confidant']['info'] = $confidant_info;
                }
            }
        }

        return $this->sendResponse($result, 'Дані покупця під ID:' . $client_id);
    }

    public function update_client($card_id, $client_id = null, Request $r)
    {
        $new = false;

//        dd($r->toArray(), $r['client'], $r['client']['data'], count($r['client']['data']));
//        dd($r['client'], $r['spouse'], $r['representative']);

        if ($client_id && !$client = Client::find($client_id)) {
            return $this->sendError('', 'Клієнт під ID:' . $client_id . ' відсутній.');
        } else {
            $new = true;
        }

        $validator = $this->validate_data($r);

        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }

        if ($r['client'] && count($r['client']['data'])) {
            $client_id = $this->create_or_update_client($card_id, $client_id, $r['client']['data']);
            if ($client_id) {
                $this->card_client($card_id, $client_id);
                $this->update_check_list($client_id, $r['client']['info']);
                $this->create_client_spouse_consents($client_id, $r['client']['data']);
            }
        }

        if ($r['spouse'] && count($r['spouse']['data'])) {
            $spouse_id = Spouse::where('client_id', $client_id)->value('spouse_id');
            $spouse_id = $this->create_or_update_client($card_id, $spouse_id, $r['spouse']['data']);
            if ($spouse_id) {
                $this->client_spouse($client_id, $spouse_id);
                $this->update_check_list($spouse_id, $r['spouse']['info']);
            } else {
                $this->del_spouse($client_id);
            }
        }

        if ($r['representative'] && count($r['representative']['data'])) {
            $representative_id = Representative::where('client_id', $client_id)->value('confidant_id');
            $representative_id = $this->create_or_update_client($card_id, $representative_id, $r['representative']['data']);
            if ($representative_id) {
                $this->client_representative($client_id, $representative_id);
                $this->update_check_list($representative_id, $r['representative']['info']);

            } else {
                $this->del_representative($client_id);
            }
        }

        if ($new) {
            $result = [];
            $result['client_id'] = $client_id;

            return $this->sendResponse($result, 'Клієнта під ID:' . $client_id . ' створено.');
        } else
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
        if ($data['surname'] == null && $data['name'] == null && $data['patronymic'] == null
            || $data['surname'] == '' && $data['name'] == '' && $data['patronymic'] == '') {
            return null;
        }

        if ($client_id) {

            Client::where('id', $client_id)->update([
                'surname_n' => $data['surname'],
                'name_n' => $data['name'],
                'patronymic_n' => $data['patronymic'],
                'phone' => isset($data['phone']) ? $data['phone'] : null,
                'email' => isset($data['email']) ? $data['email'] : null,
                'passport_type_id' => isset($data['passport_type_id']) ? $data['passport_type_id'] : null,
            ]);

            return $client_id;
        } else {
            $client = new Client();
            $client->surname_n = $data['surname'];
            $client->name_n = $data['name'];
            $client->patronymic_n = $data['patronymic'];
            $client->phone = isset($data['phone']) ? $data['phone'] : null;
            $client->email = isset($data['email']) ? $data['email'] : null;
            $client->passport_type_id = isset($data['passport_type_id']) ? $data['passport_type_id'] : null;
            $client->save();

            return $client->id;
        }
    }

    public function card_client($card_id, $client_id)
    {
        $contracts_id = Contract::where('card_id', $card_id)->pluck('id');
        foreach ($contracts_id as $contr_id) {
            ClientContract::updateOrCreate(
                ['client_id' => $client_id],
                ['contract_id' => $contr_id]);
        }
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
            ['confidant_id' => $representative_id]);
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

    public function update_check_list($client_id, $data)
    {
        ClientCheckList::updateOrCreate(
            [
                'client_id' => $client_id
            ], [
            "spouse_consent" => $data['spouse_consent'],
            "current_place_of_residence" => $data['current_place_of_residence'],
            "photo_in_the_passport" => $data['photo_in_the_passport'],
            "immigrant_help" => $data['immigrant_help'],
            "passport" => $data['passport'],
            "tax_code" => $data['tax_code'],
            "evaluation_in_the_fund" => $data['evaluation_in_the_fund'],
            "check_fop" => $data['check_fop'],
            "document_scans" => $data['document_scans'],
            "unified_register_of_court_decisions" => $data['unified_register_of_court_decisions'],
            "sanctions" => $data['sanctions'],
            "financial_monitoring" => $data['financial_monitoring'],
            "unified_register_of_debtors" => $data['unified_register_of_debtors'],
        ]);
    }

    public function create_client_spouse_consents($client_id, $data)
    {
//        ClientSpouseConsent::updateOrCreate(['client_id' => $client_id], [
//            'marriage_type_id' => $data['married_type'],
//        ]);

        ClientSpouseConsent::updateOrCreate(['client_id' => $client_id], [
            'marriage_type_id' => isset($data['married_type_id']) ? $data['married_type_id'] : null,
        ]);
    }

    public function del_spouse($client_id)
    {
        $spouse_id = Spouse::where('client_id', $client_id)->value('spouse_id');
        if ($spouse_id) {
            Spouse::where('spouse_id', $spouse_id)->delete();
            Client::where('id', $spouse_id)->delete();
        }
    }

    public function del_representative($client_id)
    {
        $representative_id = Representative::where('client_id', $client_id)->value('confidant_id');
        if ($representative_id) {
            Representative::where('confidant_id', $representative_id)->delete();
            Client::where('id', $representative_id)->delete();
        }
    }
}
