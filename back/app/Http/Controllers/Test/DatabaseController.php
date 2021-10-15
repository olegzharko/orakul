<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\CurrentTask;
use App\Models\DocumentLink;
use App\Models\NotaryService;
use App\Models\AccompanyingStep;
use App\Models\AccompanyingStepCheckList;
use App\Models\ReadStep;
use App\Models\ReadStepsCheckList;
use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Deal;
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

    public function set_notary_service()
    {
        $cards = Card::orderBy('id', 'desc')->get();
        foreach ($cards as $card) {
            $contracts = $card->has_contracts;
            if ($contracts) {
                foreach ($contracts as $contract) {
                    $notary_service_id = NotaryService::where(['dev_group_id' => $card->dev_group->id, 'contract_type_id' => $contract->type_id])->value('id');
                    if ($notary_service_id)
                        Contract::where('id', $contract->id)->update(['notary_service_id' => $notary_service_id]);
                }
            }
        }
    }

    public function delete_cards_without_contracts()
    {
        $cards = Card::orderBy('id', 'desc')->get();
        foreach ($cards as $card) {
            $contracts = $card->has_contracts;
            if (!$contracts) {
                Card::where('id', $card->id)->delete();
            }
        }
    }

    public function set_bank_document_link()
    {
        $cards_id = Card::get()->pluck('id');

        foreach ($cards_id as $card_id) {
            $card = Card::find($card_id);
            $contracts = $card->has_contracts;
            $contract = $contracts[0];
            DocumentLink::updateOrCreate(
                ['card_id' => $card_id, 'type' => 'contract'],
                ['contract_id' => $contract->id, 'link' => 'Contract/17.09.2021/17.09 Попередній АТ «Бласкет» (Єрьоменко ) - Смірнова  вул. Миру 14 кв. 1___10/17.09 Попередній АТ «Бласкет» (Єрьоменко ) - Смірнова  вул. Миру 14 кв. 1.docx']
            );

            DocumentLink::updateOrCreate(
                ['card_id' => $card_id, 'type' => 'bank_account'],
                ['contract_id' => $contract->id, 'link' => 'Contract/17.09.2021/17.09 Попередній АТ «Бласкет» (Єрьоменко ) - Смірнова  вул. Миру 14 кв. 1___10/17.09 Попередній АТ «Бласкет» (Єрьоменко ) - Смірнова  вул. Миру 14 кв. 1.docx']
            );

            DocumentLink::updateOrCreate(
                ['card_id' => $card_id, 'type' => 'consent'],
                ['contract_id' => $contract->id, 'link' => 'Contract/17.09.2021/17.09 Попередній АТ «Бласкет» (Єрьоменко ) - Смірнова  вул. Миру 14 кв. 1___10/17.09 Попередній АТ «Бласкет» (Єрьоменко ) - Смірнова  вул. Миру 14 кв. 1.docx']
            );
        }
    }


    public function reset_status()
    {
        Deal::where('id', '>', 0)->update(['ready' => 1]);
        Deal::where('id', '>', 0)->take(10)->update(['ready' => 0]);
    }

    public function set_deals_new_card()
    {
        $cards_id = Card::where('id', '>', '600')->where('id', '<', '700')->take(100)->pluck('id');

        foreach ($cards_id as $key => $card_id) {
            Deal::updateOrCreate(
                [
                    'card_id' => $card_id],
                [
                    'number_of_people' => rand(1, 4),
                    'children' => rand(0, 1),
                    'in_progress' => true,
                    'representative_arrived' => true,
                    'arrival_time' => '2021-01-01 12:21',
                    'invite_time' => '2021-01-01 12:51',
                    'waiting_time' => '2021-01-01 13:02',
                    'total_time' => '2021-01-01 13:13',
                    'payment_status' => true,
                    'ready' => true,
                ]);
        }
    }

    public function set_current_task()
    {
        $cards = Card::get();

        foreach ($cards as $card) {
            $date = new \DateTime();
            if ($card->staff_generator_id) {
                CurrentTask::updateOrCreate(
                    ['card_id' => $card->id],
                    [
                        'staff_id' => $card->staff_generator_id,
                        'date_time' => $date,
                    ]
                );
            }
        }

        $contracts = Contract::get();

        foreach ($contracts as $contract) {
            $date = new \DateTime();
            if ($contract->accompanying_id) {
                CurrentTask::updateOrCreate(
                    ['card_id' => $contract->card_id],
                    [
                        'staff_id' => $contract->accompanying_id,
                        'date_time' => $date,
                    ]
                );
            }

            if ($contract->accompanying_id) {
                CurrentTask::updateOrCreate(
                    ['card_id' => $contract->card_id],
                    [
                        'staff_id' => $contract->reader_id,
                        'date_time' => $date,
                    ]
                );
            }
        }
    }

    public function set_current_task_for_staff()
    {
        $staffs_id = User::pluck('id');
        $step = 1;
        $limit = 80;

        foreach ($staffs_id as $staff_id) {
            CurrentTask::where('card_id', '>', $step)->where('card_id', '<', $limit)->update(['staff_id' => $staff_id]);
            $step = $step + 80;
            $limit = $limit + $step;
        }
    }
}
