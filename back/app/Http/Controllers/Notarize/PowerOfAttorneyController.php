<?php

namespace App\Http\Controllers\Notarize;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\PowerOfAttorney;
use App\Models\PowerOfAttorneyGeneralCar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PowerOfAttorneyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // Получаем все доверенности из базы данных
        $powerOfAttorneys = PowerOfAttorney::all();

        // Преобразуем данные в нужную структуру
        $formattedData = $powerOfAttorneys->map(function ($poa) {
            return [
                'id' => $poa->id,
                'color' => '#f15757', // можно изменить логику определения цвета
                'title' => 'Шаблон не обрано' . $poa->id,
                'instructions' => [
                    'Document Number: ' . ($poa->document_number ?? 'N/A'),
                    'Issue Date: ' . ($poa->issue_date ?? 'N/A'),
                    'Expiry Date: ' . ($poa->expiry_date ?? 'N/A'),
                    'Details: ' . ($poa->details ?? 'N/A'),
                ],
                'trustor' => $poa->trustor,
                'agent' => $poa->agent,
            ];
        });

        $result = [
            'date_info' => now()->format('d.m.Y'),
            'powerOfAttorneys' => $formattedData
        ];

        return $this->sendResponse($result, 'Доверенности');
    }

    /**
     * Store a newly created Power of Attorney in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Создание пустой записи для доверителя
        $trustor = Client::create([]);

        // Создание пустой записи для агента
        $agent = Client::create([]);

        // Создание новой доверенности
        $powerOfAttorney = PowerOfAttorney::create([
            'trustor_id' => $trustor->id,
            'agent_id' => $agent->id,
            'document_number' => null,
            'issue_date' => null,
            'expiry_date' => null,
        ]);

        $general = PowerOfAttorneyGeneralCar::create([
            'power_of_attorney_id' => $powerOfAttorney->id,
        ]);

        // Подготовка ответа
        $result = [
            'id' => $powerOfAttorney->id,
            'trustorId' => $powerOfAttorney->trustor_id,
            'agentId' => $powerOfAttorney->agent_id,
            'generalId' => $general->id,
        ];

        // Возвращение успешного ответа
        return $this->sendResponse($result, 'Створена нова довіренність');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
