<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DailyCalorieController extends Controller
{
    public function GetDailyCalculator() {

        if(((!session()->has('logged_in_patient')) &&(!session()->has('logged_in_doctor'))&&(!session()->has('logged_in_admin')))) {
            // return back();
            return redirect()->route('all.login');
        }
        else {
            return view('Public-Views.daily-calories');
        }

    }


    public function CalculateDailyCalories(Request $request) {

        $request->validate([
            'gender' => 'required',
            'age' => ['required','numeric','min:12'],
            'height' => ['required','numeric','min:1'],
            'weight' => ['required','numeric','min:1'],
            'goal' => 'required',
            'activitylevel' => 'required'
        ]);

        if($request->gender == "female") {

            $bmr = (10 * $request->weight) + (6.25 * $request->height) - (5 * $request->age) - 161;

            if($request->activitylevel == "sedentary") {
                $amr = $bmr * 1.2;
            }
            elseif($request->activitylevel == "light") {
                $amr = $bmr * 1.375;
            }
            elseif($request->activitylevel == "moderate") {
                $amr = $bmr * 1.55;
            }
            elseif($request->activitylevel == "active") {
                $amr = $bmr * 1.725;
            }
            elseif($request->activitylevel == "veryactive") {
                $amr = $bmr * 1.9;
            }

            if($request->goal == "lose") {
                $daily_calories_intake = round($amr) - 500;
            }
            elseif($request->goal == "gain") {
                $daily_calories_intake = round($amr) + 500;
            }
            elseif($request->goal == "maintain") {
                $daily_calories_intake = round($amr);
            }


        }
        elseif($request->gender == "male") {
            $bmr = (10 * $request->weight) + (6.25 * $request->height) - (5 * $request->age) + 5;

            if($request->activitylevel == "sedentary") {
                $amr = $bmr * 1.2;
            }
            elseif($request->activitylevel == "light") {
                $amr = $bmr * 1.375;
            }
            elseif($request->activitylevel == "moderate") {
                $amr = $bmr * 1.55;
            }
            elseif($request->activitylevel == "active") {
                $amr = $bmr * 1.725;
            }
            elseif($request->activitylevel == "veryactive") {
                $amr = $bmr * 1.9;
            }

            if($request->goal == "lose") {
                $daily_calories_intake = round($amr) - 500;
            }
            elseif($request->goal == "gain") {
                $daily_calories_intake = round($amr) + 500;
            }
            elseif($request->goal == "maintain") {
                $daily_calories_intake = round($amr);
            }
        }

        session()->flash('daily_calorie_calculator', ['gender' => $request->gender, 'age' => $request->age, 'height' => $request->height,
                            'weight' => $request->weight, 'goal'=> $request->goal, 'activitylevel' => $request->activitylevel,
                            'daily_calories_intake' => $daily_calories_intake]);

        return back();
    }


}
