@extends('Shared.left-container')

@section('title')
    Read Article
@endsection

@section('right_container_css')
    <link rel="stylesheet" href="{{url('css/articles.css')}}">
@endsection

@section('right_container')

    <div class="col right-container right-conatiner-white">
        <div class="articles-header-container">
            <span class="articles-header">{{ucwords($article->title)}}</span>
            <div class="col">
                <span class="date-span"><i class="fa-solid fa-calendar-days"></i> Published in: <small class="text-muted">{{date('j- m- Y', strtotime($article->updated_at))}}</small></span>
                @if(Session::has('logged_in_admin'))
                    <a class="delete-a" href="{{route('del.article' , $article->id)}}" role="button"><i class="fa-solid fa-trash"></i></a>
                    <a id="edit-a" href="#edit-article-area" role="button"><i class="fa-solid fa-pen"></i></a>
                @endif
            </div>
        </div>

        <img src="{{ $article->image }}" class="article-full-img" id="article-full-img" alt="">

        <div class="article-itself-div">
            <span class="article-itself">
                    {{ ucfirst($article->content) }}
            </span>

            <form action="{{route('update.article', $article->id)}}" method="POST" class="article-itself-form" enctype="multipart/form-data">
                @csrf
                <label for="file" id="upload-btn"><i class="fa-solid fa-image"></i> Change article photo</label>
                <input name="article_image" id="file" type="file" accept="image/*" class="custom-file-input">
                <input required name="article_title" value="{{ ucwords($article->title) }}" type="text" class="form-control mb-3" placeholder="Article title"  >

                <textarea  name="article_content" id="edit-article-area" class="form-control edit-article-area" placeholder="Enter the article" required >
                    {{ $article->content }}
                </textarea>

                <button class="btn btn-primary mt-3" type="submit">Submit</button>
            </form>

        </div>
    </div>
@endsection

@section('jquery')
<script>
    $("#edit-a").click(function(){
        $(".article-itself").hide()
        $(".article-itself-form").show()
    })

    const file = document.getElementById('file');
        const img = document.getElementById('article-full-img');
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
