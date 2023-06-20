@extends('Shared.header')

@section('css')
    <link rel="stylesheet" href="{{url('css/doctor-details.css')}}">
@endsection

@section('title')
    Doctor Details
@endsection

@section('content')
<div class="body">
    <table>
        <tr>
            <td class="end left-col grey">First Name</td>
            <td class="center right-col grey">{{ucwords($dr_details['first_name'])}}</td>
        </tr>

        <tr>
            <td class="end left-col">Last Name</td>
            <td class="center right-col">{{ucwords($dr_details['last_name'])}}</td>
        </tr>

        <tr>
            <td class="end left-col grey">Age</td>
            <td class="center right-col grey">{{$dr_details['age']}}</td>
        </tr>

        <tr>
            <td class="end left-col">Email</td>
            <td class="center right-col">{{$dr_email['email']}}</td>
        </tr>

        <tr>
            <td class="end left-col grey">Phone Number</td>
            <td class="center right-col grey">{{$dr_details['phone_number']}}</td>
        </tr>

        <tr>
            <td class="end left-col">Gender</td>
            <td class="center right-col">{{ucfirst($dr_details['gender'])}}</td>
        </tr>

        <tr>
            <td class="end left-col grey">Area</td>
            <td class="center right-col grey">{{$dr_details['address']}}</td>
        </tr>

        <tr>
            <td class="end left-col">Registration Number</td>
            <td class="center right-col">{{$dr_details['registration_number']}}</td>
        </tr>

        <tr>
            <td class="end left-col grey">Registration Date</td>
            <td class="center right-col grey">{{date('j - m - Y', strtotime($dr_details['registration_date']))}}</td>
        </tr>

        <tr>
            <td class="end left-col">Expiry Date</td>
            <td class="center right-col">{{date('j - m - Y', strtotime($dr_details['expiry_date']))}}</td>
        </tr>

        <tr>
            <td class="end left-col grey">Last Year of Payment</td>
            <td class="center right-col grey">{{$dr_details['last_year_of_payment']}}</td>
        </tr>

        <tr>
            <td class="end left-col">Speciality Type</td>
            <td class="center right-col">{{ucfirst($dr_details['specialty_type'])}}</td>
        </tr>

        <tr>
            <td class="end left-col grey">Guild Card Image</td>
            <td class="center grey">
                <button type="button" class="btn btn-primary" id="card-image-btn">View guild card image</button>
            </td>
        </tr>
        <tr>
            <td class="center" colspan="2">
                <a class="btn btn-success m-2" href="{{route('doctor.accept', ['id'=>$dr_details->id])}}" role="button"><i class="fa-solid fa-check"></i> Accept doctor</a>
                <button class="btn btn-danger m-2" id="reject-btn"><i class="fa-solid fa-xmark"></i> Reject doctor</button>
            </td>
        </tr>
    </table>
</div>

<div class="card-image-background">
    <div class="card-image-container">
        <div class="row">
            <div class="col"></div>
            <div class="col"></div>
            <div class="col end">
                <button type="button" class="btn-close" aria-label="Close" id="close-image-card-btn"></button>
            </div>
        </div>
        <img src="{{$dr_details['gulid_card_image']}}" alt="" class="mt-5 card-image">
    </div>
</div>

<div class="reject-background">
    <div class="reject-container">
        <div class="row gutter reject-top-row mb-5">
            <div class="col"></div>
            <div class="col center reject-header">Reject Doctor</div>
            <div class="col end">
                <button type="button" class="btn-close" aria-label="Close" id="close-reject-btn"></button>
            </div>
        </div>
        <form action="{{route('doctor.reject', ['id'=>$dr_details->id])}}" method=POST>
            @csrf
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Rejection reason:</label>
                <textarea name="rejection_reason" class="form-control reject-reason" id="exampleFormControlTextarea1" rows="3" placeholder="..." required></textarea>
            </div>
            <button type="submit" class="btn btn-danger reject"><i class="fa-sharp fa-solid fa-ban"></i> Reject</button>
        </form>
    </div>
</div>
@endsection

@section('jquery')
    <script>
        $("#card-image-btn").click(function(){
            $(".card-image-background").css("display","block")
        })

        $("#close-image-card-btn").click(function(){
            $(".card-image-background").css("display","none")
        })

        $("#reject-btn").click(function(){
            $(".reject-background").css("display","block")
        })

        $("#close-reject-btn").click(function(){
            $(".reject-background").css("display","none")
        })
    </script>
@endsection

