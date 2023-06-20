<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Appointment;
use App\Models\Worktime;
use App\Models\Payment;
use Carbon\Carbon;

class PaymentController extends PatientController
{

    // public function Index() {
    //     return view('Patient.payment');
    // }


    public function RequestPayment($fees) {

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $appointment_fees = $fees;

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paymentsuccess'),
                "cancel_url" => route('paymentcancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "EGP",
                        "value" => "$appointment_fees"
                    ]
                ]
            ]
        ]);

        if(isset($response["id"]) && $response["id"] !=  null) {
                    foreach($response["links"] as $links){
                        if($links["rel"] == "approve"){
                            return redirect()->away($links["href"]);
                        }
                    }
            return redirect()->route('paymentindex')->with('error','some error');
        }
        else {
            return redirect()->route('paymentindex')->with('error',$response['messsage'] ?? 'some error');
        }
    }


    public function PaymentSuccess(Request $request) {

        $provider=new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response=$provider->capturePaymentOrder($request['token']);

        if(isset($response["status"]) && $response["status"] ==  'COMPLETED') {

            $payment = new Payment;
            $payment->transaction_id = $response['id'];
            $payment->status = $response['status'];

            $app = new Appointment;
            $app->patient_id = session('logged_in_patient')['id'];
            $app->worktime_id = session('booked_appointment_data')['dr_worktime']->id;
            $app->slot_id = session('booked_appointment_data')['appointment_slot'];
            $app->date = Carbon::parse(date("j M Y", strtotime(session('booked_appointment_data')['dr_worktime']->day)));

            foreach (session('booked_appointment_data')['patient_booked_appointments'] as $appointment) {
                if (
                    $appointment->date >= session('booked_appointment_data')['current_date'] &&
                    Carbon::parse($appointment->date)->equalTo(Carbon::parse($app->date))
                ) {
                    $getBookedAppointment = Worktime::where('id', '=', $appointment->worktime_id)->first();
                    if ($this->MakeSlots(session('booked_appointment_data')['dr_worktime']->start_time, session('booked_appointment_data')['dr_worktime']->end_time)[$app->slot_id + 1]['slots_start_time'] 
                    == $this->MakeSlots($getBookedAppointment->start_time, $getBookedAppointment->end_time)[$appointment->slot_id + 1]['slots_start_time']) {
                        
                        return redirect()->route('get_doctor_profile', [session('booked_appointment_data')['doctor_data']->request_id, session('booked_appointment_data')['dr_worktime']->clinic_id])
                            ->with('error_msg', ' ');
                    }
                }
            }

            $payment->save();
            $app->payment_id = $payment->id;
            $app->save();

            return redirect()->route('patient.profile');
        }
        else {
            return redirect()>route('patient.profile');
        }

    }

    public function PaymentCancel(){
        return redirect()->route('patient.profile');
    }


}
