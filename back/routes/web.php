<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Factory\DocumentController;
use \App\Http\Controllers\Factory\GeneratorController;
use \App\Http\Controllers\Factory\ConvertController;
use \App\Http\Controllers\React\ViewController;
use App\Http\Controllers\PassportAuthController;

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



Route::get('price', [ConvertController::class, 'convert_price_int_part_to_string']);
Route::get('test_price_convert', [ConvertController::class, 'test_price_convert']);

Route::get('clear', function () {
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
});

Route::get('create/{card_id}', [GeneratorController::class, 'create_contract_by_card_id']); // postman
Route::get('creat/contracts', [GeneratorController::class, 'create_contracts_by_cards']);
Route::get('creat/all/contracts', [GeneratorController::class, 'create_all_contracts']);
Route::get('creat/contract/{card_id}', [GeneratorController::class, 'create_contract_by_card_id']);
Route::get('service/read', [DocumentController::class, 'make_document_service']);

//Route::post('login', [PassportAuthController::class, 'login']);
//Route::get('check/user/auth', [PassportAuthController::class, 'check_user']);

Route::get('/{slug?}/{next?}/{step?}', [ViewController::class, 'index'])->where('slug', '^(?!nova).*$');;
