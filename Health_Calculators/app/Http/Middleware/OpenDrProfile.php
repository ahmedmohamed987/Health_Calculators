<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OpenDrProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(session()->has('logged_in_doctor') || session()->has('logged_in_patient') || session()->has('logged_in_admin')) {
            return $next($request);
        }
        else {
            $requestUrl =  \Request::getRequestUri();
            return redirect()->route('all.login', ['requestUrl' => $requestUrl]);
        }

    }
}
