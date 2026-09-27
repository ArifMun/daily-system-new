<?php

namespace App\Repositories\DailyExpenses\Contracts;

interface DailyExpensesRepositoryInterface
{
    public function getDataDaily(string $date, int $userId);
    public function getCostByPeriod(string $startDate, string $endDate, int $userId);
    public function findSalary(int $userId);
    public function getCategory();
    public function getSalaries(int $userId);
    public function store(array $data);
    public function updateSalary(array $data, string $process);
    public function insertSalaryUsed(array $data);
    public function deletePurchase(int $id);
    public function deleteSalaryUsed(int $purchaseId);
    public function findPurchase(int $id);
    public function updateOrInsert(array $data);
}
