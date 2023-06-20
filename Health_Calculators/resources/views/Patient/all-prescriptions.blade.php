@extends('Shared.left-container')

@section('title')
    Digital prescriptions
@endsection

@section('right_container_css')
    <link rel="stylesheet" href="{{url('css/notifications.css')}}">
@endsection

@section('right_container')
    <div class="col right-container">
        <div class="notifications-span-div2">
            <span class="notifications-span"><i class="fa-sharp fa-solid fa-clipboard"></i> Digital prescriptions</span>
            <div class="notifications-span-line mt-2"></div>
        </div>

        @if($patient_prescriptions->isEmpty())
            <div class="no-notifications-div">
                <span class="no-notifications-span"><i class="fa-regular fa-clipboard"></i> No prescriptions here</span>
            </div>
        @else
            @foreach($patient_prescriptions as $patient_prescription)
                <div class="doctor-notification mt-3">
                    <div class="row gutter">

                        <div class="col">
                            Dr. {{  ucwords($patient_prescription->first_name)}} {{ ucwords($patient_prescription->last_name) }}'s digital prescription
                        </div>
                        <div class="col end">
                            <a href="{{ route('view.prescription', $patient_prescription->prescription_id) }}" class="btn btn-primary" role="button">View prescription</a>
                        </div>

                    </div>
                    <small class="text-muted d-block mt-1"><i class="fa-solid fa-calendar-days"></i> {{ date("j M Y",strtotime($patient_prescription->app_date)) }}</small>
                </div>
            @endforeach
        @endif
    </div>
@endsection
