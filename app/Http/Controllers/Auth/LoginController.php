<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function username()
    {
        return 'email';
    }

    public function login(Request $request)
    {
        
        $this->validateLogin($request);
        // die($test);
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials, $request->filled('remember'))) {
            // die("1");
            $user = Auth::guard('web')->user();
            if ($user->enabled != 1) {
                return $this->sendFailedLoginResponse($request);
            }
            return $this->sendLoginResponse($request);
        }

        if (Auth::guard('classified_user')->attempt($credentials, $request->filled('remember'))) {
            // die("12");
            $user = Auth::guard('classified_user')->user();
            if ($user->enabled != 1) {
                return $this->sendFailedLoginResponse($request);
            }
            return $this->sendLoginResponse($request);
        }
        if (Auth::guard('service_user')->attempt($credentials, $request->filled('remember'))) {
            // die("10");
            $user = Auth::guard('service_user')->user();
            if ($user->enabled != 1) {
                return $this->sendFailedLoginResponse($request);
            }
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('classified_user')->logout();
        Auth::guard('service_user')->logout();


        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }
}
