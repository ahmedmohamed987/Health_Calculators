@extends('Shared.header')

@section('css')
    <link rel="stylesheet" href="{{url('css/dr-visit-card.css')}}">
@endsection

@section('title')
    Doctor Profile
@endsection

@section('content')
    <div class="body">
        <div class="row gutter container-row">
            <div class="col-4 left-col">
                <img src="{{ $dr_data->profile_image}}" class="doctor-img pos-center" alt="">
                <span class="dr-name">{{ ucwords($dr_request->first_name) }} {{ ucwords($dr_request->last_name) }}</span>
                <span class="dr-speciality">{{ ucwords($dr_request->specialty_type) }}</span>
            </div>

            <div class="col right-col">
                <div class="headers-div mb-2">
                    <span class="right-col-headers">
                        About the Doctor
                    </span>
                    <div class="right-header-line"></div>
                </div>

                <span class="right-col-span">{{ $dr_data->bio }}</span>

                <div class="headers-div mb-2 mt-4">
                    <span class="right-col-headers">
                        Contact info
                    </span>
                    <div class="right-header-line"></div>
                </div>

                <div class="row gutter">
                    <div class="col contact-info-col">
                        <span class="contact-info-header"><i class="fa-solid fa-location-dot"></i> Location:</span>
                        <span class="contact-info-span">
                            @if (empty($dr_clinic->detailed_clinic_address))
                                {{ ucfirst($dr_clinic->clinic_address) }}
                            @else
                                {{ ucfirst($dr_clinic->detailed_clinic_address) }}
                            @endif
                        </span>
                    </div>
                    <div class="col contact-info-col">
                        <span class="contact-info-header"><i class="fa-solid fa-star-half-stroke"></i> Rating:</span>
                        @php
                            $rates_value = number_format($value_of_doctor_rates)
                        @endphp
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

                <div class="row gutter mt-3">
                    <div class="col" id="contact-info-col">
                        <span class="contact-info-header"><i class="fa-solid fa-phone"></i> Phone:</span>
                        <span class="contact-info-span">+2{{ $dr_clinic->phone_number }}</span>
                    </div>
                    <div class="col contact-info-col">
                        <span class="contact-info-header"><i class="fa-solid fa-envelope"></i> Email:</span>
                        <button type="button" class="email-btn contact-info-span" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            {{ substr($dr_email->email,0, 15) }}...
                            </button>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-envelope"></i> Email</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $dr_email->email }}
            </div>
            </div>
        </div>
    </div>

@endsection

