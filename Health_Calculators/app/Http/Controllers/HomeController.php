<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Question;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function GetQuestion(Request $request) {

        if(!session()->has('logged_in_patient')) {
            return redirect()->route('all.login');
        }
        elseif(session()->has('logged_in_patient')) {

            $request->validate([
                'question' => ['required']
            ]);

            $new_question = new Question;
            $new_question->patient_id = session('logged_in_patient')['id'];
            $new_question->question = $request->question;
            $new_question->save();

            return redirect()->route('all.question');
        }
        elseif(session()->has('logged_in_doctor') || session()->has('logged_in_admin') ||
                session()->has('rejected_dr') || session()->has('waiting_dr')) {

                    return redirect()->route('home.page');
        }
    }


    public function ShowHome() {

        $articles = Article::orderBy('id','DESC')->get();
        return view('Public-Views.home', compact('articles'));

    }


}
