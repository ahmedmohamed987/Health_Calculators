@extends('Shared.left-container')

@section('title')
    Notifications
@endsection

@section('right_container_css')
    <link rel="stylesheet" href="{{url('css/notifications.css')}}">
@endsection

@section('right_container')

    <div class="col right-container right-conatiner-notification">
        <div class="notifications-span-div2">
            <span class="notifications-span"><i class="fa-solid fa-bell"></i> Notifications</span>
            <div class="notifications-span-line"></div>
        </div>

        {{-- PATIENT --}}
        @if(Session::has('logged_in_patient'))
            @if($patient_deleted->isEmpty() && $all_prescriptions->isEmpty())
                <div class="no-notifications-div">
                    <span class="no-notifications-span"><i class="fa-regular fa-bell"></i> No notifications here</span>
                </div>
            @elseif(!$patient_deleted->isEmpty() && !$all_prescriptions->isEmpty())
                @php
                    $merged_patient_notifications = collect($patient_deleted)->merge(collect($all_prescriptions))->sortByDesc('updated_at')
                @endphp
                @foreach ($merged_patient_notifications as $key=>$notification )
                @if(!empty($notification->reasion))
                    <div class="accordion accordion-flush mt-3 mb-4" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target={{"#flush-collapseTne".$key}} aria-expanded="false" aria-controls="flush-collapseOne">
                                Your appointment with Dr. {{ucwords($notification->first_name)}} {{ucwords($notification->last_name)}} has been canceled.
                            </button>
                            </h2>
                            <div id={{"flush-collapseTne".$key}}  class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    Your appointment with Dr. {{ucwords($notification->first_name)}} {{ucwords($notification->last_name)}} has been canceled because {{$notification->reasion}}.
                                    <br> To get your money back please contact us. <span class="fw-medium  fs-7"> <i class="fa-solid fa-phone "style="color:blue; padding:10px"></i>{{ $notification->phone_number }}</span>
                                    <br> <a href="{{route('search_doctors')}}" class="book-appointment-a">Book another appointment?</a>
                                    <small class="text-muted d-block mt-3"><i class="fa-solid fa-calendar-days"></i> {{date('j M Y', strtotime($notification->date))}} at {{ $patient_canceled_appointment_start_slot[$notification->app_id] }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="accordion accordion-flush mt-3 mb-4" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target={{"#flush-collapse".$key}} aria-expanded="false" aria-controls="flush-collapseOne">
                                Dr. {{ucwords($notification->first_name)}} {{ucwords($notification->last_name)}} creates a prescription for you.
                            </button>
                            </h2>
                            <div id={{"flush-collapse".$key}} class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    Dr. {{ucwords($notification->first_name)}} {{ucwords($notification->last_name)}} hopes you will be better soon .
                                    <a href="{{route('view.prescription', $notification->pre_id)}}" class="book-appointment-a">View your prescription...</a>
                                    <small class="text-muted d-block mt-3"><i class="fa-solid fa-calendar-days"></i> {{date('j M Y', strtotime($notification->updated_at))}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @endforeach
            @elseif(!$patient_deleted->isEmpty() || !$all_prescriptions->isEmpty())
                @if(!$patient_deleted->isEmpty())
                    @foreach ($patient_deleted as $key=>$patient )
                        <div class="accordion accordion-flush mt-3 mb-4" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target={{"#flush-collapseTne".$key}} aria-expanded="false" aria-controls="flush-collapseOne">
                                    Your appointment with Dr. {{ucwords($patient->first_name)}} {{ucwords($patient->last_name)}} has been canceled.
                                </button>
                                </h2>
                                <div id={{"flush-collapseTne".$key}}  class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        Your appointment with Dr. {{ucwords($patient->first_name)}} {{ucwords($patient->last_name)}} has been canceled because {{$patient->reasion}}.
                                        <br> To get your money back please contact to us. <span class="fw-medium  fs-7"> <i class="fa-solid fa-phone "style="color:blue; padding:10px"></i>{{ $patient->phone_number }}</span>
                                        <br> <a href="{{route('search_doctors')}}" class="book-appointment-a">Book another appointment?</a>
                                        <small class="text-muted d-block mt-3"><i class="fa-solid fa-calendar-days"></i> {{date('j M Y', strtotime($patient->date))}} at {{ $patient_canceled_appointment_start_slot[$patient->app_id] }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                @if(!$all_prescriptions->isEmpty())
                    @foreach ($all_prescriptions as $key=>$prescription )
                        <div class="accordion accordion-flush mt-3 mb-4" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target={{"#flush-collapse".$key}} aria-expanded="false" aria-controls="flush-collapseOne">
                                    Dr. {{ucwords($prescription->first_name)}} {{ucwords($prescription->last_name)}} creates a prescription for you.
                                </button>
                                </h2>
                                <div id={{"flush-collapse".$key}} class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        Dr. {{ucwords($prescription->first_name)}} {{ucwords($prescription->last_name)}} hopes you will be better soon .
                                        <a href="{{route('view.prescription', $prescription->pre_id)}}" class="book-appointment-a">View your prescription...</a>
                                        <small class="text-muted d-block mt-3"><i class="fa-solid fa-calendar-days"></i> {{date('j M Y', strtotime($prescription->updated_at))}}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif

        {{-- DOCTOR --}}
        @elseif(Session::has('logged_in_doctor'))
            @if($doctor_canceled->isEmpty() && $all_doctor_rate->isEmpty())
                <div class="no-notifications-div">
                    <span class="no-notifications-span"><i class="fa-regular fa-bell"></i> No notifications here</span>
                </div>
            @elseif(!$doctor_canceled->isEmpty() && !$all_doctor_rate->isEmpty())
                @php
                    $megred_doctor_notifications = collect($doctor_canceled)->merge(collect($all_doctor_rate))->sortByDesc('updated_at')
                @endphp
                @foreach($megred_doctor_notifications as $key => $notification)
                @if(!empty($notification->date))
                    <div class="doctor-notification mt-3">
                        Your appointment with {{ucwords($notification->first_name)}} {{ucwords($notification->last_name)}} was canceled.
                        <small class="text-muted d-block mt-1"><i class="fa-solid fa-calendar-days"></i>  {{date('j M Y',strtotime($notification->date))}} at {{ $canceled_appointment_start_slot[$notification->app_id] }}</small>
                    </div>
                @else
                    <div class="doctor-notification mt-3">
                        Your patient {{ucwords($notification->first_name)}} {{ucwords($notification->last_name)}} gives you {{ $notification->rate }} stars.
                        <small class="text-muted d-block mt-1"><i class="fa-solid fa-calendar-days"></i> {{date('j M Y',strtotime($notification->updated_at))}} </small>
                    </div>
                @endif
                @endforeach
            @elseif(!$doctor_canceled->isEmpty() || !$all_doctor_rate->isEmpty())
                @if(!$doctor_canceled->isEmpty())
                    @foreach ($doctor_canceled as $dr )
                        <div class="doctor-notification mt-3">
                            Your appointment with {{ucwords($dr->first_name)}} {{ucwords($dr->last_name)}} was canceled.
                            <small class="text-muted d-block mt-1"><i class="fa-solid fa-calendar-days"></i>  {{date('j M Y',strtotime($dr->date))}} at {{ $canceled_appointment_start_slot[$dr->app_id] }}</small>
                        </div>
                    @endforeach
                @endif
                @if(!$all_doctor_rate->isEmpty())
                    @foreach ($all_doctor_rate as $dr_rate )
                        <div class="doctor-notification mt-3">
                            Your patient {{ucwords($dr_rate->first_name)}} {{ucwords($dr_rate->last_name)}} gives you {{ $dr_rate->rate }} stars.
                            <small class="text-muted d-block mt-1"><i class="fa-solid fa-calendar-days"></i> {{date('j- m- Y',strtotime($dr_rate->updated_at))}} </small>
                        </div>
                    @endforeach
                @endif
            @endif
        @endif

    </div>
@endsection
