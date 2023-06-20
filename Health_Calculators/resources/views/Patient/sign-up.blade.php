<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('css/all.min.css')}}">
    <link rel="stylesheet" href="{{url('css/signup.css')}}">
    <title>Patient Sign-up</title>
</head>
<body>
    <div class="signup-container">
        <img src="{{url('img/full-logo-black.png')}}" alt="" class="logo"> <br>
        <span class="header-span">Sign Up</span>

        <form action="{{route('patient.save')}}" method="POST" class="mb-3">
            @csrf
            @if(session('sign_up_patient') == null)
            <div class="form-floating mb-3 mt-4">
                <input name="first_name" type="text" class="form-control" id="floatingInput" placeholder="First name" required>
                <label for="floatingInput" >First name</label>

                @if ($errors->has('first_name'))
                <span class="text-danger">
                    {{$errors->first('first_name')}}
                </span>
                @endif
            </div>


            <div class="form-floating mb-3">
                <input name="last_name" type="text" class="form-control" id="floatingInput" placeholder="Last name" required>
                <label for="floatingInput" >Last name</label>
                @if ($errors->has('last_name'))
                <span class="text-danger">
                    {{$errors->first('last_name')}}
                </span>
                @endif
            </div>

            <div class="form-floating mb-3">
                <input name="age" type="number" class="form-control" id="floatingInput" placeholder="Age" min="12" max="100" maxlength="3" required>
                <label for="floatingInput" >Age (12-100)</label>
                @if ($errors->has('age'))
                <span class="text-danger">
                    {{$errors->first('age')}}
                </span>
                @endif
            </div>


            <div class="form-floating mb-3">
                <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                <label for="floatingInput" >Email address</label>
                @if ($errors->has('email'))
                <span class="text-danger">
                    {{$errors->first('email')}}
                </span>
                @endif
            </div>


            <div class="form-floating mb-3">
                <input name="phone_number" type="tel" pattern="[0]{1}[1]{1}[0-9]{9}" class="form-control" id="floatingInput" placeholder="Phone number" required >
                <label for="floatingInput" >Phone number (Eg: 011xxxxxxxx)</label>
                @if ($errors->has('phone_number'))
                <span class="text-danger">
                    {{$errors->first('phone_number')}}
                </span>
                @endif
            </div>



            <div class="form-floating mb-3">
                <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
                @if ($errors->has('password'))
                <span class="text-danger">
                    {{$errors->first('password')}}
                </span>
                @endif
            </div>

            <select name="gender" class="form-select" aria-label="Default select example" id="select-area" required>
                <option selected disabled value="">Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            @if ($errors->has('gender'))
                <span class="text-danger d-block">
                    {{$errors->first('gender')}}
                </span>
                @endif
            <label for="select-area" class="area-label">Choose your area</label>
            <select name="address" class="form-select" aria-label="Default select example" id="select-area" required>
                <option selected disabled value="">Choose your area</option>
                @foreach ($governorates as $gov )
                <option value="{{$gov->governorate_name}}">{{$gov->governorate_name}}</option>
                @endforeach
            </select>

            @else

            <div class="form-floating mb-3 mt-4">
                <input value="{{ session('sign_up_patient')['first_name'] }}" name="first_name" type="text" class="form-control" id="floatingInput" placeholder="First name" required>
                <label for="floatingInput" >First name</label>

                @if ($errors->has('first_name'))
                <span class="text-danger">
                    {{$errors->first('first_name')}}
                </span>
                @endif
            </div>


            <div class="form-floating mb-3">
                <input value="{{ session('sign_up_patient')['last_name'] }}" name="last_name" type="text" class="form-control" id="floatingInput" placeholder="Last name" required>
                <label for="floatingInput" >Last name</label>
                @if ($errors->has('last_name'))
                <span class="text-danger">
                    {{$errors->first('last_name')}}
                </span>
                @endif
            </div>

            <div class="form-floating mb-3">
                <input value="{{ session('sign_up_patient')['age'] }}" name="age" type="number" class="form-control" id="floatingInput" placeholder="Age" min="12" max="100" maxlength="3" required>
                <label for="floatingInput" >Age (12-100)</label>
                @if ($errors->has('age'))
                <span class="text-danger">
                    {{$errors->first('age')}}
                </span>
                @endif
            </div>


            <div class="form-floating mb-3">
                <input value="{{ session('sign_up_patient')['email'] }}" name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                <label for="floatingInput" >Email address</label>
                @if ($errors->has('email'))
                <span class="text-danger">
                    {{$errors->first('email')}}
                </span>
                @endif
            </div>


            <div class="form-floating mb-3">
                <input value="{{ session('sign_up_patient')['phone_number'] }}" name="phone_number" type="tel" pattern="[0]{1}[1]{1}[0-9]{9}" class="form-control" id="floatingInput" placeholder="Phone number" required >
                <label for="floatingInput" >Phone number (Eg: 011xxxxxxxx)</label>
                @if ($errors->has('phone_number'))
                <span class="text-danger">
                    {{$errors->first('phone_number')}}
                </span>
                @endif
            </div>



            <div class="form-floating mb-3">
                <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
                @if ($errors->has('password'))
                <span class="text-danger">
                    {{$errors->first('password')}}
                </span>
                @endif
            </div>
            @if(session('sign_up_patient')['gender'] == "female")
            <select name="gender" class="form-select" aria-label="Default select example" id="select-area" required>
                {{-- <option  disabled value="">Gender</option> --}}
                <option value="male">Male</option>
                <option selected value="female">Female</option>
            </select>
            @if ($errors->has('gender'))
                <span class="text-danger d-block">
                    {{$errors->first('gender')}}
                </span>
            @endif
            @else
            <select name="gender" class="form-select" aria-label="Default select example" id="select-area" required>
                {{-- <option selected disabled value="">Gender</option> --}}
                <option selected value="male">Male</option>
                <option value="female">Female</option>
            </select>
            @if ($errors->has('gender'))
                <span class="text-danger d-block">
                    {{$errors->first('gender')}}
                </span>
            @endif
            @endif
            
            <label for="select-area" class="area-label">Choose your area</label>
            <select name="address" class="form-select" aria-label="Default select example" id="select-area" required>
                <option selected disabled value="">Choose your area</option>
                @foreach ($governorates as $gov )
                <option value="{{$gov->governorate_name}}">{{$gov->governorate_name}}</option>
                @endforeach
            </select>
            @endif

            <button type="submit" class="btn btn-primary">Sign up</button>
        </form>

        <span>Are you a doctor?</span>
        <a href="{{route('doctor.signup')}}" class="signup-link">Sign up as doctor</a>

    </div>

    <div class="login-container mb-5">
        <span>Already have an account?</span>
        <a href="{{route('all.login')}}" class="signup-link">Log in</a>
    </div>

    <script src="{{url('js/bootstrap.bundle.js')}}"></script>
</body>
</html>

