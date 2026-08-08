<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('auth', [AuthController::class, 'auth'])->name('login.auth');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('get-expenses-per-week', [DashboardController::class, 'getExpensesPerWeek']);
        Route::get('get-expenses-by-date', [DashboardController::class, 'getExpensesByDate']);
    });
});
