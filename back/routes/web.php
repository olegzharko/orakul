<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\DocumentController;
//use \App\Http\Controllers\GeneratorController;
use \App\Http\Controllers\Factory\GeneratorController;
use \App\Http\Controllers\ConvertController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('price', [ConvertController::class, 'convert_price_int_part_to_string']);
Route::get('test_price_convert', [ConvertController::class, 'test_price_convert']);

Route::get('clear', function () {
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
});

Route::get('creat/contract', [GeneratorController::class, 'creat_contract']);
Route::get('service/read', [DocumentController::class, 'make_document_service']);
