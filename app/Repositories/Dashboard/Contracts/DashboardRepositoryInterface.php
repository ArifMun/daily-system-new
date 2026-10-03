<?php

namespace App\Repositories\Dashboard\Contracts;

interface DashboardRepositoryInterface
{
    public function getExpenses(int $month, int $year, int $userId);
    public function getExpensesByDate(string $startDate, string $endDate, int $userId);
    public function getExpenseGroupCategory(int $month, int $year, int $userId);
    public function getSalaryAndRemaining(int $year, int $userId);
}
