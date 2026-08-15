<?php

namespace App\Repositories\DailyExpenses\Contracts;

interface DailyExpensesRepositoryInterface
{
    public function getDataDaily(string $date, int $userId);
}