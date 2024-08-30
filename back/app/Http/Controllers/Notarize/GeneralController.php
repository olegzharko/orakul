<?php

namespace App\Http\Controllers\Notarize;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Notarize\GeneralRequest;
use App\Models\PowerOfAttorney;
use App\Models\PowerOfAttorneyGeneralCar;

class GeneralController extends BaseController
{
    public function getGeneral($powerOfAttorneyID)
    {
        $powerOfAttorney = PowerOfAttorney::findOrFail($powerOfAttorneyID);

        $general = PowerOfAttorneyGeneralCar::where('power_of_attorney_id', $powerOfAttorney->id)->firstOrFail();

        if ($general->registration_date) {
            $general->registration_date = $general->registration_date->format('d.m.Y');
        }
        $result = [
            'car_make' => $general->car_make,
            'commercial_description' => $general->commercial_description,
            'type' => $general->type,
            'special_notes' => $general->special_notes,
            'year_of_manufacture' => $general->year_of_manufacture,
            'vin_code' => $general->vin_code,
            'registration_number' => $general->registration_number,
            'registered' => $general->registered,
            'registration_date' => $general->registration_date ? $general->registration_date->format('d.m.Y') : null,
            'registration_certificate' => $general->registration_certificate,
        ];

        return $this->sendResponse($result, 'Предмет довіреності');
    }

    public function setGeneral(GeneralRequest $generalRequest, $powerOfAttorneyID)
    {
        $powerOfAttorney = PowerOfAttorney::findOrFail($powerOfAttorneyID);

        // Преобразуем дату перед сохранением
        $registrationDate = \Carbon\Carbon::createFromFormat('d.m.Y H:i', $generalRequest['registration_date'])->format('Y-m-d H:i:s');

        $general = PowerOfAttorneyGeneralCar::updateOrCreate(
            ['power_of_attorney_id' => $powerOfAttorney->id], // Условие для поиска записи
            [
                'car_make' => $generalRequest['car_make'],
                'commercial_description' => $generalRequest['commercial_description'],
                'type' => $generalRequest['type'],
                'special_notes' => $generalRequest['special_notes'],
                'year_of_manufacture' => $generalRequest['year_of_manufacture'],
                'vin_code' => $generalRequest['vin_code'],
                'registration_number' => $generalRequest['registration_number'],
                'registered' => $generalRequest['registered'],
                'registration_date' => $registrationDate,
                'registration_certificate' => $generalRequest['registration_certificate'],
            ]
        );

        return $this->sendResponse($general, 'Предмет довіреності обновлен успешно');
    }
}
