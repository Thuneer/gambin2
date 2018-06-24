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

    <div class="list">

        <div class="list__top">

            <div class="dropdown bulk-actions">
                <button class="bulk-actions__btn btn dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Bulk actions
                </button>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <button disabled id="deleteBulkBtn" class="dropdown-item" href="#" data-toggle="modal"
                            data-target="#deleteModal">Delete selected
                    </button>
                </div>

            </div>

            @if($search)
                <div class="list__search-text">Searching for <b>{{ $search }}</b></div>
                <a class="list__clear-search" href="/admin/articles">Clear search</a> @endif

            @component('admin/components/amount', ['items' => $items])
                @slot('single') article @endslot
                @slot('plural') articles @endslot
            @endcomponent

        </div>

        <table class="table">
            <thead>
            <tr>

                <td class="list__td list__primary" style="width: 50px">
                    <input id="bulkCheckbox" type="checkbox">
                    <label for="bulkCheckbox"></label>
                </td>

                @component('admin/components/list_th')
                    @slot('title') Title @endslot
                    @slot('value') title @endslot
                    @slot('sort_type') {{ $sort_type }} @endslot
                    @slot('sort_value') {{ $sort_value }} @endslot
                    @slot('per_page') {{ $per_page }} @endslot
                    @slot('search') {{ $search }} @endslot
                    @slot('route') /admin/articles @endslot
                    @slot('list') {{ $list }} @endslot
                    @slot('type') primary @endslot
                @endcomponent

                @component('admin/components/list_th')
                    @slot('title') Author @endslot
                    @slot('value') email @endslot
                    @slot('sort_type') {{ $sort_type }} @endslot
                    @slot('sort_value') {{ $sort_value }} @endslot
                    @slot('per_page') {{ $per_page }} @endslot
                    @slot('search') {{ $search }} @endslot
                    @slot('route') /admin/articles @endslot
                    @slot('list') {{ $list }} @endslot
                    @slot('type') normal @endslot
                @endcomponent


            @component('admin/components/list_th')
                    @slot('title') Published @endslot
                    @slot('value') published @endslot
                    @slot('sort_type') {{ $sort_type }} @endslot
                    @slot('sort_value') {{ $sort_value }} @endslot
                    @slot('per_page') {{ $per_page }} @endslot
                    @slot('search') {{ $search }} @endslot
                    @slot('route') /admin/articles @endslot
                    @slot('list') {{ $list }} @endslot
                    @slot('type') normal @endslot
                @endcomponent

                @component('admin/components/list_th')
                    @slot('title') Updated @endslot
                    @slot('value') updated_at @endslot
                    @slot('sort_type') {{ $sort_type }} @endslot
                    @slot('sort_value') {{ $sort_value }} @endslot
                    @slot('per_page') {{ $per_page }} @endslot
                    @slot('search') {{ $search }} @endslot
                    @slot('route') /admin/articles @endslot
                    @slot('list') {{ $list }} @endslot
                    @slot('type') normal @endslot
                @endcomponent

                <th class="list__th" scope="col">Actions</th>

            </tr>
            </thead>
            <tbody>

            @if(count($items) === 0)
                <tr>
                    <td colspan="3" class="list__column">
                        No posts found.
                    </td>
                </tr>
            @endif

            @foreach ($items as $item)
                <tr class="list__column">

                    <input class="list-id" type="hidden" value="{{ $item->id }}">
                    <input class="list-name" type="hidden" value="{{ $item->title }}">

                    <td class="list__td list__primary">
                        <input class="list__checkbox" id="styled-checkbox-{{ $item->id }}" type="checkbox">
                        <label for="styled-checkbox-{{ $item->id }}"></label>
                    </td>

                    <td class="list__td list__primary">
                        <a class="list__link" href="/admin/articles/{{ $item->id }}/edit">
                            <span class="list__img"
                                  style="background-color: {{ $item->color }}; background-image: url('@if(count($item->images) > 0)/{{ $item->images[0]->path_thumbnail }} @else{{ userAvatar($item->id) }} @endif'"></span>

                            {{ $item->title }}
                        </a>
                        <i class="list-dropdown__icon fas fa-eye"></i>
                    </td>

                    <td class="list__td">{{ $item->user->first_name }} {{ $item->user->last_name }}</td>
                    <td class="list__td">@if($item->published == 0) No @else Yes @endif</td>

                    <td class="list__td">
                        {{ $item->updated_at->diffForHumans() }}
                    </td>

                    <td class="list__td">

                        <a href="/admin/articles/{{ $item->id }}/edit" class="list__edit">Edit</a>

                        @if(!canDeleteArticles(Auth::user(), $item))
                            <span data-toggle="tooltip" title="You do not have permission to delete this user."> @endif

                                <button @if (!canDeleteArticles(Auth::user(), $item)) disabled
                                        @endif class="list__delete" data-toggle="modal" data-target="#deleteModal">Delete</button>

                                @if(!canDeleteArticles(Auth::user(), $item))</span>@endif

                    </td>

                </tr>

                <tr class="list-dropdown list-dropdown__hidden">

                </tr>

            @endforeach

            </tbody>
        </table>

        <div class="list__bottom">
            {{ $items->appends($_GET)->links() }}
        </div>

    </div>

    @component('admin/components/delete_modal')
        @slot('title') Delete post @endslot
        @slot('route') /admin/articles/delete @endslot
        @slot('list') {{ $list }} @endslot
    @endcomponent

    @component('admin/components/message')@endcomponent

@endsection