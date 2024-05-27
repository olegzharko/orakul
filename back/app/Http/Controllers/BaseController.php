<?php


namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    /**
     * Метод для успешного ответа.
     *
     * @param mixed $result Данные, которые будут возвращены в ответе.
     * @param string $message Сообщение об успешном выполнении.
     * @return JsonResponse JSON-ответ с данными.
     */
    public function sendResponse($result, $message): JsonResponse
    {
        $response = [
            'success' => true, // Индикатор успешного выполнения.
            'message' => $message, // Сообщение об успешном выполнении.
            'data'    => $result ?? [], // Данные, которые будут возвращены (если null, то пустой массив).
        ];

        return response()->json($response, 200); // Возвращаем JSON-ответ с кодом 200 (OK).
    }

    /**
     * Метод для ответа с ошибкой.
     *
     * @param string $error Сообщение об ошибке.
     * @param array $errorMessages Дополнительные сообщения об ошибках.
     * @param int $code HTTP-код ошибки (по умолчанию 400).
     * @return JsonResponse JSON-ответ с сообщением об ошибке.
     */
    public function sendError($error, array $errorMessages = [], int $code = 400): JsonResponse
    {
        $response = [
            'success' => false, // Индикатор неуспешного выполнения.
            'message' => $error, // Сообщение об ошибке.
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages; // Дополнительные данные об ошибках, если они есть.
        }

        return response()->json($response, $code); // Возвращаем JSON-ответ с кодом ошибки.
    }
}
