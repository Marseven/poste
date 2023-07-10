<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check() && Auth::user()) {

                $role = Auth::user()->role; 

                switch ($role) {

                    case 'Admin':
                        // Redirection
                        if (intval(Auth::user()->status) == 1) {
                            # code...
                            return redirect()->route('rootAdmin');
                        } else {
                            # code...
                            return redirect()->route('accueil')->with('failed', 'Votre compte a été désactivé. Veuillez contacter votre administrateur !');
                        }
                        break;

                    

                    default:
                        return redirect()->route('accueil');
                        break;
                }
            }
        }

        return $next($request);
    }
}
