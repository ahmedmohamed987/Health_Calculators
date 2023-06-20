@extends('Shared.header')

@section('css')
    <link rel="stylesheet" href="{{url('css/left-container.css')}}">
@endsection

@yield('right_container_css')

@section('content')
    <div class="body">
        <div class="row gutter body-row">
            <div class="col-2 left-container">
                @if(!empty($best_three_doctors))
                    <div class="best-doctors-container">
                        <div class="best-doctors-header-div">
                            <span class="best-doctors-header-span">Our best doctors</span>
                        </div>
                        @foreach($best_three_doctors as $key => $doctor)
                        @foreach($best_three_doctors_avg as $docid => $rateavg)
                        @if($docid == $doctor->doc_id)
                            {{-- <table class="best-doctors-table">
                                <tr>
                                    <td rowspan="2" class="center best-doctors-td">
                                        <img src="{{$doctor->profile_image}}" class="left-doctor-img" alt="">
                                    </td>
                                    <td class="best-doctors-td left-doctor-name">
                                        {{ ucwords($doctor->first_name) }} {{ ucwords($doctor->last_name) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="best-doctors-td">
                                        {{ ucfirst($doctor->specialty_type) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                    </td>
                                    @if(Session::has('logged_in_doctor'))
                                        @if(session('logged_in_doctor')['id'] == $doctor->doc_id)
                                            <td colspan="2" class="best-doctors-td pt-2">
                                                <a class="btn btn-primary" href="{{ route('drprofile') }}" role="button">Book appointment</a>
                                            </td>
                                        @else
                                            <td colspan="2" class="best-doctors-td pt-2">
                                                <a class="btn btn-primary" href="{{ route('get_doctor_profile', $doctor->doc_id) }}" role="button">Book appointment</a>
                                            </td>
                                        @endif
                                    @else
                                        <td colspan="2" class="best-doctors-td pt-2">
                                            <a class="btn btn-primary" href="{{ route('get_doctor_profile', $doctor->doc_id) }}" role="button">Book appointment</a>
                                        </td>
                                    @endif
                                </tr>
                            </table> --}}

                            <div class="row gutter">
                                <div class="col-3 p-3">
                                    <img src="{{$doctor->profile_image}}" class="left-doctor-img" alt="">
                                </div>
                                <div class="col p-3">
                                    <span class="left-doctor-name d-block">{{ ucwords($doctor->first_name) }} {{ ucwords($doctor->last_name) }}</span>
                                    <span class="left-doctor-speciality d-block">{{ ucfirst($doctor->specialty_type) }}</span>
                                    @if(Session::has('logged_in_doctor'))
                                        @if(session('logged_in_doctor')['id'] == $doctor->request_id)
                                        <a href="{{ route('drprofile') }}" class="btn btn-primary left-book-btn">Book appointment</a>
                                        @else
                                        <a href="{{ route('get_doctor_profile', $doctor->request_id) }}" class="btn btn-primary left-book-btn">Book appointment</a>
                                        @endif
                                    @else
                                    <a href="{{ route('get_doctor_profile', $doctor->request_id) }}" class="btn btn-primary left-book-btn">Book appointment</a>
                                    @endif
                                </div>
                            </div>

                            <div class="left-line"></div>

                            <div class="left-line"></div>
                        @endif
                        @endforeach
                        @endforeach


                    </div>
                @endif

                <div class="best-doctors-container center">
                    <div class="best-doctors-header-div">
                        <span class="best-doctors-header-span">Health calculators</span>
                    </div>
                    {{-- <div class="mt-3">
                        <span class="left-container-span">Have you tried our BMI calculator ?</span>
                        <a class="btn btn-outline-primary d-block left-btn" href="{{ route('bmi.calculator') }}" role="button">Try now</a>
                    </div> --}}

                    {{-- <div class="mt-3">
                        <span class="left-container-span">Have you tried our daily calories calculator ?</span>
                        <a class="btn btn-outline-primary d-block left-btn" href="{{ route('daily.calculator') }}" role="button">Try now</a>
                    </div> --}}

                    <div class="mt-3">
                        <span class="left-container-span">Have you tried our calculators ?</span>
                        <a class="btn btn-outline-primary d-block left-btn" href="{{ route('home.page')."#services-div" }}" role="button">Try now</a>
                    </div>
                </div>

            </div>

            @yield('right_container')

        </div>
    </div>

@endsection
