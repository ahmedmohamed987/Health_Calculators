@extends('Shared.header')

@section('css')
    <link rel="stylesheet" href="{{url('css/all.min.css')}}">
    <link rel="stylesheet" href="{{url('css/questions.css')}}">
@endsection

@section('title')
    Questions
@endsection

@section('content')
    <div class="body-container">
        <div class="row gutter">
            <div class="col">
                <span class="questions-header">Questions:</span>
            </div>
            @if(Session::has('logged_in_patient'))
            <div class="col end">
                <p>
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#addQuestion" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa-solid fa-plus"></i> Add question
                    </button>
                </p>
            </div>
            @endif
            <div class="collapse" id="addQuestion">
                <div class="card card-body answer-card">
                    <form action="{{route('question.save')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="askQuestion" class="form-label">Enter your question</label>
                            <textarea name="question" class="form-control question-area" id="askQuestion" rows="3" placeholder="..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>
        @foreach ($all_questions as $key=>$question )
        @foreach ($all_patients as $patient )
        @if($question->patient_id == $patient->id)
        <div class="question-card">
            <div class="row gutter" id='row'>
                <div class="col-2 col-md-1 patient-image-col">
                    <img src="{{$patient->profile_image}}" class="patient-image" alt="">
                </div>
                <div class="col">
                    <div class="row gutter">
                        <div class="col">
                            <span class="patient-name">
                                @if($question->patient_id == $patient->id)
                                    {{ucwords($patient->first_name)}} {{ucwords($patient->last_name)}}
                                @endif
                            </span>
                        </div>
                        <!-- ONLY VISIBLE FOR ADMINS -->
                        @if (Session::has("logged_in_admin"))
                        <div class="col end">
                            <a href="{{route('del.question', ['id' => $question->id])}}" class="delete-question"><i class="fa-solid fa-trash"></i></a>
                        </div>
                        @endif
                        <!-- ----------------------- -->
                    </div>
                    <div class="row gutter">
                        <span class="patient-question">{{ucfirst($question->question)}}</span>
                    </div>
                    <!-- ------------------------ -->
                    <div class="row gutter">
                        @foreach ($all_questions as $ques )
                        @php $dr_reply=0 @endphp
                        @foreach ($all_answers as $ans )
                        @foreach ($all_doctors as $dr )
                        @foreach ($all_dr_reqs as $req )
                        @if($ans->doctor_id == $dr->id && $dr->request_id == $req->id && $req->request_status == 1)
                        @if ($ans->question_id == $question->id )
                        @php
                            $dr_reply++;
                        @endphp
                        @endif
                        @endif
                        @endforeach
                        @endforeach
                        @endforeach
                        @endforeach
                        @foreach ($all_questions as $ques )
                        @php $patient_reply=0 @endphp
                        @foreach ($all_answers as $ans )
                        @foreach ($all_patients as $patient )
                        @if($ans->patient_id == $patient->id )
                        @if ($ans->question_id == $question->id)
                        @php
                            $patient_reply++;
                        @endphp
                        @endif
                        @endif
                        @endforeach
                        @endforeach
                        @endforeach
                        <p>
                            <button class="replies-btn" type="button" data-bs-toggle="collapse" data-bs-target={{"#answerId".$key}} aria-expanded="false" aria-controls="collapseExample">
                                {{$dr_reply + $patient_reply}} Replies
                            </button>
                        </p>
                        @foreach ( $all_answers as $answer )
                        @foreach ($all_doctors as $dr )
                        @if($answer->question_id == $question->id )
                        @foreach ($all_dr_reqs as $req )
                        @if ($answer->doctor_id == $dr->id )
                        @if ($dr->request_id == $req->id)
                        <div class="collapse" id={{"answerId".$key}}>
                            <div class="card card-body answer-card">
                                <div class="row gutter">
                                    <div class="col-2 col-md-1 center">
                                        <img src="{{$dr->profile_image}}" class="doctor-image" alt="">
                                    </div>
                                    <div class="col">
                                        <div class="row gutter">
                                            <div class="col">
                                                <span class="doctor-name">
                                                    {{ucwords($req->first_name)}} {{ucwords($req->last_name)}}
                                                    <i class="fa-sharp fa-solid fa-circle-check" style="color: rgb(11, 11, 255)""></i>
                                                </span>
                                            </div>
                                            <!-- ONLY VISIBLE FOR ADMINS -->
                                            @if(Session::has('logged_in_admin'))
                                            <div class="col end">
                                                <a href="{{route('del.answer', ['id'=> $answer->id])}}" class="delete-question"><i class="fa-solid fa-trash"></i></a>
                                            </div>
                                            @endif
                                            <!-- ----------------------- -->
                                        </div>
                                        <div class="row gutter">
                                            <span class="doctor-answer">
                                                {{ucfirst($answer->answer)}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endif
                        @endforeach
                        @endif
                        @endforeach
                        @endforeach

                        @foreach ($all_answers as $ans )
                        @foreach ($all_patients as $patient )
                        @if ($ans->patient_id == $patient->id && $ans->question_id == $question->id)
                        <div class="collapse" id={{"answerId".$key}}>
                            <div class="card card-body answer-card">
                                <div class="row gutter">
                                    <div class="col-2 col-md-1 center">
                                        <img src="{{$patient->profile_image}}" class="doctor-image" alt="">
                                    </div>
                                    <div class="col">
                                        <div class="row gutter">
                                            <div class="col">
                                                <span class="doctor-name">
                                                    {{ucwords($patient->first_name)}} {{ucwords($patient->last_name)}}
                                                </span>
                                            </div>
                                            <!-- ONLY VISIBLE FOR ADMINS -->
                                            @if(Session::has('logged_in_admin'))
                                            <div class="col end">
                                                <a href="{{route('del.answer', ['id'=> $ans->id])}}" class="delete-question"><i class="fa-solid fa-trash"></i></a>
                                            </div>
                                            @endif
                                            <!-- ----------------------- -->
                                        </div>
                                        <div class="row gutter">
                                            <span class="doctor-answer">
                                                {{ucfirst($ans->answer)}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        @endforeach
                        @if(Session::has('logged_in_patient'))
                        <div class="row gutter">
                            <form action="{{route('patient.reply', $question->id)}}" method="POST">
                                @csrf
                                <div class="input-group mb-3 reply-btn">
                                    <input type="text" name="patient_reply" class="form-control" placeholder="Add reply" aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <button class="btn btn-primary" type="submit" id="button-addon2">Reply</button>
                                </div>
                            </form>
                        </div>
                        @endif
                        @if (Session::has('logged_in_doctor'))
                            <div class="row gutter">
                                <form action="{{route('answer.question',  $question->id)}}" method="POST">
                                    @csrf
                                    <div class="input-group mb-3 reply-btn">
                                        <input type="text" name="doctor_reply" class="form-control" placeholder="Add reply" aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <button class="btn btn-primary" type="submit" id="button-addon2">Reply</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach
        @endforeach
    </div>
    <div class="m-4 pag">
        {{$all_questions->links()}}
    </div>
@endsection
