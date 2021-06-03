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
        $result['total_price'] = null;
        $result['total_month'] = null;
        $result['type'] = null;

        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

        if ($immovable->installment) {
            $result['total_price'] = $immovable->installment->total_price / 100;
            $result['total_month'] = $immovable->installment->total_month;
            $result['type'] = $immovable->installment->type;
        }

        return $this->sendResponse($result, 'Дані рострочки');
    }

    public function update_installment($immovable_id, Request $r)
    {
        if (!$immovable = Immovable::find($immovable_id))
            return $this->sendError('', 'Нерухомість по ID:' . $immovable_id . ' не було знайдено.');

//        $r->total_price = floatval($r->total_price);

        Installment::updateOrCreate(['immovable_id' => $immovable_id],
            [
                'total_price' => intval($r->total_price * 100),
                'total_month' => $r->total_month,
                'type' => $r->type,
            ]);

        return $this->sendResponse('', 'Розстрочка оновлена');
    }

    public function get_data_for_doc($card, $immovable, $sign_date, $client_num)
    {
        $start_date = $sign_date;

        // обрати курс долара відповідно компанії забудовника
        if ($immovable->developer_building->dev_company->contract_rate)
            $dollar_rate_int = $card->exchange_rate->contract_buy;
        else
            $dollar_rate_int = $card->exchange_rate->rate;

        $total_price_grn_int = $immovable->installment->total_price;

        if ($client_num == 2) {
            $total_price_dollar_float = $total_price_grn_int / $dollar_rate_int;
            $total_price_dollar_float = round($total_price_dollar_float, 2);
            if (($total_price_dollar_float * 100) % 2) {
                $total_price_dollar_float += 0.01;
            }
        }
        else {
            $total_price_dollar_float = round($total_price_grn_int / $dollar_rate_int, 2);
        }

        $total_month = $immovable->installment->total_month;
        $type = $immovable->installment->type;

        if ($type == 'quarter') {
            $type = 3;
        } else {
            $type = 1;
        }

        $result = [];
        $step = $total_month / $type;
        $i = $step - 1;

        $total_price_grn_float = ($total_price_grn_int / $client_num) / 100;
        $total_price_dollar_float = ($total_price_dollar_float / $client_num);

        $month_payment_grivna = round($total_price_grn_float / $step, 2);
        $month_payment_dollar =  round($total_price_dollar_float / $step, 2);

        while ($i--) {
            $date = $start_date->modify("+$type month");
            $result[$date->format('d.m.Y')]['grn'] = $month_payment_grivna;
            $result[$date->format('d.m.Y')]['dollar'] = $month_payment_dollar;
        }
        $date = $start_date->modify("+$type month");
        $result[$date->format('d.m.Y')]['grn'] = round($total_price_grn_float - $month_payment_grivna * ($step - 1), 2);
        $result[$date->format('d.m.Y')]['dollar'] = round($total_price_dollar_float - $month_payment_dollar * ($step - 1), 2);

        return  $result;
    }
}
