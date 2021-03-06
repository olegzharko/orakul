<?php

namespace App\Http\Controllers\React;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index()
    {
        return view('index', []);
    }
}
