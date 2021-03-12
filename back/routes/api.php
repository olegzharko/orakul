<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Rakul\CalendarController;
use App\Http\Controllers\Rakul\CardController;
use App\Http\Controllers\Rakul\TextController;
use App\Http\Controllers\Rakul\FilterController;
use \App\Http\Controllers\Rakul\SlidesController;
use \App\Http\Controllers\Rakul\SearchController;
use \App\Http\Controllers\Rakul\SortController;
use \App\Http\Controllers\Rakul\ManagerController;

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
Route::get('slides', [SlidesController::class, 'slides']);
Route::post('password/forgot', [PassportAuthController::class, 'password_forgot'])->middleware('guest');

// Password reset routes...
Route::get('password/reset/{token}', [PassportAuthController::class, 'password_reset'])->name('password.request');
Route::post('password/update', [PassportAuthController::class, 'password_update'])->name('password.reset');

Route::group(['prefix' => 'local'], function () {
    Route::get('global_text', [TextController::class, 'global_text']);
    Route::get('logout', [PassportAuthController::class, 'logout']);
    Route::get('extra_logout', [PassportAuthController::class, 'extra_logout']);
    Route::get('calendar', [CalendarController::class, 'calendar']);
    Route::put('cards/move/{id}', [CardController::class, 'move']);
    Route::resource('cards', CardController::class);
    Route::group(['prefix' => 'filter'], function () {
        Route::get('dropdown', [FilterController::class, 'dropdown']);
        Route::get('developer/info/{id}', [FilterController::class, 'developer_info']);
        Route::get('total', [ManagerController::class, 'total_cards']);
        Route::get('ready', [ManagerController::class, 'ready_cards']);
        Route::get('contract_type/{type}/{page}', [ManagerController::class, 'cards_by_contract_type']);
        Route::get('cancelled/{page}', [ManagerController::class, 'cancelled_cards']);
        Route::post('search', [SearchController::class, 'search']);
        Route::post('sort/{page}', [SortController::class, 'sort']);
    });
});

Route::middleware('auth:api')->group(function () {
    Route::get('extra_logout', [PassportAuthController::class, 'extra_logout']);
    Route::get('logout', [PassportAuthController::class, 'logout']);
    Route::get('calendar', [CalendarController::class, 'calendar']);
    Route::get('global_text', [TextController::class, 'global_text']);
    Route::resource('posts', PostController::class);
    Route::put('cards/move/{id}', [CardController::class, 'move']);
    Route::resource('cards', CardController::class);
    Route::group(['prefix' => 'filter'], function () {
        Route::get('dropdown', [FilterController::class, 'dropdown']);
        Route::get('developer/info/{id}', [FilterController::class, 'developer_info']);
        Route::get('total', [ManagerController::class, 'total_cards']);
        Route::get('ready', [ManagerController::class, 'ready_cards']);
        Route::get('contract_type/{type}/{page}', [ManagerController::class, 'cards_by_contract_type']);
        Route::get('cancelled/{page}', [ManagerController::class, 'cancelled_cards']);
        Route::post('search', [SearchController::class, 'search']);
        Route::post('sort/{page}', [SortController::class, 'sort']);
    });
});
