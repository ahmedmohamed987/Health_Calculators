<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Alluser;
use App\Models\Worktime;
use App\Models\Appointment;
use App\Models\Digitalprescription;
use App\Models\Governorate;
use App\Models\Rate;
use App\Models\Doctor;
use App\Models\Req;
use App\Models\Clinic;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;



class PatientController extends Controller
{
    public function RegisterAsPatient() {

        $governorates = Governorate::all();
        return view('Patient.sign-up', compact('governorates'));
    }


    public function SavePatient(Request $request) {
        
        Session::flash('sign_up_patient', ['email' => $request->email, 'first_name' => $request->first_name,
            'last_name' => $request->last_name, 'age' => $request->age, 'gender' => $request->gender,
            'phone_number' => $request->phone_number]);

        $request->validate([
            'first_name' => ['required', 'regex:/^[\pL\s]+$/u'],
            'last_name' => ['required', 'regex:/^[\pL\s]+$/u'],
            'email' => ['required', 'email', 'unique:allusers'],
            'password' => ['required', 'min:8', 'max:16'],
            'age' => ['required', 'numeric', 'min:12', 'max:100'],
            'gender' => ['required'],
            'address' => ['required'],
            'phone_number' => ['required', 'numeric', 'regex:/(01)[0-9]{9}/']
        ]);

        $new_patient = new Patient;
        $new_user = new Alluser;

        if ((($request->age) < 12) || (($request->age) > 100)) {
            return redirect()->route('patient.signup');
        } else {
            $new_user->email = $request->email;
            $new_user->password = Hash::make($request->password);
            $new_user->role = 1;
            $new_user->save();
            $new_patient->first_name = $request->first_name;
            $new_patient->last_name = $request->last_name;
            $new_patient->age = $request->age;
            $new_patient->gender = $request->gender;
            $new_patient->address = $request->address;
            $new_patient->phone_number = $request->phone_number;
            $new_patient->user_id = $new_user->id;
            $new_patient->profile_image = url('/img/default.jpg');
            $new_patient->save();

            return redirect()->route('all.login');
        }

    }


    public function OpenPatientProfile() {

        if (session('logged_in_patient')) {
            $patient = Alluser::where('id', '=', session('logged_in_patient')['user_id'])->first();
            $current_date = Carbon::now()->toDateString();
            $booked_appointments = Appointment::where('patient_id', '=', session('logged_in_patient')['id'])
                ->where('date', '>=', $current_date)
                ->join('worktimes', 'worktimes.id', '=', 'appointments.worktime_id')
                ->join('doctors', 'doctors.clinic_id', '=', 'worktimes.clinic_id')
                ->join('requests', 'requests.id', '=', 'doctors.request_id')
                ->join('clinics', 'clinics.id', '=', 'worktimes.clinic_id')
                ->select('*', 'appointments.id as app_id')
                ->orderBy('appointments.date', 'ASC')
                ->get();

            foreach ($booked_appointments as $app) {
                $workingtime_slots[] = $this->MakeSlots($app->start_time, $app->end_time);
            }

            if (!empty($workingtime_slots)) {
                return view('Patient.profile', compact('patient', 'booked_appointments'), ['slots' => $workingtime_slots]);
            }
            else {
                return view('Patient.profile', compact('patient'));
            }
        }

    }


    public function bookAppointment(Request $request, $id) {

        $request->validate([
            'appointment_time' => 'required'
        ]);

        if (session()->has('logged_in_patient')) {

            $currentDate = Carbon::now()->toDateString();
            $dr_worktime = Worktime::where('id', '=', $id)->first();
            $findAppointment = Appointment::where('patient_id', '=', session('logged_in_patient')['id'])->get();
            $clinic_data = Clinic::where('id', '=', $dr_worktime->clinic_id)->first();
            $doctor_data = Doctor::where('clinic_id', '=', $dr_worktime->clinic_id)->first();

            session()->pull('booked_appointment_data');
            session()->put('booked_appointment_data', ['current_date' => $currentDate, 'dr_worktime' => $dr_worktime,
                            'patient_booked_appointments' => $findAppointment, 'appointment_slot' => $request->appointment_time, 'doctor_data' => $doctor_data]);

            return redirect()->route('requestpayment', $clinic_data->fees);
        }

    }


    public function MakeSlots($start, $end) {

        $start = new DateTime($start);
        $end = new DateTime($end);
        $startTime = $start->format('h:i A');
        $endTime = $end->format('h:i A');
        $i = 0;
        $time_slots = [];

        while (strtotime($startTime) <= strtotime($endTime)) {

            $start = $startTime;
            $end = date('h:i A', strtotime('+30 minutes', strtotime($startTime)));
            $startTime = date('h:i A', strtotime('+30 minutes', strtotime($startTime)));
            $i++;
            if (strtotime($startTime) <= strtotime($endTime)) {

                $time_slots[$i]['slots_start_time'] = $start;
                $time_slots[$i]['slots_end_time'] = $end;
            }
        }
        return $time_slots;

    }


    public function CancelAppointment($id) {

        if (session()->has('logged_in_patient')) {

            $deleted_appointment = Appointment::find($id);
            $deleted_appointment->delete();

            return redirect()->back();
            // return redirect()->route('patient.profile');
        }
        else {
            return redirect()->back();
        }

    }


    public function RateDoctor(Request $request, $id) {

        $request->validate([
            'star' => 'required'
        ]);

        $doctor = Doctor::where('request_id', '=', $id)->first();
        $old_rate = Rate::where('patient_id', '=', session('logged_in_patient')['id'])
                        ->where('doctor_id', '=', $doctor->id)->first();

        if(empty($old_rate)) {

            $rate = new Rate;
            $rate->patient_id = session('logged_in_patient')['id'];
            $rate->doctor_id = $doctor->id;
            $rate->rate = $request->star;
            $rate->save();

            return back();
        }
        else {

            $old_rate->rate = $request->star;
            $old_rate->save();

            return back();
        }

    }


    public function ViewPatientPrescriptions() {

        $patient_prescriptions = Digitalprescription::join('doctors', 'doctors.id', '=', 'digitalprescriptions.doctor_id')
            ->join('requests', 'requests.id', '=', 'doctors.request_id')
            ->join('appointments', 'appointments.id', '=', 'digitalprescriptions.appointment_id')
            ->select('*', 'digitalprescriptions.id as prescription_id', 'appointments.date as app_date')
            ->where('appointments.patient_id', '=', session('logged_in_patient')['id'])
            ->orderBy('digitalprescriptions.id', 'DESC')->get();

        return view('Patient.all-prescriptions', compact('patient_prescriptions'));

    }


    public function ViewPrescription($p_id) {

        $prescription = Digitalprescription::join('doctors', 'doctors.id', '=', 'digitalprescriptions.doctor_id')
            ->join('requests', 'requests.id', '=', 'doctors.request_id')
            ->join('clinics', 'clinics.id', '=', 'doctors.clinic_id')
            ->join('appointments', 'appointments.id', '=', 'digitalprescriptions.appointment_id')
            ->join('allusers', 'allusers.id', '=', 'requests.user_id')
            ->select('*', 'digitalprescriptions.id as prescription_id', 'appointments.date as app_date')
            ->where('appointments.patient_id', '=', session('logged_in_patient')['id'])
            ->where('digitalprescriptions.id', '=', $p_id)
            ->first();

        $medicines = Medicine::where('prescription_id', '=', $p_id)->get();

        return view('Patient.digital-prescription', compact('prescription', 'medicines'));

    }




}
