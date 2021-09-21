<?php

namespace App\Http\Controllers\Accompanying;

use App\Http\Controllers\BaseController;
use App\Models\AccompanyingStep;
use App\Models\AccompanyingStepCheckList;
use App\Models\Contract;
use App\Models\NotaryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;
use App\Http\Controllers\Generator\ImmovableController;

class AccompanyingController extends BaseController
{
    public $convert;
    public $tools;

    public function __construct()
    {
        $this->convert = new ConvertController();
        $this->tools = new ToolsController();
        $this->immovable = new ImmovableController();
    }

    public function main($card_id)
    {
        $result = $this->immovable->get_immovables_by_card($card_id);

        return $this->sendResponse($result, "Нерухомість по карточці ID: $card_id");
    }

    public function get_accompanying_check_list($contract_id)
    {
        $result = [];

        $contract = Contract::where('id', $contract_id)->first();
        $notary_service = NotaryService::where(['dev_group_id' => $contract->card->dev_group->id, 'contract_type_id' => $contract->type_id])->first();
        if ($notary_service) {
            $result['read_steps'] = AccompanyingStep::select('id', 'title')->where('notary_service_id', $notary_service->id)->orderBy('sort_order')->get();

            $result['check_list'] = AccompanyingStepCheckList::select('id', 'date_time')->where('contract_id', $contract_id)->get();
        }

        return $this->sendResponse($result, "Список кроків для видачі договору");
    }

    public function set_step_check_list($contact_id, $accompanying_step_id)
    {
        $now = new \DateTime();

        AccompanyingStepCheckList::updateOrCreate(
            ['contract_id' => $contact_id, 'accompanying_step_id' => $accompanying_step_id],
            ['date_tiem' => $now]);

        return $this->sendResponse('', "Крок успішно пройдено");
    }
}
