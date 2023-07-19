<?php

namespace App\Http\Middleware;

use App\Models\SecurityObject;
use App\Models\SecurityRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()) {
            $role = Auth::user()->role;

            switch ($role) {

                case 'Admin':
                    // Redirection
                    if (intval(Auth::user()->status) == 1) {
                        # code...
                        return $next($request);
                    } else {
                        # code...
                        return redirect('/')->with('error', "Vous n'avez pas accès à cet espace.");
                    }
                    break;
                default:
                    return redirect('/')->with('error', "Vous n'avez pas accès à cet espace.");
                    break;
            }
        }

        return redirect('/')->with('error', "Vous n'avez pas accès à cet espace.");
    }
}
