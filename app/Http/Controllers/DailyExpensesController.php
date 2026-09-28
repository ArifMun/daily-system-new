<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DailyExpensesService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class DailyExpensesController extends Controller
{
    public function __construct(protected DailyExpensesService $dailyExpensesService) {}
    public function index()
    {
        $data = $this->dailyExpensesService->getMasterData();
        $categories = $data['categories'];
        $salaries = $data['salaries'];
        return view('daily-expenses.index', compact('salaries', 'categories'));
    }

    public function getDataDaily(Request $request)
    {
        $date = $request->date;
        $data = $this->dailyExpensesService->getDataDaily($date);

        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));

        $thisDay = $this->dailyExpensesService->getSummary($date, $date);
        $thisMonth = $this->dailyExpensesService->getSummary(Carbon::create($year, $month, 1)->startOfMonth(), Carbon::create($year, $month, 1)->endOfMonth());
        $thisYear = $this->dailyExpensesService->getSummary(Carbon::create($year, 1, 1)->startOfYear(), Carbon::create($year, 1, 1)->endOfYear());

        return response()->json([
            'list' => $data,
            'cost_day' => 'Rp ' . number_format($thisDay['cost'], 0, ',', '.'),
            'cost_month' => 'Rp ' . number_format($thisMonth['cost'], 0, ',', '.'),
            'cost_year' => 'Rp ' . number_format($thisYear['cost'], 0, ',', '.'),
            'remaining_salary' => 'Rp ' . number_format($thisDay['salary']->salary_remaining, 0, ',', '.'),
            'salary_name' => $thisDay['salary']->name_month
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required'],
            'qty' => ['required', 'integer'],
            'salary_id' => ['required'],
            'category_id' => ['required'],
            'total_price' => ['required']
        ]);

        $result = $this->dailyExpensesService->store($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pengeluaran berhasil disimpan',
            'data' => $result
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'purchase_id' => ['required'],
            'date' => ['required', 'date'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required'],
            'qty' => ['required', 'integer'],
            'salary_id' => ['required'],
            'category_id' => ['required'],
            'total_price' => ['required']
        ]);
        $result = $this->dailyExpensesService->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pengeluaran berhasil diperbarui',
            'data' => $result
        ]);
    }

    public function delete(int $id)
    {
        try {
            $this->dailyExpensesService->deletePurchase($id);
            return response()->json([
                'success' => true,
                'message' => 'Pengeluaran berhasil dihapus'
            ]);
        } catch (Throwable $e) {
            Log::error('Gagal menyimpan purchase', [
                'error'       => $e->getMessage(),
                'file'        => $e->getFile(),
                'line'        => $e->getLine(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus pengeluaran'
            ]);
        }
    }
}
