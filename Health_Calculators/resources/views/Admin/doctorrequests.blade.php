@extends('Shared.header')

@section('css')
    <link rel="stylesheet" href="{{url('css/doctor-validation.css')}}">
@endsection

@section('title')
    Doctors' Requests
@endsection

@section('content')
    <div class="body">
        @foreach ($reqs as $item)
                <div class="request-card">
                    <div class="row gutter">
                        <div class="col-2 img-col">
                            <img class="doctor-img" src="{{url('img/doctor.png')}}" alt="">
                        </div>
                        <div class="col name-col">
                            <span class="doctor-name">{{ucwords($item->first_name) }}</span>
                        </div>
                        <div class="col buttons-col end me-3">
                            <a class="btn btn-primary" href="{{route('doctor.details',['id'=>$item->id])}}" role="button">View details</a>
                        </div>
                    </div>
                </div>
        @endforeach
    </div>
    <div class="m-4 pag">
        {{$reqs->links()}}
    </div>
@endsection


