<?php

namespace App\Http\Controllers\Read;

use App\Http\Controllers\BaseController;
use App\Models\Card;
use App\Models\Contract;
use App\Models\NotaryService;
use App\Models\ReadStep;
use App\Models\ReadStepsCheckList;
use Illuminate\Http\Request;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;
use App\Http\Controllers\Generator\ImmovableController;

class ReadController extends BaseController
{
    public $convert;
    public $tools;
    public $immovable;

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

    public function get_read_check_list($contract_id)
    {
        $result = [];

        $contract = Contract::where('id', $contract_id)->first();
        $notary_service = NotaryService::where(['dev_group_id' => $contract->card->dev_group->id, 'contract_type_id' => $contract->type_id])->first();
        if ($notary_service) {
            $result['read_steps'] = ReadStep::select('id', 'title')->where('notary_service_id', $notary_service->id)->orderBy('sort_order')->get();

            $result['check_list'] = ReadStepsCheckList::select('id', 'date_time')->where('contract_id', $contract_id)->get();
        }

        return $this->sendResponse($result, "Список кроків для читки договору");
    }

    public function set_step_check_list($contact_id, $read_step_id)
    {
        $now = new \DateTime();

        ReadStepsCheckList::updateOrCreate(
            ['contract_id' => $contact_id, 'read_step_id' => $read_step_id],
            ['date_tiem' => $now]);

        return $this->sendResponse('', "Крок успішно пройдено");
    }
}
