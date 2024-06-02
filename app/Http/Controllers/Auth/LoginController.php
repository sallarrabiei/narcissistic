<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Handle the redirection after authentication
    protected function authenticated(Request $request, $user)
    {
        if ($request->hasSession() && $request->session()->has('url.intended')) {
            return redirect()->intended();
        }

        return redirect()->route('dashboard');
    }

    // Show the login form and capture the intended URL
    public function showLoginForm(Request $request)
    {
        if ($request->has('intended_url')) {
            Session::put('url.intended', $request->input('intended_url'));
        } elseif (!Session::has('url.intended')) {
            Session::put('url.intended', url()->previous());
        }

        return view('auth.login');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}

