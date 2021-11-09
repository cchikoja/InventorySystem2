<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountsMiddleware
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
        if (Auth::user()->role === 'employee' || Auth::user()->id == $requestedUserID)
            return $next($request);
        else if (Auth::user()->role == 'legal')
            return redirect()->route('legal');
        elseif (Auth::user()->role == 'gfc')
            return redirect()->route('gfc');
        elseif (Auth::user()->role == 'manager')
            return redirect()->route('manager');
        else
            return redirect()->route('admin');
    }
}
