<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAuthenticated
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
        if (!Auth::check()) {
            // Redireciona para a p?gina de login se o usu?rio n?o estiver autenticado
            return redirect()->route('login');
        }

        // Continua com a requisi??o se o usu?rio estiver autenticado
        return $next($request);
    }
}
