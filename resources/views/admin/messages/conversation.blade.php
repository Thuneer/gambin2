@extends('layouts.admin')

@section('content')

    <div class="tool-bar">
        <div class="tool-bar__left">
            <h1 class="page-header">Conversation with @if($thread->user1->id == Auth::user()->id) {{ $thread->user2->first_name }} {{ $thread->user2->last_name }}
                                                        @else {{ $thread->user1->first_name }} {{ $thread->user1->last_name }} @endif</h1>
        </div>
    </div>

    <div class="conversation">

        @foreach($thread->messages as $item)


        <div class="conversation__item @if($item->user->id == Auth::user()->id) conversation__item--owner @endif">
            <img class="conversation__img"
                 src="@if(count($item->user->images) > 0)/{{ $item->user->images[0]->path_thumbnail }} @else {{ userAvatar($item->user->id) }} @endif"
                 alt="">
            <div class="conversation__body">
                {{ $item->text }}
                <div class="conversation__date">
                    {{ $item->created_at->diffForHumans()  }}
                </div>
            </div>

        </div>

        @endforeach
            <hr>
        <div class="conversation-new">
            <form method="POST" action="/admin/conversations/{{ $thread->id }}">
                @csrf
                <input name="message" placeholder="Send @if($thread->user1->id == Auth::user()->id) {{ $thread->user2->first_name }} @else {{ $thread->user1->first_name }} @endif a message..." class="conversation-new__input" type="text">
                <button class="conversation-new__btn"><i class="fas fa-angle-right"></i></button>
            </form>
        </div>

    </div>

    @component('admin/components/message')@endcomponent

@endsection