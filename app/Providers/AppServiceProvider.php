<?php

namespace App\Providers;

use App\Repositories\DailyExpenses\Contracts\DailyExpensesRepositoryInterface;
use App\Repositories\DailyExpenses\DailyExpensesRepositoryDB;
use App\Repositories\Dashboard\Contracts\DashboardRepositoryInterface;
use App\Repositories\Dashboard\DashboardRepositoryDB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            DashboardRepositoryInterface::class,
            DashboardRepositoryDB::class
        );
        $this->app->bind(
            DailyExpensesRepositoryInterface::class,
            DailyExpensesRepositoryDB::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}