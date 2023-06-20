@extends('Shared.header')
@section('css')
<link rel="stylesheet" href="{{url('css/home.css')}}">
@endsection
@section('title')
    Home
@endsection
@section('content')
    <div class="top-div">
        <div class="top-text-container">
            <span class="top-div-header1">Health Calculators</span>
            <span class="top-div-header2">In our system, we help you to improve your lifestyle to save your health, we give you some services to facilitate your nutrition lifestyle improvement and avoid the injury of many dangerous
                diseases.If you have a problem you can book an appointment with the best consultants or specialists in nutrition.
            </span>
            @if(!Session::has('logged_in_admin') &&
                !Session::has('logged_in_doctor') &&
                !Session::has('logged_in_patient') &&
                !Session::has ('rejected_dr') &&
                !Session::has('waiting_dr'))
            <a href="{{ route('patient.signup') }}" class="btn btn-outline-dark mt-3">Sign up now!!</a>
            @endif
        </div>
        <div class="calculators-div">
            <span class="appointment-span">Try our calculators</span>
            <a href="#services-div" type="button" class="btn btn-outline-primary appointment-btn">Get started</a>
        </div>
    </div>
    <div class="top-margin"id="services-div"></div>
    <div class="services-div mb-5">
        <div class="services-header ">Our Calculators</div>
        <div class="row gutter services-row">
            <div class="col services-col" data-aos="slide-up" data-aos-delay="50" data-aos-once="true">
                <div class="services-card ">
                    <span class="card-logo"><i class="fa-sharp fa-solid fa-calculator"></i></span>
                    <span class="card-header">Body Mass Index</span>
                    <span class="card-span">You can calculate your body mass index using our system calculators indicating total body fat.</span>
                    <a href="{{ route('bmi.calculator') }}" class="btn btn-primary services-btn">Try now</a>
                </div>
            </div>
            <div class="col services-col" data-aos="slide-up" data-aos-delay="50" data-aos-once="true">
                <div class="services-card ">
                    <span class="card-logo"><i class="fa-sharp fa-solid fa-calculator"></i></span>
                    <span class="card-header">Daily Calories</span>
                    <span class="card-span">You can calculate your daily calories intake using our system calculators.</span>
                    <a href="{{ route('daily.calculator') }}" class="btn btn-primary services-btn">Try now</a>
                </div>
            </div>
            <div class="col services-col" data-aos="slide-up" data-aos-delay="100" data-aos-once="true">
                <div class="services-card ">
                    <span class="card-logo"><i class="fa-solid fa-burger"></i></span>
                    <span class="card-header">Meal Calories</span>
                    <span class="card-span">Using AI, our system can calculate the calories in your meal by uploading its photo.</span>
                    <a href="{{ route('meal.calculator') }}" class="btn btn-primary services-btn">Try now</a>
                </div>
            </div>
        </div>
    </div>

    <div class="line" id="articles-div"></div>

    <div class="services-div mb-5">

        <div class="services-header" data-aos="fade-in" data-aos-once="true">Articles</div>
        <div class="row gutter services-row">

            @if ($articles->isEmpty())

            <p class="no-articles-p">No articles here...</p>
            @else
            @php
                $i =0;
            @endphp
            @foreach ($articles as $article )
            @if($i<3)
            <div class="col articles-col">
                <div class="card article-card">
                    <img src="{{$article->image}}" class="card-img-top articles-card-img" alt="...">
                    <div class="card-body">
                        <p class="card-text card-article-header">{{ucwords(substr($article->title,0 ,48))}}..</p>
                    </div>
                    <div class="card-details">
                        <div class="row gutter">
                            <div class="col start"><a class="view-article-btn" href="{{route('read.article', $article->id)}}">View article</a></div>
                            <div class="col end article-date">{{date('j-m-Y', strtotime($article->updated_at))}} <i class="fa-solid fa-calendar-days"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $i++
            @endphp
            @else
            @endif
            @endforeach

        </div>
        <a class="btn btn-primary more-articles-btn" href="{{route('all.articles')}}">Show more</a>
        @endif
    </div>


    <div class="line mt-5"></div>

    <div class="questions-div mt-5 mb-5">
        <div class="services-header" data-aos="fade-in" data-aos-anchor-placement="bottom-bottom" data-aos-once="true">Ask Questions</div>
        <div class="questions-card" data-aos="fade-in" data-aos-once="true">
            <div class="questions-opacity"></div>
            <span class="questions-header">Have any questions?</span>
            <form action="{{route('get.question')}}" method="POST" class="questions-form mt-3">
                @csrf
                <textarea name="question" required placeholder="Enter your question..." class="form-control question-textarea"></textarea>
                <button type="submit" class="btn btn-outline-light m-3">Submit</button>
            </form>

        </div>
    </div>

    <div class="line"></div>
    @if(!empty($best_three_doctors))
        <div class="doctors-div mt-5 mb-5">
            <div class="services-header" data-aos="fade-in" data-aos-anchor-placement="bottom-bottom" data-aos-once="true">Our Best Doctors</div>
            <div class="row gutter services-row">

            @foreach($best_three_doctors as $key => $doctor)
                @foreach($best_three_doctors_avg as $docid => $rateavg)
                    @if($docid == $doctor->doc_id)

                        <div class="col doctors-col" data-aos="slide-up" data-aos-once="true">
                            @if(Session::has('logged_in_doctor'))
                                @if(session('logged_in_doctor')['id'] == $doctor->request_id)
                                    <a class="links" href="{{route('drprofile')}}">
                                        <div class="doctors-card ">
                                            <img src="{{$doctor->profile_image}}" alt="" class="doctor-image">
                                            <span class="doctor-name">{{ ucwords($doctor->first_name) }} {{ ucwords($doctor->last_name) }}</span>
                                            <span class="doctor-speciality">{{ ucfirst($doctor->specialty_type) }}</span>
                                            <span class="doctor-rating"><i class="fa-regular fa-star"></i>{{ $rateavg }}/5</span>
                                        </div>
                                    </a>
                                @else
                                    <a class="links" href="{{route('get_doctor_profile', $doctor->request_id)}}">
                                        <div class="doctors-card ">
                                            <img src="{{$doctor->profile_image}}" alt="" class="doctor-image">
                                            <span class="doctor-name">{{ ucwords($doctor->first_name) }} {{ ucwords($doctor->last_name) }}</span>
                                            <span class="doctor-speciality">{{ ucfirst($doctor->specialty_type) }}</span>
                                            <span class="doctor-rating"><i class="fa-regular fa-star"></i>{{ $rateavg }}/5</span>
                                        </div>
                                    </a>
                                @endif
                            @else
                                <a class="links" href="{{route('get_doctor_profile', $doctor->request_id)}}">
                                    <div class="doctors-card ">
                                        <img src="{{$doctor->profile_image}}" alt="" class="doctor-image">
                                        <span class="doctor-name">{{ ucwords($doctor->first_name) }} {{ ucwords($doctor->last_name) }}</span>
                                        <span class="doctor-speciality">{{ ucfirst($doctor->specialty_type) }}</span>
                                        <span class="doctor-rating"><i class="fa-regular fa-star"></i>{{ $rateavg }}/5</span>
                                    </div>
                                </a>
                            @endif
                        </div>

                    @endif
                @endforeach
            @endforeach

            </div>
        </div>

    @else

    @endif
    <div class="footer-margin"></div>

    <footer>
        <div class="footer-opacity"></div>
        <div class="appointment-div">
            <span class="appointment-span">Book an appointment now!</span>
            <a href="{{route('search_doctors')}}" type="button" class="btn btn-outline-primary appointment-btn"><i class="fa-solid fa-magnifying-glass"></i> Search for specialists</a>
        </div>
        <div class="footer-div">
            <div class="footer-links-container">
                <a href="{{route('home.page')}}" class="footer-link">Home</a>
                <a href="{{route('all.question')}}" class="footer-link">FAQ</a>
                <a href="#services-div" class="footer-link">Calculators</a>
                <a href="#articles-div" class="footer-right-link">Articles</a>
                {{-- <a href="" class="footer-right-link">About us</a> --}}
            </div>
            <span class="copyrights-span">Copyrights &copy; 2023 Health calculators. All rights reserved</span>
        </div>
    </footer>
@endsection
