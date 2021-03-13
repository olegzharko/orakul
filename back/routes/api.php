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
use \App\Http\Controllers\Factory\GeneratorController;
use \App\Http\Controllers\Generator\DeveloperController;
use \App\Http\Controllers\Generator\ImmovableController;

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

//Route::group(['prefix' => 'local'], function () {
//    Route::get('global_text', [TextController::class, 'global_text']);
//    Route::get('logout', [PassportAuthController::class, 'logout']);
//    Route::get('extra_logout', [PassportAuthController::class, 'extra_logout']);
//    Route::get('calendar', [CalendarController::class, 'calendar']);
//    Route::put('cards/move/{id}', [CardController::class, 'move']);
//    Route::resource('cards', CardController::class);
//    Route::group(['prefix' => 'filter'], function () {
//        Route::get('dropdown', [FilterController::class, 'dropdown']);
//        Route::get('developer/info/{id}', [FilterController::class, 'developer_info']);
//        Route::get('total', [ManagerController::class, 'total_cards']);
//        Route::get('ready', [ManagerController::class, 'ready_cards']);
//        Route::get('contract_type/{type}/{page}', [ManagerController::class, 'cards_by_contract_type']);
//        Route::get('cancelled/{page}', [ManagerController::class, 'cancelled_cards']);
//        Route::post('search', [SearchController::class, 'search']);
//        Route::post('sort/{page}', [SortController::class, 'sort']);
//    });
//});

Route::middleware('auth:api')->group(function () {
    Route::get('extra_logout', [PassportAuthController::class, 'extra_logout']);
    Route::get('logout', [PassportAuthController::class, 'logout']);
    Route::get('global_text', [TextController::class, 'global_text']);
    Route::get('calendar', [CalendarController::class, 'calendar']);
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

    Route::group(['prefix' => 'generator'], function() {
       Route::get('main/{card_id}', [\App\Http\Controllers\Generator\MainController::class, 'main']);
       Route::get('create/{card_id}', [GeneratorController::class, 'creat_contract_by_card_id']);
       Route::group(['prefix' => 'developer'], function() {
           Route::get('main/{card_id}', [DeveloperController::class, 'main']);
           Route::get('fence/{card_id}', [DeveloperController::class, 'get_fence']);
           Route::post('fence/{card_id}', [DeveloperController::class, 'update_fence']);
           Route::get('spouse/{card_id}', [DeveloperController::class, 'spouse']);
           Route::get('representative/{card_id}', [DeveloperController::class, 'get_representative']);
           Route::post('representative/{card_id}', [DeveloperController::class, 'update_representative']);
       });

        Route::group(['prefix' => 'immovable'], function() {
            Route::get('main/{card_id}', [ImmovableController::class, 'main']);
        });
    });
});
