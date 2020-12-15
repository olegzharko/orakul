<?php

namespace App\Http\Controllers;

use App\Models\Assistant;
use App\Models\Client;
use App\Models\Contract;
use App\Models\Developer;
use App\Models\Immovable;
use App\Models\ImmovableOwnership;
use App\Models\Notary;
use App\Models\PVPrice;
use App\Models\Template;
use App\Models\DayConvert;
use App\Models\MonthConvert;
use App\Models\YearConvert;
use Doctrine\Inflector\Rules\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContractController extends RakulController
{
    public $word;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_contract($id = null)
    {
        $this->contract_id = $id;

        $contract = $this->get_contract_by_id($id);
        $contract = $this->set_data_contract($contract);
        $contract = $this->convert_date_to_string($contract);

        return $contract;
    }


    public function get_contract_by_id($id = null)
    {
        $contract = Contract::select(
            'contracts.id',
            'contracts.template_id as template',
            'contracts.immovable_id as immovable',
            'contracts.developer_id as developer',
            'contracts.assistant_id as assistant',
            'contracts.client_id as client',
            'contracts.notary_id as notary',
            'contracts.pvprice_id as pvprice',
            'contracts.sign_date',
        );

        $contract = $contract->where(function ($query) use ($id) {
            if ($id)
                $query = $query->where('id', $id);
            else
                $query = $query->where('contracts.active', 1);

            return $query;
        });

        if ( !$contract = $contract->first())
            dd('Return ERROR alert. There are no record in db');

        return $contract;
    }

    public function set_data_contract($contract)
    {

        $contract->template = Template::get_template($contract->template);
        $contract->immovable = Immovable::get_immovable($contract->immovable);
        $contract->developer = Developer::get_developer($contract->developer);
        $contract->assistant = Assistant::get_assistant($contract->assistant);
        $contract->client = Client::get_client($contract->client);
        $contract->notary = Notary::get_notary($contract->notary);
        $contract->pvprice = PVPrice::get_pvprice($contract->pvprice);
        $contract->immovable_ownership = ImmovableOwnership::get_immovable_ownership($contract->immovable->id);
        return $contract;
    }

    public function convert_date_to_string($contract)
    {
        $sign_date = $contract->sign_date;
        $num_day = $contract->sign_date->format('d');
        $num_month = $contract->sign_date->format('m');
        $num_year = $contract->sign_date->format('Y');

        $contract->str_day = DayConvert::where('original', $num_day)->orWhere('original', strval(intval($num_day)))->first();
        $contract->str_month = MonthConvert::where('original', $num_month)->orWhere('original', strval(intval($num_month)))->first();
        $contract->str_year = YearConvert::where('original', $num_month)->orWhere('original', strval(intval($num_year)))->first();

        return $contract;
    }
}
