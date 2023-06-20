@extends('Shared.header')

@section('css')
    <link rel="stylesheet" href="{{asset('css/doctor-waiting.css')}}">
@endsection

@section('title')
        Mail
@endsection

@section('content')
    <div class="message-container">
        <span class="message-header">{{$mails->title}}</span>
        <span class="message">{{$mails->content}}</span>
    </div>
@endsection

