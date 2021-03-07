<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\QueryController;
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

Route::redirect('/', 'dashboard');
Route::get('dashboard', DashboardController::class)->name('dashboard');
Route::post('imports', [ImportController::class, 'run'])->name('imports.run');
Route::delete('imports', [ImportController::class, 'cleanup'])->name('imports.cleanup');
Route::resource('queries', QueryController::class)->only('index', 'show');
Route::resource('logs', LogController::class)->only('index', 'show');
