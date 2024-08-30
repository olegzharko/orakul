<?php

namespace App\Http\Controllers\Notarize;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Notarize\CitizenshipRequest;
use App\Http\Requests\Notarize\UpdateFullNameRequest;
use App\Http\Requests\Notarize\UpdatePassportRequest;
use App\Models\ActualAddress;
use App\Models\AddressType;
use App\Models\ApartmentType;
use App\Models\BuildingPart;
use App\Models\BuildingType;
use App\Models\Citizenship;
use App\Models\Client;
use App\Models\PassportTemplate;
use App\Models\PowerOfAttorney;
use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ClientController extends BaseController
{
    /**
     * Get the full name of the trustor for a Power of Attorney.
     *
     * @param int $powerOfAttorneyId
     * @return JsonResponse
     */
    public function getFullName($clientType, $powerOfAttorneyId): JsonResponse
    {
        // Допустимые типы клиентов
        $validClientTypes = ['trustor', 'agent'];

        // Проверка допустимости типа клиента
        if (!in_array($clientType, $validClientTypes)) {
            return $this->sendError('Недопустимый тип клиента.');
        }

        // Найти запись PowerOfAttorney
        $powerOfAttorney = PowerOfAttorney::findOrFail($powerOfAttorneyId);

        // Получить данные о доверителе
        $client = $powerOfAttorney->$clientType;

        if (!$client) {
            return $this->sendError('Доверитель не найден.');
        }

        return $this->sendResponse([
            'surname_n' => $client->surname_n,
            'name_n' => $client->name_n,
            'patronymic_n' => $client->patronymic_n,
            'surname_r' => $client->surname_r,
            'name_r' => $client->name_r,
            'patronymic_r' => $client->patronymic_r,
            'surname_d' => $client->surname_d,
            'name_d' => $client->name_d,
            'patronymic_d' => $client->patronymic_d,
            'surname_o' => $client->surname_o,
            'name_o' => $client->name_o,
            'patronymic_o' => $client->patronymic_o
        ], 'ПІБ клієнта');
    }

    public function getCitizenships($clientType, $powerOfAttorneyId)
    {
        // Найти запись PowerOfAttorney
        $powerOfAttorney = PowerOfAttorney::findOrFail($powerOfAttorneyId);

        // Получить данные о доверителе
        $client = $powerOfAttorney->$clientType;

        if (!$client) {
            return $this->sendError('Доверитель не найден.');
        }

        $citizenships = Citizenship::select('id', 'title_n as title')->orderBy('title_n')->get();

        $citizenship_id = $client->citizenship_id;

        $result['citizenships'] = $citizenships;
        $result['citizenship_id'] = $citizenship_id;

        return $this->sendResponse($result, 'Дані для вибору громадянства клієнта');
    }

    public function setCitizenships(CitizenshipRequest $request, $clientType, $powerOfAttorneyId)
    {
        // Найти запись PowerOfAttorney
        $powerOfAttorney = PowerOfAttorney::findOrFail($powerOfAttorneyId);

        $user_id = null;
        if ($clientType === 'trustor') {
            $user_id = $powerOfAttorney->trustor_id;
        } elseif ($clientType === 'agent') {
            $user_id = $powerOfAttorney->agent_id;
        } else {
            return $this->sendError('Користувач відсутній');
        }
        // Если у PowerOfAttorney уже есть trustor_id, обновить запись, иначе создать новую
        $trustor = Client::updateOrCreate(
            ['id' => $user_id],
            $request->only([
                'citizenship_id'
            ])
        );

        return $this->sendResponse($trustor, 'Дані про довірителя оновлені або створені');
    }

    /**
     * Update or create a trustor for a Power of Attorney.
     *
     * @param UpdateFullNameRequest $request
     * @param int $powerOfAttorneyId
     * @return JsonResponse
     */
    public function updateTrustorFullName(UpdateFullNameRequest $request, $powerOfAttorneyId): JsonResponse
    {
        // Найти запись PowerOfAttorney
        $powerOfAttorney = PowerOfAttorney::findOrFail($powerOfAttorneyId);

        // Если у PowerOfAttorney уже есть trustor_id, обновить запись, иначе создать новую
        $trustor = Client::updateOrCreate(
            ['id' => $powerOfAttorney->trustor_id],
            $request->only([
                'surname_n',
                'name_n',
                'patronymic_n',
                'surname_r',
                'name_r',
                'patronymic_r',
                'surname_d',
                'name_d',
                'patronymic_d',
                'surname_o',
                'name_o',
                'patronymic_o'
            ])
        );

        // Обновить trustor_id в PowerOfAttorney
        $powerOfAttorney->trustor_id = $trustor->id;
        $powerOfAttorney->save();

        return $this->sendResponse($trustor, 'Дані про довірителя оновлені або створені');
    }

    /**
     * Update or create an agent for a Power of Attorney.
     *
     * @param UpdateFullNameRequest $request
     * @param int $powerOfAttorneyId
     * @return JsonResponse
     */
    public function updateAgentFullName(UpdateFullNameRequest $request, $powerOfAttorneyId): JsonResponse
    {
        // Найти запись PowerOfAttorney
        $powerOfAttorney = PowerOfAttorney::findOrFail($powerOfAttorneyId);

        // Если у PowerOfAttorney уже есть agent_id, обновить запись, иначе создать новую
        $agent = Client::updateOrCreate(
            ['id' => $powerOfAttorney->agent_id],
            $request->only([
                'surname_n',
                'name_n',
                'patronymic_n',
                'surname_r',
                'name_r',
                'patronymic_r',
                'surname_d',
                'name_d',
                'patronymic_d',
                'surname_o',
                'name_o',
                'patronymic_o'
            ])
        );

        // Обновить agent_id в PowerOfAttorney
        $powerOfAttorney->agent_id = $agent->id;
        $powerOfAttorney->save();

        return $this->sendResponse($agent, 'Дані про агента оновлені або створені');
    }

    public function getPassport($clientType, $powerOfAttorneyId)
    {
        // Найти запись PowerOfAttorney
        $powerOfAttorney = PowerOfAttorney::findOrFail($powerOfAttorneyId);

        // Получить данные о доверителе
        $client = $powerOfAttorney->$clientType;

        if (!$client) {
            return $this->sendError('Доверитель не найден.');
        }

        $passport_type = PassportTemplate::select('id', 'title')->get();

        $result['passport_types'] = $passport_type;
        $result['gender'] = $client->gender;
        $result['date_of_birth'] = $client->birth_date ?  $client->birth_date->format('d.m.Y') : null;
        $result['tax_code'] = $client->tax_code;
        $result['passport_type_id'] = $client->passport_type_id;
        $result['passport_code'] = $client->passport_code        ;
        $result['passport_date'] = $client->passport_date ? $client->passport_date->format('d.m.Y') : null;
        $result['passport_department'] = $client->passport_department;
        $result['passport_demographic_code'] = $client->passport_demographic_code;
        $result['passport_finale_date'] = $client->passport_finale_date ? $client->passport_finale_date->format('d.m.Y') : null;

        return $this->sendResponse($result, 'Код, стать та паспортні дані клієнта з ID: ' . $client->id);
    }

    public function setPassport(UpdatePassportRequest $request, $clientType, $powerOfAttorneyId): JsonResponse
    {
            // Получение валидированных данных
        $validatedData = $request->validated();

        // Форматирование дат
        $request['date_of_birth'] = Carbon::createFromFormat('d.m.Y H:i', $validatedData['date_of_birth'])->format('Y-m-d H:i:s');
        $request['passport_date'] = Carbon::createFromFormat('d.m.Y H:i', $validatedData['passport_date'])->format('Y-m-d H:i:s');
        $request['passport_finale_date'] = Carbon::createFromFormat('d.m.Y H:i', $validatedData['passport_finale_date'])->format('Y-m-d H:i:s');

        // Найти запись PowerOfAttorney
        $powerOfAttorney = PowerOfAttorney::findOrFail($powerOfAttorneyId);

        // Получить данные о доверителе
        $client = $powerOfAttorney->$clientType;

        if (!$client) {
            return $this->sendError('Доверитель не найден.');
        }

        if (!$client = Client::find($client->id)) {
            return $this->sendError('', 'Клієнт з ID: ' . $client->id . ' відсутній');
        }

        Client::where('id', $client->id)->update([
            'gender' => $request['gender'],
            'birth_date' => $request['date_of_birth'],
            'tax_code' => $request['tax_code'],
            'passport_type_id' => $request['passport_type_id'],
            'passport_code' => $request['passport_code'],
            'passport_date' => $request['passport_date'],
            'passport_department' => $request['passport_department'],
            'passport_demographic_code' => $request['passport_demographic_code'],
            'passport_finale_date' => $request['passport_finale_date'],
        ]);

        return $this->sendResponse('', 'Код, стать та паспортні дані клієнта з ID ' . $client->id . ' оновлено');
    }

    public function getAddress($clientType, $powerOfAttorneyId)
    {
        // Найти запись PowerOfAttorney
        $powerOfAttorney = PowerOfAttorney::findOrFail($powerOfAttorneyId);

        // Получить данные о доверителе
        $client = $powerOfAttorney->$clientType;

        if (!$client) {
            return $this->sendError('Доверитель не найден.');
        }

        $result = [];

        $regions = Region::select('id', 'title_n as title')->orderBy('title')->get();
        $address_type = AddressType::select('id', 'title_n as title')->orderBy('title')->get();
        $building_type = BuildingType::select('id', 'title_n as title')->orderBy('title')->get();
        $building_part = BuildingPart::select('id', 'title_n as title')->orderBy('title')->get();
        $apartment_type = ApartmentType::select('id', 'title_n as title')->orderBy('title')->get();

        $result['regions'] = $regions;

        $result['address_type'] = $address_type;
        $result['building_type'] = $building_type;
        $result['building_part'] = $building_part;
        $result['apartment_type'] = $apartment_type;
        $result['registration'] = $client->registration ? true : false;
        $result['region_id'] = $client->city ? $client->city->region_id : null;
        $result['district_id'] = $client->district_id;
        $result['city_id'] = $client->city_id;
        $result['address_type_id'] = $client->address_type_id;
        $result['address'] = $client->address;
        $result['building_type_id'] = $client->building_type_id;
        $result['building_num'] = $client->building;
        $result['building_part_id'] = $client->building_part_id;
        $result['building_part_num'] = $client->building_part_num;
        $result['apartment_type_id'] = $client->apartment_type_id;
        $result['apartment_num'] = $client->apartment_num;

        $result['actual'] = null;
        $result['actual_region_id'] = null;
        $result['actual_city_id'] = null;
        $result['actual_address_type_id'] = null;
        $result['actual_address'] = null;
        $result['actual_building_type_id'] = null;
        $result['actual_building_num'] = null;
        $result['actual_apartment_type_id'] = null;
        $result['actual_apartment_num'] = null;

        if ($client->actual_address) {
            $result['actual'] = true;
            $result['actual_region_id'] = $client->actual_address->city ? $client->actual_address->city->region_id : null;
            $result['actual_city_id'] = $client->actual_address->city_id;
            $result['actual_district_id'] = $client->actual_address->district_id;
            $result['actual_address_type_id'] = $client->actual_address->address_type_id;
            $result['actual_address'] = $client->actual_address->address;
            $result['actual_building_type_id'] = $client->actual_address->building_type_id;
            $result['actual_building_num'] = $client->actual_address->building;
            $result['actual_building_part_id'] = $client->actual_address->building_part_id;
            $result['actual_building_part_num'] = $client->actual_address->building_part_num;
            $result['actual_apartment_type_id'] = $client->actual_address->apartment_type_id;
            $result['actual_apartment_num'] = $client->actual_address->apartment_num;
        } else {
            $result['actual'] = false;
        }

        return $this->sendResponse($result, 'Дані адреси клієнта');
    }

    public function setAddress(Request $request, $clientType, $powerOfAttorneyId): JsonResponse
    {
        // Найти запись PowerOfAttorney
        $powerOfAttorney = PowerOfAttorney::findOrFail($powerOfAttorneyId);

        // Получить данные о доверителе
        $client = $powerOfAttorney->$clientType;

        if (!$client) {
            return $this->sendError('Доверитель не найден.');
        }

        Client::where('id', $client->id)->update([
            'registration' => $request['registration'] ? 1 : 0,
            'district_id' => $request['district_id'],
            'city_id' => $request['city_id'],
            'address_type_id' => $request['address_type_id'],
            'address' => $request['address'],
            'building_type_id' => $request['building_type_id'],
            'building' => $request['building_num'],
            'building_part_id' => $request['building_part_id'],
            'building_part_num' => $request['building_part_num'],
            'apartment_type_id' => $request['apartment_type_id'],
            'apartment_num' => $request['apartment_num'],
        ]);

        if ($request['actual']) {
            ActualAddress::updateOrCreate(
                ['client_id' => $client->id],
                [
                    'actual' => $request['actual'],
                    'district_id' => $request['actual_district_id'],
                    'city_id' => $request['actual_city_id'],
                    'address_type_id' => $request['actual_address_type_id'],
                    'address' => $request['actual_address'],
                    'building_type_id' => $request['actual_building_type_id'],
                    'building' => $request['actual_building_num'],
                    'building_part_id' => $request['actual_building_part_id'],
                    'building_part_num' => $request['actual_building_part_num'],
                    'apartment_type_id' => $request['actual_apartment_type_id'],
                    'apartment_num' => $request['actual_apartment_num'],
                ]);
        } else {
            ActualAddress::where('client_id', $client->id)->delete();
        }

        return $this->sendResponse('', 'Адреса клієнта з ID ' . $client->id . ' оновлена');
    }
}
