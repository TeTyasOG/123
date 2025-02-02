<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/home';

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

    /**
     * Determine which field (email or nickname) to use for authentication.
     *
     * @return string
     */
    public function username()
    {
        $login = request()->input('login');

        // Determine if the login is an email or a nickname
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nickname';
        request()->merge([$fieldType => $login]);

        return $fieldType;
    }
}
