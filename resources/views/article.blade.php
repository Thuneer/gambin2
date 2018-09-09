@extends('layouts.app')

@section('content')

    <div class="container">
       <div class="article">
           @if(count($item->images) > 0)
               <img class="article__img" src="/{{ $item->images[0]->path_large }}" alt="">
           @endif
           <div class="article__body">
               <h1 class="article__title">{{ $item->title }}</h1>
               <p>Author: {{ $item->user->first_name }} {{ $item->user->last_name }}</p>
               {!! $item->body !!}

               @foreach($item->tags as $category)
               <button class="button">{{ $category->name }}</button>
               @endforeach

           </div>
       </div>
    </div>

@endsection