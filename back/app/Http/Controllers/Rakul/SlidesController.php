<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MediaController;
use Illuminate\Http\Request;
use App\Models\Slide;

class SlidesController extends BaseController
{
    public $media;

    public function __construct()
    {
        $this->media = new MediaController();
    }

    public function slides()
    {
        $slides = Slide::select('id', 'sort_order')->get();

        if ($slides) {

            $slides = $this->media->get_single_media_images($slides, 'path');
            return $this->sendResponse($slides, 'Слайди передані успішно');
        } else {
            return $this->sendError("Слайди відсутні");
        }

    }
}
