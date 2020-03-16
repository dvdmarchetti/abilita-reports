<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/import', function () {
//     $files = Storage::files('input');

//     foreach ($files as $path) {
//         $service = Str::of($path)->after('SCHEDA UNICA GESTIONE UTENTI-')->before('_rev');
//         Log::channel('import')->info('Processing service input file.', ['filename' => $path]);

//         (new BilancioSocialeImport)->for($service)->import($path);
//     }
// });

Route::resource('imports', ImportController::class)->only('index', 'create', 'store');
Route::resource('queries', QueryController::class)->only('index', 'show');
Route::resource('logs', LogController::class)->only('index', 'show');