<?php

namespace App\Http\Requests\Notarize;

use Illuminate\Foundation\Http\FormRequest;

class GeneralRequest extends FormRequest
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
            'car_make' => 'required|string',
            'commercial_description' => 'required|string',
            'registered' => 'required|string',
            'registration_certificate' => 'required|string',
            'registration_date' => 'required|string',
            'registration_number' => 'required|string',
            'special_notes' => 'string|nullable',
            'type' => 'string|nullable',
            'vin_code' => 'required|string',
            'year_of_manufacture' => 'required|string',
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
            'car_make.required' => 'Поле "Car Make" обязательно для заполнения.',
            'car_make.string' => 'Поле "Car Make" должно быть строкой.',
            'commercial_description.required' => 'Поле "Commercial Description" обязательно для заполнения.',
            'commercial_description.string' => 'Поле "Commercial Description" должно быть строкой.',
            'registered.required' => 'Поле "Registered" обязательно для заполнения.',
            'registered.string' => 'Поле "Registered" должно быть строкой.',
            'registration_certificate.required' => 'Поле "Registration Certificate" обязательно для заполнения.',
            'registration_certificate.string' => 'Поле "Registration Certificate" должно быть строкой.',
            'registration_date.required' => 'Поле "Registration Date" обязательно для заполнения.',
            'registration_date.string' => 'Поле "Registration Date" должно быть строкой.',
            'registration_number.required' => 'Поле "Registration Number" обязательно для заполнения.',
            'registration_number.string' => 'Поле "Registration Number" должно быть строкой.',
            'special_notes.required' => 'Поле "Special Notes" обязательно для заполнения.',
            'special_notes.string' => 'Поле "Special Notes" должно быть строкой.',
            'type.required' => 'Поле "Type" обязательно для заполнения.',
            'type.string' => 'Поле "Type" должно быть строкой.',
            'vin_code.required' => 'Поле "VIN Code" обязательно для заполнения.',
            'vin_code.string' => 'Поле "VIN Code" должно быть строкой.',
            'year_of_manufacture.required' => 'Поле "Year of Manufacture" обязательно для заполнения.',
            'year_of_manufacture.string' => 'Поле "Year of Manufacture" должно быть строкой.',
        ];
    }
}
