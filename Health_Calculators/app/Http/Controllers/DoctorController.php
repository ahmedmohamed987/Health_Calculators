<?php

namespace App\Http\Controllers;

use App\Models\Alluser;
use App\Models\Clinic;
use App\Models\Medicine;
use App\Models\Req;
use App\Models\Rate;
use App\Models\Doctor;
use App\Models\Worktime;
use App\Models\Governorate;
use App\Models\Appointment;
use App\Models\Deletedappointment;
use App\Models\Patient;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\PatientController;
use App\Models\Digitalprescription;
use Illuminate\Support\Facades\Session;

class DoctorController extends PatientController
{
    public function registerAsDoctor() {

        $governorates = Governorate::all();
        return view('Doctor.sign-up', compact('governorates'));

    }


    public function saveRequest(Request $request) {

        Session::flash('sign_up_doctor', ['email' => $request->email, 'first_name' => $request->first_name,
            'last_name' => $request->last_name, 'age' => $request->age, 'gender' => $request->gender,
            'phone_number' => $request->phone_number, 'registration_number' =>$request->registration_number, 'registration_date' => $request->registration_date,
            'expiry_date' => $request->expiry_date, 'last_year_payment' => $request->last_year_payment, 'speciality_type' => $request->speciality_type]);

        $request->validate([
            'first_name' => ['required', 'regex:/^[\pL\s]+$/u'],
            'last_name' => ['required', 'regex:/^[\pL\s]+$/u'],
            'email' => ['required', 'email', 'unique:allusers'],
            'password' => ['required', 'min:8', 'max:16'],
            'age' => ['required', 'numeric', 'min:25', 'max:100'],
            'gender' => ['required'],
            'address' => ['required'],
            'phone_number' => ['required', 'numeric' ,'regex:/(01)[0-9]{9}/'],
            'registration_number' => ['required', 'min:6', 'max:6'],
            'registration_date' => ['required', 'date_format:Y-m-d','before:today'],
            'expiry_date' => ['required', 'date_format:Y-m-d', 'after:registration_date'],
            'last_year_payment' => ['required'],
            'speciality_type' => ['required', 'regex:/^[\pL\s]+$/u'],
            'gulid_card_image' => ['required', 'mimes:jpeg, png, jpg, gif, svg', 'max:2000']//200MB
        ]);

        $new_req = new Req;
        $new_user = new Alluser;

        if ((($request->age) < 25) || (($request->age) >100) ) {

            return redirect()->route('doctor.signup');
        }
        else {

                $new_user->email = $request->email;
                $new_user->password = Hash::make($request->password);
                $new_user->role = 2; //waiting
                $new_user->save();
                $new_req->first_name = $request->first_name;
                $new_req->last_name = $request->last_name;
                $new_req->age = $request->age;
                $new_req->gender = $request->gender;
                $new_req->address = $request->address;
                $new_req->phone_number = $request->phone_number;
                $new_req->registration_number = $request->registration_number;
                $new_req->registration_date = $request->registration_date;
                $new_req->expiry_date = $request->expiry_date;
                $new_req->last_year_of_payment = $request->last_year_payment;
                $new_req->specialty_type = $request->speciality_type;
                $gulid_card_name = time(). '.' . $request->gulid_card_image->extension();
                $gulid_card_path = "/requests/" . $gulid_card_name;
                $request->gulid_card_image->move(public_path('requests'), $gulid_card_name);
                $new_req->gulid_card_image = $gulid_card_path;
                $new_req->user_id = $new_user->id;
                $new_req->save();

                return redirect()->route('doctor.wait');
        }

    }


    public function DrProfile() {

        if(session()->has('logged_in_doctor')) {

            $dr_data = Doctor::where('request_id', '=', session('logged_in_doctor')['id'])->first();
            $dr_email = Alluser::where('id', '=', session('logged_in_doctor')['user_id'])->first();
            $governorates = Governorate::all();
            $doctor_rates = Rate::where('doctor_id', '=', $dr_data->id)->get();
            $summation_of_doctor_rates = Rate::where('doctor_id', '=', $dr_data->id)->sum('rate');

            if ($doctor_rates->count() > 0) {
                $value_of_doctor_rates = $summation_of_doctor_rates / $doctor_rates->count();
            }
            else {
                $value_of_doctor_rates = 0;
            }

            if($dr_data->clinic_id != null) {
                $dr_clinic = Clinic::where('id', '=', $dr_data->clinic_id)->first();
                $dr_worktime = Worktime::where('clinic_id', '=', $dr_clinic->id)->whereNull('deleted_at')->get();

                $days = array();
                $starttime = array();
                $endtime = array();

                foreach($dr_worktime as $day) {
                    $days[] = $day->day;
                    $starttime[] = ['day' =>$day->day , 'start_time' => $day->start_time];
                    $endtime[] = ['day' =>$day->day , 'end_time' => $day->end_time];
                }

                $booked_apps = Worktime::join('appointments', 'appointments.worktime_id', '=', 'worktimes.id')
                    ->join('patients', 'patients.id', '=', 'appointments.patient_id')
                    ->select('*', 'appointments.id as app_id')
                    ->where('clinic_id', '=', $dr_data->clinic_id)
                    ->whereNull('worktimes.deleted_at')
                    ->where('appointments.date', '>=', Carbon::now()->toDateString())
                    ->where('appointments.deleted_at', '=', null)
                    ->orderBy('appointments.date', 'ASC')
                    ->get();

                $slots = array();
                foreach($booked_apps as $app) {
                    $slots [] =   $this->MakeSlots($app->start_time , $app->end_time) ;
                }

                $patients_list = Worktime::withTrashed()->join('appointments', 'appointments.worktime_id', '=', 'worktimes.id')
                    ->join('patients', 'patients.id', '=', 'appointments.patient_id')
                    ->select('*', 'appointments.id as app_id')
                    ->where('clinic_id', '=', $dr_data->clinic_id)
                    ->where('appointments.deleted_at', '=', null)
                    ->where('appointments.date', '<', Carbon::now()->toDateString())
                    ->orderBy('appointments.date', 'DESC')->take(2)
                    ->get();

                $all_dr_prescriptions = Digitalprescription::where('doctor_id', '=', $dr_data->id)->get();
                $patients_have_prescriptions = array();

                foreach($patients_list as $patient) {
                    foreach($all_dr_prescriptions as $dr_prescription) {
                        if($dr_prescription->appointment_id == $patient->app_id) {
                            $patients_have_prescriptions[] = $dr_prescription->appointment_id;
                        }
                    }
                }

                if($patients_list->isEmpty() && $booked_apps->isEmpty()) {
                    return view('Doctor.drprofile', compact('dr_data', 'dr_email', 'dr_clinic', 'dr_worktime',
                                'starttime', 'endtime', 'governorates'),
                                ['days'=>$days, 'value_of_doctor_rates' => $value_of_doctor_rates]);
                }
                elseif(!$patients_list->isEmpty() && $booked_apps->isEmpty()) {

                    if(empty($patients_have_prescriptions)) {
                            return view('Doctor.drprofile', compact('dr_data', 'dr_email', 'dr_clinic', 'dr_worktime',
                                'starttime', 'endtime', 'governorates', 'patients_list'),
                                ['days'=>$days, 'value_of_doctor_rates' => $value_of_doctor_rates]);
                        }
                        else {
                            return view('Doctor.drprofile', compact('dr_data', 'dr_email', 'dr_clinic', 'dr_worktime',
                                'starttime', 'endtime', 'governorates', 'patients_list'),
                                ['days'=>$days, 'value_of_doctor_rates' => $value_of_doctor_rates,
                                'patients_have_prescriptions' => $patients_have_prescriptions]);
                        }
                }
                elseif ($patients_list->isEmpty() && !$booked_apps->isEmpty()) {
                    return view('Doctor.drprofile', compact('dr_data', 'dr_email', 'dr_clinic', 'dr_worktime',
                                'starttime', 'endtime', 'governorates', 'booked_apps','slots'),
                                ['days'=>$days, 'value_of_doctor_rates' => $value_of_doctor_rates]);
                }
                elseif(!$patients_list->isEmpty() && !$booked_apps->isEmpty()) {

                    if(empty($patients_have_prescriptions)) {
                            return view('Doctor.drprofile', compact('dr_data', 'dr_email', 'dr_clinic', 'dr_worktime',
                                'starttime', 'endtime', 'governorates', 'booked_apps','slots', 'patients_list'),
                                ['days'=>$days, 'value_of_doctor_rates' => $value_of_doctor_rates]);
                        }
                        else {
                            return view('Doctor.drprofile', compact('dr_data', 'dr_email', 'dr_clinic', 'dr_worktime',
                                'starttime', 'endtime', 'governorates', 'booked_apps','slots', 'patients_list'),
                                ['days'=>$days, 'value_of_doctor_rates' => $value_of_doctor_rates,
                                'patients_have_prescriptions' => $patients_have_prescriptions]);
                        }
                }
            }
            else {
                return view('Doctor.drprofile', compact('dr_data', 'dr_email', 'governorates'),
                    ['value_of_doctor_rates' => $value_of_doctor_rates]);
            }
        }

    }


    public function AboutDoctor(Request $request) {

        $request->validate([
            'doctorDescription' => 'required'
        ]);

        $dr_data = Doctor::where('request_id', '=', session('logged_in_doctor')['id'])->first();
        $dr_data->bio = $request->doctorDescription;
        $dr_data->save();

        return redirect()->route('drprofile');

    }


    public function AddDetailedClinicAddress(Request $request) {

        $request->validate([
            'detailed_location' => 'required'
        ]);

        $dr_data = Doctor::where('request_id', '=', session('logged_in_doctor')['id'])->first();
        $clinic_info = Clinic::find($dr_data->clinic_id);
        $clinic_info->detailed_clinic_address = $request->detailed_location;
        $clinic_info->save();

        return redirect()->route('drprofile');

    }


    public function FixedWorkingTime(Request $request) {

        // Session::flash('fixed_working_time', ['clinicName' => $request->clinicName, 'location' => $request->location, "phone" => $request->phone,
        // 'fees' => $request->fees, 'startTime' => $request->startTime, 'endTime' => $request->endTime, 'workingDays' => $request->workingDays]);

        $request->validate([
            'clinicName' => ['required', 'regex:/^[\pL\s]+$/u'],
            'location' => ['required'],
            'phone' => ['required', 'numeric', 'regex:/(01)[0-9]{9}/'],
            'fees' => ['required','numeric','min:1'],
            'startTime' => ['required'],
            'endTime' => ['required'],
            'workingDays' => ['required'],
        ]);

        $doctor_already_exists = Doctor::where('request_id', '=', session('logged_in_doctor')['id'])->first();
        
        if(!empty($doctor_already_exists->clinic_id)) {
           

            $old_clinic = Clinic::where('id', '=', $doctor_already_exists->clinic_id)->first();
            $old_clinic->name = $request->clinicName;
            $old_clinic->clinic_address = $request->location;
            $old_clinic->phone_number = $request->phone;
            $old_clinic->fees = $request->fees;
            $old_clinic->save();

            $old_worktime = Worktime::where('clinic_id', '=', $old_clinic->id)->get();

            foreach($old_worktime as $oldday) {
                $oldday->delete();
            }

            foreach($request->workingDays as $day) {

                $old_workingtime = new Worktime;
                $old_workingtime->start_time = $request->startTime;
                $old_workingtime->end_time = $request->endTime;
                $old_workingtime->day = $day;
                $old_workingtime->clinic_id = $old_clinic->id;
                $old_workingtime->save();

            }

        }

        else {

            $clinic = new Clinic;
            $clinic->name = $request->clinicName;
            $clinic->clinic_address = $request->location;
            $clinic->phone_number = $request->phone;
            $clinic->fees = $request->fees;
            $clinic->save();
            $doctor_already_exists->clinic_id = $clinic->id;
            $doctor_already_exists->save();

            foreach($request->workingDays as $day) {

                $working_time = new Worktime;
                $working_time->start_time = $request->startTime;
                $working_time->end_time = $request->endTime;
                $working_time->day = $day;
                $working_time->clinic_id = $clinic->id;
                $working_time->save();

            }

        }

        return redirect()->route('drprofile');

    }


    public function FlexibleWorkingTime(Request $request) {

        $request->validate([
            'clinicName' => ['required', 'regex:/^[\pL\s]+$/u'],
            'location' => ['required'],
            'phone' => ['required', 'numeric', 'regex:/(01)[0-9]{9}/'],
            'fees' => ['required'],
            'startTime' => ['required'],
            'endTime' => ['required'],
            'workingDays' => ['required'],
        ]);

        $doctor_already_exists = Doctor::where('request_id', '=', session('logged_in_doctor')['id'])->first();

        if(!empty($doctor_already_exists->clinic_id)) {

            $old_clinic = Clinic::where('id', '=', $doctor_already_exists->clinic_id)->first();
            $old_clinic->name = $request->clinicName;
            $old_clinic->clinic_address = $request->location;
            $old_clinic->phone_number = $request->phone;
            $old_clinic->fees = $request->fees;
            $old_clinic->save();

            $old_worktime = Worktime::where('clinic_id', '=', $old_clinic->id)->get();

            foreach($old_worktime as $oldday) {
                $oldday->delete();
            }

            $i = 0;
            foreach($request->workingDays as $day) {

                $working_time = new Worktime;
                $working_time->start_time = $request->startTime[$i];
                $working_time->end_time = $request->endTime[$i];
                $working_time->day = $day;
                $working_time->clinic_id = $old_clinic->id;
                $working_time->save();
                $i++;

            }

        }
        else {

            $clinic = new Clinic;
            $clinic->name = $request->clinicName;
            $clinic->clinic_address = $request->location;
            $clinic->phone_number = $request->phone;
            $clinic->fees = $request->fees;
            $clinic->save();
            $doctor_already_exists->clinic_id = $clinic->id;
            $doctor_already_exists->save();

            $i = 0;
            foreach($request->workingDays as $day) {

                $working_time = new Worktime;
                $working_time->start_time = $request->startTime[$i];
                $working_time->end_time = $request->endTime[$i];
                $working_time->day = $day;
                $working_time->clinic_id = $clinic->id;
                $working_time->save();
                $i++;

            }
        }

        return redirect()->route('drprofile');

    }


    public function DrVisit($id) {

        $dr_data = Doctor::where('request_id', '=', $id)->first();
        $dr_request = Req::where('id', '=', $id)->first();
        $dr_email = Alluser::where('id', '=', $dr_request->user_id)->first();
        $dr_clinic = Clinic::where('id', '=', $dr_data->clinic_id)->first();
        $dr_worktime = Worktime::where('clinic_id', '=', $dr_clinic->id)->where('deleted_at', '=', null)->get();
        $book_appointment = Appointment::all();
        $dr_prescriptions = Digitalprescription::where('doctor_id', '=', $dr_data->id)->get();

        $i=0;

        //doctor rates
        $rate_doctor = false;
        $doctor_rates = Rate::where('doctor_id', '=', $dr_data->id)->get();
        $summation_of_doctor_rates = Rate::where('doctor_id', '=', $dr_data->id)->sum('rate');

        if($doctor_rates->count() > 0) {
            $value_of_doctor_rates = $summation_of_doctor_rates / $doctor_rates->count();
        }
        else {
            $value_of_doctor_rates = 0;
        }
        //

        if (session()->has('logged_in_patient')) {

            foreach ($book_appointment as $app) {
                foreach ($dr_worktime as $wt) {
                    if ($app->patient_id == (session('logged_in_patient')['id'])) {
                        if ($wt->id == $app->worktime_id) {
                            $i = 1;
                            foreach ($dr_prescriptions as $dr_prescription) {
                                if ($dr_prescription->appointment_id == $app->id) {
                                    $rate_doctor = true;
                                }
                            }
                        }
                        if ($app->date < Carbon::now()->toDateString()) {
                            $i = 0;
                        }
                    }
                }
            }

            $patient_booked_appointment = Appointment::join('worktimes', 'worktimes.id', '=', 'appointments.worktime_id')
                ->join('clinics', 'clinics.id', '=', 'worktimes.clinic_id')
                ->select('*', 'appointments.id as app_id')
                ->where('appointments.patient_id', '=', session('logged_in_patient')['id'])
                ->where('appointments.date', '>=', now()->format('Y-m-d'))
                ->where('clinics.id', '=', $dr_data->clinic_id)
                ->whereNull('appointments.deleted_at')->first();

            $patient_rates = Rate::where('patient_id', '=', session('logged_in_patient')['id'])
                ->where('doctor_id', '=', $dr_data->id)->first();

            if (empty($patient_rates) && is_null($patient_booked_appointment)) {

                return view('Patient.drVisit', compact('dr_data', 'dr_clinic', 'dr_worktime', 'dr_request', 'dr_email'),
                    ['checker' => $i, 'rate_doctor' => $rate_doctor, 'value_of_doctor_rates' => $value_of_doctor_rates]);
            }
            elseif (empty($patient_rates) || is_null($patient_booked_appointment)) {

                if (empty($patient_rates)) {

                    return view('Patient.drVisit', compact('dr_data', 'dr_clinic', 'dr_worktime', 'dr_request', 'dr_email'),
                        ['checker' => $i, 'rate_doctor' => $rate_doctor, 'value_of_doctor_rates' => $value_of_doctor_rates,
                            'patient_booked_appointment' => $patient_booked_appointment]);
                }
                else {

                    return view( 'Patient.drVisit', compact('dr_data', 'dr_clinic', 'dr_worktime', 'dr_request', 'dr_email'),
                        ['checker' => $i, 'rate_doctor' => $rate_doctor, 'value_of_doctor_rates' => $value_of_doctor_rates,
                            'patient_rates' => $patient_rates]);
                }

            }
            else {

                return view('Patient.drVisit', compact('dr_data', 'dr_clinic', 'dr_worktime', 'dr_request', 'dr_email'),
                        ['checker' => $i, 'rate_doctor' => $rate_doctor,'patient_booked_appointment' => $patient_booked_appointment,
                        'value_of_doctor_rates' => $value_of_doctor_rates, 'patient_rates' => $patient_rates]);
            }
        }

        else {

            return view('Admin.dr-visit-card', compact('dr_data', 'dr_clinic', 'dr_request', 'dr_email'),
                    ['rate_doctor' => $rate_doctor, 'value_of_doctor_rates' => $value_of_doctor_rates]);
        }

    }


    public function DrAppointments($id , $c_id) {

        if(session()->has('logged_in_patient')) {

            $dr_data = Doctor::where('request_id', '=', $id)->first();
            $dr_request = Req::where('id', '=', $id)->first();
            $dr_email = Alluser::where('id', '=', $dr_request->user_id)->first();
            $dr_clinic = Clinic::where('id', '=', $dr_data->clinic_id)->first();
            $dr_worktime = Worktime::where('id', '=', $c_id)->first();

            $doctor_rates = Rate::where('doctor_id', '=', $dr_data->id)->get();
            $summation_of_doctor_rates = Rate::where('doctor_id', '=', $dr_data->id)->sum('rate');

            if ($doctor_rates->count() > 0) {
                $value_of_doctor_rates = $summation_of_doctor_rates / $doctor_rates->count();
            } else {
                $value_of_doctor_rates = 0;
            }

            $start = new DateTime($dr_worktime->start_time);
            $end = new DateTime($dr_worktime->end_time);
            $startTime = $start->format('h:i A');
            $endTime = $end->format('h:i A');
            $i = 0;
            $time_slots = [];

            while(strtotime($startTime) <= strtotime($endTime)) {

                $start = $startTime;
                $end = date('h:i A', strtotime('+30 minutes', strtotime($startTime)));
                $startTime = date('h:i A', strtotime('+30 minutes', strtotime($startTime)));
                $i++;

                if(strtotime($startTime) <= strtotime($endTime)) {

                    $time_slots[$i]['slots_start_time'] = $start;
                    $time_slots[$i]['slots_end_time'] = $end;
                }

            }

            $currentDate=Carbon::now()->toDateString();
            $findAppointment=Appointment::where('date','>=',$currentDate)->get();

            return view('Patient.appointment', compact('dr_data', 'dr_clinic', 'dr_worktime', 'dr_request', 'dr_email', 'findAppointment'),
                        ['time_slots'=>$time_slots, 'value_of_doctor_rates' => $value_of_doctor_rates]);

        }
        else {
            return redirect()->back();
        }

    }


    public function DeleteAppointment($id, Request $request) {

        $request->validate([
            'reason' => 'required'
        ]);

        $del_app = new Deletedappointment;
        $del_app->appointment_id = $id;
        $del_app->reasion = $request->reason;
        $del_app->save();
        $deleted_appointment = Appointment::find($id);
        $deleted_appointment->delete();

        return redirect()->route('drprofile');

    }


    public function AddPrescription($patient_app_id) {

        if(session()->has('logged_in_doctor')) {

            $apps_worktimes_info = Appointment::join('worktimes', 'worktimes.id', '=', 'appointments.worktime_id')
                ->select('*', 'appointments.date as appointment_date', 'appointments.id as app_id')
                ->where('appointments.id', '=', $patient_app_id)->first();
            $doctor_info = Doctor::join('requests', 'requests.id', '=', 'doctors.request_id')
                ->join('clinics', 'clinics.id', '=', 'doctors.clinic_id')
                ->where('doctors.request_id', '=', session('logged_in_doctor')['id'])->first();
            $doctor_email = Alluser::where('id', '=', $doctor_info->user_id)->first();
            $patient_info = Patient::where('id', '=', $apps_worktimes_info->patient_id)->first();

            return view('Doctor.add-prescription', compact('patient_info','apps_worktimes_info', 'doctor_info', 'doctor_email'));

        } else {

            return back();
        }

    }


    public function SavePrescription(Request $request, $app_id) {

        $request->validate([
            'medicines.*.name' => 'required',
            'medicines.*.dosage' => 'required',
            'medicines.*.period' => 'required',
            'medicines.*.time' => 'required'
        ], [
            'medicines.*.name.required' => 'Medicine name field is required',
            'medicines.*.dosage.required' => 'Dosage field is required',
            'medicines.*.period.required' => 'Period field is required',
            'medicines.*.time.required' => 'Time field is required',
        ]);


        $dr_data = Doctor::where('request_id', '=',session('logged_in_doctor')['id'] )->first();
        $new_prescription = new Digitalprescription;
        $new_prescription->doctor_id = $dr_data->id;
        $new_prescription->appointment_id = $app_id;
        $new_prescription->save();

        foreach ($request['medicines'] as $med) {

            $medicine = new Medicine;
            $medicine->prescription_id = $new_prescription->id;
            $medicine->name = $med['name'];
            $medicine->dosage = $med['dosage'];
            $medicine->period = $med['period'];
            $medicine->time = $med['time'];
            $medicine->notes = $med['notes'];
            $medicine->save();

        }

        return redirect()->route('drprofile');

    }


    public function EditPrescription($app_id) {

        if(session()->has('logged_in_doctor')) {

            $prescription = Digitalprescription::where('appointment_id', '=', $app_id)->first();
            $patient_info = Appointment::join('patients', 'patients.id', '=', 'appointments.patient_id')
                ->where('appointments.id', '=', $app_id)->first();
            $doctor_info = Doctor::join('requests', 'requests.id', '=', 'doctors.request_id')
                ->join('allusers', 'allusers.id', '=', 'requests.user_id')
                ->join('clinics', 'clinics.id', '=', 'doctors.clinic_id')
                ->where('doctors.id', '=', $prescription->doctor_id)->first();
            $medicines = Medicine::where('prescription_id', '=', $prescription->id)->get();
            $number_of_medicines = Medicine::where('prescription_id', '=', $prescription->id)->count();

            return view('Doctor.edit-prescription', compact('prescription', 'patient_info', 'doctor_info', 'medicines'),
                        ['number_of_medicines' => $number_of_medicines]);

        } else {

            return back();
        }

    }


    public function UpdatePrescription(Request $request, $pre_id) {

        $request->validate([
            'medicines.*.name' => 'required',
            'medicines.*.dosage' => 'required',
            'medicines.*.period' => 'required',
            'medicines.*.time' => 'required'
        ], [
            'medicines.*.name.required' => 'Medicine name field is required',
            'medicines.*.dosage.required' => 'Dosage field is required',
            'medicines.*.period.required' => 'Period field is required',
            'medicines.*.time.required' => 'Time field is required',
        ]);

        $old_medicines = Medicine::where('prescription_id', '=', $pre_id)->get();

        foreach($old_medicines as $old_med) {

            $old_med->delete();
        }

        foreach ($request['medicines'] as $med) {

            $medicine = new Medicine;
            $medicine->prescription_id = $pre_id;
            $medicine->name = $med['name'];
            $medicine->dosage = $med['dosage'];
            $medicine->period = $med['period'];
            $medicine->time = $med['time'];
            $medicine->notes = $med['notes'];
            $medicine->save();
        }

        return redirect()->route('drprofile');

    }


    public function GetAllPatients() {

        $dr_data = Doctor::where('request_id', '=', session('logged_in_doctor')['id'])->first();
        $dr_email = Alluser::where('id', '=', session('logged_in_doctor')['user_id'])->first();
        $governorates = Governorate::all();
        $doctor_rates = Rate::where('doctor_id', '=', $dr_data->id)->get();
        $summation_of_doctor_rates = Rate::where('doctor_id', '=', $dr_data->id)->sum('rate');
        $dr_clinic = Clinic::where('id', '=', $dr_data->clinic_id)->first();

        if ($doctor_rates->count() > 0) {
            $value_of_doctor_rates = $summation_of_doctor_rates / $doctor_rates->count();
        } else {
            $value_of_doctor_rates = 0;
        }

        $patients_list = Worktime::withTrashed()->join('appointments', 'appointments.worktime_id', '=', 'worktimes.id')
            ->join('patients', 'patients.id', '=', 'appointments.patient_id')
            ->select('*', 'appointments.id as app_id')
            ->where('clinic_id', '=', $dr_data->clinic_id)
            ->where('appointments.deleted_at', '=', null)
            ->where('appointments.date', '<', Carbon::now()->toDateString())
            ->orderBy('appointments.date', 'DESC')->paginate(15);

        $all_dr_prescriptions = Digitalprescription::where('doctor_id', '=', $dr_data->id)->get();
        $patients_have_prescriptions = array();

        foreach ($patients_list as $patient) {
            foreach ($all_dr_prescriptions as $dr_prescription) {
                if ($dr_prescription->appointment_id == $patient->app_id) {
                    $patients_have_prescriptions[] = $dr_prescription->appointment_id;
                }
            }
        }

        if (!empty($patients_have_prescriptions)) {
            return view('Doctor.patients-list', compact('dr_data', 'dr_email', 'dr_clinic', 'patients_list'),
                ['value_of_doctor_rates' => $value_of_doctor_rates,'patients_have_prescriptions' => $patients_have_prescriptions]);
        }
        else {
            return view('Doctor.patients-list',compact('dr_data', 'dr_email', 'dr_clinic', 'patients_list'),
                ['value_of_doctor_rates' => $value_of_doctor_rates]);
        }

    }


}
