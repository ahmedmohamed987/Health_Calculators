<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class Doctor_LoginChecks
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
        // if(!session()->has('logged_in_doctor')&& ($request->path()== "doctor/profile")) {
        //     // return redirect()->route('all.login');
        //     return Redirect::back();
        // } //3ashan nprotect routes al dr lw ay had gher al dr flsession w byaccess ay haga gher al login
        if(!session()->has('logged_in_doctor')&& ($request->path()== "drprofile")) {
            // return redirect()->route('all.login');
            return Redirect::back();
        } //3ashan nprotect routes al dr lw ay had gher al dr flsession w byaccess ay haga gher al login

        if (session()->has('logged_in_doctor') && ($request->path() == "login")) {
            return redirect()-> route('drprofile');
        }

        // if(session()->has('logged_in_doctor') && ($request->path() != "doctor/profile")) {
        //     return back();
        // }//dah lw al dr flsession w byhawel yaccess ay profile gher bta3o ymna3o

        if(session()->has('logged_in_admin') && ($request->path() == "drprofile")) {
            return back();
        }//dah 3ashan nmna3 al admin mn eno yftah profile al dr

        if(session()->has('logged_in_patient') && ($request->path() == "drprofile")) {
            return back();
        }//dah 3ashan nmna3 al patient` mn eno yftah profile al dr

        if(session()->has('logged_in_doctor') && $request->path() == "mail") {
            return redirect()->back();
        }

        if(session()->has('logged_in_patient') && $request->path() == "mail") {
            return redirect()->back();
        }

        if(session()->has('logged_in_admin') && $request->path() == "mail") {
            return redirect()->back();
        }

        if(session()->has('logged_in_doctor') && ($request->path() == "all/doctors/detials/{id}")) {
            // return redirect()->route('all.login');
            return back();
        }
///////////////////////////////////////////////////////////////////////////////////////////////////////
        // if(session()->has('waiting_dr') && $request->path() == "doctor/rej") {
        //     return redirect()->route('doctor.wait');
        // }

        // if(session()->has('rejected_dr') && $request->path() == "doctor/wait") {
        //     return redirect()->route('doctor.rej');
        // }

        if(!session()->has('rejected_dr')) {
            $previousurl = url()->previous();
            if(($previousurl == "http://localhost:8000"  && $request->path() == "mail")) {
                return redirect()->back();
            }
            // elseif(($previousurl == "http://localhost:8000"  && $request->path() == "doctor/rej")) {
            //     return redirect()->back();
            // }
        }
        // prescriptions middleware
        // if(!session()->has('logged_in_doctor') && $request->path() == "add/prescription/{patient_app_id}") {
        //     return back();
        // }
        // if(!session()->has('logged_in_doctor') && $request->path() == "edit/prescription/{app_id}") {
        //     return back();
        // }
///////////////////////////////////////////////////////////////////////////////////////
        //to prevent going back on previous back after logout using browser back buttons
        return $next($request)->header('Cache-Control','no-cache, no-store, max-age=0, must-revalidate')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat 01 Jan 1990 00:00:00 GMT' );
    }
}
