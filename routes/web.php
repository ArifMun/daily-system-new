<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DailyExpensesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Pph21Controller;
use App\Http\Controllers\SalariesController;
use App\Http\Controllers\SalarySavingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('auth', [AuthController::class, 'auth'])->name('login.auth');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('calculate-pph21', [Pph21Controller::class, 'calculate']);
Route::middleware(['auth'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('get-expenses-per-week', [DashboardController::class, 'getExpensesPerWeek']);
        Route::get('get-expenses-by-date', [DashboardController::class, 'getExpensesByDate']);
    });

    Route::prefix('daily-expenses')->group(function () {
        Route::get('/', [DailyExpensesController::class, 'index'])->name('daily-expense.index');
        Route::get('get-data-daily', [DailyExpensesController::class, 'getDataDaily']);
        Route::post('store', [DailyExpensesController::class, 'store']);
        Route::post('update', [DailyExpensesController::class, 'update']);
        Route::delete('delete/{id}', [DailyExpensesController::class, 'delete']);
    });

    Route::prefix('salaries')->group(function () {
        Route::get('/', [SalariesController::class, 'index'])->name('salaries');
        Route::get('get-data', [SalariesController::class, 'getData']);
        Route::post('store', [SalariesController::class, 'store']);
        Route::post('update', [SalariesController::class, 'update']);
    });

    Route::prefix('salary-saving')->group(function () {
        Route::get('/', [SalarySavingController::class, 'index'])->name('salary-saving');
    });
});
