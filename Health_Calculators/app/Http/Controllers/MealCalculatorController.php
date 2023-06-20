<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \GuzzleHttp\Client;
use \GuzzleHttp\Psr7\Request as guzzlereq;
use Illuminate\Support\Facades\Http;
use  Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class MealCalculatorController extends Controller
{
    public function ShowMealCalculator() {

        if(((!session()->has('logged_in_patient')) &&(!session()->has('logged_in_doctor'))&&(!session()->has('logged_in_admin')))) {
            // return bac;
            return redirect()->route('all.login');
        }
        else {
            return view('Public-Views.meal-calories');
        }

    }


    public function GetMealImage(Request $request) {

        $request->validate([
            "meal_img" => ['required', 'max:2000']//200MB
        ], [
            'meal_img.required' => 'Meal image field is required'
        ]);

        $meal_img_name = time(). '.' . $request->meal_img->extension();
        $img = $request->meal_img->move(public_path('meal_images'), $meal_img_name);

        $client = new Client();
        $req = new guzzlereq('POST', 'http://127.0.0.1:5000/predict');
        $response = $client->send($req, [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => fopen($img, 'r')
                ]
            ]
        ]);

        $meal_name = $response->getBody()->getContents();
        $result = json_decode($meal_name, true);
        $meal_calories = $this->FetchCalories($result['MealName']);

        Session::flash('mealname', $result['MealName']);
        Session::flash('meal_calories', $this->ConvertToEnglish($meal_calories));
        Session::flash('image', $meal_img_name);

        return back();

    }



    public function FetchCalories($prediction) {

        try {
            $url = 'https://www.google.com/search?&q=caloriesin ' . $prediction;
            $response = Http::get($url);
            $scrap = new \Illuminate\Support\HtmlString($response->body());
            $calories = (new Crawler($scrap))->filter('div.BNeawe.iBp4i')->text();

            return $calories;
        }
        catch (\Exception $e) {
            Log::error('Failed to fetch calories: ' . $e->getMessage());
            Session::flash('error', "Can't able to fetch the Calories");

            return null;
        }

    }


    public function ConvertToEnglish($input) {

        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $english = [ 0 ,  1 ,  2 ,  3 ,  4 ,  4 ,  5 ,  5 ,  6 ,  6 ,  7 ,  8 ,  9];

        return str_replace($arabic, $english, $input);
    }


}
