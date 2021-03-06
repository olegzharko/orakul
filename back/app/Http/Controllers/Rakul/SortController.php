<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Validator;

class SortController extends BaseController
{
    public function sort($page, Request $r)
    {
        $validator = $this->validate_data($r);


        if (count($validator->errors()->getMessages())) {
            return $this->sendError('Форма передає помилкові дані', $validator->errors());
        }
        dd('good');
    }

    public function validate_data($r)
    {
        $validator = Validator::make([
            'notary_id' => $r['notary_id'],
            'reader_id' => $r['reader_id'],
            'giver_id' => $r['giver_id'],
            'dev_company_id' => $r['dev_company_id'],
            'dev_representative_id' => $r['dev_representative_id'],
            'sort_type_id' => $r['sort_type_id'],
        ], [
            'notary_id' => ['required', 'numeric', 'nullable'],
            'reader_id' => ['required', 'numeric', 'nullable'],
            'giver_id' => ['required', 'numeric', 'nullable'],
            'dev_company_id' => ['required', 'numeric', 'nullable'],
            'dev_representative_id' => ['required', 'numeric', 'nullable'],
            'sort_type_id' => ['required', 'numeric', 'nullable'],
        ], [
            'notary_id.required' => 'Необхідно передати ID нотаріса або 0',
            'reader_id.required' => 'Необхідно передати ID читача або 0',
            'giver_id.required' => 'Необхідно передати ID видавача або 0',
            'dev_company_id.required' => 'Необхідно передати ID компанії забудовника або 0',
            'dev_representative_id.required' => 'Необхідно передати ID представника забудовника або 0',
            'sort_type_id.required' => 'Необхідно передати ID метода сортування або 0',
            'notary_id.numeric' => 'Необхідно передати ID нотаріса в числовому форматі',
            'reader_id.numeric' => 'Необхідно передати ID читача в числовому форматі',
            'giver_id.numeric' => 'Необхідно передати ID видавача в числовому форматі',
            'dev_company_id.numeric' => 'Необхідно передати ID компанії забудовника в числовому форматі',
            'dev_representative_id.numeric' => 'Необхідно передати ID представника забудовника в числовому форматі',
            'sort_type_id.numeric' => 'Необхідно передати ID метода сортування в числовому форматі',
        ]);

        return $validator;
    }

}
