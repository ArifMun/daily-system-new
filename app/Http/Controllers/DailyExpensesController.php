<?php

namespace App\Http\Controllers;

use App\Services\DailyExpensesService;
use Illuminate\Http\Request;

class DailyExpensesController extends Controller
{
    public function __construct(protected DailyExpensesService $dailyExpensesService) {}
    public function index()
    {
        return view('daily-expenses.index');
    }

    public function getDataDaily(Request $request)
    {
        $date = $request->date;
        $data = $this->dailyExpensesService->getDataDaily($date);
        return response()->json([
            'list' => $data
        ]);
    }
}