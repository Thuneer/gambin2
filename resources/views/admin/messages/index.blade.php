@extends('layouts.admin')

@section('content')

    <div class="tool-bar">
        <div class="tool-bar__left">
            <h1 class="page-header">All conversations</h1>
        </div>
    </div>

    <div class="conversations">

        @foreach($threads as $thread)

            <a href="/admin/conversations/{{ $thread->id }}" class="conversations__item">
                <img class="conversations__img"
                     src="
                         @if($thread->user1->id == Auth::user()->id)
                     @if(count($thread->user2->images) > 0)/{{ $thread->user2->images[0]->path_thumbnail }}
                     @else {{ userAvatar($thread->user2->id) }}
                     @endif

                     @else
                     @if(count($thread->user1->images) > 0)/{{ $thread->user1->images[0]->path_thumbnail }}
                     @else {{ userAvatar($thread->user1->id) }}
                     @endif
                     @endif
                             "

                     alt="">

                <div class="conversations__container">
                    <div class="conversations__name">@if($thread->user1->id == Auth::user()->id){{ $thread->user2->first_name }} {{ $thread->user2->last_name }}
                        @else{{ $thread->user1->first_name }} {{ $thread->user1->last_name }}
                        @endif


                    </div>
                    <div class="conversations__amount">   {{ count($thread->messages) }}</div>
                </div>
            </a>


        @endforeach

    </div>

    <div class="conversations-new">

        <hr>

        <form method="POST" action="/admin/conversations">
            @csrf

            <label for="sel1">Add new conversation with</label>
            <select name="user" class="form-control" id="sel1">
                @foreach($users as $user)
                    @if($user->roles[0]->name != 'standard user')
                        <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>@endif
                @endforeach
            </select>
            <button class="conversations-new__btn"><i class="fas fa-plus"></i></button>
        </form>


    </div>

    @component('admin/components/message')@endcomponent

@endsection