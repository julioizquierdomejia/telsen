<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
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

    //use AuthenticatesUsers;
    use AuthenticatesUsers {
        logout as performLogout;
    }

    public function logout(Request $request) {
        //session('priority', 'false');
        $this->performLogout($request);
        return redirect('/');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    protected function attemptLogin(Request $request)
    {
        $attempt = auth()->attempt(['email' => $request->email, 'password' => $request->password, 'enabled' => 1]);
        return ($attempt);
    }

    protected function authenticated(Request $request, $user)
    {
        $request->session()->put('priority', 'true');
        $user_roles = $user->roles()->first();
        if ($user_roles && $user_roles->name == 'client') {
            return redirect()->route('ordenes.list');
        }
        /*if ( $user->isAdmin() ) {
            return redirect()->route('dashboard');
        }*/
        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
