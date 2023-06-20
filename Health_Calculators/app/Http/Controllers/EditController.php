<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Req;
use App\Models\Alluser;
use App\Models\Governorate;
use Illuminate\Http\Request;

class EditController extends Controller
{
    function showdata(Request $req){

        if (session()->has('logged_in_admin')){
            $user=Alluser:: where('id','=',session('logged_in_admin')['id'])->first();
            $admin = Admin::where('id','=',session('logged_in_admin')['id'])->first();
            return view('Admin.editprofile',compact('user','admin'));
        }
        elseif(session()->has('logged_in_patient')){
            $user=Alluser:: where('id','=', session('logged_in_patient')['user_id'])->first();
            $patient = Patient::where('id','=',session('logged_in_patient')['id'])->first();
            $governorates = Governorate::all();
            return view('Admin.editprofile',compact(['user'], 'governorates','patient'));
        }
        elseif(session()->has('logged_in_doctor')){
            $user=Alluser:: where('id','=', session('logged_in_doctor')['user_id'])->first();
            $doctordata=Doctor::where('request_id','=',session('logged_in_doctor')['id'])->first();
            $governorates = Governorate::all();
            return view('Admin.editprofile',compact(['user','doctordata', 'governorates']));
        }
    }


    function update($id, Request $req){

        $req->validate([
            'first_name' => ['required', 'regex:/^[\pL\s]+$/u'],
            'last_name' => ['required', 'regex:/^[\pL\s]+$/u'],
            'email' => ['required', 'email'],
            'phone_number' => ['required' , 'numeric', 'regex:/(01)[0-9]{9}/']]);

        $user = Alluser::where('id', '=',$id)->first();

        if($user->role == 1) {
            {
                $req->validate([
                    'age' => ['required', 'numeric','min:12','max:100'],
                    'gender' => ['required'],]);

                $user->update(['email'=>$req->email]);

                if ((($req->age) < 12) || (($req->age) >100) ) {
                    return redirect()->route('profile.edit');
                }
                else{
                        if(session()->has('logged_in_patient')){
                            $findP = Patient::where('user_id', '=',$id)->first();
                            $findP->first_name=$req->first_name;
                            $findP->last_name=$req->last_name;
                            $findP->phone_number=$req->phone_number;
                            $findP->age=$req->age;
                            $findP->gender=$req->gender;
                            $findP->address=$req->location;
                            $img = $req['file'];

                            if ($img  == null){
                                $findP->profile_image;
                            }
                            else{
                                $name = time(). '.' . $img->extension();
                                $path = "/profile_photo/" . $name;
                                $img->move(public_path('profile_photo'), $name);
                                $findP->profile_image = $path;
                            }

                            $findP->update();
                            session('logged_in_patient')['first_name'] = $findP->first_name;
                            session('logged_in_patient')['last_name'] = $findP->last_name;
                            session('logged_in_patient')['phone_number'] = $findP->phone_number;
                            session('logged_in_patient')['age'] = $findP->age;
                            session('logged_in_patient')['gender'] = $findP->gender;
                            session('logged_in_patient')['address'] = $findP->address;
                            session('logged_in_patient')['profile_image'] = url("$findP->profile_image");

                            return  redirect()->route('patient.profile');
                        }
                    }
            }
        }

        elseif($user->role == 0){
            $req->validate([
                'age' => ['required', 'numeric','min:25','max:100']]);

            $user->update(['email'=>$req->email]);
            if ((($req->age) < 25) || (($req->age) >100) ) {
                return redirect()->route('profile.edit');
            }
            else{
                if(session()->has('logged_in_admin')){
                    $findA = Admin::where('user_id', '=',$id)->first();
                    $findA->first_name=$req->first_name;
                    $findA->last_name=$req->last_name;
                    $findA->phone_number=$req->phone_number;
                    $findA->age=$req->age;
                    $findA->gender=$req->gender;
                    $img = $req['file'];
                    if ($img  == null){
                        $findA->profile_image;
                    }
                    else{
                        $name = time(). '.' . $img->extension();
                        $path = "/profile_photo/" . $name;
                        $img->move(public_path('profile_photo'), $name);
                        $findA->profile_image = $path;
                    }
                    $findA->update();
                    session('logged_in_admin')['first_name'] = $findA->first_name;
                    session('logged_in_admin')['last_name'] = $findA->last_name;
                    session('logged_in_admin')['phone_number'] = $findA->phone_number;
                    session('logged_in_admin')['age'] = $findA->age;
                    session('logged_in_admin')['gender'] = $findA->gender;
                    session('logged_in_admin')['profile_image'] = url("$findA->profile_image");
                    return  redirect()->route('doctor.request');
                }
            }
        }
        elseif($user->role == 2) {
            {
                $req->validate([
                    'age' => ['required', 'numeric','min:25','max:100'],
                    'gender' => ['required']]);

                $user->update(['email'=>$req->email]);
                if ((($req->age) < 25) || (($req->age) >100)) {
                    return redirect()->route('profile.edit');
                }
                else{
                    if(session()->has('logged_in_doctor')){

                        $findD = Req::where('user_id', '=',$id)->first();
                        $findd = Doctor::where('request_id', '=',$findD->id)->first();
                        $findD->first_name=$req->first_name;
                        $findD->last_name=$req->last_name;
                        $findD->phone_number=$req->phone_number;
                        $findD->age=$req->age;
                        $findD->gender=$req->gender;
                        $findD->address=$req->location;
                        $img = $req['file'];
                        if ($img  == null) {
                            $findd->profile_image;
                        }
                        else{
                            $name = time(). '.' . $img->extension();
                            $path = "/profile_photo/" . $name;
                            $img->move(public_path('profile_photo'), $name);
                            $findd->profile_image = $path;
                        }
                        $findd->phone_number=$req->phone_number;
                        $findd->save();
                        $findD->update();
                        session('logged_in_doctor')['first_name'] = $findD->first_name;
                        session('logged_in_doctor')['last_name'] = $findD->last_name;
                        session('logged_in_doctor')['phone_number'] = $findD->phone_number;
                        session('logged_in_doctor')['age'] = $findD->age;
                        session('logged_in_doctor')['gender'] = $findD->gender;
                        session('logged_in_doctor')['address'] = $findD->address;
                        session('logged_in_doctor')['profile_image'] = $findD->profile_image;
                        return  redirect()->route('drprofile');
                    }
                }
            }
        }
    }


    public function DeletePhoto($id){

        if(session()->has('logged_in_admin')) {
            if($id == session('logged_in_doctor')['id']){
            $admin = Admin::find($id);
            $admin->profile_image = url('img/default.jpg');
            $admin->save();
            }
            else{
                return back();
            }
        }
        if(session()->has('logged_in_doctor')) {
         if($id == session('logged_in_doctor')['id']){
            $dr = Doctor::where('request_id', '=', $id)->first();
            $dr->profile_image = url('img/doctor.png');
            $dr->save();
         }
         else{
            return back();
         }
        }
        if(session()->has('logged_in_patient')) {
         if($id == session('logged_in_patient')['id']){
            $patient = Patient::find($id);
            $patient->profile_image = url('img/default.jpg');
            $patient->save();
         }
         else{
            return back();
         }
        }
        return redirect()->back();
    }


}
