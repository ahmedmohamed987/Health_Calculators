@extends('Shared.left-container')

@section('title')
    Daily Calories Calculator
@endsection

@section('right_container_css')
    <link rel="stylesheet" href="{{url('css/notifications.css')}}">
    <link rel="stylesheet" href="{{url('css/daily-calories.css')}}">
@endsection

@section('right_container')
    <div class="col right-container right-conatiner-white white">
        <div class="notifications-span-div2">
            <span class="notifications-span"><i class="fa-solid fa-burger"></i> Daily calories calculator</span>
            <div class="notifications-span-line"></div>
        </div>
        <div class="mt-3 calories-input-div">
            <img src="{{ url('img/calories-calculator.png') }}" alt="" class="meal-img pos-center">

            <form action="{{ route('daily.calories') }}" method="POST" class="inputs-form">
                @csrf
                @if(Session('daily_calorie_calculator')== null)
                    <div class="btn-group gender-div pos-center" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" value="male" class="btn-check" name="gender" id="male" autocomplete="off" >
                        <label class="btn btn-outline-primary" for="male"><i class="fa-solid fa-mars"></i> Male</label>

                        <input type="radio" value="female" class="btn-check" name="gender" id="female" autocomplete="off" checked>
                        <label class="btn btn-outline-primary" for="female"><i class="fa-solid fa-venus"></i> Female</label>
                    </div>
                    @error('gender')
                    <span class="text-danger massage">{{ $message }}</span>
                    @enderror

                    <div class="input-group mb-3 calories-input pos-center">
                        <span class="input-group-text" id="age">Age</span>
                        <input name="age" type="number" class="form-control" aria-label="Age" aria-describedby="age" required>
                    </div>
                    @error('age')
                    <span class="text-danger massage">{{ $message }}</span>
                    @enderror

                    <div class="input-group mb-3 calories-input pos-center">
                        <span class="input-group-text" id="height">Height</span>
                        <input name="height" type="number" class="form-control" aria-label="Height" placeholder="(cm)" aria-describedby="height" required>
                    </div>
                    @error('height')
                    <span class="text-danger massage">{{ $message }}</span>
                    @enderror

                    <div class="input-group mb-3 calories-input pos-center">
                        <span class="input-group-text" id="weight">Weight</span>
                        <input name="weight" type="number" class="form-control" aria-label="Weight" placeholder="(kg)" aria-describedby="weight" required>
                    </div>
                    @error('weight')
                    <span class="text-danger massage">{{ $message }}</span>
                    @enderror

                    <div class="input-group mb-3 calories-input pos-center">
                        <span class="input-group-text" id="weight">Goal</span>
                        <select name="goal" class="form-select " aria-label="Default select example" required>
                            <option selected disabled value=""></option>
                            <option  value="lose">Lose weight</option>
                            <option value="gain">Gain weight</option>
                            <option value="maintain">Maintain weight</option>
                        </select>
                    </div>
                    @error('goal')
                    <span class="text-danger massage">{{ $message }}</span>
                    @enderror

                    <div class="input-group mb-3 calories-input pos-center">
                        <span class="input-group-text" id="weight">Activity level</span>
                        <select name="activitylevel" class="form-select " aria-label="Default select example" required>
                            <option selected disabled value=""></option>
                            <option  value="sedentary">Sedentary</option>
                            <option value="light">Light</option>
                            <option value="moderate">Moderate</option>
                            <option value="active">Active</option>
                            <option value="veryactive">Very active</option>
                        </select>
                    </div>
                    @error('activitylevel')
                    <span class="text-danger massage">{{ $message }}</span>
                    @enderror
                @else
                    @if(Session('daily_calorie_calculator')['gender'] == "male")
                        <div class="btn-group gender-div pos-center" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" value="male" class="btn-check" name="gender" id="male" autocomplete="off" checked >
                            <label class="btn btn-outline-primary" for="male"><i class="fa-solid fa-mars"></i> Male</label>

                            <input type="radio" value="female" class="btn-check" name="gender" id="female" autocomplete="off" >
                            <label class="btn btn-outline-primary" for="female"><i class="fa-solid fa-venus"></i> Female</label>
                        </div>
                    @else
                        <div class="btn-group gender-div pos-center" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" value="male" class="btn-check" name="gender" id="male" autocomplete="off"  >
                            <label class="btn btn-outline-primary" for="male"><i class="fa-solid fa-mars"></i> Male</label>

                            <input type="radio" value="female" class="btn-check" name="gender" id="female" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="female"><i class="fa-solid fa-venus"></i> Female</label>
                        </div>
                    @endif
                    @error('gender')
                    <span class="text-danger massage">{{ $message }}</span>
                    @enderror

                    <div class="input-group mb-3 calories-input pos-center">
                        <span class="input-group-text" id="age">Age</span>
                        <input name="age" value={{ Session('daily_calorie_calculator')['age'] }} type="number" class="form-control" aria-label="Age" aria-describedby="age" required>
                    </div>
                    @error('age')
                    <span class="text-danger massage">{{ $message }}</span>
                    @enderror

                    <div class="input-group mb-3 calories-input pos-center">
                        <span class="input-group-text" id="height">Height</span>
                        <input name="height" value={{ Session('daily_calorie_calculator')['height'] }} type="number" class="form-control" aria-label="Height" placeholder="(cm)" aria-describedby="height" required>
                    </div>
                    @error('height')
                    <span class="text-danger massage">{{ $message }}</span>
                    @enderror

                    <div class="input-group mb-3 calories-input pos-center">
                        <span class="input-group-text" id="weight">Weight</span>
                        <input name="weight" value={{ Session('daily_calorie_calculator')['weight'] }} type="number" class="form-control" aria-label="Weight" placeholder="(kg)" aria-describedby="weight" required>
                    </div>
                    @error('weight')
                    <span class="text-danger massage">{{ $message }}</span>
                    @enderror

                    @if(Session('daily_calorie_calculator')['goal'] == "lose")
                        <div class="input-group mb-3 calories-input pos-center">
                            <span class="input-group-text" id="weight">Goal</span>
                            <select name="goal" class="form-select " aria-label="Default select example" required>
                                <option selected value="lose">Lose weight</option>
                                <option value="gain">Gain weight</option>
                                <option value="maintain">Maintain weight</option>
                            </select>
                        </div>
                    @elseif(Session('daily_calorie_calculator')['goal'] == "gain")
                        <div class="input-group mb-3 calories-input pos-center">
                            <span class="input-group-text" id="weight">Goal</span>
                            <select name="goal" class="form-select " aria-label="Default select example" required>
                                <option value="lose">Lose weight</option>
                                <option selected  value="gain">Gain weight</option>
                                <option value="maintain">Maintain weight</option>
                            </select>
                        </div>
                    @elseif(Session('daily_calorie_calculator')['goal'] == "maintain")
                        <div class="input-group mb-3 calories-input pos-center">
                            <span class="input-group-text" id="weight">Goal</span>
                            <select name="goal" class="form-select " aria-label="Default select example" required>
                                <option value="lose">Lose weight</option>
                                <option value="gain">Gain weight</option>
                                <option selected value="maintain">Maintain weight</option>
                            </select>
                        </div>
                    @endif
                    @error('goal')
                    <span class="text-danger massage">{{ $message }}</span>
                    @enderror

                    @if(Session('daily_calorie_calculator')['activitylevel'] == "sedentary")
                        <div class="input-group mb-3 calories-input pos-center">
                            <span class="input-group-text" id="weight">Activity level</span>
                            <select name="activitylevel" class="form-select " aria-label="Default select example" required>
                                <option selected value="sedentary">Sedentary</option>
                                <option value="light">Light</option>
                                <option value="moderate">Moderate</option>
                                <option value="active">Active</option>
                                <option value="veryactive">Very active</option>
                            </select>
                        </div>
                    @elseif(Session('daily_calorie_calculator')['activitylevel'] == "light")
                        <div class="input-group mb-3 calories-input pos-center">
                            <span class="input-group-text" id="weight">Activity level</span>
                            <select name="activitylevel" class="form-select " aria-label="Default select example" required>
                                <option value="sedentary">Sedentary</option>
                                <option selected value="light">Light</option>
                                <option value="moderate">Moderate</option>
                                <option value="active">Active</option>
                                <option value="veryactive">Very active</option>
                            </select>
                        </div>
                    @elseif(Session('daily_calorie_calculator')['activitylevel'] == "moderate")
                        <div class="input-group mb-3 calories-input pos-center">
                            <span class="input-group-text" id="weight">Activity level</span>
                            <select name="activitylevel" class="form-select " aria-label="Default select example" required>
                                <option value="sedentary">Sedentary</option>
                                <option value="light">Light</option>
                                <option selected value="moderate">Moderate</option>
                                <option value="active">Active</option>
                                <option value="veryactive">Very active</option>
                            </select>
                        </div>
                    @elseif(Session('daily_calorie_calculator')['activitylevel'] == "active")
                        <div class="input-group mb-3 calories-input pos-center">
                            <span class="input-group-text" id="weight">Activity level</span>
                            <select name="activitylevel" class="form-select " aria-label="Default select example" required>
                                <option value="sedentary">Sedentary</option>
                                <option value="light">Light</option>
                                <option value="moderate">Moderate</option>
                                <option selected value="active">Active</option>
                                <option value="veryactive">Very active</option>
                            </select>
                        </div>
                    @elseif(Session('daily_calorie_calculator')['activitylevel'] == "veryactive")
                        <div class="input-group mb-3 calories-input pos-center">
                            <span class="input-group-text" id="weight">Activity level</span>
                            <select name="activitylevel" class="form-select " aria-label="Default select example" required>
                                <option value="sedentary">Sedentary</option>
                                <option value="light">Light</option>
                                <option value="moderate">Moderate</option>
                                <option value="active">Active</option>
                                <option selected value="veryactive">Very active</option>
                            </select>
                        </div>
                    @endif
                    @error('activitylevel')
                    <span class="text-danger massage">{{ $message }}</span>
                    @enderror
                @endif
                <button class="btn btn-primary calories-submit d-block pos-center" type="submit">Calculate your daily calories</button>
            </form>

            @if(session('daily_calorie_calculator')!=null)
                <div class="results-div" id="results-div">
                    <p class="check-span m-0"><i class="fa-solid fa-circle-check"></i></p>
                    <p class="target-span">Target calorie intake per day:</p>
                    <div class="score-div pos-center">
                        <p class="score-span">{{ session('daily_calorie_calculator')['daily_calories_intake'] }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection


