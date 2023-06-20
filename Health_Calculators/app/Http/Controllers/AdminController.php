<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alluser;
use App\Models\Appointment;
use App\Models\Req;
use App\Models\Mail;
use App\Models\Doctor;
use App\Models\Worktime;
use App\Models\Clinic;

class AdminController extends Controller
{

    public function ShowDoctorRequests() {

        $all_reqs = Req::where('request_status', NULL)->orderBy('id','DESC')->paginate(10);
        return view('Admin.doctorrequests', ["reqs"=> $all_reqs]);

    }


    public function ShowDoctorDetails($id) {
        if (session()->has('logged_in_admin')){
        $req= Req::find($id);
        $detail = Alluser::find($req->user_id);
        return view('Admin.doctordetails' , ['dr_details'=> $req], ['dr_email' => $detail]);
        }else{
            return back();
        }
    }


    public function AccecptDoctor($id) {
     if (session()->has('logged_in_admin')){
        $req=Req::find($id);
        $req->admin_id = session('logged_in_admin')['id'];
        $req->request_status = 1;
        $req->save();
        $dr = new Doctor;
        $dr->request_id = $req->id;
        $dr->phone_number = $req->phone_number;
        $dr->bio = "doctor";
        $dr->profile_image = url('/img/doctor.png');
        $dr->save();
        return redirect()->route('doctor.request');
     }
     else{
        return back();
     }

    }


    public function RejectDoctor($id, Request $request) {
    
        $req=Req::find($id);
        $mail = new Mail;
        $mail->title = "Rejection Mail";
        $mail->content = $request->rejection_reason;
        $req->request_status = 0;
        $req->admin_id = session('logged_in_admin')['id'];
        $mail->request_id = $id;
        $mail->save();
        $req->save();
        return redirect()->route('doctor.request');
    
    

    }


    public function SendMail() {

        if (session()->has('rejected_dr')) {

            $mail = Mail::where('request_id', '=', session('rejected_dr')['id'])->first();
            if($mail->request_status == 0) {

                return view('Doctor.waitingmail', ['mails'=>$mail]);
            }
        }
        elseif(session()->has('waiting_dr')) {

            $mail = new Mail;
            $mail->title = 'Thank You,';
            $mail->content = 'Your form has been submited, please wait until it gets confirmed';
            return view('Doctor.waitingmail', ['mails' => $mail]);
        }
        elseif (!session()->has('logged_in_doctor') || !session()->has('rejected_dr') || !session('waiting_dr')) {

            $mail = new Mail;
            $mail->title = 'Thank You,';
            $mail->content = 'Your form has been submited, please wait until it gets confirmed';
            return view('Doctor.waitingmail', ['mails' => $mail]);
        }

    }


    public function ShowAllDoctors() {

        $all_doctorrs = Req::where('request_status','=', 1)->orderBy('id','DESC')->paginate(10);
        $all_doctors_data = Doctor::all();
        return view('Admin.alldoctors', ['all_drs'=> $all_doctorrs], compact('all_doctors_data'));

    }


    public function allDoctorDetails($id) {
       if (session()->has('logged_in_admin')){

        $req = Req::find($id);
        $detail = Alluser::find($req->user_id);
        return view('Admin.alldrdetails' , ['dr_details'=> $req], ['dr_email' => $detail]);
       }
       else{
        return back();
       }
    }


    public function DeleteDoctor($id, Request $req) {

        $deleted_dr = Req::find($id);
        $deleted_dr->request_status = 0;
        $deleted_dr->save();
        //
        $doctor = Doctor::where('request_id', '=', $id)->first();
        if($doctor->clinic_id !== null) {
            $clinic = Clinic::where('id', '=', $doctor->clinic_id)->first();
            $worktime = Worktime::where('clinic_id', '=', $doctor->clinic_id)->get();
            foreach($worktime as $wt){
                $booked_appointment = Appointment::where('worktime_id', '=', $wt->id);
                if(!empty($booked_appointmentd)) {
                    $booked_appointment->delete();
                    $wt->delete();
                }
                else {
                    $wt->delete();
                }
            }
            $clinic->delete();
            $doctor->delete();
        }
        else {
            $doctor->delete();
        }
        //
        $deleted_mail = new Mail;
        $deleted_mail->title = "Deleted Doctor";
        $deleted_mail->content = $req->delete_reason;
        $deleted_mail->request_id = $deleted_dr->id;
        $deleted_mail->save();
        return redirect()->route('all.dr');

    }


}
