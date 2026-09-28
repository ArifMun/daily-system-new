<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalariesController extends Controller
{
    public function index()
    {
        return view('salaries.index');
    }
}
