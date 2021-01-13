<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ContractController;
use \App\Http\Controllers\GeneratorController;
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

Route::get('clear', function () {
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
});

Route::get('creat/contract', [GeneratorController::class, 'creat_contract']);
//Route::get('consent/spouses', [ContractController::class, 'consent_spouses']);
