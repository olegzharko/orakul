<?php

namespace App\Http\Controllers\Info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StepController extends Controller
{
    public function __construct()
    {

    }

    public function todo_list($card)
    {
        $result = [];

        $result[] = "Тестовий текст для Крточки №$card->id";
        $result[] = "Паспорт тест";
        $result[] = "Код тест";

        return $result;
    }
}
