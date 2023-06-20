<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Patient;
use App\Models\Req;
use App\Models\Alluser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function MultiLogin(Request $request) {

        $requestUrl = $request->requestUrl;
        return view('Public-Views.login', compact('requestUrl'));
    }


    public function MultiLoginCheck(Request $request) {

        Session::flash('login', $request->email);

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = Alluser::where('email', '=', $request->email)->first();
        if (!$user) {

            return redirect()->route('all.login')
                ->with('error_msg', 'This email does not exist please sign up');
        }
        else {

            if ($user->role == 1) {

                if (Hash::check($request->password, $user->password)) {

                    $registered_patient_info = Patient::where('user_id', '=', $user->id)->first();
                    $request->session()->put('logged_in_patient', $registered_patient_info);

                    if(!empty($request->requestUrl)) {
                        return redirect()->to($request->requestUrl);
                    }

                    return redirect()->route('patient.profile');
                }
                else {

                    return redirect()->route('all.login')
                        ->with('error_msg', 'Incorrect Email or password');
                }
            }
            if ($user->role == 2) {

                $registered_doctor_info = Req::where('user_id', '=', $user->id)->first();
                if ($registered_doctor_info->request_status == 1) {

                    if (Hash::check($request->password, $user->password)) {

                        $request->session()->put('logged_in_doctor', $registered_doctor_info);
                        if(!empty($request->requestUrl)) {
                            if (str_contains($request->requestUrl, '/search/doctor/profile')) {
                                $url_parts=explode("/", $request->requestUrl);
                                $url_id=Arr::last($url_parts);
                                if($url_id == strVal($registered_doctor_info->id))
                                    return redirect()->route('drprofile');
                                else
                                    return redirect()->to($request->requestUrl);
                            }
                            else
                                return redirect()->to($request->requestUrl);
                        }
                        return redirect()->route('drprofile');
                    }
                    else {

                        return redirect()->route('all.login')
                            ->with('error_msg', 'Incorrect Email or password');
                    }
                }
                elseif (is_null($registered_doctor_info->request_status) == true) {
                    $request->session()->put('waiting_dr', $registered_doctor_info);
                    return redirect()->route('doctor.wait');
                }
                else {
                    $request->session()->put('rejected_dr', $registered_doctor_info);
                    return redirect()->route('doctor.wait');
                }
            }
            if ($user->role == 0) {

                if (($user->password == $request->password)) {

                    $admin = Admin::where('user_id', '=', $user->id)->first();
                    $request->session()->put('logged_in_admin', $admin);
                    if(!empty($request->requestUrl)) {

                        return redirect()->to($request->requestUrl);
                    }
                    return redirect()->route('doctor.request');
                }
                else {

                    return redirect()->route('all.login')
                        ->with('error_msg', 'Incorrect Email or password');
                }
            }
        }

    }


    public function MultiLogout() {

        if (session()->has('logged_in_patient')) {
            session()->pull('logged_in_patient');
            return redirect()->route('home.page');
        }
        elseif (session()->has('logged_in_doctor')) {
            session()->pull('logged_in_doctor');
            return redirect()->route('home.page');
        }
        elseif (session()->has('logged_in_admin')) {
            session()->pull('logged_in_admin');
            return redirect()->route('home.page');
        }
        elseif (session()->has('waiting_dr')) {
            session()->pull('waiting_dr');
            return redirect()->route('home.page');
        }
        elseif (session()->has('rejected_dr')) {
            session()->pull('rejected_dr');
            return redirect()->route('home.page');
        }
        else {
            return redirect()->route('home.page');
        }
    }





}
