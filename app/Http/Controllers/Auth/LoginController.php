<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
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
    public function redirectTo()
    {

        $role = Auth::user()->role;

        switch ($role) {

            case 'Admin':

                if (intval(Auth::user()->status) == 1) {
                    # code...
                    return '/dashboard/admin';
                } else {
                    # code...
                    return redirect('/')->with('failed', 'Votre compte a été désactivé. Veuillez contacter votre administrateur !');
                }

                break;

            default:
                return '/';
                break;
        }
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

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {

        $app_name = "LA POSTE";
        $page_title = "Administration";

        // Notice the second argument
        return view(
            'auth.login',
            [
                'app_name' => $app_name,
                'page_title' => $page_title
            ]
        );
    }
}
