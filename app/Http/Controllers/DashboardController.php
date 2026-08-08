<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $dashboardService) {}
    public function index()
    {
        return view('dashboard.index');
    }

    public function getExpensesPerWeek(Request $request)
    {
        $month  = $request->query('month');
        $year   = $request->query('year');

        $data = $this->dashboardService->getExpensePerWeek($month, $year, Auth::user()->id);
        return response()->json([
            'data' => $data
        ]);
    }

    public function getExpensesByDate(Request $request)
    {
        $date  = $request->query('date');

        $data = $this->dashboardService->getExpensesByDate($date,  Auth::user()->id);
        return response()->json([
            'data' => $data
        ]);
    }
}