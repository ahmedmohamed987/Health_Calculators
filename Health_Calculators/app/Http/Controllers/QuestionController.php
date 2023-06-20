<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Req;

class QuestionController extends Controller
{
    public function AskQuestion() {

        return view('Patient.question');
    }


    public function SaveQuestion( Request $request) {

        $request->validate([
            "question"=>['required']
        ]);

        $new_question = new Question;
        $new_question->question = $request->question;
        $new_question->patient_id = session('logged_in_patient')['id'];
        $new_question->save();

        return back();

    }


    public function AllQuestions() {

        $ques = Question::get();
        $ques = Question::OrderBy('id','DESC')->paginate(10);
        $patients = Patient::get();
        $answers = Answer::OrderBy('id','ASC')->get();
        $doctors = Doctor::get();
        $dr_reqs = Req::where('request_status', '=', 1)->get();

        return view('Patient.question')->with('all_questions', $ques)
        ->with('all_patients', $patients)->with('all_answers', $answers)
        ->with('all_dr_reqs', $dr_reqs)->with('all_doctors', $doctors);
    }


    public function AnswerQuestion(Request $request , $id) {

        $request->validate([
            'doctor_reply'=>['required']
        ]);

        $new_answer = new Answer;
        $dr_id=session('logged_in_doctor')['id'];
        $doctor = Doctor::where('request_id', '=', $dr_id)->first();
        $new_answer->answer = $request->doctor_reply;
        $new_answer->doctor_id = $doctor->id;
        $new_answer->question_id = $id;
        $new_answer->save();
        return redirect()->route('all.question')->withFragment('row');
    }


    public function PatientReply(Request $request, $id) {

        $request->validate([
            'patient_reply' => ['required']
        ]);

        $new_answer = new Answer;
        $pa_id=session('logged_in_patient')['id'];
        $patient = Patient::where('id', '=', $pa_id)->first();
        $new_answer->answer = $request->patient_reply;
        $new_answer->patient_id = $patient->id;
        $new_answer->question_id = $id;
        $new_answer->save();
        return redirect()->route('all.question')->withFragment('row');
    }


    public function DeleteQuestion($id) {

        if(session()->has('logged_in_admin')) {
            $question = Question::find($id);
            $question->delete();
            return back();
        }
        else {
            return back();
        }
    }


    public function DeleteAnswer($id) {

        if(session()->has('logged_in_admin')) {
            $answer = Answer::find($id);
            $answer->delete();
            return back();
        }
        else {
            return back();
        }
    }

}
