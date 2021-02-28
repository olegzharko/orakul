<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Rakul\CalendarController;
use App\Http\Controllers\Rakul\CardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);


Route::group(['prefix' => 'local'], function () {
    Route::get('calendar', [CalendarController::class, 'calendar']);
    Route::resource('calendar/cards', CardController::class);
});
Route::middleware('auth:api')->group(function () {
    Route::get('calendar', [CalendarController::class, 'calendar']);
    Route::resource('posts', PostController::class);
    Route::resource('cards', CardController::class);
});
