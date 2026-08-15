<?php

namespace App\Repositories\DailyExpenses;

use App\Repositories\DailyExpenses\Contracts\DailyExpensesRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DailyExpensesRepositoryDB implements DailyExpensesRepositoryInterface
{
    public function getDataDaily(string $date, int $userId)
    {
        return DB::table('purchase as p')
            ->select('p.*', 'c.name_category')
            ->leftJoin('category as c', 'p.category_id', 'c.id')
            ->where('p.user_id', $userId)
            ->where('p.date', $date)->get();
    }
}