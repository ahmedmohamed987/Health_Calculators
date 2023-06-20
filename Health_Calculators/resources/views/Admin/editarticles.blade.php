@extends('Shared.header')
@section('title')
Edit Article
@endsection
@section('css')
<link rel="stylesheet" href="{{url('css/editarticle.css')}}">
@endsection
@section('content')
<div class="article-edit-container">
    <span class="edit-header">Edit article</span>
    <form action="{{route('update.article', $article->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 mt-3">
            <label for="articleTitle" class="form-label">Article title</label>
            <input name="title" type="text" value="{{$article->title}}" class="form-control" id="articleTitle" placeholder="Article title">
        </div>
        <div class="mb-3">
            <label for="article" class="form-label">Article</label>
            <input name="content" type="text" value="{{$article->content}}" class="form-control article-input" id="article" placeholder="Article">
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Article Image</label>
            <input name="image" class="form-control" type="file" id="formFile" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
