<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPhase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $phase)
    {
        if(env('APP_PHASE') == $phase || Auth::user()->hasRole('admin')) {
            return $next($request);
        }
        return redirect('dashboard');
    }
}
