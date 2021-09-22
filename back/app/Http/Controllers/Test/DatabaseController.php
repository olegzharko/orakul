<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\NotaryService;
use App\Models\AccompanyingStep;
use App\Models\AccompanyingStepCheckList;
use App\Models\ReadStep;
use App\Models\ReadStepsCheckList;
use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\User;
use App\Models\Contract;

class DatabaseController extends Controller
{
    public function set_database_current_date()
    {
        $date = new \DateTime('today');

//        Card::where('id', '>', 0)->update(['date_time' => '2021-09-19']);die;

        $date_time = Card::orderBy('date_time')->where('id', '=', 500)->first()->value('date_time');

        $date_diff_info = $date_time->diff($date);
        $days = $date_diff_info->days;

        $days = 42;

        $cards_id = Card::pluck('id');

        $i = 0;
        foreach ($cards_id as $key => $id) {
            if ($id >= 500) {
                $card = Card::find($id);

                $new_date = $card->date_time->addDays($days);

                if ($card->date_time < $date)
                    Card::where('id', $id)->update(['date_time' => $new_date]);
            }
        }
    }

    public function set_reader_and_accompanying_for_contracts()
    {
        $readers_id = User::where('reader', true)->pluck('id')->toArray();
        $accompanyings_id = User::where('accompanying', true)->pluck('id')->toArray();

        $contracts_id = Contract::pluck('id');

        foreach ($contracts_id as $contract_id) {
            Contract::find($contract_id)->update(['reader_id' => array_rand($readers_id), 'accompanying_id' => array_rand($accompanyings_id)]);
        }
    }

    public function set_steps_for_contract()
    {
        $cards = Card::where('id', '>', 0)->get();
        $first = new \DateTime('2021-01-01 12:00');
        $second = new \DateTime('2021-01-01 12:10');
        $third = new \DateTime('2021-01-01 12:30');
        $time = [$first, $second, $third];

        foreach ($cards as $ck => $card) {
            $dev_group = $card->dev_group;
            $contracts = $card->has_contracts;

            if ($dev_group && $contracts) {
                foreach ($contracts as $contract) {
                    $notary_service = NotaryService::where(['dev_group_id' => $dev_group->id, 'contract_type_id' => $contract->type_id])->first();
                    if ($notary_service) {
                        $accompanying_steps = AccompanyingStep::where('notary_service_id', $notary_service->id)->get();
                        foreach ($accompanying_steps as $ak => $step) {
                            if ($ak < 3) {
                                AccompanyingStepCheckList::updateOrCreate(
                                    ['contract_id' => $contract->id, 'accompanying_step_id' => $step->id],
                                    ['date_time' => $time[$ak], 'status' => true]);
                            } else {
                                AccompanyingStepCheckList::updateOrCreate(
                                    ['contract_id' => $contract->id, 'accompanying_step_id' => $step->id],
                                    ['date_time' => null, 'status' => false]);
                            }
                        }
                        $read_steps = ReadStep::where('notary_service_id', $notary_service->id)->get();
                        foreach ($read_steps as $rk => $step) {
                            if ($rk < 3) {
                                ReadStepsCheckList::updateOrCreate(
                                    ['contract_id' => $contract->id, 'read_step_id' => $step->id],
                                    ['date_time' => $time[$rk], 'status' => true]);
                            } else {
                                ReadStepsCheckList::updateOrCreate(
                                    ['contract_id' => $contract->id, 'read_step_id' => $step->id],
                                    ['date_time' => null, 'status' => false]);
                            }
                        }
                    }
                }
            }
        }
    }
}
