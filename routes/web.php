<?php

use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\DailyReportStatsController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WelcomeController::class, 'index']);

Route::resource('daily-reports', DailyReportController::class)->except('show');
Route::get('daily-reports-stats', [DailyReportStatsController::class, 'index'])->name('daily-reports.stats');
