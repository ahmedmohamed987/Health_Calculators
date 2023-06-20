<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AllLoginCheck
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
        if(session()->has('logged_in_admin') && ($request->path() == "login")) {
            return back();
        }

        if(session()->has('logged_in_patient') && ($request->path() == "login")) {
            return redirect()->route('patient.profile');
            // return back();// de bt3ml conflict m3 aly taht
        }

        if(session()->has('logged_in_doctor') && ($request->path() == "login")) {
            return redirect()->route('drprofile');
        }

        //al 3 conditions doul bymna3o ay user 3amel login mn eno uruh y3ml login tanyy



         //al middleware dah hatyno lkoul routes al admin
        // if(!session()->has('logged_in_admin') && ($request->path() != "login")) {
        //     // return  redirect()->route('all.login');
        //     return Redirect::back();
        // }
        
       
        if(!session()->has('logged_in_admin') && $request->path()== "show/doctor/requests") {
            // return redirect()->back();
            return redirect()->back();
        }
       
        if(!session()->has('logged_in_admin') && $request->path()== "all/doctors") {
            return redirect()->back();
        }

        
        

        //edit profile
        if((session()->has('waiting_dr') || session()->has('rejected_dr')) && $request->path() == "edit") {
            return back();
        }
        if((!session()->has('waiting_dr') && !session()->has('rejected_dr') &&
            !session()->has('logged_in_admin') && !session()->has('logged_in_doctor') &&
            !session()->has('logged_in_patient'))
            && $request->path() == "edit") {
            return back();
        }

        // if((session()->has('logged_in_patient') )&& $request->path()=="all/notifications")   {
        //         return redirect()->route('all.notifications');
        // }
        // elseif((session()->has('logged_in_doctor'))&& $request->path()=="all/notifications")   {
        //         return redirect()->route('all.notifications');
        // }
        // elseif((session()->has('logged_in_admin'))&& $request->path()=="all/notifications")   {
        //         return redirect()->route('all.notifications');
        // }
        // else{
        //     return redirect()->back();
        // }
        if(!session()->has('logged_in_doctor') && !session()->has('logged_in_patient')
        && $request->path() == "all/notifications") {
            return redirect()->back();
        }
        // if(!session()->has('logged_in_doctor') && !session()->has('logged_in_patient')
        // && $request->path() == "dr/profile/appointment/{id}/{c_id}") {
        //     return redirect()->back();
        // }


        //to prevent going back on previous back after logout using browser back buttons
        return $next($request)->header('Cache-Control','no-cache, no-store, max-age=0, must-revalidate')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat 01 Jan 1990 00:00:00 GMT' );
    }

}
