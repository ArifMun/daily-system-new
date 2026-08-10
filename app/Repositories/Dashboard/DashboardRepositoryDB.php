<?php

namespace App\Repositories\Dashboard;

use App\Repositories\Dashboard\Contracts\DashboardRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DashboardRepositoryDB implements DashboardRepositoryInterface
{
    public function getExpenses(int $month, int $year, int $userId)
    {
        return DB::table('purchase')
            ->where('user_id', $userId)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();
    }

    public function getExpensesByDate(string $startDate, string $endDate, int $userId)
    {
        return DB::table('purchase')
            ->select('date')
            ->selectRaw('SUM(total_price) as total_amount')
            ->where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy('date')
            ->get();
    }
}
