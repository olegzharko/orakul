<?php

namespace App\Http\Requests\Notarize;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFullNameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'surname_n' => 'nullable|string|max:255',
            'name_n' => 'nullable|string|max:255',
            'patronymic_n' => 'nullable|string|max:255',
            'surname_r' => 'nullable|string|max:255',
            'name_r' => 'nullable|string|max:255',
            'patronymic_r' => 'nullable|string|max:255',
            'surname_d' => 'nullable|string|max:255',
            'name_d' => 'nullable|string|max:255',
            'patronymic_d' => 'nullable|string|max:255',
            'surname_o' => 'nullable|string|max:255',
            'name_o' => 'nullable|string|max:255',
            'patronymic_o' => 'nullable|string|max:255',
        ];
    }
}
