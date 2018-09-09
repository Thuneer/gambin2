@extends('layouts.admin')

@section('content')

    <div class="tool-bar">
        <div class="tool-bar__left">
            <h1 class="page-header">All Articles</h1>
            <a href="/admin/articles/new" class="button button--primary">
                <i class="tool-bar-add__icon fas fa-plus"></i>
                Add new article
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
                @slot('route') {{ '/admin/articles' }} @endslot
                @slot('list') {{ $list }} @endslot
                @slot('placeholder') Search for article... @endslot
            @endcomponent

            <button class="search-mobile__toggle">
                <i class="fas fa-search"></i>
            </button>

            <form class="search-mobile">
                <input class="search-mobile__input" type="text" placeholder="Search for article...">
                <button class="search-mobile__btn"><i class="fas fa-search"></i></button>
            </form>

        </div>

    </div>

    @component('admin/components/list', ['items' => $items, 'list_options' => $list_options])
        @slot('search') {{ $search }} @endslot
        @slot('sort_column') {{ $sort_column }} @endslot
        @slot('sort_direction') {{ $sort_direction }} @endslot
        @slot('per_page') {{ $per_page }} @endslot
        @slot('list') {{ $list }} @endslot
        @slot('route') /admin/articles @endslot
        @slot('singular') article @endslot
        @slot('plural') articles @endslot
    @endcomponent

    @component('admin/components/delete_modal')
        @slot('title') Delete post @endslot
        @slot('route') /admin/articles/delete @endslot
        @slot('list') {{ $list }} @endslot
    @endcomponent

    @component('admin/components/message')@endcomponent

@endsection