{{-- @extends('Shared.header')

@section('title')
    Doctor's profile
@endsection

@section('content')
    <h1>Doctor Profile</h1>
    <hr>
    {{session('logged_in_doctor')['first_name']}}
    {{session('logged_in_doctor')['last_name']}}
    {{session('logged_in_doctor')['phone_number']}}
    {{session('logged_in_doctor')['age']}}
    {{session('logged_in_doctor')['gender']}}
    {{session('logged_in_doctor')['address']}}
@endsection --}}
@extends('Shared.header')

@section('title')
    Doctor's profile
@endsection

@section('content')
    <h1>Doctor Profile</h1>
    <hr>

    @if(!empty(session('logged_in_doctor') && empty($id)))
        {{session('logged_in_doctor')['first_name']}}
        {{session('logged_in_doctor')['last_name']}}
        {{session('logged_in_doctor')['phone_number']}}
        {{session('logged_in_doctor')['age']}}
        {{session('logged_in_doctor')['gender']}}
        {{session('logged_in_doctor')['address']}}
    @else
        @if(!empty($doctordata))
            {{$doctordata->first_name}}
            {{$doctordata->last_name}}
            {{$doctordata->phone_number}}
            {{$doctordata->age}}
            {{$doctordata->gender}}
            {{$doctordata->address}}
        @else
            Not Found
        @endif
    @endif

    
@endsection
