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
}
