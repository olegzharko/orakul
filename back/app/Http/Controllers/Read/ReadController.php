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

        $card = Card::find($card_id);
        $dev_group = $card->dev_group;
        $contracts = $card->has_contracts;
        if ($dev_group && $contracts) {
            foreach ($contracts as $contract) {
                $notary_service = NotaryService::where(['dev_group_id' => $dev_group->id, 'contract_type_id' => $contract->type_id])->first();
                $read_step = ReadStep::where('notary_service_id', $notary_service->id)->get();
                foreach ($read_step as $read) {
                    ReadStepsCheckList::firstOrCreate(['contract_id' => $contract->id, 'read_step_id' => $read->id]);
                }
            }
        }

        return $this->sendResponse($result, "Нерухомість по карточці ID: $card_id");
    }

    public function get_read_check_list($contract_id)
    {
        $result = ReadStep::select(
            'read_steps_check_lists.id',
            'read_steps.title',
            'read_steps_check_lists.status',
            'read_steps_check_lists.date_time',
        )
        ->where('read_steps_check_lists.contract_id', $contract_id)
        ->leftJoin('read_steps_check_lists', 'read_steps_check_lists.read_step_id', '=', 'read_steps.id')
        ->get();

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

    public function set_read_check_list($contact_id, Request $r)
    {
        $read_steps = $r->toArray();
        $now = new \DateTime();

        foreach ($read_steps as $read_step) {
            ReadStepsCheckList::updateOrCreate(
                ['contract_id' => $contact_id, 'read_step_id' => $read_step->id],
                ['date_tiem' => $now]
            );
        }
    }
}
