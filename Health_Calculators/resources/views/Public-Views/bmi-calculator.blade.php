@extends('Shared.left-container')

@section('title')
    BMI Calculator
@endsection

@section('right_container_css')
    <link rel="stylesheet" href="{{url('css/notifications.css')}}">
    <link rel="stylesheet" href="{{url('css/daily-calories.css')}}">
@endsection

@section('right_container')
    <div class="col right-container right-conatiner-white white">
        <div class="notifications-span-div2">
            <span class="notifications-span"><i class="fa-solid fa-weight-scale"></i> Body mass index</span>
            <div class="notifications-span-line"></div>
        </div>
        <div class="mt-3 calories-input-div">
            <img src="{{ url('img/bmi-vector.png') }}" alt="" class="meal-img pos-center">
            <form action="{{ route('bmi.result') }}" method="POST" class="inputs-form">
                @csrf
                @if(Session('bmi_calculator') == null)
                    <div class="input-group mb-3 calories-input pos-center">
                        <span class="input-group-text" id="height">Height</span>
                        <input name="height" type="number" class="form-control" aria-label="Height" placeholder="(cm)" aria-describedby="height">
                    </div>
                    @error('height')
                    <span class="text-danger massage"> {{ $message }}</span>
                    @enderror

                    <div class="input-group mb-3 calories-input pos-center">
                        <span class="input-group-text" id="weight">Weight</span>
                        <input name="weight" type="number" class="form-control" aria-label="Weight" placeholder="(kg)" aria-describedby="weight">
                    </div>
                    @error('weight')
                    <span class="text-danger massage"> {{ $message }}</span>
                    @enderror

                @else
                    <div class="input-group mb-3 calories-input pos-center">
                        <span class="input-group-text" id="height">Height</span>
                        <input name="height" value={{ Session('bmi_calculator')['height'] }} type="number" class="form-control" aria-label="Height" placeholder="(cm)" aria-describedby="height">
                    </div>
                    @error('height')
                    <span class="text-danger massage"> {{ $message }}</span>
                    @enderror

                    <div class="input-group mb-3 calories-input pos-center">
                        <span class="input-group-text" id="weight">Weight</span>
                        <input name="weight" value={{ Session('bmi_calculator')['weight'] }} type="number" class="form-control" aria-label="Weight" placeholder="(kg)" aria-describedby="weight">
                    </div>
                        @error('weight')
                        <span class="text-danger massage"> {{ $message }}</span>
                        @enderror
                @endif
                <button class="btn btn-primary calories-submit d-block pos-center" type="submit">Calculate your BMI</button>
            </form>

            @if(Session('bmi_calculator') != null)
                <div class="results-div" id="results-div">
                    <p class="check-span m-0"><i class="fa-solid fa-circle-check"></i></p>
                    <p class="target-span">You're {{ Session('bmi_calculator')['bmi_classification'] }}</p>
                    <div class="score-div pos-center">
                        <p class="score-span">{{ Session('bmi_calculator')['bmi_result'] }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
