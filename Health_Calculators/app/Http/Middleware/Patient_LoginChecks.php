<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Patient_LoginChecks
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
        if(!session()->has('logged_in_patient') && ($request->path() != "login")) {
            return back();
        }

        if(!session()->has('logged_in_patient') && $request->path() == "all/prescriptions") {
            return back();
        }

        if(!session()->has('logged_in_patient') && $request->path() == "view/prescription/{p_id}") {
            return back();
        }
        if(session()->has('logged_in_patient') && ($request->path() == "all/doctors/detials/{id}")) {
            // return redirect()->route('all.login');
            return back();
        }
        //to prevent going back on previous back after logout using browser back buttons
        return $next($request)->header('Cache-Control','no-cache, no-store, max-age=0, must-revalidate')
                            ->header('Pragma', 'no-cache')
                            ->header('Expires', 'Sat 01 Jan 1990 00:00:00 GMT' );
    }
}
