<?php

namespace App\Http\Requests\Notarize;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePassportRequest extends FormRequest
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
            'gender' => 'required|string|in:male,female',
            'date_of_birth' => 'required',
            'tax_code' => 'nullable|string|max:255',
            'passport_type_id' => 'required|integer|exists:passport_templates,id',
            'passport_code' => 'nullable|string|max:255',
            'passport_date' => 'required',
            'passport_department' => 'nullable|string|max:255',
            'passport_demographic_code' => 'nullable|string|max:255',
            'passport_finale_date' => 'nullable|string|max:255',
        ];
    }
}
