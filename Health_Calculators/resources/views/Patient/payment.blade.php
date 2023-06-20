@extends('Shared.header')

@section('css')
    <link rel="stylesheet" href="{{asset('css/doctor-waiting.css')}}">
@endsection

@section('title')
    Payment
@endsection

@section('content')
    <div class="message-container">
        <span class="message-header">Dr name: {{ ucwords(session('doctor_first_name')) }} {{ ucwords(session('doctor_last_name')) }} </span>
        <span class="message">Clinic name: {{ ucwords(session('clinic_name')) }} </span>
        <span class="message">Clinic address: {{ ucfirst(session('clinic_address')) }} </span>
        <span class="message">Fees: {{ session('clinic_fees') }} EGP </span>
        <a href="{{ route('requestpayment', [session('clinic_fees')]) }}" value="Pay with paypal" class="btn btn-primary mt-3">Pay with paypal</a>
    </div>
@endsection
