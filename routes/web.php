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

// Route::redirect('/', route('dashboard.children'));
Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::redirect('/', 'dashboard/children');
    Route::get('children', [DashboardController::class, 'children'])->name('children');
    Route::get('families', [DashboardController::class, 'families'])->name('families');
});
Route::prefix('imports')->name('imports.')->group(function () {
    Route::redirect('/', 'dashboard/children');
    Route::post('/', [ImportController::class, 'run'])->name('run');
    Route::delete('/', [ImportController::class, 'cleanup'])->name('cleanup');
});
Route::resource('queries', QueryController::class)->only('index', 'show');
Route::resource('logs', LogController::class)->only('index', 'show');
