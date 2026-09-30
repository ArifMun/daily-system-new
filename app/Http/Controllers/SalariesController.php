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
        $salaries = $salaries->map(function ($item) {
            $item->salary_amount = 'Rp ' . number_format($item->salary_amount, 0, ',', '.');
            $item->salary_remaining = 'Rp ' . number_format($item->salary_remaining, 0, ',', '.');
            $item->date_salary_payment_ori = $item->date_salary_payment;
            $item->date_salary_payment = date('d M Y', strtotime($item->date_salary_payment));
            return $item;
        });
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

        $data['salary_amount'] = preg_replace('/\D/', '', $validated['salary_amount']);

        Salaries::create([
            'date_salary_payment' => $validated['date_salary_payment'],
            'name_month'          => $validated['name_month'],
            'salary_amount'       => $data['salary_amount'],
            'salary_remaining'       => $data['salary_amount'],
            'fund_type'           => $validated['fund_type'],
            'date'                => date('Y-m-d')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pemasukan berhasil disimpan',
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'date_salary_payment' => ['required'],
            'name_month' => ['required'],
            'salary_amount' => ['required'],
            'fund_type' => ['required']
        ]);
        // dd($request->all());
        $data['salary_amount'] = preg_replace('/\D/', '', $validated['salary_amount']);
        Salaries::where('id', $request->salary_id)->update([
            'date_salary_payment' => $validated['date_salary_payment'],
            'name_month'          => $validated['name_month'],
            'salary_amount'       => $data['salary_amount'],
            // 'salary_remaining'       => $validated['salary_amount'],
            'fund_type'           => $validated['fund_type'],
            'date'                => date('Y-m-d')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pemasukan berhasil disimpan',
        ]);
    }
}
