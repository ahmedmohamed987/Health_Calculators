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
                    <span class="description-span">{{ucwords(Session('logged_in_doctor')['first_name']) .' '. ucwords(Session('logged_in_doctor')['last_name'])}}</span>
                </div>
            </div>
            <div class="defination-container">
                <div class="row gutter defination-row mt-4">
                    <span class="defination-span"><i class="fa-solid fa-clipboard"></i> Speciality</span>
                </div>
                <div class="row gutter description-row">
                    <span class="description-span">{{ucfirst(Session('logged_in_doctor')['specialty_type'])}}</span>
                </div>
            </div>
            <div class="defination-container">
                <div class="row gutter defination-row mt-4">
                    <span class="defination-span"><i class="fa-solid fa-location-dot"></i> Location</span>
                </div>
                <div class="row gutter description-row">
                    <span class="description-span">
                        @if(is_null($dr_data->clinic_id))
                            {{Session('logged_in_doctor')['address']}}
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
                        @if(is_null($dr_data->clinic_id))
                            {{Session('logged_in_doctor')['phone_number']}}
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
            <div class="add-appointment mb-5">
                <span class="schedule-header d-block">Patients list</span>
                @foreach($patients_list as $patient)
                    <div class="patient-card">
                        <div class="row gutter">
                            <div class="col">
                                <p class="patient-name">{{ ucwords($patient->first_name) }} {{ ucwords($patient->last_name) }}</p>
                                <p class="patient-date"><i class="fa-solid fa-calendar-days"></i> {{ date('j- m- Y', strtotime($patient->date)) }}</p>
                            </div>

                            @if(isset($patients_have_prescriptions))
                                @if(in_array($patient->app_id, $patients_have_prescriptions) )
                                    <div class="col end">
                                        <a href="{{ route('edit.prescription', $patient->app_id) }}"><button class="btn btn-primary"><i class="fa-solid fa-clipboard"></i> Edit prescription</button></a>
                                    </div>
                                @else
                                    <div class="col end">
                                        <a href="{{ route('add.prescription', $patient->app_id) }}"><button class="btn btn-primary"><i class="fa-solid fa-clipboard"></i> Add prescription</button></a>
                                    </div>
                                @endif
                            @else
                                <div class="col end">
                                    <a href="{{ route('add.prescription', $patient->app_id) }}"><button class="btn btn-primary"><i class="fa-solid fa-clipboard"></i> Add prescription</button></a>
                                </div>
                            @endif

                        </div>
                    </div>
                @endforeach
                <div class="m-4 pag">
                    {{$patients_list->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
