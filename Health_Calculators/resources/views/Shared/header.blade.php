<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{url('css/all.min.css')}}">
        <link rel="stylesheet" href="{{url('css/header.css')}}">
        <link rel="stylesheet" href="{{url('css/aos.css')}}">
        @yield('css')

        <title>@yield('title')</title>
    </head>
    <body>
        <div class="header">
            <div class="row gutter header-row ">
                <div class="col-3 header-left-col">
                    <a href="">
                        <img src="{{url('img/full-logo-black.png')}}" class="header-logo" alt="">
                    </a>
                </div>
                <div class="col header-right-col">
                    <a href="{{route('home.page')}}" class="header-link"><i class="fa-solid fa-house"></i> Home</a>
                    <a href="{{route('all.question')}}" class="header-link"><i class="fa-sharp fa-solid fa-circle-question"></i> FAQ</a>

                    @if(Session::has('logged_in_admin'))
                    <div class="dropdown-center header-dropdown">
                        <button class="dropdown-toggle header-dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-sharp fa-solid fa-circle-check"></i>  {{'Admin'}}
                        </button>
                        <ul class="dropdown-menu header-dropdown-menu mt-3">
                            <li><button class="dropdown-item header-item" id="add-article-btn"><i class="fa-solid fa-paperclip"></i> Add article</button></li>
                            <li><a class="dropdown-item header-item" href="{{route('all.articles')}}"><i class="fa-solid fa-file-pen"></i> View / Edit articles</a></li>
                            <li><a class="dropdown-item header-item" href="{{route('doctor.request')}}"><i class="fa-solid fa-user-doctor"></i> Doctor's requests</a></li>
                            <li><a class="dropdown-item header-item" href="{{route('all.dr')}}"><i class="fa-solid fa-user-pen"></i> View / Edit Doctors</a></li>
                        </ul>
                    </div>
                    @elseif (Session::has('logged_in_patient'))
                    <div class="dropdown-center header-dropdown">
                        <button class="dropdown-toggle header-dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-sharp fa-solid fa-circle-check"></i>  {{'Patient'}}
                        </button>
                        <ul class="dropdown-menu header-dropdown-menu mt-3">
                            <li><a class="dropdown-item header-item" href="{{route('patient.profile')}}"><i class="fa-solid fa-user-pen"></i> Profile</a></li>
                            <li><a class="dropdown-item header-item" href="{{route('all.patient.prescriptions')}}"><i class="fa-sharp fa-solid fa-clipboard"></i> Prescriptions</a></li>
                        </ul>
                    </div>
                    <!-- new -->
                    @if($patient_deleted_appointments->isEmpty() && $prescriptions->isEmpty())
                        <div class="dropdown-center header-dropdown">
                            <a href="{{route('all.notifications')}}" class="notification-item">
                                <button class="header-dropdown-btn" type="button" aria-expanded="false">
                                    <i class="fa-solid fa-bell"></i>
                                </button>
                            </a>
                        </div>
                    @elseif(!$patient_deleted_appointments->isEmpty() && !$prescriptions->isEmpty())
                        @php
                            $merged_patient_notifications = collect($patient_deleted_appointments)->merge(collect($prescriptions))->sortByDesc('updated_at')
                        @endphp
                        <div class="dropdown-center header-dropdown">
                            <button class="header-dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bell"></i>
                                <span class="position-absolute top-10 start-90 translate-middle p-1 bg-danger border border-light rounded-circle">
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                            </button>
                            <ul class="dropdown-menu header-dropdown-menu notification-menu mt-3">
                            @foreach($merged_patient_notifications as $notification)
                            @if(!empty($notification->reasion))
                                <div class="notification-card">
                                    <a href="{{route('all.notifications')}}" class="notification-item">Your appointment with dr. {{$notification->first_name}} {{$notification->last_name}} has been canceled.</a>
                                </div>
                            @else
                                <div class="notification-card">
                                    <a href="{{route('all.notifications')}}" class="notification-item">Dr. {{ucwords($notification->first_name)}} {{ucwords($notification->last_name)}} creates a prescription for you.</a>
                                </div>
                            @endif
                            @endforeach
                            <div class="view-more-card">
                                <a href="{{route('all.notifications')}}" class="view-more-a">View more..</a>
                            </div>
                            </ul>
                        </div>
                    @elseif(!$patient_deleted_appointments->isEmpty() || !$prescriptions->isEmpty())
                        <div class="dropdown-center header-dropdown">
                            <button class="header-dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bell"></i>
                                <span class="position-absolute top-10 start-90 translate-middle p-1 bg-danger border border-light rounded-circle">
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                            </button>
                            <ul class="dropdown-menu header-dropdown-menu notification-menu mt-3">
                                @if(!$patient_deleted_appointments->isEmpty())
                                    @foreach ($patient_deleted_appointments as $patient_notification )
                                    <div class="notification-card">
                                        <a href="{{route('all.notifications')}}" class="notification-item">Your appointment with dr. {{$patient_notification->first_name}} {{$patient_notification->last_name}} has been canceled.</a>
                                    </div>
                                    @endforeach
                                @endif
                                @if(!$prescriptions->isEmpty())
                                    @foreach ($prescriptions as $pre )
                                    <div class="notification-card">
                                        <a href="{{route('all.notifications')}}" class="notification-item">Dr. {{ucwords($pre->first_name)}} {{ucwords($pre->last_name)}} creates a prescription for you.</a>
                                    </div>
                                    @endforeach
                                @endif
                                <div class="view-more-card">
                                    <a href="{{route('all.notifications')}}" class="view-more-a">View more..</a>
                                </div>
                            </ul>
                        </div>
                    @endif
                    <!-- end -->
                    @elseif ((Session::has('logged_in_doctor')))
                    <div class="dropdown-center header-dropdown">
                        <button class="dropdown-toggle header-dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-sharp fa-solid fa-circle-check"></i>  {{'Doctor'}}
                        </button>
                        <ul class="dropdown-menu header-dropdown-menu mt-3">
                            <li><a class="dropdown-item header-item" href="{{route('drprofile')}}"><i class="fa-solid fa-user-pen"></i> Profile</a></li>
                        </ul>
                    </div>
                    <!-- new -->
                    @if(isset($new_dr))

                    @else
                    @if($doctor_canceled_appointments->isEmpty() && $doctor_rate->isEmpty())
                        <div class="dropdown-center header-dropdown">
                            <a href="{{route('all.notifications')}}" class="notification-item">
                                <button class="header-dropdown-btn" type="button" aria-expanded="false">
                                    <i class="fa-solid fa-bell"></i>
                                </button>
                            </a>
                        </div>
                    @elseif(!$doctor_canceled_appointments->isEmpty() && !$doctor_rate->isEmpty())
                        @php
                            $megred_doctor_notifications = collect($doctor_canceled_appointments)->merge(collect($doctor_rate))->sortByDesc('updated_at')
                        @endphp
                        <div class="dropdown-center header-dropdown">
                            <button class="header-dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bell"></i>
                                <span class="position-absolute top-10 start-90 translate-middle p-1 bg-danger border border-light rounded-circle">
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                            </button>
                            <ul class="dropdown-menu header-dropdown-menu notification-menu mt-3">
                                @foreach($megred_doctor_notifications as $notification)
                                @if(!empty($notification->date))
                                    <div class="notification-card">
                                        <a href="{{route('all.notifications')}}" class="notification-item">Your appointment with {{$notification->first_name}} {{$notification->last_name}} has been canceled.</a>
                                    </div>
                                @else
                                    <div class="notification-card">
                                        <a href="{{route('all.notifications')}}" class="notification-item">Your patient {{lcfirst($notification->first_name)}} {{lcfirst($notification->last_name)}} gives you {{ $notification->rate }} stars. </a>
                                    </div>
                                @endif
                                @endforeach
                                <div class="view-more-card">
                                    <a href="{{route('all.notifications')}}" class="view-more-a">View more..</a>
                                </div>
                            </ul>
                        </div>
                    @elseif(!$doctor_canceled_appointments->isEmpty() || !$doctor_rate->isEmpty())
                        <div class="dropdown-center header-dropdown">
                            <button class="header-dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bell"></i>
                                <span class="position-absolute top-10 start-90 translate-middle p-1 bg-danger border border-light rounded-circle">
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                            </button>
                            <ul class="dropdown-menu header-dropdown-menu notification-menu mt-3">
                                @if(!$doctor_canceled_appointments->isEmpty())
                                    @foreach ($doctor_canceled_appointments as $dr )
                                        <div class="notification-card">
                                            <a href="{{route('all.notifications')}}" class="notification-item">Your appointment with {{$dr->first_name}} {{$dr->last_name}} has been canceled.</a>
                                        </div>
                                    @endforeach
                                @endif
                                @if(!($doctor_rate)->isEmpty())
                                    @foreach ($doctor_rate as $dr_rate )
                                        <div class="notification-card">
                                            <a href="{{route('all.notifications')}}" class="notification-item">Your patient {{lcfirst($dr_rate->first_name)}} {{lcfirst($dr_rate->last_name)}} gives you {{ $dr_rate->rate }} stars. </a>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="view-more-card">
                                    <a href="{{route('all.notifications')}}" class="view-more-a">View more..</a>
                                </div>
                            </ul>
                        </div>
                    @endif
                    @endif
                    <!-- end -->
                    @elseif (Session::has('waiting_dr') || Session::has('rejected_dr'))
                    @endif


                    <div class="dropdown-center header-dropdown">
                        <button class="dropdown-toggle header-dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user"></i>
                        </button>
                        @if (Session::has('waiting_dr') || Session::has('rejected_dr'))
                            <ul class="dropdown-menu header-dropdown-menu mt-3">
                                <li><a class="dropdown-item header-item" href="{{route('all.logout')}}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a></li>
                            </ul>
                        @elseif(Session::has('logged_in_admin') || Session::has('logged_in_doctor') || Session::has('logged_in_patient'))
                            <ul class="dropdown-menu header-dropdown-menu mt-3">
                                <li><a class="dropdown-item header-item" href="{{route('profile.edit')}}"><i class="fa-solid fa-pen-to-square"></i> Edit profile</a></li>
                                <li><a class="dropdown-item header-item" href="{{route('all.logout')}}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a></li>
                            </ul>
                        @else
                            <ul class="dropdown-menu header-dropdown-menu mt-3">
                                <li><a class="dropdown-item header-item" href="{{route('all.login')}}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Login</a></li>
                            </ul>
                        @endif
                    </div>

                    <form action="{{route('search_doctors')}}" method="POST" class="header-search" id="searchFormHeader">
                        @csrf
                        <div class="input-group">
                            <input type="text" id="search_query_header" class="header-search-input" name="searchQuery" placeholder="Search" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <input type="hidden" id="search_speciality_type_header" name="search_speciality_type">
                            <input type="hidden" id="search_by_rating" name="search_by_rating">
                            <input type="hidden" id="search_location_header" name="search_location">
                            <input type="hidden" id="search_gov" name="search_gov">
                            <input type="hidden" id="search_city" name="search_city">
                            <input type="hidden" id="search_page" name="search_page">
                            <button class="btn btn-primary search-btn" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                </div>

                <div class="col end header-nav-col">
                    <button class="navbar-toggler nav-toggler-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div class="offcanvas offcanvas-end header-canvas" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img src="{{url('img/full-logo-black.png')}}" class="header-logo" alt=""></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>


                        @if (Session::has('logged_in_admin'))
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('home.page')}}"><i class="fa-solid fa-house"></i> Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('all.question')}}"><i class="fa-sharp fa-solid fa-circle-question"></i> FAQ</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-sharp fa-solid fa-circle-check"></i> {{'Admin'}}
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><button class="dropdown-item header-item" id="add-article-btn-sm" data-bs-dismiss="offcanvas" aria-label="Close" type="btn"><i class="fa-solid fa-paperclip"></i> Add article</button></li>
                                        <li><a class="dropdown-item header-item" href="{{route('all.articles')}}"><i class="fa-solid fa-file-pen"></i> View / Edit articles</a></li>
                                        <li><a class="dropdown-item header-item" href="{{route('doctor.request')}}"><i class="fa-solid fa-user-doctor"></i> Doctor's requests</a></li>
                                        <li><a class="dropdown-item header-item" href="{{route('all.dr')}}"><i class="fa-solid fa-user-pen"></i> View / Edit Doctors</a></li>
                                    </ul>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-user"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item header-item" href="{{route('profile.edit')}}"><i class="fa-solid fa-pen-to-square"></i> Edit profile</a></li>
                                        <li><a class="dropdown-item header-item" href="{{route('all.logout')}}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <form action="{{route('search_doctors')}}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="searchQuery" id="search_query_header2" class="header-search-input-sm" placeholder="Search" aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <button class="btn btn-primary search-btn" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>


                        @elseif (Session::has('logged_in_doctor'))
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('home.page')}}"><i class="fa-solid fa-house"></i> Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('all.question')}}"><i class="fa-sharp fa-solid fa-circle-question"></i> FAQ</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-sharp fa-solid fa-circle-check"></i> {{'Doctor'}}
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item header-item" href="{{route('drprofile')}}"><i class="fa-solid fa-user-pen"></i> Profile</a></li>
                                    </ul>
                                </li>

                                <!-- new -->
                                @if(isset($new_dr))

                                @else
                                @if($doctor_canceled_appointments->isEmpty() && $doctor_rate->isEmpty())
                                    <li class="nav-item">
                                        <a class="ahmed-link" href="{{route('all.notifications')}}">
                                            <button class="nav-link"  role="button" aria-expanded="false">
                                                <i class="fa-solid fa-bell"></i> Notifications
                                            </button>
                                        </a>
                                    </li>
                                @elseif(!$doctor_canceled_appointments->isEmpty() && !$doctor_rate->isEmpty())
                                @php
                                    $megred_doctor_notifications = collect($doctor_canceled_appointments)->merge(collect($doctor_rate))->sortByDesc('updated_at')
                                @endphp
                                    <li class="nav-item dropdown">
                                        <button class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-bell"></i> Notifications
                                            <span class="position-absolute top-10 start-10 translate-middle p-1 bg-danger border border-light rounded-circle">
                                                <span class="visually-hidden">New alerts</span>
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu header-dropdown-menu notification-menu">
                                        @foreach($megred_doctor_notifications as $notification)
                                        @if(!empty($notification->date))
                                            <div class="notification-card">
                                                <a href="{{route('all.notifications')}}" class="notification-item">Your appointment with {{$notification->first_name}} {{$notification->last_name}} has been canceled.</a>
                                            </div>
                                        @else
                                            <div class="notification-card">
                                                <a href="{{route('all.notifications')}}" class="notification-item">Your patient {{lcfirst($notification->first_name)}} {{lcfirst($notification->last_name)}} gives you {{ $notification->rate }} stars. </a>
                                            </div>
                                        @endif
                                        @endforeach
                                        <div class="view-more-card">
                                                <a href="{{route('all.notifications')}}" class="view-more-a">View more..</a>
                                            </div>
                                        </ul>
                                    </li>
                                @elseif(!$doctor_canceled_appointments->isEmpty() || !$doctor_rate->isEmpty())
                                    <li class="nav-item dropdown">
                                        <button class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-bell"></i> Notifications
                                            <span class="position-absolute top-10 start-10 translate-middle p-1 bg-danger border border-light rounded-circle">
                                                <span class="visually-hidden">New alerts</span>
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu header-dropdown-menu notification-menu">
                                            @if(!$doctor_canceled_appointments->isEmpty())
                                                @foreach ( $doctor_canceled_appointments as $dr )
                                                    <div class="notification-card">
                                                        <a href="{{route('all.notifications')}}" class="notification-item">Your appointment with {{$dr->first_name}} {{$dr->last_name}} has been canceled.</a>
                                                    </div>
                                                @endforeach
                                            @endif
                                            @if(!$doctor_rate->isEmpty())
                                                @foreach ( $doctor_rate as $dr_rate )
                                                    <div class="notification-card">
                                                        <a href="{{route('all.notifications')}}" class="notification-item">Your patient {{lcfirst($dr_rate->first_name)}} {{lcfirst($dr_rate->last_name)}} gives you {{ $dr_rate->rate }} stars. </a>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="view-more-card">
                                                <a href="{{route('all.notifications')}}" class="view-more-a">View more..</a>
                                            </div>
                                        </ul>
                                    </li>
                                @endif
                                @endif
                                <!-- end -->

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-user"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item header-item" href="{{route('profile.edit')}}"><i class="fa-solid fa-pen-to-square"></i> Edit profile</a></li>
                                        <li><a class="dropdown-item header-item" href="{{route('all.logout')}}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <form action="{{route('search_doctors')}}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="searchQuery" id="search_query_header2" class="header-search-input-sm" placeholder="Search" aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <button class="btn btn-primary search-btn" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>


                        @elseif (Session::has('logged_in_patient'))
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('home.page')}}"><i class="fa-solid fa-house"></i> Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('all.question')}}"><i class="fa-sharp fa-solid fa-circle-question"></i> FAQ</a>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-sharp fa-solid fa-circle-check"></i> {{'Patient'}}
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item header-item" href="{{route('patient.profile')}}"><i class="fa-solid fa-user-pen"></i> Profile</a></li>
                                        <li><a class="dropdown-item header-item" href="{{route('all.patient.prescriptions')}}"><i class="fa-sharp fa-solid fa-clipboard"></i> Prescriptions</a></li>
                                    </ul>
                                </li>

                                <!-- new -->
                                @if($patient_deleted_appointments->isEmpty() && $prescriptions->isEmpty())
                                    <li class="nav-item">
                                        <a class="ahmed-link" href="{{route('all.notifications')}}">
                                            <button class="nav-link"  role="button" aria-expanded="false">
                                                <i class="fa-solid fa-bell"></i> Notifications
                                            </button>
                                        </a>
                                    </li>
                                @elseif(!$patient_deleted_appointments->isEmpty() && !$prescriptions->isEmpty())
                                @php
                                    $merged_patient_notifications = collect($patient_deleted_appointments)->merge(collect($prescriptions))->sortByDesc('updated_at')
                                @endphp
                                <li class="nav-item dropdown">
                                    <button class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-bell"></i> Notifications
                                        <span class="position-absolute top-10 start-10 translate-middle p-1 bg-danger border border-light rounded-circle">
                                            <span class="visually-hidden">New alerts</span>
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu header-dropdown-menu notification-menu">
                                    @foreach($merged_patient_notifications as $notification)
                                    @if(!empty($notification->reasion))
                                        <div class="notification-card">
                                            <a href="{{route('all.notifications')}}" class="notification-item">Your appointment with Dr {{$notification->first_name}} {{$notification->last_name}} has been canceled.</a>
                                        </div>
                                    @else
                                        <div class="notification-card">
                                            <a href="{{route('all.notifications')}}" class="notification-item"> Dr. {{ucwords($notification->first_name)}} {{ucwords($notification->last_name)}} creates a prescription for you.</a>
                                        </div>
                                    @endif
                                    @endforeach
                                        <div class="view-more-card">
                                            <a href="{{route('all.notifications')}}" class="view-more-a">View more..</a>
                                        </div>
                                    </ul>
                                </li>
                                @elseif(!$patient_deleted_appointments->isEmpty() || !$prescriptions->isEmpty())
                                    <li class="nav-item dropdown">
                                        <button class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-bell"></i> Notifications
                                            <span class="position-absolute top-10 start-10 translate-middle p-1 bg-danger border border-light rounded-circle">
                                                <span class="visually-hidden">New alerts</span>
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu header-dropdown-menu notification-menu">
                                            @if(!$patient_deleted_appointments->isEmpty())
                                                @foreach ( $patient_deleted_appointments as $patient )
                                                    <div class="notification-card">
                                                        <a href="{{route('all.notifications')}}" class="notification-item">Your appointment with Dr {{$patient->first_name}} {{$patient->last_name}} has been canceled.</a>
                                                    </div>
                                                @endforeach
                                            @endif
                                            @if(!$prescriptions->isEmpty())
                                                @foreach ( $prescriptions as $pre )
                                                    <div class="notification-card">
                                                        <a href="{{route('all.notifications')}}" class="notification-item"> Dr. {{ucwords($pre->first_name)}} {{ucwords($pre->last_name)}} creates a prescription for you.</a>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="view-more-card">
                                                <a href="{{route('all.notifications')}}" class="view-more-a">View more..</a>
                                            </div>
                                        </ul>
                                    </li>
                                @endif
                                <!-- end -->

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-user"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item header-item" href="{{route('profile.edit')}}"><i class="fa-solid fa-pen-to-square"></i> Edit profile</a></li>
                                        <li><a class="dropdown-item header-item" href="{{route('all.logout')}}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <form action="{{route('search_doctors')}}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="searchQuery" id="search_query_header2" class="header-search-input-sm" placeholder="Search" aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <button class="btn btn-primary search-btn" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>


                        @elseif (Session::has('waiting_dr') || Session::has('rejected_dr'))
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('home.page')}}"><i class="fa-solid fa-house"></i> Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('all.question')}}"><i class="fa-sharp fa-solid fa-circle-question"></i> FAQ</a>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-user"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item header-item" href="{{route('all.logout')}}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <form action="{{route('search_doctors')}}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="searchQuery" id="search_query_header2" class="header-search-input-sm" placeholder="Search" aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <button class="btn btn-primary search-btn" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>


                        @else
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('home.page')}}"><i class="fa-solid fa-house"></i> Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{route('all.question')}}"><i class="fa-sharp fa-solid fa-circle-question"></i> FAQ</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-user"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item header-item" href="{{route('all.login')}}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Login</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <form action="{{route('search_doctors')}}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="searchQuery" id="search_query_header2" class="header-search-input-sm" placeholder="Search" aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <button class="btn btn-primary search-btn" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="add-article-background">
            <div class="add-article-container p-3">
                <div class="row gutter add-article-top-row">
                    <div class="col"></div>
                    <div class="col center">
                        <span class="add-article-header">ADD ARTICLE</span>
                    </div>
                    <div class="col end">
                        <button type="button" class="btn-close" aria-label="Close" id="article-close-btn"></button>
                    </div>
                </div>
                <form action="{{route('add.article')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 mt-5">
                        <label for="exampleFormControlInput1" class="form-label">Article title</label>
                        <input name="title" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Title" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Enter the article</label>
                        <textarea name="content" class="form-control article-area" id="exampleFormControlTextarea1" rows="3" required></textarea>
                    </div>
                    <div class="mb-3 mt-5">
                        <label for="formFile" class="form-label">Enter an image</label>
                        <input name="image" class="form-control" type="file" id="formFile" accept="image/*" required>
                    </div>
                    <button class="btn btn-primary article-submit-btn" type="submit">Submit</button>
                </form>
            </div>
        </div>
        <div class="margin"></div>

        @yield('content')
        <script src="{{url('js/bootstrap.bundle.js')}}"></script>
        <script src="{{url('js/jquery-3.6.0.min.js')}}"></script>
        <script src="{{url('js/aos.js')}}"></script>
        <script>
            // header
            AOS.init();
            $("#add-article-btn").click(function(){
                $(".add-article-background").css("display","block")
            })
            $("#add-article-btn-sm").click(function(){
                $(".add-article-background").css("display","block")
            })
            $("#article-close-btn").click(function(){
                $(".add-article-background").css("display","none")
            })
            // header-end
        </script>
        @yield('jquery')
    </body>
</html>
