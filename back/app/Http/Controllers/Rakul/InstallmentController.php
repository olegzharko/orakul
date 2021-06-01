<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Models\Installment;
use Illuminate\Http\Request;
use App\Models\Immovable;

class InstallmentController extends BaseController
{
    public function get_installment($immovable_id)
    {
        $result = [];

        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $result['total_price'] = $immovable->installment->total_price;
        $result['total_month'] = $immovable->installment->total_month;
        $result['type'] = $immovable->installment->type;

        return $this->sendResponse($result, 'Дані рострочки');
    }

    public function update_installment($immovable_id, Request $r)
    {
        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        Installment::updateOrCreate(['immovable_id' => $immovable_id],
            [
                'total_price' => $r->total_price,
                'total_month' => $r->total_month,
                'type' => $r->type,
            ]);

        return $this->sendResponse('', 'Розстрочка оновлена');
    }

    public function get_data_for_doc($card, $immovable, $sign_date)
    {
        $start_date = $sign_date;
        $dollar_rate = $card->exchange_rate->contract_buy; // ####
        $last_part = 0;
        $total_price_grn = $immovable->installment->total_price;
        $total_price_dollar = round($total_price_grn / $dollar_rate, 2);
        $total_month = $immovable->installment->total_month;
        $type = $immovable->installment->type;
        $count_client = 1;

        if ($type == 'quarter') {
            $type = 3;
        } else {
            $type = 1;
        }

        $result = [];
        $step = $total_month / $type;
        $i = $step - 1;
        $month_payment_givna = round($total_price_grn / $step, 2);
        $month_payment_dollar =  round($total_price_dollar / $step, 2);

        while ($i--) {
            $date = $start_date->modify("+$type month");
            $result[$date->format('d.m.Y')]['grn'] = $month_payment_givna;
            $result[$date->format('d.m.Y')]['dollar'] = $month_payment_dollar;
        }
        $date = $start_date->modify("+$type month");
        $result[$date->format('d.m.Y')]['grn'] = round($total_price_grn - $month_payment_givna * ($step - 1), 2);
        $result[$date->format('d.m.Y')]['dollar'] = round($total_price_dollar - $month_payment_dollar * ($step - 1), 2);

        return  $result;
    }

    public function test($immovable_id)
    {
        dd($immovable_id);
        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        $start_date = new \DateTime();
        $dollar_rate = 27.46; // ####
        $last_part = 0;
        $total_price_grn = $immovable->installment->total_price = 513800.00; // ####
        $total_price_dollar = round($total_price_grn / $dollar_rate, 2);
        $total_month = $immovable->installment->total_month;
        $type = $immovable->installment->type;
        $count_client = 1;

        if ($type == 'quarter') {
            $type = 3;
        } else {
            $type = 1;
        }

        $type = 3; // ####

        $result = [];
//        $result_grivna = [];
//        $result_dollar = [];
        $step = $total_month / $type;
        $i = $step - 1;
        $month_payment_givna = round($total_price_grn / $step, 2);
        $month_payment_dollar =  round($total_price_dollar / $step, 2);

        while ($i--) {
            $date = $start_date->modify("+$type month");
//            $current_price = round($total_price_grn / $step, 2);
            $result[$date->format('d.m.Y')]['grn'] = $month_payment_givna;
            $result[$date->format('d.m.Y')]['dollar'] = $month_payment_dollar;
//            $result_grivna[$date->format('d.m.Y')] = $month_payment_givna;
//            $result_dollar[$date->format('d.m.Y')] = $month_payment_dollar;
        }
        $date = $start_date->modify("+$type month");
        $result[$date->format('d.m.Y')]['grn'] = round($total_price_grn - $month_payment_givna * ($step - 1), 2);
        $result[$date->format('d.m.Y')]['dollar'] = round($total_price_dollar - $month_payment_dollar * ($step - 1), 2);
//        $result_grivna[$date->format('d.m.Y')] = $total_price_grn - $month_payment_givna * ($step - 1);
//        $result_dollar[$date->format('d.m.Y')] = $total_price_dollar - $month_payment_dollar * ($step - 1);

        return  $result;
    }
}
