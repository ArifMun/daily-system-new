<?php

namespace App\Services;

use App\Repositories\DailyExpenses\Contracts\DailyExpensesRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class DailyExpensesService
{

    public function __construct(protected DailyExpensesRepositoryInterface $dailyExpensesRepository) {}

    public function getDataDaily(string $date)
    {
        $userId = Auth::user()->id;
        $data = $this->dailyExpensesRepository->getDataDaily($date, $userId);
        $data = $data->map(function ($query) {
            $query->name = ucfirst($query->name);
            $query->price_format = 'Rp ' . number_format($query->price, 0, ',', '.');
            $query->total_price_format = 'Rp ' . number_format($query->total_price, 0, ',', '.');
            return $query;
        });
        return [
            'data' => $data
        ];
    }

    public function getSummary(string $startDate, string $endDate)
    {
        $userId = Auth::user()->id;
        $cost = $this->dailyExpensesRepository->getCostByPeriod($startDate, $endDate, $userId);
        $salary = $this->dailyExpensesRepository->findSalary($userId);

        // $salaryUsed = DB::table('salary_used as su')
        //     ->where('su.salary_id', '51')
        //     ->join('purchase as p', 'su.purchase_id', 'p.id')
        //     ->sum('p.total_price');
        // dd($salaryUsed);
        return [
            'cost' => $cost,
            'salary' => $salary
        ];
    }

    public function getMasterData()
    {
        $categories = $this->dailyExpensesRepository->getCategory();
        $salaries = $this->dailyExpensesRepository->getSalaries(Auth::user()->id);

        return [
            'categories' => $categories,
            'salaries' => $salaries
        ];
    }

    public function store(array $data)
    {
        $data['price'] = preg_replace('/\D/', '', $data['price']);
        $data['total_price'] = preg_replace('/\D/', '', $data['total_price']);
        $data['amount'] = $data['qty'];
        $data['user_id'] = Auth::user()->id;

        DB::beginTransaction();
        try {

            $purchase = $this->dailyExpensesRepository->store($data);
            $data['purchase_id'] = $purchase;

            if ($data['category_id'] == 11) {
                $this->dailyExpensesRepository->updateOrInsert($data);
            }

            $this->dailyExpensesRepository->insertSalaryUsed($data);
            $this->dailyExpensesRepository->updateSalary($data, 'store');
            DB::commit();
            return $purchase;
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan purchase', [
                'data' => $data,
                'salary_id' => $data['salary_id'] ?? null,
                'total_price' => $data['total_price'] ?? null,
            ]);
        }
    }

    public function deletePurchase(int $id)
    {
        DB::beginTransaction();
        try {

            $purchase = $this->dailyExpensesRepository->findPurchase($id);
            $data['total_price'] = $purchase->total_price;
            $data['salary_id'] = $purchase->salary_id;
            $this->dailyExpensesRepository->updateSalary($data, 'delete');

            $this->dailyExpensesRepository->deletePurchase($id);
            $this->dailyExpensesRepository->deleteSalaryUsed($id);
            DB::commit();
            return true;
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan purchase', [
                'salary_id' => $data['salary_id'] ?? null,
                'total_price' => $data['total_price'] ?? null,
            ]);

            throw $e;
        }
    }
}
