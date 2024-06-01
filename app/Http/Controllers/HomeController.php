<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;

class HomeController extends Controller
{
    public function index()
    {
        $surveys = Survey::all();
        return view('welcome', compact('surveys'));
    }
}
