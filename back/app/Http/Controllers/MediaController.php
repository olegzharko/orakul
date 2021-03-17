<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use URL;

class MediaController extends Controller
{
    public function get_single_media_images($model, $media)
    {
        foreach ($model as $key => $value) {
            if ($value = $value->getMedia($media)) {
                if ($image = $value->first()) {
//                    $model[$key]->image = str_replace(URL::to('/'), '', $image->getUrl());
                    $model[$key]->image = $image->getUrl();

                    unset($model[$key]->media);
                } else {
                    $model[$key]->image = "";
                }
            }
        }

        return $model;
    }
}
