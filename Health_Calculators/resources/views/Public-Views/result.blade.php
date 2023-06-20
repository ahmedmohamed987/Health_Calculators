
@extends('Shared.header')

@section('css')
    <link rel="stylesheet"  href="{{url('css/fontawesome-free-6.1.2-web/css/all.min.css')}}">
    <link rel="stylesheet"  href="{{url('css/main.css')}}">

@endsection

@section('title')
    Search Results
@endsection

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12  ">
                <div class="grid search">
                    <div class="grid-body">
                        <div class="row">
                            <div class="col-md-3  labell">
                                <h2 class="grid-title"><i class="fa fa-filter icon"></i> Filters</h2>
                                <hr>
                                <h4>Filter by:</h4>
                                
                                <div class="checkbox">
                                    <div class="dropdown">
                                        <input type="text" class="btn btn-light dropdown-toggle location-city" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="false" id="myin" onkeyup="search()" placeholder="Location">
                                        <ul class="dropdown-menu">
                                            @php
                                            $governorateCount = 0;
                                            @endphp
                                            @foreach($Governorates as $gov)
                                            @php
                                            $governorateCount++;
                                            @endphp
                                            <li class="dropend ">
                                                @if($governorateCount <= 12)
                                                <a class="dropdown-item dropdown-toggle lig " data-bs-toggle="dropdown" href="#">{{$gov->governorate_name}}</a>
                                                <ul class="dropdown-menu scrollable-menu" id="cities_{{$gov->id}}">
                                                    <input type="search" class="search-city" data-gov="{{$gov->id}}" id="seach_city_input_{{$gov->id}}" placeholder="City">
                                                    @foreach($Cities as $city)
                                                    @if($gov->id == $city->governorate_id)
                                                    <li><a class="dropdown-item selectCity cities_class_{{$gov->id}}" data-gov="{{$gov->governorate_name}}" data-city="{{$city->name}}" href="#">{{$city->name}}</a></li>
                                                    @endif
                                                    @endforeach
                                                </ul>
                                                @endif
                                            </li>
                                            @endforeach
                                            @if(count($Governorates) > 12)
                                            <li class="dropend ">
                                                <a class="dropdown-item dropdown-toggle dropdown-menu-end show-gov-dropdown" data-bs-toggle="dropdown" href="#">Show More</a>
                                                <ul class="dropdown-menu mm ">
                                                    @foreach($Governorates as $gov)
                                                        @if($loop->index >= 12)
                                                        <li class="dropend ">
                                                            <a class="dropdown-item dropdown-toggle show-gov lig" data-bs-toggle="dropdown" href="#">{{$gov->governorate_name}}</a>
                                                            <ul class="dropdown-menu scrollable-menu" id="cities_{{$gov->id}}">
                                                            <input type="search" class="search-city" data-gov="{{$gov->id}}" id="seach_city_input_{{$gov->id}}" placeholder="City">
                                                            @foreach($Cities as $city)
                                                            @if($gov->id == $city->governorate_id)
                                                            <li><a class="dropdown-item selectCity cities_class_{{$gov->id}}" data-gov="{{$gov->governorate_name}}" data-city="{{$city->name}}" href="#">{{$city->name}}</a></li>
                                                            @endif
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                    @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                
                                
                                
                                
                                
                                
                                  
                                {{-- <div class="checkbox">
                                    <div class="dropdown ">
                                        <input  type="text" class="btn btn-light dropdown-toggle location-city " data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="false" id="myin" onkeyup="search()"  placeholder=" Location" >
                                        <ul class="dropdown-menu" >
                                            @foreach($Governorates as $gov)
                                            <li class="dropend lig">
                                                <a  class="dropdown-item  dropdown-toggle" data-bs-toggle="dropdown" href="#">{{$gov->governorate_name}}</a>
                                                <ul class="dropdown-menu scrollable-menu" id="cities_{{$gov->id}}">
                                                    <input type="search" class="search-city" data-gov="{{$gov->id}}" id="seach_city_input_{{$gov->id}}" placeholder="City" >
                                                       @foreach($Cities as $city)
                                                        @if($gov->id == $city->governorate_id)
                                                            <li ><a class="dropdown-item selectCity cities_class_{{$gov->id}}" data-gov="{{$gov->governorate_name}}" data-city="{{$city->name}}" href="#">{{$city->name}}</a></li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div> --}}

                            {{-- new filter --}}
                            <div class="checkbox">
                                <label>
                                    @if($search_by_rating == 1)
                                        <input type="checkbox" checked id="filter_by_rating" class="icheck">
                                    @else
                                        <input type="checkbox" id="filter_by_rating" class="icheck">
                                    @endif
                                    Rating
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    @php($consultantStatus = "")
                                    @if(!empty($speciality_type) && $speciality_type == "consultant")
                                        @php($consultantStatus = "checked")
                                    @endif
                                    <input type="checkbox" {{$consultantStatus}} class="icheck speciality_type_checkbox" id="consultant_checkbox" data-value="consultant">
                                    Consultant
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    @php($specialistStatus = "")
                                    @if(!empty($speciality_type) && $speciality_type == "specialist")
                                        @php($specialistStatus = "checked")
                                    @endif
                                    <input type="checkbox" {{$specialistStatus}} class="icheck speciality_type_checkbox" id="specialist_checkbox" data-value="specialist">
                                    Specialist
                                </label>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <h2><i class="fa-regular fa-file icon"></i> Result</h2>
                            <hr>
                            <p>Showing all results matching </p>
                        <div class="row">
                            <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if(!empty($speciality_type))
                                    {{$speciality_type}}
                                    @elseif($search_by_location==1)
                                    Location
                                    @elseif($search_by_rating==1)
                                    Rating
                                    @else
                                    Search by
                                    @endif
                                </button>
                                <ul class="dropdown-menu ">
                                   
                                    <li><a class="dropdown-item" id="filter_by_rating_dropdown" href="javascript:void(0)">Rating</a></li>
                                    <li><a class="dropdown-item speciality_type" data-value="consultant" href="javascript:void(0)">Consultant</a></li>
                                    <li><a class="dropdown-item speciality_type" data-value="specialist" href="javascript:void(0)">Specialist</a></li>
                                </ul>
                            </div>
                            <div class="table-responsive   ">
                                @php($counter = 0)
                                @if(count($Doctors) != 0)
                                @foreach($Doctors as $doctor)
                                @foreach($value_of_doctor_rates as $key)
                                @if($doctor["id"] == $key['dr_id'])
                                    @if(Session::has('logged_in_doctor'))
                                        @if($doctor["request_id"] == session('logged_in_doctor')['id'])
                                            <a class="links" href="{{route('drprofile')}}">
                                                <table class="table table-hover  ">
                                                    <tbody>
                                                    <tr>
                                                        <td class="number text-center">{{++$counter}}</td>
                                                        <td class="image"><img src="{{$doctor["profile_image"]}}" alt=""></td>
                                                        <td class="name">
                                                            <a class="dr-link" href="{{route('drprofile')}}">
                                                            {{-- <a class="dr-link" href="{{route('get_doctor_profile', $doctor["request_id"])}}"> --}}
                                                            <strong>{{ucfirst($doctor["first_name"])}} {{ucfirst($doctor["last_name"])}} </strong></a> <br>
                                                            {{ucfirst($doctor["speciality_type"])}}
                                                        </td>

                                                        @php($rates_value = number_format($key['dr_rate']))

                                                        <td class="rate text-right">
                                                            <span>
                                                                @for($i = 1; $i <= $rates_value; $i++)
                                                                    <i class="fa fa-star"></i>
                                                                @endfor
                                                                @for($j = $rates_value+1; $j <= 5; $j++)
                                                                    <i class="fa-regular fa-star"></i>
                                                                @endfor
                                                            </span>
                                                        </td>

                                                        <td class="Location text-right">{{$doctor["clinic_address"]}}</td>
                                                    </tr>
                                                </tbody>
                                                </table>
                                            </a>
                                        @else
                                            <a class="links" href="{{route('get_doctor_profile', $doctor["request_id"])}}">
                                                <table class="table table-hover  ">
                                                    <tbody>
                                                    <tr>
                                                        <td class="number text-center">{{++$counter}}</td>
                                                        <td class="image"><img src="{{$doctor["profile_image"]}}" alt=""></td>
                                                        <td class="name">
                                                            <a class="dr-link" href="{{route('get_doctor_profile', $doctor["request_id"])}}">
                                                            <strong>{{ucfirst($doctor["first_name"])}} {{ucfirst($doctor["last_name"])}}</strong></a> <br>
                                                            {{ucfirst($doctor["speciality_type"])}}
                                                        </td>

                                                        @php($rates_value = number_format($key['dr_rate']))

                                                        <td class="rate text-right">
                                                            <span>
                                                                @for($i = 1; $i <= $rates_value; $i++)
                                                                    <i class="fa fa-star"></i>
                                                                @endfor
                                                                @for($j = $rates_value+1; $j <= 5; $j++)
                                                                    <i class="fa-regular fa-star"></i>
                                                                @endfor
                                                            </span>
                                                        </td>

                                                        <td class="Location text-right">{{$doctor["clinic_address"]}}</td>
                                                    </tr>
                                                </tbody>
                                                </table>
                                            </a>
                                        @endif
                                    @else

                                        <a class="links" href="{{route('get_doctor_profile', $doctor["request_id"])}}">
                                            <table class="table table-hover  ">
                                                <tbody>
                                                <tr>
                                                    <td class="number text-center">{{++$counter}}</td>
                                                    <td class="image"><img src="{{$doctor["profile_image"]}}" alt=""></td>
                                                    <td class="name">
                                                        <a class="dr-link" href="{{route('get_doctor_profile', $doctor["request_id"])}}">
                                                        <strong>{{ucfirst($doctor["first_name"])}} {{ucfirst($doctor["last_name"])}}</strong></a> <br>
                                                        {{ucfirst($doctor["speciality_type"])}}
                                                    </td>

                                                    @php($rates_value = number_format($key['dr_rate']))

                                                    <td class="rate text-right ">
                                                        <span>
                                                            @for($i = 1; $i <= $rates_value; $i++)
                                                                <i class="fa fa-star"></i>
                                                            @endfor
                                                            @for($j = $rates_value+1; $j <= 5; $j++)
                                                                <i class="fa-regular fa-star"></i>
                                                            @endfor
                                                        </span>
                                                    </td>

                                                    <td class="Location text-right">{{$doctor["clinic_address"]}}</td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </a>
                                    @endif
                                    @endif
                            @endforeach
                            @endforeach
                            @endif
                        </div>

                        <div class="pagination">
                            @for ($i =1; $i <= $number_of_pages; $i++)
                                <a href="javascript:void(0)" class="page" data-page="{{$i}}">{{$i}}</a>
                            @endfor
                          </div>

                        @if(count($Doctors) == 0)
                            <div >
                                <p class=" text-center " >No Data</p>
                                <hr>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
@section('jquery')

        <script src="{{url('css/fontawesome-free-6.1.2-web/js/all.min.js')}}"></script>
        <script src="{{url('js/jquery-3.6.0.min.js')}}"></script>
        <script src="{{url('js/popper.min.js')}}"></script>
        <script>
            $(document).ready(function(){

                var search_query_header = '{{$searchQuery}}';
                $("#search_query_header").val(search_query_header);
                $("#search_query_header2").val(search_query_header);

                var search_gov = '{{$search_gov}}';
                var search_city = '{{$search_city}}';
                $("#search_gov").val(search_gov);
                $("#search_city").val(search_city);


                $(".speciality_type").click(function(){
                var specialityType = $(this).data('value');
                $("#search_speciality_type_header").val(specialityType);
                $("#searchFormHeader").submit();
                });

                if($("#filter_by_rating").is(':checked'))
                    $("#search_by_rating").val(1);

                if($("#specialist_checkbox").is(':checked'))
                    $("#search_speciality_type_header").val("specialist");

                if($("#consultant_checkbox").is(':checked'))
                    $("#search_speciality_type_header").val("consultant");
               

                $(".speciality_type_checkbox").click(function(){
                var specialityType = $(this).data('value');

                if($(this).is(":checked"))
                    $("#search_speciality_type_header").val(specialityType);
                else
                    $("#search_speciality_type_header").val("");

                $("#searchFormHeader").submit();
                });

                $("#reset").click(function(){
                    $("#search_speciality_type_header").val("");
                    $("#searchFormHeader").submit();
                });

                $(document).on('click','.selectCity',function(){
                    var gov = $(this).data('gov');
                    var city = $(this).data('city');

                    $("#search_gov").val(gov);
                    $("#search_city").val(city);


                    $("#searchFormHeader").submit();

                });

                $("#filter_by_rating").click(function(){

                    if($(this).is(':checked'))
                        $("#search_by_rating").val(1);
                    else
                        $("#search_by_rating").val(0);

                    $("#searchFormHeader").submit();
                });

                $("#filter_by_rating_dropdown").click(function(){

                    $("#search_by_rating").val(1);
                    $("#searchFormHeader").submit();
                });

                $(".page").click(function(){
                    var page=$(this).data('page');
                    $("#search_page").val(page);
                    $("#searchFormHeader").submit();
                });

                $(document).on('keyup','.search-city',function(){
                    var query=$(this).val();
                    var govId=$(this).data('gov');
                    var url = '{{ route("search_city", [":city", ":gov"]) }}';
                    url = url.replace(':city', query);
                    url = url.replace(':gov', govId);

                    $.ajax({
                        url: url,
                        dataType: 'json',
                        success: function(data) {console.log(data);
                            $(".cities_class_"+govId).remove();
                            var html = '';
                            data.forEach(function(city){
                                html += `<li ><a class="dropdown-item selectCity cities_class_${govId}" data-gov="${city.governorate_name}" data-city="${city.name}" href="#">${city.name}</a></li>`;
                            });

                            $("#cities_"+govId).append(html);
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            console.log(xhr.responseText);
                        }
                    });


                });

            });

           
         
       
    $(document).ready(function() {
        $(".show-gov").click(function(e) {
            e.stopPropagation();
            var citiesId = $(this).next("ul.dropdown-menu").attr("id");
            $("#" + citiesId).toggleclass();
        });
    });




        </script>

         <script>
            var x=document.getElementsByClassName("scrollable");
              x[0].addEventListener("onclick", function () {
              x[0].style.maxHeight = "15px";
              x[0].style.backgroundColor="yellow";
            });
        </script>

        <script>

            var searchCityElements=document.getElementsByClassName("search-city");
            var locationCityElements=document.getElementsByClassName("location-city");

            for (var i = 0; i < searchCityElements.length; i++) {
                searchCityElements[i].addEventListener("focus", function() {
                this.style.border = "none";
                this.style.padding = "4px";
                });
            }

            for (var j = 0; j < locationCityElements.length; j++) {
                locationCityElements[j].addEventListener("focus", function() {
                    this.style.border = "none";
                    this.style.padding = "4px";
                });
                }


            </script>


            <script>

        function search() {

            var filter = document.getElementById("myin").value.toUpperCase();
            var x = document.getElementsByClassName("lig");

            for (let i = 0; i < x.length; i++) {
                if (x[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
                x[i].style.display = "block";
                }
                else {
                x[i].style.display = "none";
                }
            }
            }

  

        </script>


@endsection


