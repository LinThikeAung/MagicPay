<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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

    //for guard user in auth.php
    protected function guard(){
        return Auth::guard();
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    //login win p dr nae users table ko ip,agent,logined date htae mar
    protected function authenticated(Request $request, $user)
    {
        //logined user
        $user->ip = $request->ip();
        $user->user_agent = $request->server('HTTP_USER_AGENT');
        $user->login_at = date('Y-m-d H:i:');
        $user->update();
        return redirect($this->redirectTo);
    }


    //customize return logout type
    // logout call lite dr nae redirect link ma pyan bal ajax response type json pyan lar say chin loz
    // change new 'Response(['success'], 204)'-> json return type 'response()->json([],204)'

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? response()->json([],204)//for accept json and so return this format json
            : redirect('/');
    }
}
