<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Factory\DocumentController;
use \App\Http\Controllers\Factory\GeneratorController;
use \App\Http\Controllers\Factory\ConvertController;
use \App\Http\Controllers\React\ViewController;
use \App\Http\Controllers\PDFParserController;
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


// Route::get('password/reset/{token}', [PassportAuthController::class, 'password_reset'])->name('password.request');


Route::get('start_dzubuk', [\App\Http\Controllers\GiftController::class, 'start_dzubuk']);
Route::get('get_excel', [\App\Http\Controllers\GiftController::class, 'get_excel']);

Route::get('price', [ConvertController::class, 'convert_price_int_part_to_string']);
Route::get('test_price_convert/{number}', [ConvertController::class, 'test_price_convert']);

Route::get('pdf_parser', [PDFParserController::class, 'start']);

Route::get('set-database-current-date', [\App\Http\Controllers\Test\DatabaseController::class, 'set_database_current_date']);
Route::get('set_reader_and_accompanying_for_contracts', [\App\Http\Controllers\Test\DatabaseController::class, 'set_reader_and_accompanying_for_contracts']);
Route::get('set_steps_for_contract', [\App\Http\Controllers\Test\DatabaseController::class, 'set_steps_for_contract']);

Route::get('clear', function () {
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
});

Route::get('phpinfo', function () {
   phpinfo();die;
});

Route::get('lftp-nspace', function () {
    $command = "/usr/bin/lftp -c 'open -u Contract,123QWer45 ftp://192.168.22.2; put -O / Нота.txt'";
    exec($command, $output);
    dd($output);
});


Route::get('lftp-rakul', function () {
    $command = "/usr/bin/lftp -c 'open -u ozharko_dir,75vUtTYh9x3P ftp://ozharko.ftp.tools; put -O / Нота.txt'";
    exec($command, $output);
    dd($output);
});

Route::get('create/{card_id}', [GeneratorController::class, 'create_contract_by_card_id']); // postman
Route::get('creat/contracts', [GeneratorController::class, 'create_contracts_by_cards']);
Route::get('creat/all/contracts', [GeneratorController::class, 'create_all_contracts']);
Route::get('creat/contract/{card_id}', [GeneratorController::class, 'create_contract_by_card_id']);
Route::get('service/read', [DocumentController::class, 'make_document_service']);

//Route::post('login', [PassportAuthController::class, 'login']);
//Route::get('check/user/auth', [PassportAuthController::class, 'check_user']);

Route::get('/{slug?}/{next?}/{step?}', [ViewController::class, 'index'])->where('slug', '^(?!nova).*$');;
