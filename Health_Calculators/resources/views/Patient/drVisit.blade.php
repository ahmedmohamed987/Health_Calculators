@extends('Shared.header')

@section('css')
    <link rel="stylesheet" href="{{url('css/drProfile.css')}}">
@endsection

@section('title')
    Doctor's profile
@endsection

@section('content')
    <div class="body-container">
        <div class="fixed-left">
            <img src="{{$dr_data->profile_image}}" class="doctor-profile-img">
            <div class="defination-container1">
                <div class="defination-container">
                    <div class="row gutter defination-row mt-4">
                        <span class="defination-span"><i class="fa-solid fa-user"></i> Name</span>
                    </div>
                    <div class="row gutter description-row">
                        <span class="description-span">{{ucwords($dr_request->first_name)}} {{ucwords($dr_request->last_name)}}</span>
                    </div>
                </div>
                <div class="defination-container">
                    <div class="row gutter defination-row mt-4">
                        <span class="defination-span"><i class="fa-solid fa-clipboard"></i> Speciality</span>
                    </div>
                    <div class="row gutter description-row">
                        <span class="description-span">{{ucfirst($dr_request->specialty_type)}}</span>
                    </div>
                </div>
                <div class="defination-container">
                    <div class="row gutter defination-row mt-4">
                        <span class="defination-span"><i class="fa-solid fa-location-dot"></i> Location</span>
                    </div>
                    <div class="row gutter description-row">
                        <span class="description-span">
                            @if (empty($dr_clinic->clinic_address))
                                {{$dr_request->address}}
                            @else
                                {{$dr_clinic->clinic_address}}
                            @endif
                        </span>
                    </div>
                </div>
                <div class="defination-container">
                    <div class="row gutter defination-row mt-4">
                        <span class="defination-span"><i class="fa-solid fa-star-half-stroke"></i> Rating</span>
                    </div>
                    @php
                        $rates_value = number_format($value_of_doctor_rates)
                    @endphp
                    <div class="row gutter description-row">
                        <span class="description-span">
                            @for($i = 1; $i <= $rates_value; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                            @for($j = $rates_value+1; $j <= 5; $j++)
                                <i class="fa-regular fa-star"></i>
                            @endfor
                        </span>
                    </div>
                </div>
                <div class="defination-container">
                    <div class="row gutter defination-row mt-4">
                        <span class="defination-span"><i class="fa-solid fa-phone"></i> Phone</span>
                    </div>
                    <div class="row gutter description-row">
                        <span class="description-span">
                            @if (empty($dr_clinic->phone_number))
                                {{$dr_request->phone_number}}
                            @else
                                {{$dr_clinic->phone_number}}
                            @endif
                        </span>
                    </div>
                </div>
                <div class="defination-container">
                    <div class="row gutter defination-row mt-4">
                        <span class="defination-span"><i class="fa-solid fa-envelope"></i> Email</span>
                    </div>
                    <div class="row gutter description-row email-row">
                        <span class="description-span">{{$dr_email->email}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="right-container">
            <span class="schedule-header d-block">About the doctor</span>
            <span class="d-block">{{ucfirst($dr_data->bio)}}</span>

            @if(empty($dr_clinic->detailed_clinic_address))

            @else
                <button class="btn btn-primary rate-btn mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#addQuestion" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fa-solid fa-location-dot"></i> View location in details
                </button>
                <div class="collapse" id="addQuestion">
                    <div class="card card-body answer-card">
                        <!-- WILL BE VISIBLE ONLY FOR CLIENTS -->
                        <span>{{ ucfirst($dr_clinic->detailed_clinic_address) }}</span>
                        <!-- END -->
                    </div>
                </div>
            @endif

            <div class="line mt-3 mb-3"></div>
            @if(session()->has('logged_in_patient'))
                <div class="book-appointment-div">
                    <span class="schedule-header d-block">Book appointment</span>
                    @if($checker != 1)
                        <table class="appointment-table">
                            @if (session()->has('error_msg'))
                            <div class="alert alert-danger mt-1" role="alert">
                                    Sorry! You have booked another appointment at the same time.
                            </div>
                           @endif
                            <tr>
                                <th>
                                    Location
                                </th>
                                <td colspan="2">
                                    {{$dr_clinic->clinic_address}}
                                </td>
                            </tr>
                            @foreach ($dr_worktime as $time )
                            <tr>
                                <th>

                                        @if(!date("j M Y") > date("j M Y", strtotime($time->day)))
                                            @php
                                                echo date("j M Y", strtotime("+7 days", strtotime($time->day)));
                                            @endphp
                                        @else
                                            @php
                                                echo date("j M Y", strtotime($time->day));
                                            @endphp
                                        @endif

                                </th>
                                <td>{{ ucfirst($time->day) }}</td>
                                <td>
                                    <a href="{{route('appointment', [$dr_data->request_id , $time->id])}}" class="btn btn-primary">View appointments</a>
                                </td>
                            </tr>

                            @endforeach
                        </table>

                        <div class="line"></div>

                    @else
                        <div class="patient-card">
                                <div class="row gutter">
                                    <div class="col">
                                        <p class="patient-name">You've already booked an appointment on {{ date('j M Y', strtotime($patient_booked_appointment->date)) }} </p>
                                        <!-- new -->
                                        {{-- <p class="patient-date">From 6:00PM - 8:00PM</p> --}}
                                    </div>
                                    <div class="col end">
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <i class="fa-solid fa-xmark"></i> Cancel appointment
                                        </button>
                                    </div>
                                </div>
                        </div>
                        <div class="line mt-5"></div>
                    @endif
                </div>


                @if($rate_doctor == false)

                @else

                    <div class="rating-div">
                        <span class="schedule-header d-block">Rate the doctor</span>

                        @if(isset($patient_rates))

                            <form action="{{ route('rate.doctor', [$dr_data->request_id]) }}" method="POST">
                                <div class="rating center">
                                    @csrf

                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= (6 - $patient_rates->rate))
                                            <input type="radio" name="star" value="{{ 6 - $i }}" id="star{{ $i }}" checked>
                                            <label for="star{{ $i }}"></label>
                                        @else
                                            <input type="radio" name="star" value="{{ 6 - $i }}" id="star{{ $i }}">
                                            <label for="star{{ $i }}"></label>
                                        @endif
                                    @endfor

                                </div>
                                <button type="submit" class="btn btn-primary rate-btn mb-5">Submit</button>
                            </form>

                        @else

                            <form action="{{ route('rate.doctor', [$dr_data->request_id]) }}" method="POST">
                                <div class="rating center">
                                    @csrf

                                    <input type="radio" name="star" value="5" id="star5">
                                    <label for="star5"></label>

                                    <input type="radio" name="star" value="4" id="star4">
                                    <label for="star4"></label>

                                    <input type="radio" name="star" value="3" id="star3">
                                    <label for="star3"></label>

                                    <input type="radio" name="star" value="2" id="star2">
                                    <label for="star2"></label>

                                    <input type="radio" name="star" value="1" id="star1">
                                    <label for="star1"></label>

                                </div>
                                <button type="submit" class="btn btn-primary rate-btn mb-5">Submit</button>
                            </form>

                        @endif
                    </div>
                @endif
            @endif
        </div>
    </div>
    @if(isset($patient_booked_appointment))
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Cancel appointment</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                To get back your money, please contact us.
                <br>
                <span class="fw-medium  fs-7"> <i class="fa-solid fa-phone "style="color:blue; padding:10px"></i>{{ $patient_booked_appointment->phone_number }}</span>
            </div>
            <div class="modal-footer">
            <a href="{{ route('cancel.app', $patient_booked_appointment->app_id) }}" class="btn btn-danger"><i class="fa-solid fa-xmark"></i> Cancel appointment</a>
            </div>
        </div>
        </div>
    </div>
    @endif
    
@endsection
