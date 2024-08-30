<?php

namespace App\Http\Requests\Notarize;

use Illuminate\Foundation\Http\FormRequest;

class TemplateInfoRequest extends FormRequest
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
            'contract_template_id' => 'required|exists:power_of_attorney_templates,id',
            'issue_date' => 'required|date|before_or_equal:expiry_date',
            'expiry_date' => 'required|date|after_or_equal:issue_date',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'contract_template_id.required' => 'Поле "Шаблон договора" обязательно для заполнения.',
            'contract_template_id.exists' => 'Выбранный шаблон договора не существует.',
            'issue_date.required' => 'Поле "Дата выдачи" обязательно для заполнения.',
            'issue_date.date' => 'Поле "Дата выдачи" должно быть датой.',
            'issue_date.before_or_equal' => 'Поле "Дата выдачи" должно быть раньше или равно дате окончания.',
            'expiry_date.required' => 'Поле "Дата окончания" обязательно для заполнения.',
            'expiry_date.date' => 'Поле "Дата окончания" должно быть датой.',
            'expiry_date.after_or_equal' => 'Поле "Дата окончания" должно быть позже или равно дате выдачи.',
        ];
    }
}
