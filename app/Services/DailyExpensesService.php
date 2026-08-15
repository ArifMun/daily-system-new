<?php

namespace App\Services;

use App\Repositories\DailyExpenses\Contracts\DailyExpensesRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class DailyExpensesService
{

    public function __construct(protected DailyExpensesRepositoryInterface $dailyExpensesRepository) {}

    public function getDataDaily(string $date)
    {
        $userId = Auth::user()->id;
        $data = $this->dailyExpensesRepository->getDataDaily($date, $userId);
        $data = $data->map(function ($query) {
            $query->name = ucfirst($query->name);
            $query->price_format = 'Rp ' . number_format($query->price);
            $query->total_price_format = 'Rp ' . number_format($query->total_price);
            return $query;
        });
        return [
            'data' => $data
        ];
    }
}
