<?php

namespace App\Http\Controllers;

use App\Models\Salaries;
use Illuminate\Http\Request;

class SalariesController extends Controller
{
    public function index()
    {
        return view('salaries.index');
    }

    public function getData()
    {
        $salaries = Salaries::orderByDesc('id')->get();
        return response()->json([
            'success' => true,
            'list' => $salaries
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_salary_payment' => ['required'],
            'name_month' => ['required'],
            'salary_amount' => ['required'],
            'fund_type' => ['required']
        ]);

        Salaries::create([
            'date_salary_payment' => $validated['date_salary_payment'],
            'name_month'          => $validated['name_month'],
            'salary_amount'       => $validated['salary_amount'],
            'fund_type'           => $validated['fund_type'],
            'date'                => date('Y-m-d')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pemasukan berhasil disimpan',
        ]);
    }
}
