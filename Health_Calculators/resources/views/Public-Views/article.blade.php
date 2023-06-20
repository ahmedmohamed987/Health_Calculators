@extends('Shared.left-container')

@section('title')
    All articles
@endsection

@section('right_container_css')
    <link rel="stylesheet" href="{{url('css/articles.css')}}">
@endsection

@section('right_container')

<div class="col right-container">
                <div class="articles-header-container">
                    <span class="articles-header"><i class="fa-solid fa-book"></i> Articles</span>
                    <form action="{{ route('all.articles') }}" method="POST" class="header-search1 pos-center">
                        @csrf
                        @if(Session('article') != null)
                            <div class="input-group ">
                                <input value="{{ Session('article') }}" type="text" id="search_query_header" class="header-search-input" name="search_article" placeholder="Search" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button class="btn btn-primary search-btn" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        @else
                            <div class="input-group ">
                                <input type="text" id="search_query_header" class="header-search-input" name="search_article" placeholder="Search" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button class="btn btn-primary search-btn" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        @endif
                    </form>
                </div>

                @if(Session('article_result') != null)
                    @foreach (Session('article_result') as  $article)
                        <div class="card mb-3 mt-3 article-card-2">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{$article->image}}" class="right-article-img" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title right-article-header">{{ucwords(substr($article->title,0, 48))}}..</h5>
                                        <!-- ONLY 100 LETTERS ALLOWED -->
                                        <p class="card-text">{{ucfirst(substr($article->content, 0, 100))}}....</p>
                                        <div class="row g-0">
                                            <div class="col">
                                                <p class="card-text article-date-p"><small class="text-muted"><i class="fa-solid fa-calendar-days"></i> {{ date('d-m-Y', strtotime($article->updated_at)) }}</small></p>
                                                @if(Session::has('logged_in_admin'))
                                                    <a class="delete-a" href="{{route('del.article', $article->id)}}" role="button"><i class="fa-solid fa-trash"></i></a>
                                                @endif
                                            </div>
                                            <div class="col end">
                                                <a href="{{route('read.article', $article->id)}}" class="view-more-a">Read article</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                @elseif(session('empty_result') != null)
                    <p class="no-articles-p">{{ session('empty_result') }}</p>

                @elseif(isset($all_articles) && !$all_articles ->isEmpty())
                    @foreach ($all_articles as  $article)
                        <div class="card mb-3 mt-3 article-card-2">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{$article->image}}" class="right-article-img" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title right-article-header">{{ucwords(substr($article->title,0, 48))}}..</h5>
                                        <!-- ONLY 100 LETTERS ALLOWED -->
                                        <p class="card-text">{{ucfirst(substr($article->content, 0, 100))}}....</p>
                                        <div class="row g-0">
                                            <div class="col">
                                                <p class="card-text article-date-p"><small class="text-muted"><i class="fa-solid fa-calendar-days"></i> {{ date('d-m-Y', strtotime($article->updated_at)) }}</small></p>
                                                @if(Session::has('logged_in_admin'))
                                                    <a class="delete-a" href="{{route('del.article', $article->id)}}" role="button"><i class="fa-solid fa-trash"></i></a>
                                                @endif
                                            </div>
                                            <div class="col end">
                                                <a href="{{route('read.article', $article->id)}}" class="view-more-a">Read article</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="m-4 pag">
                        {{$all_articles->links()}}
                    </div>

                @elseif(isset($all_articles) && $all_articles ->isEmpty())
                    <p class="no-articles-p">No articles here...</p>
                @endif
            </div>
        </div>
    </div>

@endsection
