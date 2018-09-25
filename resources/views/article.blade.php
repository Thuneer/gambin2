@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="article">
                    @if(count($item->images) > 0)
                        <img class="article__img"
                             src="/{{ $item->images[0]->path . '-21-9-lg.' . $item->images[0]->extension }}" alt="">
                    @endif
                    <div class="article__content">
                        <div class="article__top">
                   <span class="article__author">
                       <i class="far fa-user"></i>
                       by {{ $item->user->first_name }} {{ $item->user->last_name }}</span>

                            <span class="article__date"><i
                                        class="far fa-clock"></i> {{ $item->created_at->toFormattedDateString() }}</span>

                            <h1 class="article__title">{{ $item->title }}</h1>
                            <p class="article__ingress">{{ $item->ingress }}</p>

                        </div>

                        <div class="article__bottom">
                            {!! $item->body !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="row article-related">
            <div class="col-md-12">
                <h2 class="article-related__heading">Read similar articles</h2>
            </div>
          @foreach($articles as $article)
                <div class="col-md-4 article-related__column">
                    <a href="/articles/{{ $article->slug }}" class="article-related__item">
                        <img class="article__img lazy"
                             src="/{{ $article->images[0]->path . '-21-9-lg.' . $article->images[0]->extension }}" alt="">
                        <h3 class="article-related__title">{{ $article->title }}</h3>
                    </a>
                </div>
            @endforeach
        </div>


    </div>

@endsection