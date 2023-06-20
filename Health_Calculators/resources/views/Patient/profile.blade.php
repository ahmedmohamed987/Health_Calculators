@extends('Shared.header')

@section('css')
    <link rel="stylesheet" href="{{url('css/fontawesome-free-6.1.2-web/css/all.min.css')}}">
    <link rel="stylesheet" href="{{url('css/Patient-profile.css')}}">
@endsection

@section('title')
    Patient's profile
@endsection

@section('content')
    <body class="body">
        <div class="container">
            
            <div class="main-body">

                <div class="row gutters-sm">
                    <div class="col-md-4 mb-3">

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img class="imgg" src="{{session('logged_in_patient')['profile_image']}}" alt="Admin"
                                        class="rounded-circle" width="150">
                                    <div class="mt-3 mb-3">
                                        <h3>{{ucwords(session('logged_in_patient')['first_name'])}} {{ucwords(session('logged_in_patient')['last_name'])}}</h3>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card mb-3 mt-3">
                            <div class="card-body txt">
                                <h3>Personal Info:</h3>
                                <div class="row">
                                    <div class="col-sm-3 ">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{$patient->email}}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Phone number</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{session('logged_in_patient')['phone_number']}}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-4">Address</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{session('logged_in_patient')['address']}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(isset($booked_appointments))
                    <div class="col-md-8 col-sm-12">
                        <div class="containeer rounded mt-2 bg-white p-md-6">
                            <div class="h2 font-weight-bold">Appointments schedule:</div>
                            <div class="table-responsive ">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Time</th>
                                            <th scope="col">Location</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i=0
                                        @endphp
                                     @foreach ($booked_appointments as $key => $appointment)
                                     <tr class="bg-blue">
                                         <td class="pt-2">
                                             <img src="{{$appointment->profile_image}}" class="immg rounded-circle" alt="">
                                             <h6 class="pt-4">Dr {{ucwords($appointment->first_name)}} {{ucwords($appointment->last_name)}}</h6>
                                         </td>
                                         <td class="pt-4 dataa">{{date('j-m-Y', strtotime($appointment->date))}}</td>
                                         <td class="pt-4 time">
                                             @if(!empty($slots[$i][$appointment->slot_id +1]['slots_start_time']))
                                                 {{$slots[$i][$appointment->slot_id +1]['slots_start_time']}}
                                             @endif
                                             @php
                                                 $i++
                                             @endphp
                                         </td>
                                         <td class="pt-4">
                                             <span class="pl-5">
                                                 <p>{{$appointment->clinic_address}}</p>
                                             </span>
                                         </td>
                                         <td>
                                             <button type="button" class=" btn-close" data-bs-toggle="modal" data-bs-target={{"#cancelModal".$key}}  ></button>

                                             <div class="modal" tabindex="-1" id={{"cancelModal".$key}}>
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h5 class="modal-title fs-4">Cancel Appointment</h5>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="fw-medium fs-5">To get back your money, please contact us.</p>
                                                        <span class="fw-medium fs-5">
                                                            <i class="fa-solid fa-phone" style="color:blue; padding:10px"></i>
                                                            {{ $appointment->phone_number }}
                                                        </span>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="{{ route('cancel.app', $appointment->app_id) }}" class="btn btn-primary confirm">Confirm</a>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>

                                         </td>
                                         <tr id="spacing-row px-2">
                                           
                                        </tr>
                                     </tr>
                                 @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @else

                    <div class="card mb-3 card-wrapper" >
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ url("img/img.jpeg") }}" class="img-fluid rounded-start imgs" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body ">
                                    <br>
                                    <h5 class="card-title ">There is no booked appointments yet.</h5>
                                    <p class="card-text info">Now you can book appointment with our best consultants and specialists
                                        in fitness and nutirtion filed to improve your lifestyle and achieve your goal easily.</p>
                                    <br>
                                        <div class="btnnasser-wrapper">
                                            <a href="{{route('search_doctors')}}"><button class="btnnasser">Book appointment</button></a>
                                        </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    @endif
                </div>


            </div>
        </div>
    </body>
@endsection


