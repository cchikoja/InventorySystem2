<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpirePassword
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
        if (Auth::user()->force_passwd_change == false)
            return $next($request);
        else {
            if (Auth::user()->role == 'admin'){
                \Session::flash('error-notification', 'Password Expired, Please change your password !');
                return redirect()->route('admin.settings');
            }
            elseif (Auth::user()->role == 'legal'){
                \Session::flash('error-notification', 'Password Expired, Please change your password !');
                return redirect()->route('legal.settings');
            }

            elseif (Auth::user()->role == 'employee'){
                \Session::flash('error-notification', 'Password Expired, Please change your password !');
                return redirect()->route('home.settings');
            }
            elseif (Auth::user()->role == 'manager'){
                \Session::flash('error-notification', 'Password Expired, Please change your password !');
                return redirect()->route('manager.settings');
            }else{
                \Session::flash('error-notification', 'Password Expired, Please change your password !');
                return redirect()->route('gfc.settings');
            }

        }
    }
}
