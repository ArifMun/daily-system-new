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

    public function getExpenseGroupCategory(int $month, int $year, int $userId)
    {
        return DB::table('purchase as p')
            ->select('c.name_category', 'p.category_id')
            ->selectRaw('SUM(total_price) as total_amount')
            ->join('category as c', 'p.category_id', 'c.id')
            ->where('user_id', $userId)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->groupBy('c.id')
            ->get();
    }

    public function getSalaryAndRemaining(int $year, int $userId)
    {
        return DB::table('salary as s')
            ->select('s.name_month', 's.salary_amount')
            ->selectRaw('SUM(p.total_price) as total_cost')
            ->selectRaw('(s.salary_amount - SUM(p.total_price)) as remaining_amount')
            ->join('purchase as p', 's.id', 'p.salary_id')
            ->whereYear('s.date_salary_payment', $year)
            ->where('s.user_id', $userId)
            ->groupBy('s.id')
            ->get()->toArray();
    }
}
