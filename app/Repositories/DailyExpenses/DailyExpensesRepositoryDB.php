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

    public function getCostByPeriod(string $startDate, string $endDate, int $userId)
    {
        return DB::table('purchase')
            ->whereBetween('date', [$startDate, $endDate])
            ->where('user_id', $userId)
            ->sum('total_price');
    }

    public function findSalary(int $userId)
    {
        return DB::table('salary')
            ->select('salary_remaining', 'name_month', 'user_id')
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function getCategory()
    {
        return DB::table('category')->get();
    }

    public function getSalaries(int $userId)
    {
        return DB::table('salary')
            ->whereYear('date', date('Y'))
            ->where('user_id', $userId)->orderByDesc('id')->get();
    }

    public function store(array $data)
    {
        return DB::table('purchase')
            ->insertGetId([
                'date' => $data['date'],
                'user_id' => $data['user_id'],
                'category_id' => $data['category_id'],
                'salary_id' => $data['salary_id'],
                'name' => $data['name'],
                'price' => $data['price'],
                'amount' => $data['amount'],
                'total_price' => $data['total_price']
            ]);
    }

    public function updateSalary(array $data, string $process)
    {
        $process = $process == 'store' ? '-' : '+';
        return DB::table('salary')
            ->where('id', $data['salary_id'])
            ->update([
                'salary_remaining' => DB::raw(
                    "salary_remaining {$process} {$data['total_price']}"
                ),
            ]);
    }

    public function insertSalaryUsed(array $data)
    {
        return DB::table('salary_used')->insert([
            'purchase_id' => $data['purchase_id'],
            'salary_id' => $data['salary_id'],
            'date' => $data['date'],
            'user_id' => $data['user_id']
        ]);
    }

    public function deletePurchase(int $id)
    {
        return DB::table('purchase')
            ->where('id', $id)
            ->delete();
    }

    public function deleteSalaryUsed(int $purchaseId)
    {
        return DB::table('salary_used')
            ->where('purchase_id', $purchaseId)
            ->delete();
    }

    public function findPurchase(int $id)
    {
        return DB::table('purchase')
            ->where('id', $id)->first();
    }
}
