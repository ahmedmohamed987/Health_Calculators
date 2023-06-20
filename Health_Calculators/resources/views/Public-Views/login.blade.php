<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('css/all.min.css')}}">
    <link rel="stylesheet" href="{{url('css/login.css')}}">
    <title>Login</title>
</head>
<body>

    <div class="login-container">
        <img src="{{url('img/full-logo-black.png')}}" alt="" class="logo"> <br>
        <span class="header-span">Login Account</span>

        <form action="{{route('all.login.check')}}" method="POST" class="mb-3">
            @csrf
            @if(session('login') == null)
            <input type="hidden" value="{{$requestUrl}}" name="requestUrl" id="requestUrl">
            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                <label for="floatingInput" >Email address</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
            </div>

            <span class="fs-6">
                @if (Session::get('error_msg'))
                <div class="text-danger">
                    {{Session::get('error_msg')}}
                </div>
                @endif
            </span>
            @else
            <input type="hidden" value="{{$requestUrl}}" name="requestUrl" id="requestUrl">
            <div class="form-floating mb-3">
                <input value="{{ session('login') }}" type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                <label for="floatingInput" >Email address</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
            </div>

            <span class="fs-6">
                @if (Session::get('error_msg'))
                <div class="text-danger">
                    {{Session::get('error_msg')}}
                </div>
                @endif
            </span>
            @endif
            <button type="submit" class="btn btn-primary mt-1">Log in</button>
        </form>

        <span class="no-account-span">Don't have an account yet?</span>
        <a href="{{route('patient.signup')}}" class="signup-link">Sign up</a>
    </div>
    <script src="{{url('js/bootstrap.bundle.js')}}"></script>
</body>
</html>
