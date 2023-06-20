<?php

namespace App\Providers;

use DateTime;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Digitalprescription;
use App\Models\Doctor;
use App\Models\Rate;
use App\Models\Worktime;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        view()->composer('*', function ($view) {

            if(session()->has('logged_in_patient')) {

                $patient_deleted_appointments = Appointment::join('worktimes', 'worktimes.id', '=', 'appointments.worktime_id')
                    ->join('doctors','doctors.clinic_id','=','worktimes.clinic_id')
                    ->join('deletedappointments', 'deletedappointments.appointment_id', '=', 'appointments.id')
                    ->join('requests','requests.id','=','doctors.request_id')
                    ->select('*', 'appointments.id as app_id', 'appointments.updated_at')
                    ->where('patient_id', '=', session('logged_in_patient')['id'])
                    ->onlyTrashed()->orderBy('deletedappointments.id','DESC')->take(2)->get();

                $patient_deleted = Appointment::join('worktimes', 'worktimes.id', '=', 'appointments.worktime_id')
                    ->join('doctors','doctors.clinic_id','=','worktimes.clinic_id')
                    ->join('deletedappointments', 'deletedappointments.appointment_id', '=', 'appointments.id')
                    ->join('requests','requests.id','=','doctors.request_id')
                    ->select('*', 'appointments.id as app_id', 'appointments.updated_at')
                    ->where('patient_id', '=', session('logged_in_patient')['id'])
                    ->onlyTrashed()->orderBy('appointments.id', 'DESC')->get();

                $i=array();
                foreach($patient_deleted_appointments as $patient){
                    $i [] = $patient->patient_id;
                }

                $prescriptions = Digitalprescription::join('appointments', 'appointments.id', '=', 'digitalprescriptions.appointment_id')
                    ->join('doctors', 'doctors.id', '=', 'digitalprescriptions.doctor_id')
                    ->join('requests', 'requests.id', '=', 'doctors.request_id')
                    ->select('digitalprescriptions.updated_at', 'requests.first_name', 'requests.last_name','digitalprescriptions.id as pre_id', 'appointments.id as app_id')
                    ->where('appointments.patient_id', '=', session('logged_in_patient')['id'])
                    ->orderBy('digitalprescriptions.id','DESC')->take(2)->get();

                $all_prescriptions = Digitalprescription::join('appointments', 'appointments.id', '=', 'digitalprescriptions.appointment_id')
                    ->join('doctors', 'doctors.id', '=', 'digitalprescriptions.doctor_id')
                    ->join('requests', 'requests.id', '=', 'doctors.request_id')
                    ->select('digitalprescriptions.updated_at', 'requests.first_name', 'requests.last_name','digitalprescriptions.id as pre_id', 'appointments.id as app_id')
                    ->where('appointments.patient_id', '=', session('logged_in_patient')['id'])
                    ->orderBy('digitalprescriptions.id','DESC')->get();

        //    dd($all_prescriptions);
                $patient_canceled_appointment_start_slot = [];
                foreach($patient_deleted as $patient) {
                    $start = new DateTime($patient->start_time);
                    $end = new DateTime($patient->end_time);
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
                            $time_slots[$i] = $start;
                        }
                    }
                    foreach($time_slots as $slotkey=>$value) {
                        if($patient->slot_id == $slotkey-1) {
                            $patient_canceled_appointment_start_slot [$patient->app_id] = $value;
                        }
                    }
                }

                $our_best_doctors = array();
                $all_doctors = Doctor::all();

                foreach($all_doctors as $doctor) {
                    $doctor_rates = Rate::where('doctor_id', '=', $doctor->id)->get();
                    $summation_of_doctor_rates = Rate::where('doctor_id', '=', $doctor->id)->sum('rate');
                    if ($doctor_rates->count() > 0) {
                        $average_of_doctor_rates = $summation_of_doctor_rates / $doctor_rates->count();
                        $sorted_our_best_doctors [$doctor->id] = round($average_of_doctor_rates);
                    }
                }

                if(!empty($sorted_our_best_doctors)) {
                    arsort($sorted_our_best_doctors, SORT_REGULAR);
                    $best_three_doctors = array();
                    $i = 0;
                    foreach ($sorted_our_best_doctors as $k=>$item) {
                        if($i<3) {
                            $best_three_doctors [] = Doctor::leftjoin('requests', 'requests.id', '=', 'doctors.request_id')
                                                    // ->leftjoin('clinics','clinics.id','=','doctors.clinic_id')
                                                    ->select('*', 'doctors.id as doc_id')
                                                    ->where('doctors.id', '=', $k)->first();
                            $i++;
                        }
                        else {
                            break;
                        }
                    }
                    $best_three_doctors_avg = array();
                    $x = 0;
                    foreach($sorted_our_best_doctors as $k=>$dr_avg) {
                        if($x<3) {
                            $best_three_doctors_avg [$k] = $dr_avg;
                            $x++;
                        }
                        else {
                            break;
                        }
                    }

                    // if(empty($i)) {
                    //     $view->with('patient_deleted_appointments', $patient_deleted_appointments)
                    //             ->with('i',$i)->with('patient_deleted', $patient_deleted)
                    //             ->with('patient_canceled_appointment_start_slot', $patient_canceled_appointment_start_slot)
                    //             ->with('prescriptions', $prescriptions)->with('all_prescriptions', $all_prescriptions)
                    //             ->with('best_three_doctors_avg', $best_three_doctors_avg)
                    //             ->with('best_three_doctors', $best_three_doctors);
                    // }
                    // else {
                        $view->with('patient_deleted_appointments', $patient_deleted_appointments)
                                ->with('i',$i)->with('patient_deleted', $patient_deleted)
                                ->with('patient_canceled_appointment_start_slot', $patient_canceled_appointment_start_slot)
                                ->with('prescriptions', $prescriptions)->with('all_prescriptions', $all_prescriptions)
                                ->with('best_three_doctors_avg', $best_three_doctors_avg)
                                ->with('best_three_doctors', $best_three_doctors);
                    // }

                }
                else {
                    // if(empty($i)) {
                    //     $view->with('patient_deleted_appointments', $patient_deleted_appointments)
                    //         ->with('i',$i)->with('patient_deleted', $patient_deleted)
                    //         ->with('patient_canceled_appointment_start_slot', $patient_canceled_appointment_start_slot)
                    //         ->with('prescriptions', $prescriptions)->with('all_prescriptions', $all_prescriptions);
                    // }
                    // else {
                            $view->with('patient_deleted_appointments', $patient_deleted_appointments)
                                ->with('i',$i)->with('patient_deleted', $patient_deleted)
                                ->with('patient_canceled_appointment_start_slot', $patient_canceled_appointment_start_slot)
                                ->with('prescriptions', $prescriptions)->with('all_prescriptions', $all_prescriptions);
                    // }
                }
            }

            elseif (session()->has('logged_in_doctor')) {

                $clinic_data = Doctor::where('request_id', '=', session('logged_in_doctor')['id'])->first();

                if (empty($clinic_data)) {
                    // echo "test";
                    $view->with('new_dr', false);
                } else {
                    $doctor_canceled_appointments = Appointment::leftJoin('deletedappointments', 'deletedappointments.appointment_id', '=', 'appointments.id')
                        ->join('patients', 'patients.id', '=', 'appointments.patient_id')
                        ->join('worktimes', 'worktimes.id', '=', 'appointments.worktime_id')
                        ->select('*', 'appointments.id as app_id', 'appointments.updated_at')
                        // ->where('appointments.id', '=', 'deletedappointments.appointment_id')
                        ->whereNull('deletedappointments.appointment_id')
                        ->where('worktimes.clinic_id', '=', $clinic_data->clinic_id)
                        ->onlyTrashed()->orderBy('appointments.id', 'DESC')->take(2)->get();

                    $doctor_canceled = Appointment::leftJoin('deletedappointments', 'deletedappointments.appointment_id', '=', 'appointments.id')
                        ->join('patients', 'patients.id', '=', 'appointments.patient_id')
                        ->join('worktimes', 'worktimes.id', '=', 'appointments.worktime_id')
                        ->select('*', 'appointments.id as app_id', 'appointments.updated_at')
                        // ->where('appointments.id', '=', 'deletedappointments.appointment_id')
                        ->whereNull('deletedappointments.appointment_id')
                        ->where('worktimes.clinic_id', '=', $clinic_data->clinic_id)
                        ->onlyTrashed()->orderBy('appointments.id', 'DESC')->get();
                    // dd($doctor_canceled);

                    $m = array();
                    foreach ($doctor_canceled_appointments as $doctor) {
                        if ($doctor->appointment_id == null) {
                            $m[] = $doctor->patient_id;
                        }
                    }

                    $canceled_appointment_start_slot = [];
                    foreach($doctor_canceled as $dr) {
                        $start = new DateTime($dr->start_time);
                        $end = new DateTime($dr->end_time);
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
                                $time_slots[$i] = $start;
                            }
                        }
                        foreach($time_slots as $slotkey=>$value) {
                            if($dr->slot_id == $slotkey-1) {
                                $canceled_appointment_start_slot [$dr->app_id] = $value;
                            }
                        }
                    }

                    $doctor_rate = Rate::join('patients', 'patients.id', '=', 'rates.patient_id')
                        ->select('*', 'rates.updated_at')
                        ->where('rates.doctor_id', '=', $clinic_data->id)
                        ->orderBy('rates.id','DESC')->take(2)->get();

                    $all_doctor_rate = Rate::join('patients', 'patients.id', '=', 'rates.patient_id')
                        ->select('*', 'rates.updated_at')
                        ->where('rates.doctor_id', '=', $clinic_data->id)
                        ->orderBy('rates.id','DESC')->get();

                    $our_best_doctors = array();
                    $all_doctors = Doctor::all();

                    foreach($all_doctors as $doctor) {
                        $all_doctor_rates = Rate::where('doctor_id', '=', $doctor->id)->get();
                        $summation_of_doctor_rates = Rate::where('doctor_id', '=', $doctor->id)->sum('rate');
                        if ($all_doctor_rates->count() > 0) {
                            $average_of_doctor_rates = $summation_of_doctor_rates / $all_doctor_rates->count();
                            $sorted_our_best_doctors [$doctor->id] = round($average_of_doctor_rates);
                        }
                    }

                    if(!empty($sorted_our_best_doctors)) {
                        arsort($sorted_our_best_doctors, SORT_REGULAR);
                        $best_three_doctors = array();
                        $i = 0;
                        foreach ($sorted_our_best_doctors as $k=>$item) {
                            if($i<3) {
                                $best_three_doctors [] = Doctor::leftjoin('requests', 'requests.id', '=', 'doctors.request_id')
                                // ->leftjoin('clinics','clinics.id','=','doctors.clinic_id')
                                                        ->select('*', 'doctors.id as doc_id')
                                                        ->where('doctors.id', '=', $k)->first();
                                $i++;
                            }
                            else {
                                break;
                            }
                        }
                        $best_three_doctors_avg = array();
                        $x = 0;
                        foreach($sorted_our_best_doctors as $k=>$dr_avg) {
                            if($x<3) {
                                $best_three_doctors_avg [$k] = $dr_avg;
                                $x++;
                            }
                            else {
                                break;
                            }
                        }
                        // if (empty($m)) {
                        //     $view->with('doctor_canceled_appointments', $doctor_canceled_appointments)
                        //         ->with('m', $m)->with('doctor_canceled', $doctor_canceled)
                        //         ->with('canceled_appointment_start_slot', $canceled_appointment_start_slot)
                        //         ->with('doctor_rate', $doctor_rate)->with('all_doctor_rate', $all_doctor_rate)
                        //         ->with('best_three_doctors_avg', $best_three_doctors_avg)
                        //         ->with('best_three_doctors', $best_three_doctors);
        //   dd($best_three_doctors);
                        // } else {
                            $view->with('doctor_canceled_appointments', $doctor_canceled_appointments)
                                ->with('m', $m)->with('doctor_canceled', $doctor_canceled)
                                ->with('canceled_appointment_start_slot', $canceled_appointment_start_slot)
                                ->with('doctor_rate', $doctor_rate)->with('all_doctor_rate', $all_doctor_rate)
                                ->with('best_three_doctors_avg', $best_three_doctors_avg)
                                ->with('best_three_doctors', $best_three_doctors);

                        // }
                    }

                    else {
                    //     if (empty($m)) {
                    //         $view->with('doctor_canceled_appointments', $doctor_canceled_appointments)
                    //             ->with('m', $m)->with('doctor_canceled', $doctor_canceled)
                    //             ->with('canceled_appointment_start_slot', $canceled_appointment_start_slot)
                    //             ->with('doctor_rate', $doctor_rate)->with('all_doctor_rate', $all_doctor_rate);

                    //     } else {
                            $view->with('doctor_canceled_appointments', $doctor_canceled_appointments)
                                ->with('m', $m)->with('doctor_canceled', $doctor_canceled)
                                ->with('canceled_appointment_start_slot', $canceled_appointment_start_slot)
                                ->with('doctor_rate', $doctor_rate)->with('all_doctor_rate', $all_doctor_rate);

                        // }
                    }
                }

            }
            else {
                $our_best_doctors = array();
                $all_doctors = Doctor::all();

                foreach($all_doctors as $doctor) {
                    $doctor_rates = Rate::where('doctor_id', '=', $doctor->id)->get();
                    $summation_of_doctor_rates = Rate::where('doctor_id', '=', $doctor->id)->sum('rate');
                    if ($doctor_rates->count() > 0) {
                        $average_of_doctor_rates = $summation_of_doctor_rates / $doctor_rates->count();
                        $sorted_our_best_doctors [$doctor->id] = round($average_of_doctor_rates);
                    }
                }

                if(!empty($sorted_our_best_doctors)) {
                    arsort($sorted_our_best_doctors, SORT_REGULAR);
                    $best_three_doctors = array();
                    $i = 0;
                    foreach ($sorted_our_best_doctors as $k=>$item) {
                        if($i<3) {
                            $best_three_doctors [] = Doctor::leftjoin('requests', 'requests.id', '=', 'doctors.request_id')
                                                    // ->leftjoin('clinics','clinics.id','=','doctors.clinic_id')
                                                    ->select('*', 'doctors.id as doc_id')
                                                    ->where('doctors.id', '=', $k)->first();
                            $i++;
                        }
                        else {
                            break;
                        }
                    }
                    $best_three_doctors_avg = array();
                    $x = 0;
                    foreach($sorted_our_best_doctors as $k=>$dr_avg) {
                        if($x<3) {
                            $best_three_doctors_avg [$k] = $dr_avg;
                            $x++;
                        }
                        else {
                            break;
                        }
                    }

                    if (!empty($best_three_doctors) && !empty($best_three_doctors_avg)) {
                        $view->with('best_three_doctors_avg', $best_three_doctors_avg)
                            ->with('best_three_doctors', $best_three_doctors);
                    }
                }
            }

        });

    }
}
