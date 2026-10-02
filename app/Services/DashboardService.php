<?php

namespace App\Services;

use App\Repositories\DailyExpenses\Contracts\DailyExpensesRepositoryInterface;
use App\Repositories\Dashboard\Contracts\DashboardRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected DashboardRepositoryInterface $dashboardRepository, protected DailyExpensesRepositoryInterface $dailyRepository) {}

    public function getExpensePerWeek(int $month, int $year, int $userId)
    {
        $data = $this->dashboardRepository->getExpenses($month, $year, $userId);
        $weeklyExpense = [];
        $totalAllWeek = 0;
        foreach ($data as $item) {
            $week = Carbon::parse($item->date)->weekOfMonth();
            $weekName = 'Minggu ke - ' . $week;

            $totalPrice = (int) ($item->total_price ?? 0);

            if (!isset($weeklyExpense[$weekName])) {
                $weeklyExpense[$weekName] = 0;
            }

            $weeklyExpense[$weekName] += $totalPrice;
            $totalAllWeek += $totalPrice;
        }

        $result = [];

        foreach ($weeklyExpense as $week => $total) {
            $result[] = [
                'week' => $week,
                'total_amount' => $total,
            ];
        }

        // Tambahkan total semua minggu
        $result[] = [
            'week' => 'Semua - Minggu',
            'total_amount' => $totalAllWeek,
        ];

        return $result;
    }

    public function getExpensesByDate(string $startDate, string $endDate, int $userId)
    {
        $data = $this->dashboardRepository->getExpensesByDate($startDate, $endDate, $userId);
        $dailyExpense = [];
        foreach ($data as $item) {
            $dailyExpense[] = [
                'date' => date('d', strtotime($item->date)),
                'total_amount' => 'Rp ' . number_format(
                    $item->total_amount ?? 0,
                    0,
                    ',',
                    '.'
                ),
                'total_amount_not_format' => (int)$item->total_amount
            ];
        }
        return $dailyExpense;
    }

    public function getExpenseGroupCategory(int $month, int $year)
    {
        $categories = $this->dailyRepository->getCategory();
        $data = $this->dashboardRepository->getExpenseGroupCategory($month, $year, Auth::user()->id);
        $groupCategory = [];

        foreach ($categories as $index => $category) {
            $groupCategory[$index] = [
                'name_category' => $category->name_category,
                'total_amount' => 0
            ];

            foreach ($data as $item) {
                if ($item->category_id == $category->id) {
                    $groupCategory[$index] = [
                        'name_category' => $category->name_category,
                        'total_amount' => (int)$item->total_amount,
                    ];
                }
            }
        }
        return $groupCategory;
    }
}
