<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        return view('home', compact(
            'user',
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        // Récupérer les données du formulaire
        $email = $request->input('email');
        $password = $request->input('password');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            $request->session()->regenerate();

            $role = Auth::user()->role;

            //dd($role);
            //die();

            switch ($role) {

                case 'Admin':
                    # code...
                    if (intval(Auth::user()->active) == 1) {
                        # code...
                        return redirect()->intended('/');
                    } else {
                        # code...
                        return redirect()->intended('/')->with('failed', 'Votre compte a été désactivé. Veuillez contacter votre administrateur !');
                    }
                    break;

                default:
                    # code...
                    return redirect()->intended('/')->with('failed', 'Erreur systeme. Veuillez reessayer svp !');
                    break;
            }
        }

        return redirect()->back()->with([
            'failed' => ' Les identifiants fournies ne correspondent pas !',
        ]);
    }
}
