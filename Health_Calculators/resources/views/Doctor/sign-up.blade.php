<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('css/all.min.css')}}">
    <link rel="stylesheet" href="{{url('css/signup-doctor.css')}}">
    <title>Doctor Sign-up</title>
</head>
<body>

    <div class="signup-container">
        <img src="{{url('img/full-logo-black.png')}}" alt="" class="logo"> <br>
        <span class="header-span">Sign Up As Doctor</span>

        <form action="{{route('doctor.save')}}" method="POST" class="mb-3" enctype="multipart/form-data">
            @csrf
            @if(session('sign_up_doctor') == null)
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
                <input name="age" type="number" class="form-control" id="floatingInput" placeholder="Age" min="25" max="100" maxlength="3" required>
                <label for="floatingInput" >Age (25-100)</label>
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
                <input name="phone_number" type="tel" pattern="[0]{1}[1]{1}[0-9]{9}" class="form-control" id="floatingInput" placeholder="Phone number" required>
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

            <select name="gender" class="form-select mb-3" aria-label="Default select example" id="select-area" required>
                <option selected disabled value="">Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            @if ($errors->has('gender'))
            <span class="text-danger">
                {{$errors->first('gender')}}
            </span>
            @endif
            <select name="address" class="form-select" aria-label="Default select example" id="select-area" required>
                <option selected disabled value="">Choose your area</option>
                @foreach ($governorates as $gov )
                <option value="{{$gov->governorate_name}}">{{$gov->governorate_name}}</option>
                @endforeach
            </select>
            @if ($errors->has('address'))
            <span class="text-danger">
                {{$errors->first('address')}}
            </span>
            @endif
            <div class="line"></div>
            <span class="doctor-info-span">Doctor's Information</span>

            <div class="form-floating mb-1 mt-3">
                <input name="registration_number" type="number" class="form-control" id="floatingInput" placeholder="registration-number" required>
                <label for="floatingInput" >Registration number</label>

            </div>
            @if ($errors->has('registration_number'))
                <span class="text-danger">
                    {{$errors->first('registration_number')}}
                </span>
                @endif

            <div class="form-floating mb-3 mt-3">
                <input name="registration_date" type="date" class="form-control" id="floatingInput" placeholder="registration-date" required>
                <label for="floatingInput" >Registration date</label>
            </div>
            @if ($errors->has('registration_date'))
                <span class="text-danger">
                    {{$errors->first('registration_date')}}
                </span>
            @endif

            <div class="form-floating mb-3 mt-3">
                <input name="expiry_date" type="date" class="form-control" id="floatingInput" placeholder="expiry-date" required>
                <label for="floatingInput" >Expiry date</label>
            </div>
            @if ($errors->has('expiry_date'))
                <span class="text-danger">
                    {{$errors->first('expiry_date')}}
                </span>
            @endif

            <div class="form-floating mb-3 mt-3">
                <input name="last_year_payment" type="number" min="1950" max="2023" value="2023" class="form-control" id="floatingInput" placeholder="last-year-payment" required>
                <label for="floatingInput" >Last year of payment</label>
            </div>
            @if ($errors->has('last_year_payment'))
                <span class="text-danger">
                    {{$errors->first('last_year_payment')}}
                </span>
            @endif

            <select name="speciality_type" class="form-select" aria-label="Default select example" id="select-area" required >
                <option selected disabled value="">Speciality type</option>
                <option value="consultant">Consultant</option>
                <option value="specialist">Specialist</option>
            </select>
            @if ($errors->has('speciality_type'))
                <span class="text-danger">
                    {{$errors->first('speciality_type')}}
                </span>
            @endif

            <div class="mb-3 guide-card-image">
                <label for="formFile" class="form-label"> Guild card image</label>
                <input name="gulid_card_image" class="form-control" type="file" id="formFile" accept="image/*" required>
                @if ($errors->has('gulid_card_image'))
                <span class="text-danger">
                    {{$errors->first('gulid_card_image')}}
                </span>
                @endif
            </div>

            @else
            <div class="form-floating mb-3 mt-4">
                <input value="{{ session('sign_up_doctor')['first_name'] }}" name="first_name" type="text" class="form-control" id="floatingInput" placeholder="First name" required>
                <label for="floatingInput" >First name</label>
                @if ($errors->has('first_name'))
                <span class="text-danger">
                    {{$errors->first('first_name')}}
                </span>
                @endif
            </div>

            <div class="form-floating mb-3">
                <input value="{{ session('sign_up_doctor')['last_name'] }}" name="last_name" type="text" class="form-control" id="floatingInput" placeholder="Last name" required>
                <label for="floatingInput" >Last name</label>
                @if ($errors->has('last_name'))
                <span class="text-danger">
                    {{$errors->first('last_name')}}
                </span>
                @endif
            </div>

            <div class="form-floating mb-3">
                <input value="{{ session('sign_up_doctor')['age'] }}" name="age" type="number" class="form-control" id="floatingInput" placeholder="Age" min="25" max="100" maxlength="3" required>
                <label for="floatingInput" >Age (25-100)</label>
                @if ($errors->has('age'))
                <span class="text-danger">
                    {{$errors->first('age')}}
                </span>
                @endif
            </div>

            <div class="form-floating mb-3">
                <input value="{{ session('sign_up_doctor')['email'] }}" name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                <label for="floatingInput" >Email address</label>
                @if ($errors->has('email'))
                <span class="text-danger">
                    {{$errors->first('email')}}
                </span>
                @endif
            </div>

            <div class="form-floating mb-3">
                <input value="{{ session('sign_up_doctor')['phone_number'] }}" name="phone_number" type="tel" pattern="[0]{1}[1]{1}[0-9]{9}" class="form-control" id="floatingInput" placeholder="Phone number" required>
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

            @if(session('sign_up_doctor')['gender'] == "female")
            <select name="gender" class="form-select mb-3" aria-label="Default select example" id="select-area" required>
                {{-- <option selected disabled value="">Gender</option> --}}
                <option value="male">Male</option>
                <option selected value="female">Female</option>
            </select>
            @if ($errors->has('gender'))
            <span class="text-danger">
                {{$errors->first('gender')}}
            </span>
            @endif
            @else
            <select name="gender" class="form-select mb-3" aria-label="Default select example" id="select-area" required>
                {{-- <option selected disabled value="">Gender</option> --}}
                <option selected value="male">Male</option>
                <option value="female">Female</option>
            </select>
            @if ($errors->has('gender'))
            <span class="text-danger">
                {{$errors->first('gender')}}
            </span>
            @endif
            @endif
            <select name="address" class="form-select" aria-label="Default select example" id="select-area" required>
                <option selected disabled value="">Choose your area</option>
                @foreach ($governorates as $gov )
                <option value="{{$gov->governorate_name}}">{{$gov->governorate_name}}</option>
                @endforeach
            </select>
            @if ($errors->has('address'))
            <span class="text-danger">
                {{$errors->first('address')}}
            </span>
            @endif
            <div class="line"></div>
            <span class="doctor-info-span">Doctor's Information</span>

            <div class="form-floating mb-1 mt-3">
                <input value="{{ session('sign_up_doctor')['registration_number'] }}" name="registration_number" type="number" class="form-control" id="floatingInput" placeholder="registration-number" required>
                <label for="floatingInput" >Registration number</label>

            </div>
            @if ($errors->has('registration_number'))
                <span class="text-danger">
                    {{$errors->first('registration_number')}}
                </span>
                @endif

            <div class="form-floating mb-3 mt-3">
                <input value="{{ session('sign_up_doctor')['registration_date'] }}" name="registration_date" type="date" class="form-control" id="floatingInput" placeholder="registration-date" required>
                <label for="floatingInput" >Registration date</label>
            </div>
            @if ($errors->has('registration_date'))
                <span class="text-danger">
                    {{$errors->first('registration_date')}}
                </span>
            @endif

            <div class="form-floating mb-3 mt-3">
                <input value="{{ session('sign_up_doctor')['expiry_date'] }}" name="expiry_date" type="date" class="form-control" id="floatingInput" placeholder="expiry-date" required>
                <label for="floatingInput" >Expiry date</label>
            </div>
            @if ($errors->has('expiry_date'))
                <span class="text-danger">
                    {{$errors->first('expiry_date')}}
                </span>
            @endif

            <div class="form-floating mb-3 mt-3">
                <input value="{{ session('sign_up_doctor')['last_year_payment'] }}" name="last_year_payment" type="number" min="1950" max="2023" value="2023" class="form-control" id="floatingInput" placeholder="last-year-payment" required>
                <label for="floatingInput" >Last year of payment</label>
            </div>
            @if ($errors->has('last_year_payment'))
                <span class="text-danger">
                    {{$errors->first('last_year_payment')}}
                </span>
            @endif

            @if(session('sign_up_doctor')['speciality_type'] == "consultant")
            <select name="speciality_type" class="form-select" aria-label="Default select example" id="select-area" required >
                {{-- <option selected disabled value="">Speciality type</option> --}}
                <option selected value="consultant">Consultant</option>
                <option value="specialist">Specialist</option>
            </select>
            @if ($errors->has('speciality_type'))
                <span class="text-danger">
                    {{$errors->first('speciality_type')}}
                </span>
            @endif
            @else
            <select name="speciality_type" class="form-select" aria-label="Default select example" id="select-area" required >
                {{-- <option selected disabled value="">Speciality type</option> --}}
                <option value="consultant">Consultant</option>
                <option selected value="specialist">Specialist</option>
            </select>
            @if ($errors->has('speciality_type'))
                <span class="text-danger">
                    {{$errors->first('speciality_type')}}
                </span>
            @endif
            @endif

            <div class="mb-3 guide-card-image">
                <label for="formFile" class="form-label"> Guild card image</label>
                <input  name="gulid_card_image" class="form-control" type="file" id="formFile" accept="image/*" required>
                @if ($errors->has('gulid_card_image'))
                <span class="text-danger">
                    {{$errors->first('gulid_card_image')}}
                </span>
                @endif
            </div>

            @endif

            <button type="submit" class="btn btn-primary">Sign up</button>
        </form>
        <span>Are you a patient?</span>
        <a href="{{route('patient.signup')}}" class="signup-link">Sign up as patient</a>

    </div>

    <div class="login-container mb-5">
        <span>Already have an account?</span>
        <a href="{{route('all.login')}}" class="signup-link">Log in</a>
    </div>

    <script src="{{url('js/bootstrap.bundle.js')}}"></script>
</body>
</html>
