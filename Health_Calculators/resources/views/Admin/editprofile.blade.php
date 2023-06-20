@extends('Shared.header')

@section('css')
    <link rel="stylesheet" href="{{url('css/edit-profile.css')}}">
@endsection

@section('title')
    Edit Profile
@endsection

@section('content')

    <div class="body-container">

    <form  action="@if (Session::has('logged_in_patient')){{Route('user.update', session('logged_in_patient')['user_id'])}}
                    @elseif (Session::has('logged_in_admin')){{Route('user.update', session('logged_in_admin')['user_id'])}}
                    @elseif (Session::has('logged_in_doctor')){{Route('user.update', session('logged_in_doctor')['user_id'])}} @endif" method="post" enctype="multipart/form-data">
        @csrf
        <table >
            <tr>
                @if (Session::has('logged_in_patient'))
                    <td class="left-col">
                        @if (session('logged_in_patient')['profile_image'] == true)
                            <img src=" {{$patient->profile_image}}" class="profile-image" id="profile-image"alt="">

                        @endif
                    </td>
                @elseif (Session::has('logged_in_doctor'))
                    <td class="left-col">
                        <img src=" {{url("$doctordata->profile_image")}}" class="profile-image" id="profile-image"alt="">
                    </td>
                @elseif (Session::has('logged_in_admin'))
                    <td class="left-col">
                        @if (session('logged_in_admin')['profile_image'] == true)
                            <img src=" {{$admin->profile_image}}" class="profile-image" id="profile-image"alt="">
                        @else
                        <img src="{{url('img/default.jpg')}}" class="profile-image" id="profile-image"alt="">
                        @endif
                    </td>
                @endif

                <td class="right-col">
                    <div class="row gutter">
                        <span class="name">
                            @if (Session::has('logged_in_patient'))
                                {{ucwords(session('logged_in_patient')['first_name'])}}  {{ucwords(session('logged_in_patient')['last_name'])}}
                            @elseif (Session::has('logged_in_admin'))
                                {{ucwords(session('logged_in_admin')['first_name'])}}  {{ucwords(session('logged_in_admin')['last_name'])}}
                            @elseif (Session::has('logged_in_doctor'))
                                {{ucwords(session('logged_in_doctor')['first_name'])}}  {{ucwords(session('logged_in_doctor')['last_name'])}}
                            @endif
                        </span>
                    </div>
                    <div class="row gutter">
                        <label for="file" id="upload-btn">Change profile photo</label>
                        <input id="file" name="file" type="file" accept="image/*" class="custom-file-input">
                        @if(Session()->has('logged_in_patient'))
                        <a href="{{route('remove.photo', Session('logged_in_patient')['id'])}}" id="remove-btn">
                            Remove profile photo
                        </a>
                        @elseif(Session()->has('logged_in_doctor'))
                        <a href="{{route('remove.photo', Session('logged_in_doctor')['id'])}}" id="remove-btn">
                        Remove profile photo
                        </a>
                        @elseif(Session()->has('logged_in_admin'))
                        <a href="{{route('remove.photo', Session('logged_in_admin')['id'])}}" id="remove-btn">
                                Remove profile photo
                        </a>
                        @endif
                        <input name="removeProfilePicture" value="true" id="removeFilee" type="Radio" class="custom-file-input">
                    </div>
                </td>
            </tr>

            <tr>
                <td class="left-col">
                    <span class="left-label">First name</span>
                </td>
                <td class="right-col">
                    <input type="text" name="first_name" value="@if (Session::has('logged_in_patient')){{session('logged_in_patient')['first_name']}}
                                                                @elseif (Session::has('logged_in_admin')){{session('logged_in_admin')['first_name']}}
                                                                @elseif (Session::has('logged_in_doctor')){{session('logged_in_doctor')['first_name']}} @endif" class="form-control right-input" id="exampleFormControlInput1" placeholder="First name">
                                                                @if ($errors->has('first_name'))
                                                                <span class="text-danger">
                                                                    {{$errors->first('first_name')}}
                                                                </span>
                                                                @endif
                </td>
            </tr>

            <tr>
                <td class="left-col">
                    <span class="left-label">Last name</span>
                </td>
                <td class="right-col">
                    <input type="text" name="last_name"value="@if (Session::has('logged_in_patient')){{session('logged_in_patient')['last_name']}}
                                                            @elseif (Session::has('logged_in_admin')){{session('logged_in_admin')['last_name']}}
                                                            @elseif (Session::has('logged_in_doctor')){{session('logged_in_doctor')['last_name']}} @endif" placeholder="Last name" class="form-control right-input" id="exampleFormControlInput1">
                                                            @if ($errors->has('last_name'))
                                                            <span class="text-danger">
                                                                {{$errors->first('last_name')}}
                                                            </span>
                                                            @endif
                </td>
            </tr>

            <tr>
                <td class="left-col">
                    <span class="left-label">Age</span>
                </td>
                <td class="right-col">
                    @if (Session::has('logged_in_doctor'))
                        <input type="number" name="age"value="{{session('logged_in_doctor')['age']}}" maxlength="3" placeholder="Age" class="form-control right-input" id="exampleFormControlInput1">
                    @elseif (Session::has('logged_in_patient'))
                        <input type="number" name="age"value="{{session('logged_in_patient')['age']}}" maxlength="3" placeholder="Age" class="form-control right-input" id="exampleFormControlInput1">
                    @elseif (Session::has('logged_in_admin'))
                        <input type="number" name="age"value="{{session('logged_in_admin')['age']}}" maxlength="3" placeholder="Age" class="form-control right-input" id="exampleFormControlInput1">
                    @endif
                    @if ($errors->has('age'))
                        <span class="text-danger">
                            {{$errors->first('age')}}
                        </span>
                    @endif
                </td>
            </tr>

            <tr>
                <td class="left-col">
                    <span class="left-label">Email</span>
                </td>
                <td class="right-col">
                    <input type="email" name="email" value="{{$user->email}}" placeholder="email" class="form-control right-input" id="exampleFormControlInput1">
                    @if ($errors->has('email'))
                        <span class="text-danger">
                            {{$errors->first('email')}}
                        </span>
                    @endif
                </td>
            </tr>

            <tr>
                <td class="left-col">
                    <span class="left-label">Phone</span>
                </td>
                <td class="right-col">
                    <input type="tel"  name="phone_number" value="@if (Session::has('logged_in_patient')){{session('logged_in_patient')['phone_number']}}
                                                                @elseif (Session::has('logged_in_admin')){{session('logged_in_admin')['phone_number']}}
                                                                @elseif (Session::has('logged_in_doctor')){{session('logged_in_doctor')['phone_number']}} @endif" placeholder="phone" class="form-control right-input" id="exampleFormControlInput1">
                                                                @if ($errors->has('phone_number'))
                                                                <span class="text-danger">
                                                                    {{$errors->first('phone_number')}}
                                                                </span>
                                                                @endif
                </td>
            </tr>

            <tr>
                <td class="left-col">
                    <span class="left-label">Gender</span>
                </td>
                <td class="right-col">
                    <select name="gender"  class="form-select right-input" aria-label="Default select example">
                        <option  value="male"  @if (Session::has('logged_in_doctor'))@if(session('logged_in_doctor')['gender'] == "male") selected @endif
                                                @elseif(Session::has('logged_in_patient'))@if(session('logged_in_patient')['gender'] == "male") selected @endif
                                                @elseif(Session::has('logged_in_admin'))@if(session('logged_in_admin')['gender'] == "male") selected @endif
                                                @endif>Male
                        </option>
                        <option value="female" @if (Session::has('logged_in_doctor'))@if(session('logged_in_doctor')['gender'] == "female") selected @endif
                                                @elseif(Session::has('logged_in_patient'))@if(session('logged_in_patient')['gender'] == "female") selected @endif
                                                @elseif(Session::has('logged_in_admin'))@if(session('logged_in_admin')['gender'] == "female") selected @endif
                                                @endif>Female
                        </option>
                    </select>
                    @if ($errors->has('gender'))
                    <span class="text-danger d-block">
                        {{$errors->first('gender')}}
                    </span>
                    @endif
                </td>
            </tr>

            @if(Session::has('logged_in_doctor') || Session::has('logged_in_patient'))
                <tr>
                    <td class="left-col">
                        <span class="left-label">Location</span>
                    </td>
                    <td class="right-col">
                        <select name="location" class="form-select right-input" aria-label="Default select example">
                            <option selected > @if(Session::has('logged_in_doctor')){{session('logged_in_doctor')['address']}}
                                                @elseif(Session::has('logged_in_patient')){{session('logged_in_patient')['address']}}
                                                @endif
                            </option>
                            {{-- <option  value="Maadi">Maadi</option>
                            <option value="Haram">Haram</option>
                            <option value="Madint nasr">Madint nasr</option> --}}
                            @foreach ($governorates as $gov )
                            <option value="{{$gov->governorate_name}}">{{$gov->governorate_name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            @endif

            <tr>
                <td class="left-col"></td>
                <td class="right-col">
                    <button type="submit" class="btn btn-primary">Update</button>
                </td>
            </tr>

        </table>
    </form>
    </div>
    @section('jquery')
    <script>
        $("#add-article-btn").click(function(){
            $(".add-article-background").css("display","block")
        })
        $("#article-close-btn").click(function(){
            $(".add-article-background").css("display","none")
        })

        // edit-profile
        const file = document.getElementById('file');
        const img = document.getElementById('profile-image');
        file.addEventListener('change', function(){
            const choosedFile = this.files[0];
            if(choosedFile){
                const reader = new FileReader();

                reader.addEventListener('load',function(){
                    img.setAttribute('src',reader.result);
                })
                reader.readAsDataURL(choosedFile);
            }
        });
        $("#removeFilee").click(function(){
            img.setAttribute('src','img/doctor.png')
        })
    </script>
@endsection
@endsection





