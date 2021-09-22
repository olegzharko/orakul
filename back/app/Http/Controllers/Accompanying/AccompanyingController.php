<?php

namespace App\Http\Controllers\Accompanying;

use App\Http\Controllers\BaseController;
use App\Models\AccompanyingStep;
use App\Models\AccompanyingStepCheckList;
use App\Models\Contract;
use App\Models\Card;
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

        $card = Card::find($card_id);
        $dev_group = $card->dev_group;
        $contracts = $card->has_contracts;
        if ($dev_group && $contracts) {
            foreach ($contracts as $contract) {
                $notary_service = NotaryService::where(['dev_group_id' => $dev_group->id, 'contract_type_id' => $contract->type_id])->first();
                $accompanying_step = AccompanyingStep::where('notary_service_id', $notary_service->id)->get();
                foreach ($accompanying_step as $accompanying) {
                    AccompanyingStepCheckList::firstOrCreate(['contract_id' => $contract->id, 'accompanying_step_id' => $accompanying->id]);
                }
            }
        }

        return $this->sendResponse($result, "Нерухомість по карточці ID: $card_id");
    }

    public function get_accompanying_check_list($contract_id)
    {
        $result = AccompanyingStep::select(
            'accompanying_step_check_lists.id',
            'accompanying_steps.title',
            'accompanying_step_check_lists.status',
            'accompanying_step_check_lists.date_time',
        )
        ->where('accompanying_step_check_lists.contract_id', $contract_id)
        ->leftJoin('accompanying_step_check_lists', 'accompanying_step_check_lists.accompanying_step_id', '=', 'accompanying_steps.id')
        ->get();

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
