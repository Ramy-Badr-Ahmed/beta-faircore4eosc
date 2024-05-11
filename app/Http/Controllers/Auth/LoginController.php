<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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

    use ThrottlesLogins, AuthenticatesUsers {login as baseLogin; logout as baseLogout;}

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    protected int $maxAttempts = 3;

    protected int $decayMinutes = 2;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $response = $this->baseLogin($request);

        if($response instanceof RedirectResponse){
            session()->flash('status', "You've been logged in!");
        }
        return $response;
    }

    public function logout(Request $request): JsonResponse|RedirectResponse
    {
        $response = $this->baseLogout($request);
        session()->flash('status', "Goodbye!");
        return $response;
    }
}
