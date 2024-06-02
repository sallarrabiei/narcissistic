<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SurveyResult;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $results = SurveyResult::where('user_id', Auth::id())->with('survey')->get();
        return view('dashboard.user', compact('results'));
    }
}
