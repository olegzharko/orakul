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
}
