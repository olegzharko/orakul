<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Rakul\ReceptionController;
use App\Http\Controllers\Rakul\CardController;
use App\Http\Controllers\Rakul\TextController;
use App\Http\Controllers\Rakul\FilterController;
use \App\Http\Controllers\Rakul\SlidesController;
use \App\Http\Controllers\Rakul\SearchController;
use \App\Http\Controllers\Rakul\SortController;
//use \App\Http\Controllers\Rakul\ManagerController;
use \App\Http\Controllers\Factory\GeneratorController;
use \App\Http\Controllers\Generator\DeveloperController;
use \App\Http\Controllers\Generator\ImmovableController;
use \App\Http\Controllers\Generator\ClientController;
use \App\Http\Controllers\API\MinfinController;

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
Route::get('password/reset/{token}', [PassportAuthController::class, 'password_reset'])->name('password.request');
Route::post('password/update', [PassportAuthController::class, 'password_update'])->name('password.reset');

Route::middleware('auth:api')->group(function () {

    Route::get('extra_logout', [PassportAuthController::class, 'extra_logout']);
    Route::get('logout', [PassportAuthController::class, 'logout']);
    Route::get('global_text', [TextController::class, 'global_text']);
    Route::get('reception', [ReceptionController::class, 'reception']);
    Route::get('calendar', [ReceptionController::class, 'reception']); // убрать этот запрос. сменить на reception
    Route::put('cards/move/{id}', [CardController::class, 'move']);
    Route::resource('cards', CardController::class);
    Route::get('exchange', [MinfinController::class, 'get_rate_exchange']);

    Route::group(['prefix' => 'filter'], function () {
        Route::get('dropdown', [FilterController::class, 'dropdown']);
        Route::get('developer/info/{id}', [FilterController::class, 'developer_info']);
        #######################
        Route::get('ready', [FilterController::class, 'ready_cards']);
        Route::get('contract/type/{contract_type}', [FilterController::class, 'cards_by_contract_type']);
        Route::get('cancelled', [FilterController::class, 'cancelled_cards']);
        #######################
        Route::post('sort', [SortController::class, 'sort']);
        Route::post('search', [SearchController::class, 'search']);
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

            Route::get('general/{immovable_id}', [ImmovableController::class, 'get_general']);
            Route::put('general/{immovable_id}', [ImmovableController::class, 'update_general']);

            Route::get('exchange/{immovable_id}', [ImmovableController::class, 'get_exchange']);
            Route::post('exchange/{immovable_id}', [ImmovableController::class, 'new_exchange']);
            Route::put('exchange/{immovable_id}', [ImmovableController::class, 'update_exchange']);

            Route::get('payment/{immovable_id}', [ImmovableController::class, 'get_payment']);
            Route::put('payment/{immovable_id}', [ImmovableController::class, 'update_payment']);

            Route::get('fence/{immovable_id}', [ImmovableController::class, 'get_fence']);
            Route::put('fence/{immovable_id}', [ImmovableController::class, 'update_fence']);

            Route::get('valuation/{immovable_id}', [ImmovableController::class, 'get_valuation']);
            Route::put('valuation/{immovable_id}', [ImmovableController::class, 'update_valuation']);

            Route::get('ownership/{immovable_id}', [ImmovableController::class, 'get_ownership']);
            Route::put('ownership/{immovable_id}', [ImmovableController::class, 'update_ownership']);

            Route::get('template/{immovable_id}', [ImmovableController::class, 'get_template']);
            Route::put('template/{immovable_id}', [ImmovableController::class, 'update_template']);
       });

       Route::group(['prefix' => 'client'], function() {
            Route::get('main/{card_id}', [ClientController::class, 'main']);
            Route::get('name/{client_id}', [ClientController::class, 'get_name']);
            Route::put('name/{client_id}', [ClientController::class, 'update_name']);

            Route::get('contacts/{client_id}', [ClientController::class, 'get_contacts']);
            Route::put('contacts/{client_id}', [ClientController::class, 'update_contacts']);

            Route::get('citizenships/{client_id}', [ClientController::class, 'get_citizenships']);
            Route::put('citizenships/{client_id}', [ClientController::class, 'update_citizenships']);

            Route::get('passport/{client_id}', [ClientController::class, 'get_passport']);
            Route::put('passport/{client_id}', [ClientController::class, 'update_passport']);

            Route::get('cities/{region_id}', [ClientController::class, 'get_cities']);
            Route::get('address/{client_id}', [ClientController::class, 'get_address']);
            Route::put('address/{client_id}', [ClientController::class, 'update_address']);

            Route::get('city/create', [ClientController::class, 'start_data_create_city']);
            Route::get('region/district/{region_id}', [ClientController::class, 'district_by_region']);
            Route::post('city/create', [ClientController::class, 'create_city']);

            Route::get('consents/{client_id}/{card_id}', [ClientController::class, 'get_consents']);
            Route::put('consents/{client_id}', [ClientController::class, 'update_consents']);

            Route::get('representative/{client_id}/{card_id}', [ClientController::class, 'get_representative']);
            Route::put('representative/{client_id}', [ClientController::class, 'update_representative']);

            Route::get('notaries/{card_id}', [ClientController::class, 'get_notaries']);
            Route::get('notary/{notary_id}', [ClientController::class, 'get_notary']);
            Route::put('notary/{notary_id}', [ClientController::class, 'update_notary']);
       });
    });

    Route::group(['prefix' => 'manager'], function() {
        Route::get('main/{card_id}', [\App\Http\Controllers\Manager\ManagerController::class, 'main']);
        Route::put('notary/developer/{card_id}', [\App\Http\Controllers\Manager\ManagerController::class, 'update_notary_developer']);
        Route::put('contact/person/{card_id}', [\App\Http\Controllers\Manager\ManagerController::class, 'update_contact_person']);
        Route::get('immovables/{card_id}', [\App\Http\Controllers\Manager\ManagerController::class, 'immovable']);
        Route::get('immovable/{immovable_id}', [\App\Http\Controllers\Manager\ManagerController::class, 'get_immovable']);
        Route::put('immovable/{immovable_id?}', [\App\Http\Controllers\Manager\ManagerController::class, 'update_immovable']);
        Route::get('client/{client_id?}', [\App\Http\Controllers\Manager\ManagerController::class, 'get_client']);
        Route::put('client/{client_id?}', [\App\Http\Controllers\Manager\ManagerController::class, 'update_client']);
    });

    Route::group(['prefix' => 'assistant'], function() {
        Route::get('card/settings/{card_id}', [\App\Http\Controllers\Assistant\AssistantController::class, 'get_card_settings']);
        Route::put('card/settings/{card_id}', [\App\Http\Controllers\Assistant\AssistantController::class, 'update_card_settings']);
    });

    Route::group(['prefix' => 'registrator'], function() {
        Route::get('developers', [\App\Http\Controllers\Registrator\RegistratorController::class, 'get_developers']);
        Route::put('developer/{developer_id}', [\App\Http\Controllers\Registrator\RegistratorController::class, 'update_developer']);

        Route::get('immovables', [\App\Http\Controllers\Registrator\RegistratorController::class, 'get_immovables']);
        Route::put('immovable/{immovable_id}', [\App\Http\Controllers\Registrator\RegistratorController::class, 'update_immovable']);
    });
});

Route::get('clear_table', [\App\Http\Controllers\Test\ClearController::class, 'clear_table']);
//Route::get('dev_start_data', [\App\Http\Controllers\Test\DeveloperController::class, 'dev_start_data']);
Route::get('test', [\App\Http\Controllers\Test\ContractController::class, 'test']);

Route::get('check_sql', [\App\Http\Controllers\Test\SqlController::class, 'check_sql']);
