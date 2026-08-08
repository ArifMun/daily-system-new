<?php

namespace App\Services;

use App\Repositories\Dashboard\Contracts\DashboardRepositoryInterface;
use Carbon\Carbon;

class DashboardService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected DashboardRepositoryInterface $dashboardRepository) {}

    public function getExpensePerWeek(int $month, int $year, int $userId)
    {
        $data = $this->dashboardRepository->getExpenses($month, $year, $userId);
        $weeklyExpense = [];
        $totalAllWeek = 0;
        foreach ($data as $item) {
            $week = Carbon::parse($item->date)->weekOfMonth();
            $weeklyExpense['Week - ' . $week] = ($weeklyExpense['Week - ' . $week] ?? 0) + $item->total_price ?? 0;
            $totalAllWeek += $item->total_price;
        }

        $weeklyExpense = array_map(
            fn($total) => 'Rp ' . number_format($total, 0, ',', '.'),
            $weeklyExpense
        );

        $weeklyExpense['Week - all'] = 'Rp ' . number_format($totalAllWeek, 0, ',', '.');
        return $weeklyExpense;
    }

    public function getExpensesByDate(string $date, int $userId)
    {
        $data = $this->dashboardRepository->getExpensesByDate($date, $userId);
        $dailyExpense['date'] = $date;
        $dailyExpense['total_amount'] = 'Rp ' . number_format($data->total_amount ?? 0, 0, ',', '.');
        return $dailyExpense;
    }
}