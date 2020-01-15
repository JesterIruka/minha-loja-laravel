<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->role < 3) {
            flash('Você não tem permissão para acessar esta página')->error();
            return redirect()->route('admin.dashboard');
        }
        return $next($request);
    }
}
