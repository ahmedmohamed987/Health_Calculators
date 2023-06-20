@extends('Shared.header')

@section('css')
    <link rel="stylesheet" href="{{url('css/doctor-validation.css')}}">
@endsection

@section('title')
    All Doctors
@endsection

@section('content')
    <div class="body">
        @foreach ($all_drs as $key=>$item)
        @foreach ($all_doctors_data as $dr )
        @if ($item->id == $dr->request_id)
                <div class="request-card">
                    <div class="row gutter">
                        <div class="col-2 img-col">
                            <img class="doctor-img" src="{{$dr->profile_image}}" alt="">
                        </div>
                        <div class="col name-col">
                            <span class="doctor-name">{{ ucwords($item->first_name) }} {{ ucwords($item->last_name) }}</span>
                        </div>
                        <div class="col buttons-col end me-3">
                            <a class="btn btn-primary" href="{{route('all.dr.details',['id'=>$item->id])}}" role="button"><i class="fa-solid fa-circle-info"></i></a>
                            <p class="bs-p">
                                <button class="btn btn-danger" type="button" data-bs-toggle="collapse" data-bs-target={{"#collapseExample".$key}} aria-expanded="false" aria-controls="collapseExample">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </p>
                            </div>
                    </div>
                    <div class="collapse mt-2" id={{"collapseExample".$key}}>
                        <div class="card card-body">
                            <form action="{{route('doctor.delete', $item->id)}}" method="POST">
                                @csrf
                                <textarea name="delete_reason" class="form-control delete-textarea" id="exampleFormControlTextarea1" rows="3" placeholder="Enter deletion reason.."></textarea>
                                <button class="btn btn-danger mt-2" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
    @endforeach
    @endforeach
    <div class="m-4 pag">
        {{$all_drs->links()}}
    </div>
</div>
@endsection

@section('jquery')
    <script>
        $(".delete-btn").click(function(){
            $(".reject-background").css("display","block")
        })

        $(".btn-close").click(function(){
            $(".reject-background").css("display","none")
        })
    </script>
@endsection

