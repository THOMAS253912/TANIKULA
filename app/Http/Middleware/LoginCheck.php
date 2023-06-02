<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->check() && auth()->user()->hasRole('pembeli')) {
            return $next($request)->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')->header('Expires', 'Sat 01 Jan 1990 00:00:00 GMT');
        } elseif(auth()->check() && auth()->user()->hasRole('gapoktan')) {
            return $next($request)->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')->header('Expires', 'Sat 01 Jan 1990 00:00:00 GMT');
        } elseif(auth()->check() && auth()->user()->hasRole('poktan')) {
            return $next($request)->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')->header('Expires', 'Sat 01 Jan 1990 00:00:00 GMT');
        } elseif(auth()->check() && auth()->user()->hasRole('petani')) {
            return $next($request)->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')->header('Expires', 'Sat 01 Jan 1990 00:00:00 GMT');
        } elseif(auth()->check() && auth()->user()->hasRole('admin')) {
            return $next($request)->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')->header('Expires', 'Sat 01 Jan 1990 00:00:00 GMT');
        } elseif(auth()->check() && auth()->user()->hasRole('support')) {
            return $next($request)->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')->header('Expires', 'Sat 01 Jan 1990 00:00:00 GMT');
        }
        return redirect()->route('login');
    }
}
