<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Text;
use Illuminate\Http\Request;

class TextController extends BaseController
{
    public function global_text()
    {
        $text = Text::pluck('value', 'alias');

        return $this->sendResponse($text, "Глобальний текст");
    }
}
