@extends('layouts.admin')

@section('content')

<div class="tool-bar">
    <div class="tool-bar__left">
        <span class="page-header__icon"><i class="fas fa-lock"></i></span> <h1 class="page-header"> Permissions</h1>
    </div>
</div>

<div class="tomato">


    <div class="permissions">

        <div class="permissions__top">
            <form class="permissions__form"><input name="role" type="hidden" value="super"><button class="permissions__role @if($role->name == 'super admin') permissions__role--active @endif" type="submit">Super admins</button></form>
            <form class="permissions__form"><input name="role" type="hidden" value="admin"><button class="permissions__role @if($role->name == 'administrator') permissions__role--active @endif" type="submit">Administrators</button></form>
            <form class="permissions__form"><input name="role" type="hidden" value="editor"><button class="permissions__role @if($role->name == 'editor') permissions__role--active @endif" type="submit">Editors</button></form>
            <form class="permissions__form"><input name="role" type="hidden" value="standard"><button class="permissions__role @if($role->name == 'standard user') permissions__role--active @endif" type="submit">Standard users</button></form>
        </div>

        <div class="permissions__body">

            <input id="role_id" type="hidden" value="{{ $role->id }}">

            @foreach($permissions as $index => $permission)

                @if($index == 0) <h3 class="permissions__header"> General </h3>
                @elseif($index == 3) <h3 class="permissions__header"> Articles </h3>
                @elseif($index == 7) <h3 class="permissions__header"> Pages </h3>
                @elseif($index == 11) <h3 class="permissions__header"> Media </h3>
                @elseif($index == 15) <h3 class="permissions__header"> Users </h3>

                @endif

                <div class="permissions__item
               @if($index == 15 || $index == 19 || $index == 23) permissions__item--spacer
                @elseif($index == 2 || $index == 6 || $index == 10 || $index == 14) permissions__item--spacer-lg @endif">



                    <span class="checkbox permissions__checkbox">
                    <input class="styled-checkbox permission-checkbox" id="styled-checkbox-{{ $index }}" type="checkbox" value="{{ $permission->name }}" @if($role->permissions->contains('name', $permission->name) == 1) checked @endif>
                    <label for="styled-checkbox-{{ $index }}">{{ ucfirst($permission->name) }}</label>


                </span>
                    <i class="permissions__success fas fa-check"></i>
                    <img class="permissions__loading" src="/img/loading.gif" alt="">
                </div>
            @endforeach

        </div>

    </div>

</div>

<img style="visibility: hidden" class="permissions__loading" src="/img/loading.gif" alt="">

    @component('admin/components/message')@endcomponent

@endsection