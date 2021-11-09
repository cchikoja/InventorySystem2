<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministratorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $requestedUserID = $request->route()->parameter('id');
        if (Auth::user()->role === 'admin' || Auth::user()->id == $requestedUserID)
            return $next($request);
        elseif(Auth::user()->role == 'legal')
            return redirect()->route('legal');
        else
            return redirect()->route('home');
    }
}
