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
            <img src="{{ $dr_data->profile_image }}" class="doctor-profile-img">
            <div class="defination-container1">
                <div class="defination-container">
                    <div class="row gutter defination-row mt-4">
                        <span class="defination-span"><i class="fa-solid fa-user"></i> Name</span>
                    </div>
                    <div class="row gutter description-row">
                        <span class="description-span">{{ ucwords($dr_request->first_name) }}  {{ ucwords($dr_request->last_name) }}</span>
                    </div>
                </div>
                <div class="defination-container">
                    <div class="row gutter defination-row mt-4">
                        <span class="defination-span"><i class="fa-solid fa-clipboard"></i> Speciality</span>
                    </div>
                    <div class="row gutter description-row">
                        <span class="description-span">{{ ucfirst($dr_request->specialty_type) }}</span>
                    </div>
                </div>
                <div class="defination-container">
                    <div class="row gutter defination-row mt-4">
                        <span class="defination-span"><i class="fa-solid fa-location-dot"></i> Location</span>
                    </div>
                    <div class="row gutter description-row">
                        <span class="description-span">
                            @if (empty($dr_clinic->clinic_address))
                                {{ $dr_request->address }}
                            @else
                                    {{ $dr_clinic->clinic_address }}
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
                            {{ $dr_request->phone_number }}
                            @else
                            {{ $dr_clinic->phone_number }}
                            @endif
                        </span>
                    </div>
                </div>
                <div class="defination-container">
                    <div class="row gutter defination-row mt-4">
                        <span class="defination-span"><i class="fa-solid fa-envelope"></i> Email</span>
                    </div>
                    <div class="row gutter description-row email-row">
                        <span class="description-span">{{ $dr_email->email }}</span>
                    </div>
                </div>
            </div>
        </div>


        <div class="right-container">

            <span class="schedule-header">About the doctor</span>
            <span class="d-block mb-5">{{ ucfirst($dr_data->bio) }}</span>

            <div class="line"></div>
            @if(session()->has('logged_in_patient'))
            <div class="book-appointment-div">
                <span class="schedule-header d-block">Book appointment</span>
                <table class="appointment-table">
                    <form action="{{ route('patient.bookappointment', $dr_worktime->id) }}" method="post">
                        @csrf
                        <tr>
                            <th colspan="2">Appointment time</th>
                            <th>Select appointment</th>
                        </tr>
                        @php
                            $i=0;
                        @endphp
                        @foreach ($time_slots as $slot)
                            <tr>
                                <td> {{$slot['slots_start_time']}}  </td>
                                <td> {{$slot['slots_end_time']}} </td>
                                <td>
                                    <input type="radio" name="appointment_time" value={{intval($i)}}
                                    @foreach($findAppointment as $appointment)
                                    {{ $appointment->slot_id == intval($i) && $appointment->worktime_id == $dr_worktime->id?'disabled':'' }}
                                    @endforeach

                                    >
                                </td>
                                @php
                                    $i++
                                @endphp
                            </tr>
                        @endforeach

                        

                        <tr>
                            @if ($errors->has('appointment_time'))
                                <div class="alert alert-danger mt-1" role="alert">
                                            {{$errors->first('appointment_time')}}
                                </div>
                            @endif

                            <td colspan="3">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Choose appointment
                                </button>
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" id="modalBodyContent">
                                            <span class="d-block"><b>Doctor:</b>  {{ ucwords($dr_request->first_name) }} {{ ucwords($dr_request->last_name) }}</span>
                                            <span class="d-block"><b>Clinic's name:</b> {{ ucwords($dr_clinic->name) }}</span>
                                            <span class="d-block"><b>Clinic address:</b>
                                                @if(!is_null($dr_clinic->detailed_clinic_address))
                                                    {{ ucfirst($dr_clinic->detailed_clinic_address) }}
                                                @else
                                                    {{ ucfirst($dr_clinic->clinic_address) }}
                                                @endif
                                            </span>
                                            <span class="d-block"><b>Fees:</b> {{ $dr_clinic->fees }} EGP</span>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Pay with <i>Paypal</i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    </form>
                </table>
            </div>
            @endif
        </div>
    </div>
@endsection
