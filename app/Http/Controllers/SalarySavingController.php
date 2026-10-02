<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SalarySaving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalarySavingController extends Controller
{
    public function index()
    {
        $salarySaving = SalarySaving::with('purchase')->whereHas('purchase', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();
        return view('salary-saving.index', compact('salarySaving'));
    }
}
