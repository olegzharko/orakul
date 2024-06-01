<?php

namespace App\Http\Controllers\Archive;

use App\Http\Controllers\BaseController;
use App\Models\ArchiveColumn;
use App\Models\Client;
use App\Models\ContractType;
use App\Models\DevCompanyEmployer;
use App\Models\DevEmployerType;
use App\Models\Notary;
use App\Models\Deal;
use App\Models\Card;
use App\Models\Text;
use App\Models\ClientContract;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;

class ArchiveController extends BaseController
{
    public $convert;
    public $tools;
    public $deals;

    public function __construct()
    {
        $this->convert = new ConvertController();
        $this->tools = new ToolsController();
        $this->deals = null;
    }

    public function get_tools()
    {
        $result = [];

        $result['column'] = $this->get_archive_column();
        $result['notary'] = $this->get_archive_notary();

        return $this->sendResponse($result, 'Дані для колонок архіву');
    }

    public function get_archive_data($notary_id, Request $r)
    {
        $result = [];

        $result['data'] = $this->get_archive_notary_info($notary_id, $r);
        $result['tools'] = $this->get_archive_tools($notary_id);

        return $this->sendResponse($result, 'Дані для колонок архіву');
    }

    public function get_archive_column()
    {
        return ArchiveColumn::select('alias', 'title')->where('active', true)->orderBy('sort_order')->get()->toArray();
    }

    public function get_archive_notary()
    {
        $result = [];

        $notaries = Notary::where(['active' => true, 'rakul_company' => true])->get();

        foreach ($notaries as $key => $notary) {
            $result[] = $this->tools->get_notary_id_and_title($notary->id);
        }

        return $result;
    }

    public function get_archive_tools($notary_id)
    {
        $result = [];

//        $cards = Card::where(['notary_id' => $notary_id, 'ready' => true, 'cancelled' => false])->paginate(15);

        $cards = $this->deals;

        $result['total_items'] = $cards->total();
        $result['hasPages'] = $cards->hasPages();
        $result['on_first_page'] = $cards->onFirstPage();
        $result['current_page'] = $cards->currentPage();
        $result['previous_page_url'] = $cards->previousPageUrl();
        $result['next_page_url'] = $cards->nextPageUrl();
        $result['last_page'] = $cards->lastPage();

        return $result;
    }

    /*
     *  ?page=1
        "id": "ID",
        "seller": "Продавець",
        "buyer": "Покупець",
        "notary_service": "Тип нотаріальної дії",
        "date": "Дата",
        "number": "Номер",
        "immovable": "Об'єкт",
        "price": "Ціна",
        "dev_representative": "Підписант",
        "marriage": "Шлюб",
        "volume": "Том"
     * */
    public function get_archive_notary_info($notary_id, $r)
    {
        $result = [];

        $archive_column = ArchiveColumn::select('active', 'alias')->where('active', true)->orderBy('sort_order')->pluck('active', 'alias')->toArray();

        $deals_query = Deal::select(
            'deals.id',
            'deals.card_id',
            'deals.number_of_people',
            'deals.children',
            'deals.representative_arrived',
            'deals.arrival_time',
            'deals.invite_time',
            'deals.waiting_time',
            'deals.total_time',
            'deals.payment_status',
            'cards.dev_group_id',
            'cards.dev_representative_id',
            'contracts.type_id',
        )->where(['cards.notary_id' => $notary_id, 'cards.ready' => true, 'cards.cancelled' => false, 'deals.deleted_at' => null])
            ->leftJoin('cards', 'cards.id', '=', 'deals.card_id')
            ->leftJoin('contracts', 'contracts.card_id', '=', 'cards.id')
            ->distinct('deals.id');

        if (isset($r['contract_type_id']) && !empty($r['contract_type_id']))
            $deals_query = $deals_query->where('contracts.type_id', $r['contract_type_id']);
        if (isset($r['dev_group_id']) && !empty($r['dev_group_id']))
            $deals_query = $deals_query->where('cards.dev_group_id', $r['dev_group_id']);
        if (isset($r['dev_representative_id']) && !empty($r['dev_representative_id']))
            $deals_query = $deals_query->where('cards.dev_representative_id', $r['dev_representative_id']);
        if (isset($r['start_date']) && !empty($r['start_date']))
            $deals_query = $deals_query->where('cards.date_time', '>=', $r['start_date']);
        if (isset($r['final_date']) && !empty($r['final_date']))
            $deals_query = $deals_query->where('cards.date_time', '<=', $r['final_date']);

        $deals = $deals_query->paginate(15);

        $this->deals = $deals;

        foreach ($deals as $key => $deal) {
            $card = $deal->card;
            if ($archive_column['id'])
                $result[$key]['id'] = $card->id;
            if ($archive_column['seller'])
                $result[$key]['seller'] = $this->get_seller_info($card->dev_group);
            if ($archive_column['buyer'])
                $result[$key]['buyer'] = $this->get_buyer_info($card);
            if ($archive_column['notary_service'])
                $result[$key]['notary_service'] = $this->get_notary_service($card);
            if ($archive_column['date'])
                $result[$key]['date'] = $card->date_time->format('d.m.Y H:i');
            if ($archive_column['number'])
                $result[$key]['number'] = $this->get_contract_reg_number($card);
            if ($archive_column['immovable'])
                $result[$key]['immovable'] = $this->get_immovables($card);
            if ($archive_column['price'])
                $result[$key]['price'] = $this->get_price($card);
            if ($archive_column['dev_representative'])
                $result[$key]['dev_representative'] = $this->get_dev_representative($card);
            if ($archive_column['spouse'])
                $result[$key]['spouse'] = $this->get_client_spouse($card);
        }

        return $result;
    }

    public function get_seller_info($dev_group)
    {
        $dev_employer_type_id = DevEmployerType::where('alias', 'developer')->value('id');
        if ($dev_owner = DevCompanyEmployer::where(['dev_company_id' => $dev_group->id, 'type_id' => $dev_employer_type_id])->first()) {
//            $dev_group_owner_full_name = $this->convert->get_initials_and_surname_n(Client::find($dev_owner->employer_id));
//            $dev_company_title = "$dev_group_owner_full_name ($dev_group->title)";
            $dev_company_title = $dev_group->title;
        }

        return $dev_company_title;
    }

    public function get_buyer_info($card)
    {
        $result = [];
        $contract = $card->has_contracts->first();
        $clients_id = ClientContract::where('contract_id', $contract->id)->pluck('client_id');
        $clients = Client::whereIn('id', $clients_id)->get();

        foreach ($clients as $key => $client) {
//            $result[$key] = $this->convert->get_full_name_n($client);
            $result[$key] = $this->convert->get_initials_and_surname_n($client);
        }

        return $result;
    }

    public function get_notary_service($card)
    {
        $result = [];
        $contracts = $card->has_contracts;

        foreach ($contracts as $key => $contract) {
            if ($contract->notary_service)
                $result[$key] = $contract->notary_service->short;
        }

        return $result;
    }

    public function get_contract_reg_number($card)
    {
        $result = [];
        $contracts = $card->has_contracts;

        foreach ($contracts as $key => $contract) {

        }

        return $result;
    }

    public function get_immovables($card)
    {
        $result = [];
        $contracts = $card->has_contracts;

        foreach ($contracts as $key => $contract) {
            $result[$key] = $this->convert->building_city_address_number_immovable($contract->immovable);
        }

        return $result;
    }

    public function get_price($card)
    {
        $result = [];
        $contracts = $card->has_contracts;

        foreach ($contracts as $key => $contract) {
            if ($contract->notary_service) {
//                $result[$key] = $contract->notary_service->price;
                $result[$key] = number_format($contract->notary_service->price, 0, ".",  " " );
            }
        }

        return $result;
    }

    public function get_dev_representative($card)
    {
        $dev_representative = null;

        if ($card->dev_representative)
            $dev_representative = $this->convert->get_initials_and_surname_n($card->dev_representative);

        return $dev_representative;
    }

    public function get_client_spouse($card)
    {
        $result = [];
        $contract = $card->has_contracts->first();
        $clients_id = ClientContract::where('contract_id', $contract->id)->pluck('client_id');
        $clients = Client::whereIn('id', $clients_id)->get();

        foreach ($clients as $key => $client) {
            $result[$key] = $client->married ? $this->convert->get_full_name_n($client->married->spouse) : $this->convert->mb_ucfirst(Text::where('alias', 'not_married')->value('value'));
        }

        return $result;
    }

    public function get_archive_detail($card_id)
    {
        $result = [];

        if (!$deal = Deal::where('card_id', $card_id)->first()) {
            return $this->sendError('', "Картка по ID: $card_id не знайдена");
        }

        $result['color'] = $deal->card->dev_group->color;
        $result['room'] = $this->convert->get_id_in_pad_format($deal->id);
        $result['time'] = $this->tools->get_deal_time($deal);
        $result['dev_representative'] = $this->tools->get_dev_representative_info($deal);
        $result['steps_list'] = $this->tools->get_deal_step_list($deal);
        $result['payment'] = $this->tools->get_deal_payment($deal);
        $result['immovable'] = $this->tools->get_deal_immovable($deal);
//        $result['help'] = '';
        $result['info'] = $this->tools->get_deal_info($deal);

        return $this->sendResponse($result, 'Дані угоди');
    }
}
