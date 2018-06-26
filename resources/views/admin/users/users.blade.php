@extends('layouts.admin')

@section('content')

    <div class="tool-bar">
        <div class="tool-bar__left">
            <span class="page-header__icon"><i class="fas fa-user"></i></span><h1 class="page-header">All Users</h1>
            <a href="/admin/users/new" class="button button--primary">
                <i class="tool-bar-add__icon fas fa-plus"></i>
                Add new user
            </a>
        </div>
        <div class="tool-bar__right">

            @component('admin/components/per_page')
                @slot('per_page'){{ $per_page }}@endslot
                @slot('search'){{ $search }}@endslot
                @slot('list'){{ $list }}@endslot
            @endcomponent

            @component('admin/components/search')
                @slot('per_page') {{ $per_page }} @endslot
                @slot('search') {{ $search }} @endslot
                @slot('route') {{ '/admin/users' }} @endslot
                @slot('list') {{ $list }} @endslot
                @slot('placeholder') Search for user... @endslot
            @endcomponent

            <button class="search-mobile__toggle">
                <i class="fas fa-search"></i>
            </button>

            <form class="search-mobile">
                <input class="search-mobile__input" type="text" placeholder="Search for user...">
                <button class="search-mobile__btn"><i class="fas fa-search"></i></button>
            </form>

        </div>

    </div>

    @component('admin/components/list', ['items' => $users, 'list_options' => $list_options])
        @slot('search') {{ $search }} @endslot
        @slot('sort_column') {{ $sort_column }} @endslot
        @slot('sort_direction') {{ $sort_direction }} @endslot
        @slot('per_page') {{ $per_page }} @endslot
        @slot('list') {{ $list }} @endslot
        @slot('route') /admin/users @endslot
        @slot('singular') user @endslot
        @slot('plural') users @endslot
    @endcomponent

    @component('admin/components/delete_modal')
        @slot('title') Delete user @endslot
        @slot('route') /admin/users/delete @endslot
        @slot('list') {{ $list }} @endslot
    @endcomponent

    @component('admin/components/message')@endcomponent

@endsection