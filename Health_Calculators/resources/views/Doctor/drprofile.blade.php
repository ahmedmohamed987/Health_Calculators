@extends('Shared.header')

@section('css')
    <link rel="stylesheet" href="{{url('css/drProfile.css')}}">
@endsection

@section('title')
    Doctor's profile
@endsection

@section('content')

<div class="body-container">
    <div class="fixed-left">
        <img src="{{$dr_data->profile_image}}" class="doctor-profile-img">
        <div class="defination-container1">
            <div class="defination-container">
                <div class="row gutter defination-row mt-4">
                    <span class="defination-span"><i class="fa-solid fa-user"></i> Name</span>
                </div>
                <div class="row gutter description-row">
                    <span class="description-span">{{ucwords(Session('logged_in_doctor')['first_name']) .' '. ucwords(Session('logged_in_doctor')['last_name'])}}</span>
                </div>
            </div>
            <div class="defination-container">
                <div class="row gutter defination-row mt-4">
                    <span class="defination-span"><i class="fa-solid fa-clipboard"></i> Speciality</span>
                </div>
                <div class="row gutter description-row">
                    <span class="description-span">{{ucfirst(Session('logged_in_doctor')['specialty_type'])}}</span>
                </div>
            </div>
            <div class="defination-container">
                <div class="row gutter defination-row mt-4">
                    <span class="defination-span"><i class="fa-solid fa-location-dot"></i> Location</span>
                </div>
                <div class="row gutter description-row">
                    <span class="description-span">
                        @if(is_null($dr_data->clinic_id))
                            {{Session('logged_in_doctor')['address']}}
                        @else
                            {{$dr_clinic->clinic_address}}
                        @endif
                    </span>
                </div>
            </div>
            <div class="defination-container">
                <div class="row gutter defination-row mt-4">
                    <span class="defination-span"><i class="fa-solid fa-star-half-stroke"></i> Rating</span>
                </div>
                @php
                    $rates_value = number_format($value_of_doctor_rates)
                @endphp
                <div class="row gutter description-row">
                    <span class="description-span">
                        @for($i = 1; $i <= $rates_value; $i++)
                            <i class="fa-solid fa-star"></i>
                        @endfor
                        @for($j = $rates_value+1; $j <= 5; $j++)
                            <i class="fa-regular fa-star"></i>
                        @endfor
                    </span>
                </div>
            </div>
            <div class="defination-container">
                <div class="row gutter defination-row mt-4">
                    <span class="defination-span"><i class="fa-solid fa-phone"></i> Phone</span>
                </div>
                <div class="row gutter description-row">
                    <span class="description-span">
                        @if(is_null($dr_data->clinic_id))
                            {{Session('logged_in_doctor')['phone_number']}}
                        @else
                            {{$dr_clinic->phone_number}}
                        @endif
                    </span>
                </div>
            </div>
            <div class="defination-container">
                <div class="row gutter defination-row mt-4">
                    <span class="defination-span"><i class="fa-solid fa-envelope"></i> Email</span>
                </div>
                <div class="row gutter description-row email-row">
                    <span class="description-span">{{$dr_email->email}}</span>
                </div>
            </div>
        </div>
    </div>


    <div class="right-container">
        <span class="schedule-header d-block">About the doctor</span>
            <div class="about-doctor" id="docAbout">
                <span class="d-block">{{ucfirst($dr_data->bio)}}</span>
                <button type="button" class="btn btn-primary mt-3" id="editDescBtn"><i class="fa-solid fa-pen"></i> Edit description</button>
            </div>
            <div class="mb-2" id="editDocDesc" style="display: none;">
                <form action="{{route('save.bio')}}" method="POST">
                    @csrf
                    <label for="doctorAbout" class="form-label">Edit description</label>
                    <textarea required name="doctorDescription" class="form-control" id="doctorAbout" rows="3" style="resize: none;">{{ucfirst($dr_data->bio)}}</textarea>
                    <button type="submit" class="btn btn-primary mt-3"><i class="fa-solid fa-pen"></i> Edit</button>
                    <button type="button" class="btn btn-danger mt-3" id="cancelEditBtn"><i class="fa-solid fa-xmark"></i> Cancel</button>
                </form>
            </div>

            @if($dr_data->clinic_id != null)
            <button class="btn btn-primary mt-3 mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#addQuestion" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa-solid fa-location-dot"></i> Edit location
            </button>
            <div class="collapse" id="addQuestion">
                <div class="card card-body answer-card">

                    <!-- WILL BE VISIBLE ONLY FOR DOCTOR HIMSELF -->
                    <form action="{{route('detailed.clinic.address')}}" method="POST" class="">
                        @csrf
                        <input value="{{ $dr_clinic->detailed_clinic_address }}" required name="detailed_location" type="text" class="form-control" placeholder="Enter location in details">
                        <button class="btn btn-primary mt-3 mb-1">Submit</button>
                    </form>
                    <!-- END -->
                </div>
            </div>
            @else

            @endif

        <div class="line mt-3"></div>

        @if(!isset($booked_apps))

        @else
        <div class="cancel-appointments-div mt-5 mb-5">
            <span class="schedule-header d-block">Booked appointments</span>
            <div class="accordion mt-3" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        {{$dr_clinic->clinic_address}}
                    </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="appointment-table">
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Cancel</th>
                                </tr>
                                @php
                                    $i=0
                                @endphp
                                @foreach ($booked_apps as $app )
                                <tr>
                                    <td>{{date('l', strtotime($app->date))}}<br>{{date('d-m-Y', strtotime($app->date))}}</td>
                                    <td> {{$slots[$i][$app->slot_id+1 ]['slots_start_time']}}</td>
                                    <td>{{ucwords($app->first_name)}} {{ucwords($app->last_name)}}</td>
                                    <td>{{$app->phone_number}}</td>
                                    @php
                                        $i++
                                    @endphp
                                    <td>
                                        <div class="dropdown-center">
                                            <button class="btn btn-danger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <ul class="dropdown-menu appointment-delete-dropdown">
                                                <li>
                                                    <form action="{{route('del.app', $app->app_id)}}" method="POST">
                                                        @csrf
                                                        {{-- <input type="hidden" name="appointmentId" value={{$app->id}}> --}}
                                                        <label for="deleteAppointmentReason1"  class="form-label">Enter deletion reason</label>
                                                        <textarea required name = 'reason'  placeholder="Enter reason" class="form-control mb-3" id="deleteAppointmentReason1" rows="3"></textarea>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                @endforeach

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="line"></div>
        @endif

        <div class="add-appointment mb-5">
            <span class="schedule-header d-block">Choose working time</span>
            @if($errors->any())
            <div class="alert alert-danger mt-1" role="alert">
                Sorry! updated doesn't successfully.
             </div>
            @endif
            <div class="editable-tables">
                <div class="form-check form-switch" id="table-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                    <label class="form-check-label" for="flexSwitchCheckChecked">Fixed working time</label>
                </div>
                
                
                
                @if($dr_data->clinic_id == null)
                <form action="{{route('save.fixedtime')}}" method="POST" class="fixed-working-hours">
                    @csrf
                    <table class="appointment-table">
                        <tr>
                            <th>Location</th>
                            <td>
                                <select name="location" class="form-select" aria-label="Default select example" id="select-area" required>
                                    <option selected disabled value="">Choose your clinic area</option>
                                    @foreach ($governorates as $gov )
                                    <option value="{{$gov->governorate_name}}">{{$gov->governorate_name}}</option>
                                    @endforeach
                                </select>
                                    @if ($errors->has('clinic_address'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('clinic_address')}}
                                        </span>
                                    @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Clinic name</th>
                            <td>
                                <input name="clinicName" type="text" class="form-control" placeholder="Enter clinic's name" required>
                                    @if ($errors->has('name'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('name')}}
                                        </span>
                                    @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Phone number</th>
                            <td>
                                <input  name="phone" type="tel" class="form-control" placeholder="Enter phone number" required>
                                    @if ($errors->has('phone_number'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('phone_number')}}
                                        </span>
                                    @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Fees</th>
                            <td>
                                <input name="fees" type="number" class="form-control" placeholder="Enter fees" required>
                                    @if ($errors->has('fees'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('fees')}}
                                        </span>
                                    @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Working days</th>
                            <td>
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="saturday" id="satWorkingDay">
                                    <label class="form-check-label" for="satWorkingDay">
                                        Saturday
                                    </label>
                                </div>

                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="sunday" id="sunWorkingDay" >
                                    <label class="form-check-label" for="sunWorkingDay">
                                        Sunday
                                    </label>
                                </div>

                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="monday" id="monWorkingDay"  >
                                    <label class="form-check-label" for="monWorkingDay">
                                        Monday
                                    </label>
                                </div>

                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="tuesday" id="tueWorkingDay" >
                                    <label class="form-check-label" for="tueWorkingDay">
                                        Tuesday
                                    </label>
                                </div>

                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="wednesday" id="wedWorkingDay" >
                                    <label class="form-check-label" for="wedWorkingDay">
                                        Wednesday
                                    </label>
                                </div>

                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="thursday" id="thuWorkingDay">
                                    <label class="form-check-label" for="thuWorkingDay">
                                        Thursday
                                    </label>
                                </div>

                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="friday" id="friWorkingDay" >
                                    <label class="form-check-label" for="friWorkingDay">
                                        Friday
                                    </label>
                                </div>

                                @if ($errors->has('day'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('day')}}
                                    </span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Start time</th>
                            <td>
                                <input name="startTime" type="time" class="form-control" id="floatingInput" placeholder="" required>
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>End time</th>
                            <td>
                                <input name="endTime" type="time" class="form-control" id="floatingInput" placeholder="" required>
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2"><button type="submit" class="btn btn-primary">Submit</button></td>
                        </tr>
                    </table>
                </form>

                @else
                <form action="{{route('save.fixedtime')}}" method="POST" class="fixed-working-hours">
                    @csrf
                    <table class="appointment-table">
                        <tr>
                            <th>Location</th>
                            <td>
                                <select name="location" class="form-select" aria-label="Default select example" id="select-area" required>
                                    <option selected  value="{{$dr_clinic->clinic_address}}">{{$dr_clinic->clinic_address}}</option>
                                    @foreach ($governorates as $gov )
                                    <option value="{{$gov->governorate_name}}">{{$gov->governorate_name}}</option>
                                    @endforeach
                                </select>
                                    @if ($errors->has('clinic_address'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('clinic_address')}}
                                        </span>
                                    @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Clinic name</th>
                            <td>
                                <input value="{{ucwords($dr_clinic->name)}}" name="clinicName" type="text" class="form-control" placeholder="Enter clinic's name" required>
                                    @if ($errors->has('name'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('name')}}
                                        </span>
                                    @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Phone number</th>
                            <td>
                                <input value={{$dr_clinic->phone_number}} name="phone" type="tel" class="form-control" placeholder="Enter phone number" required>
                                    @if ($errors->has('phone_number'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('phone_number')}}
                                        </span>
                                    @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Fees</th>
                            <td>
                                <input value={{$dr_clinic->fees}} name="fees" type="number" class="form-control" placeholder="Enter fees" required>
                                    @if ($errors->has('fees'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('fees')}}
                                        </span>
                                    @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Working days</th>
                            <td>
                                @if (in_array("saturday" , $days))
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="saturday" id="satWorkingDay" checked>
                                    <label class="form-check-label" for="satWorkingDay">
                                        Saturday
                                    </label>
                                </div>
                                @else
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="saturday" id="satWorkingDay">
                                    <label class="form-check-label" for="satWorkingDay">
                                        Saturday
                                    </label>
                                </div>
                                @endif
                                @if (in_array("sunday" , $days))
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="sunday" id="sunWorkingDay" checked>
                                    <label class="form-check-label" for="sunWorkingDay">
                                        Sunday
                                    </label>
                                </div>
                                @else
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="sunday" id="sunWorkingDay" >
                                    <label class="form-check-label" for="sunWorkingDay">
                                        Sunday
                                    </label>
                                </div>
                                @endif

                                @if (in_array("monday" , $days))
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="monday" id="monWorkingDay" checked >
                                    <label class="form-check-label" for="monWorkingDay">
                                        Monday
                                    </label>
                                </div>
                                @else
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="monday" id="monWorkingDay"  >
                                    <label class="form-check-label" for="monWorkingDay">
                                        Monday
                                    </label>
                                </div>
                                @endif

                                @if (in_array("tuesday" , $days))
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="tuesday" id="tueWorkingDay" checked >
                                    <label class="form-check-label" for="tueWorkingDay">
                                        Tuesday
                                    </label>
                                </div>
                                @else
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="tuesday" id="tueWorkingDay" >
                                    <label class="form-check-label" for="tueWorkingDay">
                                        Tuesday
                                    </label>
                                </div>
                                @endif

                                @if (in_array("wednesday" , $days))
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="wednesday" id="wedWorkingDay" checked>
                                    <label class="form-check-label" for="wedWorkingDay">
                                        Wednesday
                                    </label>
                                </div>
                                @else
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="wednesday" id="wedWorkingDay" >
                                    <label class="form-check-label" for="wedWorkingDay">
                                        Wednesday
                                    </label>
                                </div>
                                @endif

                                @if (in_array("thursday" , $days))
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="thursday" id="thuWorkingDay"checked>
                                    <label class="form-check-label" for="thuWorkingDay">
                                        Thursday
                                    </label>
                                </div>
                                @else
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="thursday" id="thuWorkingDay">
                                    <label class="form-check-label" for="thuWorkingDay">
                                        Thursday
                                    </label>
                                </div>
                                @endif
                                @if (in_array("friday" , $days))
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="friday" id="friWorkingDay" checked>
                                    <label class="form-check-label" for="friWorkingDay">
                                        Friday
                                    </label>
                                </div>
                                @else
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="friday" id="friWorkingDay" >
                                    <label class="form-check-label" for="friWorkingDay">
                                        Friday
                                    </label>
                                </div>
                                @endif

                                @if ($errors->has('day'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('day')}}
                                    </span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Start time</th>
                            <td>
                                <input name="startTime" type="time" class="form-control" id="floatingInput" placeholder="" required>
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>End time</th>
                            <td>
                                <input name="endTime" type="time" class="form-control" id="floatingInput" placeholder="" required>
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2"><button type="submit" class="btn btn-primary">Submit</button></td>
                        </tr>
                    </table>
                </form>
                @endif


                @if($dr_data->clinic_id == null)

                <form action="{{route('save.flexibletime')}}" method="POST" class="custom-working-hours">
                    @csrf
                    <table class="appointment-table">
                        <tr>
                            <th colspan="3">Location</th>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <select name="location" class="form-select" aria-label="Default select example" id="select-area" required>
                                    <option selected disabled value="">Choose your clinic area</option>
                                    @foreach ($governorates as $gov )
                                    <option value="{{$gov->governorate_name}}">{{$gov->governorate_name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('clinic_address'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('clinic_address')}}
                                    </span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Clinic name</th>
                            <th>Clinic number</th>
                            <th>Fees</th>
                        </tr>

                        <tr>
                            <td>
                                <input name="clinicName" type="text" class="form-control" placeholder="Enter clinic's name" required>
                                @if ($errors->has('name'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('name')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <input name="phone" type="tel" class="form-control" placeholder="Enter phone number" required>
                                @if ($errors->has('phone_number'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('phone_number')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <input name="fees" type="number" class="form-control" placeholder="Enter fees" required>
                                @if ($errors->has('fees'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('fees')}}
                                    </span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Working days</th>
                            <th>Start time</th>
                            <th>End time</th>
                        </tr>

                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="saturday" id="satCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="satCustom">
                                        Saturday
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input name="startTime[]" type="time" class="form-control" id="satStartTime" disabled required>
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <input name="endTime[]" type="time" class="form-control" id="satEndTime" disabled required>
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="sunday" id="sunCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="sunCustom">
                                        Sunday
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input name="startTime[]" type="time" class="form-control" id="sunStartTime" disabled required>
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <input name="endTime[]" type="time" class="form-control" id="sunEndTime" disabled required>
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="monday" id="monCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="monCustom">
                                        Monday
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input name="startTime[]" type="time" class="form-control" id="monStartTime" disabled required>
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <input name="endTime[]" type="time" class="form-control" id="monEndTime" disabled required>
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="tuesday" id="tueCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="tueCustom">
                                        Tuesday
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input name="startTime[]" type="time" class="form-control" id="tueStartTime" disabled required>
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <input name="endTime[]" type="time" class="form-control" id="tueEndTime" disabled required>
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="wednesday" id="wedCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="wedCustom">
                                        Wednesday
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input name="startTime[]" type="time" class="form-control" id="wedStartTime" disabled required>
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <input name="endTime[]" type="time" class="form-control" id="wedEndTime" disabled required>
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="thursday" id="thuCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="thuCustom">
                                        Thursday
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input name="startTime[]" type="time" class="form-control" id="thuStartTime" disabled required>
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <input name="endTime[]" type="time" class="form-control" id="thuEndTime" disabled required>
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="friday" id="friCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="friCustom">
                                        Friday
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input name="startTime[]" type="time" class="form-control" id="friStartTime" disabled required>
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <input name="endTime[]" type="time" class="form-control" id="friEndTime" disabled required>
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td colspan="3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </td>
                        </tr>
                    </table>
                </form>
                @else
                <form action="{{route('save.flexibletime')}}" method="POST" class="custom-working-hours">
                    @csrf
                    <table class="appointment-table">
                        <tr>
                            <th colspan="3">Location</th>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <select name="location" class="form-select" aria-label="Default select example" id="select-area" required >
                                    <option selected value="{{$dr_clinic->clinic_address}}">{{$dr_clinic->clinic_address}}</option>
                                    @foreach ($governorates as $gov )
                                    <option value="{{$gov->governorate_name}}">{{$gov->governorate_name}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('clinic_address'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('clinic_address')}}
                                    </span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Clinic name</th>
                            <th>Clinic number</th>
                            <th>Fees</th>
                        </tr>

                        <tr>
                            <td>
                                <input value="{{ucwords($dr_clinic->name)}}" name="clinicName" type="text" class="form-control" placeholder="Enter clinic's name" required>
                                @if ($errors->has('name'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('name')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <input value={{$dr_clinic->phone_number}} name="phone" type="tel" class="form-control" placeholder="Enter phone number" required>
                                @if ($errors->has('phone_number'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('phone_number')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <input value={{$dr_clinic->fees}} name="fees" type="number" class="form-control" placeholder="Enter fees" required>
                                @if ($errors->has('fees'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('fees')}}
                                    </span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Working days</th>
                            <th>Start time</th>
                            <th>End time</th>
                        </tr>

                        @if(in_array("saturday", $days))
                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input checked class="form-check-input" type="checkbox" name="workingDays[]" value="saturday" id="satCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="satCustom">
                                        Saturday
                                    </label>
                                </div>
                            </td>
                            <td>
                                @foreach ($starttime as $key => $k)
                                @if ($k["day"] === "saturday")
                                    <input value={{$k['start_time']}} name="startTime[]" type="time" class="form-control" id="satStartTime"  required>
                                @endif
                                @endforeach
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @foreach ($endtime as $key => $k)
                                @if ($k["day"] === "saturday")
                                <input value={{$k['end_time']}} name="endTime[]" type="time" class="form-control" id="satEndTime"  required>
                                @endif
                                @endforeach
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="saturday" id="satCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="satCustom">
                                        Saturday
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input name="startTime[]" type="time" class="form-control" id="satStartTime" disabled required>
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <input name="endTime[]" type="time" class="form-control" id="satEndTime" disabled required>
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endif

                        @if(in_array("sunday", $days))
                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input checked class="form-check-input" type="checkbox" name="workingDays[]" value="sunday" id="sunCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="sunCustom">
                                        Sunday
                                    </label>
                                </div>
                            </td>
                            <td>
                                @foreach ($starttime as $key => $k)
                                @if ($k["day"] === "sunday")
                                    <input value={{$k['start_time']}} name="startTime[]" type="time" class="form-control" id="sunStartTime"  required>
                                @endif
                                @endforeach
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @foreach ($endtime as $key => $k)
                                @if ($k["day"] === "sunday")
                                    <input value={{$k['end_time']}} name="endTime[]" type="time" class="form-control" id="sunEndTime"  required>
                                @endif
                                @endforeach
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="sunday" id="sunCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="sunCustom">
                                        Sunday
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input name="startTime[]" type="time" class="form-control" id="sunStartTime" disabled required>
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <input name="endTime[]" type="time" class="form-control" id="sunEndTime" disabled required>
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endif

                        @if(in_array("monday", $days))
                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input checked class="form-check-input" type="checkbox" name="workingDays[]" value="monday" id="monCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="monCustom">
                                        Monday
                                    </label>
                                </div>
                            </td>
                            <td>
                                @foreach ($starttime as $key => $k)
                                @if ($k["day"] === "monday")
                                    <input value={{$k['start_time']}} name="startTime[]" type="time" class="form-control" id="monStartTime"  required>
                                @endif
                                @endforeach
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @foreach ($endtime as $key => $k)
                                @if ($k["day"] === "monday")
                                    <input value={{$k['end_time']}} name="endTime[]" type="time" class="form-control" id="monEndTime"  required>
                                @endif
                                @endforeach
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="monday" id="monCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="monCustom">
                                        Monday
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input name="startTime[]" type="time" class="form-control" id="monStartTime" disabled required>
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <input name="endTime[]" type="time" class="form-control" id="monEndTime" disabled required>
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endif

                        @if(in_array("tuesday", $days))
                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input checked class="form-check-input" type="checkbox" name="workingDays[]" value="tuesday" id="tueCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="tueCustom">
                                        Tuesday
                                    </label>
                                </div>
                            </td>
                            <td>
                                @foreach ($starttime as $key => $k)
                                @if ($k["day"] === "tuesday")
                                    <input value={{$k['start_time']}} name="startTime[]" type="time" class="form-control" id="tueStartTime"  required>
                                @endif
                                @endforeach
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @foreach ($endtime as $key => $k)
                                @if ($k["day"] === "tuesday")
                                    <input value={{$k['end_time']}} name="endTime[]" type="time" class="form-control" id="tueEndTime"  required>
                                @endif
                                @endforeach
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="tuesday" id="tueCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="tueCustom">
                                        Tuesday
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input name="startTime[]" type="time" class="form-control" id="tueStartTime" disabled required>
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <input name="endTime[]" type="time" class="form-control" id="tueEndTime" disabled required>
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endif

                        @if(in_array("wednesday", $days))
                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input checked class="form-check-input" type="checkbox" name="workingDays[]" value="wednesday" id="wedCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="wedCustom">
                                        Wednesday
                                    </label>
                                </div>
                            </td>
                            <td>
                                @foreach ($starttime as $key => $k)
                                @if ($k["day"] === "wednesday")
                                    <input value={{$k['start_time']}} name="startTime[]" type="time" class="form-control" id="wedStartTime"  required>
                                @endif
                                @endforeach
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @foreach ($endtime as $key => $k)
                                @if ($k["day"] === "wednesday")
                                <input value={{$k['end_time']}} name="endTime[]" type="time" class="form-control" id="wedEndTime"  required>
                                @endif
                                @endforeach
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="wednesday" id="wedCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="wedCustom">
                                        Wednesday
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input name="startTime[]" type="time" class="form-control" id="wedStartTime" disabled required>
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <input name="endTime[]" type="time" class="form-control" id="wedEndTime" disabled required>
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endif

                        @if(in_array("thursday", $days))
                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input checked class="form-check-input" type="checkbox" name="workingDays[]" value="thursday" id="thuCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="thuCustom">
                                        Thursday
                                    </label>
                                </div>
                            </td>
                            <td>
                                @foreach ($starttime as $key => $k)
                                @if ($k["day"] === "thursday")
                                <input value={{$k['start_time']}} name="startTime[]" type="time" class="form-control" id="thuStartTime"  required>
                                @endif
                                @endforeach
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @foreach ($endtime as $key => $k)
                                @if ($k["day"] === "thursday")
                                <input value={{$k['end_time']}} name="endTime[]" type="time" class="form-control" id="thuEndTime"  required>
                                @endif
                                @endforeach
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="thursday" id="thuCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="thuCustom">
                                        Thursday
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input name="startTime[]" type="time" class="form-control" id="thuStartTime" disabled required>
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <input name="endTime[]" type="time" class="form-control" id="thuEndTime" disabled required>
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endif

                        @if(in_array("friday", $days))
                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input checked class="form-check-input" type="checkbox" name="workingDays[]" value="friday" id="friCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="friCustom">
                                        Friday
                                    </label>
                                </div>
                            </td>
                            <td>
                                @foreach ($starttime as $key => $k)
                                @if ($k["day"] === "friday")
                                <input value={{$k['start_time']}} name="startTime[]" type="time" class="form-control" id="friStartTime"  required>
                                @endif
                                @endforeach
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @foreach ($endtime as $key => $k)
                                @if ($k["day"] === "friday")
                                <input value={{$k['end_time']}} name="endTime[]" type="time" class="form-control" id="friEndTime"  required>
                                @endif
                                @endforeach
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td>
                                <div class="form-check days-check-div">
                                    <input class="form-check-input" type="checkbox" name="workingDays[]" value="friday" id="friCustom">
                                    @if ($errors->has('day'))
                                        <span class="text-danger d-block">
                                            {{$errors->first('day')}}
                                        </span>
                                    @endif
                                    <label class="form-check-label" for="friCustom">
                                        Friday
                                    </label>
                                </div>
                            </td>
                            <td>
                                <input name="startTime[]" type="time" class="form-control" id="friStartTime" disabled required>
                                @if ($errors->has('start_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('start_time')}}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <input name="endTime[]" type="time" class="form-control" id="friEndTime" disabled required>
                                @if ($errors->has('end_time'))
                                    <span class="text-danger d-block">
                                        {{$errors->first('end_time')}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endif

                        <tr>
                            <td colspan="3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </td>
                        </tr>
                    </table>
                </form>
                @endif
            </div>

            @if($dr_data->clinic_id != null)
                <table class="appointment-table" id="static-table">
                    <tr>
                        <th colspan="3">Location</th>
                    </tr>
                    <tr>
                        <td colspan="3">
                            {{$dr_clinic->clinic_address}}
                        </td>
                    </tr>
                    <tr>
                        <th>Clinic name</th>
                        <th>Clinic number</th>
                        <th>Fees</th>
                    </tr>
                    <tr>
                        <td>
                            {{ucwords($dr_clinic->name)}}
                        </td>
                        <td>
                            {{$dr_clinic->phone_number}}
                        </td>
                        <td>
                            {{$dr_clinic->fees}} EGP
                        </td>
                    </tr>
                    <tr>
                        <th>Working days</th>
                        <th>Start time</th>
                        <th>End time</th>
                    </tr>

                    @foreach ($dr_worktime as $time)
                    <tr>
                        <td>
                            {{ucfirst($time->day)}}
                        </td>
                        <td>
                            {{date('h:i A', strtotime($time->start_time)) }}
                        </td>
                        <td>
                            {{date('h:i A', strtotime($time->end_time))}}
                        </td>
                    </tr>
                    @endforeach
                    @if(!isset($booked_apps))
                        <tr>
                            <td colspan="3"><button type="button" class="btn btn-danger" id="update-schedule-btn">Update</button></td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="3" class="fw-semibold  fs-5"> To update your working time, you must cancel your booked appointments first. </td>
                        </tr>
                    @endif
                </table>


            @else
                <div class="no-working-hours-div">
                    <span class="no-hours-span">No available working hours</span>
                    <button type="button" class="btn btn-primary add-hours-btn" id="add-hours-btn">Add working hours</button>
                </div>
            @endif

        </div>

        <div class="line"></div>

        @if(isset($patients_list))

            <div class="add-appointment mb-5">
                <span class="schedule-header d-block">Patients list</span>

                @foreach($patients_list as $patient)
                <div class="patient-card">
                    <div class="row gutter">
                        <div class="col">
                            <p class="patient-name">{{ ucwords($patient->first_name) }} {{ ucwords($patient->last_name) }}</p>
                            <p class="patient-date"><i class="fa-solid fa-calendar-days"></i> {{ date('j- m- Y', strtotime($patient->date)) }}</p>
                        </div>

                        @if(isset($patients_have_prescriptions))
                            @if(in_array($patient->app_id, $patients_have_prescriptions) )
                                <div class="col end">
                                    <a href="{{ route('edit.prescription', $patient->app_id) }}"><button class="btn btn-primary"><i class="fa-solid fa-clipboard"></i> Edit prescription</button></a>
                                </div>
                            @else
                                <div class="col end">
                                    <a href="{{ route('add.prescription', $patient->app_id) }}"><button class="btn btn-primary"><i class="fa-solid fa-clipboard"></i> Add prescription</button></a>
                                </div>
                            @endif
                        @else
                            <div class="col end">
                                <a href="{{ route('add.prescription', $patient->app_id) }}"><button class="btn btn-primary"><i class="fa-solid fa-clipboard"></i> Add prescription</button></a>
                            </div>
                        @endif

                    </div>
                </div>
                @endforeach

                <a href="{{ route('all.patients') }}" class="btn btn-primary more-patient-btn">Show more</a>
            </div>

        @endif
    </div>
</div>
@endsection

@section('jquery')
<script>
    $("#editDescBtn").click(function(){
                $("#docAbout").toggle()
                $("#editDocDesc").toggle()
            })
            $("#cancelEditBtn").click(function(){
                $("#docAbout").toggle()
                $("#editDocDesc").toggle()
            })
            $("#flexSwitchCheckChecked").click(function(){
                $(".fixed-working-hours").toggle()
                $(".custom-working-hours").toggle()
            })

            $("#satCustom").click(function(){
                if(this.checked){
                    $("#satStartTime").prop("disabled", false);
                    $("#satEndTime").prop("disabled", false);
                }else{
                    $("#satEndTime").attr("value", "--:--");
                    $("#satStartTime").attr("value", "--:--");
                    $("#satStartTime").prop("disabled", true);
                    $("#satEndTime").prop("disabled", true);
                }
            })
            $("#sunCustom").click(function(){
                if(this.checked){
                    $("#sunStartTime").prop("disabled", false);
                    $("#sunEndTime").prop("disabled", false);
                }else{
                    $("#sunEndTime").attr("value", "--:--");
                    $("#sunStartTime").attr("value", "--:--");
                    $("#sunStartTime").prop("disabled", true);
                    $("#sunEndTime").prop("disabled", true);
                }
            })
            $("#monCustom").click(function(){
                if(this.checked){
                    $("#monStartTime").prop("disabled", false);
                    $("#monEndTime").prop("disabled", false);
                }else{
                    $("#monEndTime").attr("value", "--:--");
                    $("#monStartTime").attr("value", "--:--");
                    $("#monStartTime").prop("disabled", true);
                    $("#monEndTime").prop("disabled", true);
                }
            })
            $("#tueCustom").click(function(){
                if(this.checked){
                    $("#tueStartTime").prop("disabled", false);
                    $("#tueEndTime").prop("disabled", false);
                }else{
                    $("#tueEndTime").attr("value", "--:--");
                    $("#tueStartTime").attr("value", "--:--");
                    $("#tueStartTime").prop("disabled", true);
                    $("#tueEndTime").prop("disabled", true);
                }
            })
            $("#wedCustom").click(function(){
                if(this.checked){
                    $("#wedStartTime").prop("disabled", false);
                    $("#wedEndTime").prop("disabled", false);
                }else{
                    $("#wedEndTime").attr("value", "--:--");
                    $("#wedStartTime").attr("value", "--:--");
                    $("#wedStartTime").prop("disabled", true);
                    $("#wedEndTime").prop("disabled", true);
                }
            })
            $("#thuCustom").click(function(){
                if(this.checked){
                    $("#thuStartTime").prop("disabled", false);
                    $("#thuEndTime").prop("disabled", false);
                }else{
                    $("#thuEndTime").attr("value", "--:--");
                    $("#thuStartTime").attr("value", "--:--");
                    $("#thuStartTime").prop("disabled", true);
                    $("#thuEndTime").prop("disabled", true);
                }
            })
            $("#friCustom").click(function(){
                if(this.checked){
                    $("#friStartTime").prop("disabled", false);
                    $("#friEndTime").prop("disabled", false);
                }else{
                    $("#friEndTime").attr("value", "--:--");
                    $("#friStartTime").attr("value", "--:--");
                    $("#friStartTime").prop("disabled", true);
                    $("#friEndTime").prop("disabled", true);
                }
            })

            $("#update-schedule-btn").click(function(){
                $("#static-table").toggle()
                $(".editable-tables").toggle()

            })
            $("#add-hours-btn").click(function(){
                $(".editable-tables").toggle()
                $(".no-working-hours-div").toggle()
            })
</script>
@endsection

