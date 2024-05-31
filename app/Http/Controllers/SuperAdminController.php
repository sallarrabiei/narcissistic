<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SuperAdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('dashboard.superadmin', compact('users'));
    }
}
