@extends('Shared.left-container')

@section('title')
    Meal Calories Calculator
@endsection

@section('right_container_css')
    <link rel="stylesheet" href="{{url('css/notifications.css')}}">
    <link rel="stylesheet" href="{{url('css/meal-calories.css')}}">
@endsection

@section('right_container')
    <div class="col right-container right-conatiner-white white">
        <div class="notifications-span-div2">
            <span class="notifications-span"><i class="fa-solid fa-burger"></i> Meal calories calculator</span>
            <div class="notifications-span-line"></div>
        </div>

        <div class="mt-3 calories-input-div">

            @if(Session::has('image'))
            <img src="{{ url("meal_images")}}/{{ Session::get('image') }}" id="meal-imge" alt="" class="meal-img pos-center">
            @else
            <img src="{{ url('img/meal.png') }}" id="meal-imge" alt="" class="meal-img pos-center">
            @endif


            <form action="{{ route('get.meal.name') }}" method="POST" enctype="multipart/form-data" id="SubmitForm">
                @csrf
                <label for="file" id="upload-btn"><i class="fa-solid fa-image"></i> Upload meal photo
                @error('meal_img')
                    <br>
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </label>
                <input name="meal_img" id="file" type="file" accept="image/*" class="custom-file-input">

                <button class="btn btn-primary d-block pos-center mt-3" type="submit">Calculate meal calories!</button>
            </form>


            @if(Session('mealname')!=null)
            <div class="results-div" id="results-div">
                <p class="check-span m-0"><i class="fa-solid fa-circle-check"></i></p>
                <p class="target-span">{{ session('mealname') }}</p>
                @if(Session('meal_calories') != null)
                <div class="score-div pos-center">
                    <p class="score-span">{{Session('meal_calories')}} in 100 grams of your meal.</p>
                </div>
                @else
                <div class="score-div pos-center">
                    <p class="score-span">Can't fetch your meal calories </p>
                </div>
                @endif
            </div>
            @endif

        </div>

    </div>
@endsection

@section('jquery')
    <script>
        const file = document.getElementById('file');
        const img = document.getElementById('meal-imge');
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
    </script>
@endsection
