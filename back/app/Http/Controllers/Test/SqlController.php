<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SqlController extends Controller
{
    public function check_sql()
    {
        $cards = \DB::table('cards')->select(
                    'cards.id',
                    'cards.notary_id',
                    'cards.room_id',
                    'cards.date_time',
                    'cards.dev_company_id',
                    'cards.dev_representative_id',
                    'cards.dev_manager_id',
                    'cards.generator_step',
                    'cards.staff_generator_id',
                    'cards.ready',
                    'cards.cancelled',
                    'contracts.immovable_id',
                    'contracts.accompanying_id',
                    'contracts.reader_id',
                    'contracts.bank',
                    'contracts.proxy',
                    'contracts.sign_date',
                    'contracts.type_id',
                    'clients.surname_n',
                    'clients.name_n',
                    'clients.patronymic_n',
                )
                ->where('cards.id', 190)
                ->join('contracts', 'contracts.card_id', '=', 'cards.id')
                ->join('client_contract', 'client_contract.contract_id', '=', 'contracts.id')
                ->join('clients', 'clients.id', '=', 'client_contract.client_id')
                ->toSql();
        dd($cards);
        \DB::enableQueryLog();
        dd(\DB::getQueryLog());
        dd($cards, \DB::getQueryLog());
    }
}
