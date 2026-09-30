<?php

namespace App\Http\Controllers;

use App\Models\SalarySaving;
use Illuminate\Http\Request;

class SalarySavingController extends Controller
{
    public function index()
    {
        $salarySaving = SalarySaving::with('purchase')->get();
        return view('salary-saving.index', compact('salarySaving'));
    }
}
