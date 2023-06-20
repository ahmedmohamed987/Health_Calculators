<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/doctor-waiting.css')}}">
    <title>Rejection Mail</title>
</head>
<body>

    <div class="header">
        <div class="row gutter header-row">
            <div class="col header-col">
                <img src="{{url('img/full-logo-white.png')}}" alt="" class="header-logo">
            </div>
        </div>
    </div>

    <!------------------------------------------------------------------------------------------------------------------ -->

    <div class="message-container">
        <span class="message-header text-danger">Rejected Registration</span>
        <span class="message">Incorrect Registered Information</span>
        <a class="btn btn-primary" href="{{route('doctor.signup')}}" role="button">Sign Up</a>
    </div>

    <script src="{{url('js/bootstrap.bundle.js')}}"></script>
    <script src="{{url('js/jquery-3.6.0.min.js')}}"></script>

</body>
</html>
