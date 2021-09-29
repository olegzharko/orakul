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
use \App\Http\Controllers\Rakul\InstallmentController;
use \App\Http\Controllers\Generator\ClientController;
use \App\Http\Controllers\API\MinfinController;
use \App\Http\Controllers\Deal\DealController;
use \App\Http\Controllers\Location\SpaceController;
use \App\Http\Controllers\Archive\ArchiveController;

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

Route::get('create/{card_id}', [GeneratorController::class, 'create_contract_by_card_id']); // postman

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
Route::get('slides', [SlidesController::class, 'slides']); // postman
Route::post('password/forgot', [PassportAuthController::class, 'password_forgot'])->middleware('guest');
Route::get('password/reset/{token}', [PassportAuthController::class, 'password_reset'])->name('password.request');
Route::post('password/update', [PassportAuthController::class, 'password_update'])->name('password.reset');

Route::middleware('auth:api')->group(function () {

    Route::get('extra_logout', [PassportAuthController::class, 'extra_logout']);
    Route::get('logout', [PassportAuthController::class, 'logout']);
    Route::get('global_text', [TextController::class, 'global_text']); // postman
    Route::get('reception', [ReceptionController::class, 'reception']); // postman
    Route::get('calendar', [ReceptionController::class, 'reception']); // postman // убрать этот запрос. сменить на reception /api/calendar
    Route::put('cards/move/{id}', [CardController::class, 'move']);
    Route::get('cards/{user_type}', [CardController::class, 'index']);
    Route::resource('cards', CardController::class); // postman get cards
    Route::get('exchange', [MinfinController::class, 'get_rate_exchange']); // postman

    Route::group(['prefix' => 'filter'], function () {
        Route::get('dropdown/{user_type?}', [FilterController::class, 'dropdown']); // postman
        Route::get('developer/info/{id}', [FilterController::class, 'developer_info']); // postman
        #######################
        Route::get('total/{user_type?}', [CardController::class, 'index']); // postman
        Route::get('contract/type/{contract_type}/{user_type?}', [FilterController::class, 'cards_by_contract_type']); // postman
        Route::get('ready/{user_type?}', [FilterController::class, 'ready_cards']); // postman
        Route::get('process/{user_type?}', [FilterController::class, 'process_cards']);
        Route::get('cancelled/{user_type?}', [FilterController::class, 'cancelled_cards']); // postman
        #######################
        Route::post('sort', [SortController::class, 'sort']);
        Route::post('search', [SearchController::class, 'search']);
    });

    Route::group(['prefix' => 'generator'], function() {
        Route::get('main/{card_id}', [\App\Http\Controllers\Generator\MainController::class, 'main']); // postman
        Route::get('create/{card_id}', [GeneratorController::class, 'create_contract_by_card_id']); // postman

        Route::get('city/create', [ClientController::class, 'start_data_create_city']); // postman
        Route::get('region/district/{region_id}', [ClientController::class, 'district_by_region']); // postman
        Route::post('city/create', [ClientController::class, 'create_city']); // postman

       Route::group(['prefix' => 'developer'], function() {
           Route::get('group/{card_id}', [DeveloperController::class, 'group']); // postman
           Route::get('main/{dev_company_id}/{card_id}', [DeveloperController::class, 'main']); // postman
           Route::post('fence/{dev_company_id}/{card_id}', [DeveloperController::class, 'update_fence']); // postman
           Route::get('representative/{card_id}', [DeveloperController::class, 'get_representative']); // postman
           Route::post('representative/{card_id}', [DeveloperController::class, 'update_representative']);
       });

       Route::group(['prefix' => 'immovable'], function() {
            Route::get('main/{card_id}', [ImmovableController::class, 'main']);
//            Route::get('{card_id}', [ImmovableController::class, 'main']);

            Route::get('general/{immovable_id}', [ImmovableController::class, 'get_general']); // postman
            Route::put('general/{immovable_id}', [ImmovableController::class, 'update_general']);

            Route::get('exchange/{card_id}', [ImmovableController::class, 'get_exchange']); // postman
//            Route::post('exchange/{card_id}', [ImmovableController::class, 'new_exchange']);
            Route::put('exchange/{card_id}', [ImmovableController::class, 'update_exchange']);

            Route::get('payment/{immovable_id}', [ImmovableController::class, 'get_payment']); // postman
            Route::put('payment/{immovable_id}', [ImmovableController::class, 'update_payment']);

            Route::get('fence/{immovable_id}', [ImmovableController::class, 'get_fence']); // postman
            Route::put('fence/{immovable_id}', [ImmovableController::class, 'update_fence']);

            Route::get('valuation/{immovable_id}', [ImmovableController::class, 'get_valuation']); // postman
            Route::put('valuation/{immovable_id}', [ImmovableController::class, 'update_valuation']);

            Route::get('ownership/{immovable_id}', [ImmovableController::class, 'get_ownership']); // postman
            Route::put('ownership/{immovable_id}', [ImmovableController::class, 'update_ownership']);

            Route::get('termination/{immovable_id}', [ImmovableController::class, 'get_termination']); // postman
            Route::put('termination/{immovable_id}', [ImmovableController::class, 'update_termination']);

            Route::get('installment/{immovable_id}', [InstallmentController::class, 'get_installment']); // postman
            Route::put('installment/{immovable_id}', [InstallmentController::class, 'update_installment']);
            Route::get('installment_test/{immovable_id}', [InstallmentController::class, 'test']);

            Route::get('template/{immovable_id}', [ImmovableController::class, 'get_template']); // postman
            Route::put('template/{immovable_id}', [ImmovableController::class, 'update_template']);

            Route::delete('delete/{immovable_id}', [ImmovableController::class, 'destroy']); // postman
       });

       Route::group(['prefix' => 'client'], function() {
            Route::get('main/{card_id}', [ClientController::class, 'main']); // postman
//            Route::get('{card_id}', [ClientController::class, 'main']); // postman

            Route::get('name/{client_id}', [ClientController::class, 'get_name']); // postman
            Route::put('name/{client_id}', [ClientController::class, 'update_name']);

            Route::get('contacts/{client_id}', [ClientController::class, 'get_contacts']); // postman
            Route::put('contacts/{client_id}', [ClientController::class, 'update_contacts']);

            Route::get('citizenships/{client_id}', [ClientController::class, 'get_citizenships']); // postman
            Route::put('citizenships/{client_id}', [ClientController::class, 'update_citizenships']);

            Route::get('passport/{client_id}', [ClientController::class, 'get_passport']); // postman
            Route::put('passport/{client_id}', [ClientController::class, 'update_passport']);

            Route::get('districts/{region_id}', [ClientController::class, 'get_districts']); // postman
//            Route::get('root_city/{region_id}', [ClientController::class, 'get_root_city']); // postman
            Route::get('cities/{region_id}/{district_id?}', [ClientController::class, 'get_cities']); // postman
            Route::get('address/{client_id}', [ClientController::class, 'get_address']); // postman
            Route::put('address/{client_id}', [ClientController::class, 'update_address']);

            Route::get('consents/{card_id}/{client_id}', [ClientController::class, 'get_consents']); // postman
            Route::put('consents/{client_id}', [ClientController::class, 'update_consents']);

            Route::get('termination/{card_id}/{client_id}', [ClientController::class, 'get_termination']); // postman
            Route::put('termination/{card_id}/{client_id?}', [ClientController::class, 'update_termination']);

            Route::get('representative/{card_id}/{client_id}', [ClientController::class, 'get_representative']);
            Route::put('representative/{client_id}', [ClientController::class, 'update_representative']);

            Route::get('notaries/{card_id}', [ClientController::class, 'get_notaries']); // postman
            Route::get('notary/{notary_id}', [ClientController::class, 'get_notary']); // postman
            Route::put('notary/{card_id}/{notary_id?}', [ClientController::class, 'update_notary']);

            Route::delete('delete/{client_id}/{card_id}', [ClientController::class, 'destroy']); // DELETE REQUEST
       });

       Route::group(['prefix' => 'read'], function() {
           Route::get('main/{card_id}', [\App\Http\Controllers\Read\ReadController::class, 'main']); // postman
           Route::get('checklist/{contract_id}', [\App\Http\Controllers\Read\ReadController::class, 'get_read_check_list']); // postman
           Route::post('checklist/{contract_id}', [\App\Http\Controllers\Read\ReadController::class, 'set_read_check_list']); // postman
       });

       Route::group(['prefix' => 'accompanying'], function() {
           Route::get('main/{card_id}', [\App\Http\Controllers\Accompanying\AccompanyingController::class, 'main']); // postman
           Route::get('checklist/{contract_id}', [\App\Http\Controllers\Accompanying\AccompanyingController::class, 'get_accompanying_check_list']); // postman
           Route::post('checklist/{contract_id}', [\App\Http\Controllers\Accompanying\AccompanyingController::class, 'set_accompanying_check_list']); // postman
       });

    });

    Route::group(['prefix' => 'manager'], function() {
        Route::get('main/{card_id}', [\App\Http\Controllers\Manager\ManagerController::class, 'main']); // postman
        Route::put('notary/developer/{card_id}', [\App\Http\Controllers\Manager\ManagerController::class, 'update_notary_developer']);
        Route::put('contact/person/{card_id}', [\App\Http\Controllers\Manager\ManagerController::class, 'update_contact_person']);
        Route::get('immovables/{card_id}', [\App\Http\Controllers\Manager\ManagerController::class, 'immovable']); // postman
        Route::get('immovable/{card_id}/{immovable_id?}', [\App\Http\Controllers\Manager\ManagerController::class, 'get_immovable']); // postman
        Route::put('immovable/{card_id}/{immovable_id?}', [\App\Http\Controllers\Manager\ManagerController::class, 'update_immovable']);
        Route::get('clients/{card_id}', [\App\Http\Controllers\Manager\ManagerController::class, 'get_card_client']); // postman
        Route::get('client/{client_id?}', [\App\Http\Controllers\Manager\ManagerController::class, 'get_client']); // postman
        Route::put('client/{card_id}/{client_id?}', [\App\Http\Controllers\Manager\ManagerController::class, 'update_client']);
        Route::delete('immovable/delete/{immovable_id}/{card_id}', [ImmovableController::class, 'destroy']); // postman
        Route::delete('client/delete/{client_id}/{card_id}', [ClientController::class, 'destroy']); // DELETE REQUEST

    });

    Route::group(['prefix' => 'assistant'], function() {
        Route::get('card/settings/{card_id}', [\App\Http\Controllers\Assistant\AssistantController::class, 'get_card_settings']); // postman
        Route::put('card/settings/{card_id}', [\App\Http\Controllers\Assistant\AssistantController::class, 'update_card_settings']);
    });

    Route::group(['prefix' => 'registrator'], function() {
        Route::get('developers', [\App\Http\Controllers\Registrator\RegistratorController::class, 'get_developers']); // postman
        Route::put('developer/{developer_id}', [\App\Http\Controllers\Registrator\RegistratorController::class, 'update_developer']);

        Route::get('immovables', [\App\Http\Controllers\Registrator\RegistratorController::class, 'get_immovables']); // postman
        Route::put('immovable/{immovable_id}', [\App\Http\Controllers\Registrator\RegistratorController::class, 'update_immovable']);
    });

    Route::group(['prefix' => 'deal'], function() {
        Route::post('set/info', [DealController::class, 'create_deal_info']);
        Route::put('update', [DealController::class, 'update_deal_info']);
        Route::get('space', [SpaceController::class, 'space']);
        Route::post('close/{deal_id}', [SpaceController::class, 'close']);
        Route::post('move/to/reception/{deal_id}', [SpaceController::class, 'move_to_reception']);
        Route::post('move/to/room/{room_id}/{deal_id}', [SpaceController::class, 'move_to_room']);
        Route::post('move/to/notary/{deal_id}', [SpaceController::class, 'move_to_notary']);
        Route::get('detail/{deal_id}', [DealController::class, 'get_deal_detail']);
    });

    Route::group(['prefix' => 'archive'], function() {
        Route::get('tools', [ArchiveController::class, 'get_tools']);
        Route::post('data/{notary_id}', [ArchiveController::class, 'get_archive_data']);
        Route::get('detail/{card_id}', [ArchiveController::class, 'get_archive_detail']);
    });

    Route::group(['prefix' => 'bank'], function() {
        Route::get('data', [\App\Http\Controllers\Bank\BankController::class, 'get_bank_data']);
    });

    Route::group(['prefix' => 'developer'], function() {
        Route::get('representative', [\App\Http\Controllers\Developer\RepresentativeController::class, 'get_data_for_developer']);
    });

    Route::group(['prefix' => 'staff'], function() {
        Route::get('info', [\App\Http\Controllers\Staff\StaffController::class, 'get_staff_info']);
    });
});

//Route::get('clear_table', [\App\Http\Controllers\Test\ClearController::class, 'clear_table']); // postman
//Route::get('dev_start_data', [\App\Http\Controllers\Test\DeveloperController::class, 'dev_start_data']);
//Route::get('test', [\App\Http\Controllers\Test\ContractController::class, 'test']); // postman
Route::get('single_test', [\App\Http\Controllers\Test\ContractController::class, 'single_test']); // postman

Route::get('check_sql', [\App\Http\Controllers\Test\SqlController::class, 'check_sql']);
