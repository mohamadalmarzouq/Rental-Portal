<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard'); // update with your route name if different
        }

        return view('auth.login');
    }

    protected function attemptLogin(Request $request)
    {
        /* return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        ); */
        $credentials = $this->credentials($request);
        $remember = $request->filled('remember');
        if ($this->guard()->attempt($credentials, $remember)) {
            // If login is successful, generate and update the token
            $this->updateLoginToken();
            return true;
        }
        return false;
    }


    protected function updateLoginToken()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        $token = str::random(80);
        $user->login_token = $token;
        $user->save();
    }
}
