<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsurePersonIsSupervisorOrHigher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && (Auth::person()->role === 'admin' || Auth::person()->role === 'supervisor')) {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'You do not have access to this section.');
    }
}
