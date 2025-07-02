<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {
        \Log::info('Login attempt', [
            'username' => $request->username,
            'ip' => $request->ip()
        ]);

        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            \Log::info('Login successful', ['username' => $request->username]);
            return $this->sendLoginResponse($request);
        }

        \Log::warning('Login failed', [
            'username' => $request->username,
            'errors' => [trans('auth.failed')]
        ]);

        return $this->sendFailedLoginResponse($request);
    }
}
