<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BMICalculatorController extends Controller
{
    public function ShowBMICalculator() {

        if(((!session()->has('logged_in_patient')) &&(!session()->has('logged_in_doctor'))&&(!session()->has('logged_in_admin')))) {
            // return back();
            return redirect()->route('all.login');
        }
        else {
            return view('Public-Views.bmi-calculator');
        }

    }


    public function CalculateBMI(Request $request) {

        $request->validate([
            'height' => ['required','numeric','min:1'],
            'weight' => ['required','numeric','min:1'],
        ]);

        $bmi = round($request->weight / ($request->height/100)**2, 1);

        if($bmi <= 18) {
            $bmi_classification = "under weight";
        }
        elseif(18 < $bmi && $bmi <= 25 ) {
            $bmi_classification = "normal";
        }
        elseif(25 < $bmi && $bmi <= 30 ) {
            $bmi_classification = "over weight";
        }
        elseif(30 < $bmi && $bmi <= 35 ) {
            $bmi_classification = "obese type 1";
        }
        elseif(35 < $bmi && $bmi <= 40 ) {
            $bmi_classification = "obese type 2";
        }
        elseif($bmi > 40 ) {
            $bmi_classification = "obese type 3";
        }

        session()->flash('bmi_calculator', ['gender' => $request->gender, 'age' => $request->age, 'height' => $request->height,
                            'weight' => $request->weight, 'bmi_result' => $bmi, 'bmi_classification' => $bmi_classification]);

        return back();

    }
}
