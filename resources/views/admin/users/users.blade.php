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
                <a class="list__clear-search" href="/admin/users">Clear search</a> @endif

            @component('admin/components/amount', ['items' => $users])
                @slot('single') user @endslot
                @slot('plural') users @endslot
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
                    @slot('title') Name @endslot
                    @slot('value') first_name @endslot
                    @slot('sort_type') {{ $sort_type }} @endslot
                    @slot('sort_value') {{ $sort_value }} @endslot
                    @slot('per_page') {{ $per_page }} @endslot
                    @slot('search') {{ $search }} @endslot
                    @slot('route') /admin/users @endslot
                    @slot('list') {{ $list }} @endslot
                    @slot('type') primary @endslot
                @endcomponent

                @component('admin/components/list_th')
                    @slot('title') Email @endslot
                    @slot('value') email @endslot
                    @slot('sort_type') {{ $sort_type }} @endslot
                    @slot('sort_value') {{ $sort_value }} @endslot
                    @slot('per_page') {{ $per_page }} @endslot
                    @slot('search') {{ $search }} @endslot
                    @slot('route') /admin/users @endslot
                    @slot('list') {{ $list }} @endslot
                    @slot('type') normal @endslot
                @endcomponent

                @component('admin/components/list_th')
                    @slot('title') Role @endslot
                    @slot('value') role_id @endslot
                    @slot('sort_type') {{ $sort_type }} @endslot
                    @slot('sort_value') {{ $sort_value }} @endslot
                    @slot('per_page') {{ $per_page }} @endslot
                    @slot('search') {{ $search }} @endslot
                    @slot('route') /admin/users @endslot
                    @slot('list') {{ $list }} @endslot
                    @slot('type') normal @endslot
                @endcomponent

                <th class="list__th" scope="col">Actions</th>

            </tr>
            </thead>
            <tbody>

            @if(count($users) === 0)
                <tr>
                    <td colspan="3" class="list__column">
                        No users found.
                    </td>
                </tr>
            @endif

            @foreach ($users as $user)
                <tr class="list__column">

                    <input class="list-id" type="hidden" value="{{ $user->id }}">
                    <input class="list-name" type="hidden" value="{{ $user->first_name }} {{ $user->last_name }}">

                    <td class="list__td list__primary">
                        <input class="list__checkbox" id="styled-checkbox-{{ $user->id }}" type="checkbox">
                        <label for="styled-checkbox-{{ $user->id }}"></label>
                    </td>

                    <td class="list__td list__primary">
                        <a class="list__link" href="/admin/users/{{ $user->id }}/edit">
                            <span class="list__img"
                                  style="background-color: {{ $user->color }}; background-image: url('@if(count($user->images) > 0)/{{ $user->images[0]->path_thumbnail }} @else{{ userAvatar($user->id) }} @endif'"></span>

                            {{ $user->first_name }} {{ $user->last_name }}
                        </a>
                        <i class="list-dropdown__icon fas fa-eye"></i>
                    </td>

                    <td class="list__td">{{ $user->email }}</td>
                    <td class="list__td">{{ ucfirst($user->roles->pluck('name')[0]) }}</td>
                    <td class="list__td">

                        <a href="/admin/users/{{ $user->id }}/edit" class="list__edit">Edit</a>


                        @if(!canDeleteUsers(Auth::user(), $user))
                            <span data-toggle="tooltip" title="You do not have permission to delete this user."> @endif

                                <button @if (!canDeleteUsers(Auth::user(), $user)) disabled
                                        @endif class="list__delete" data-toggle="modal" data-target="#deleteModal">Delete</button>

                                @if(!canDeleteUsers(Auth::user(), $user))</span>@endif

                    </td>

                </tr>

                <tr class="list-dropdown list-dropdown__hidden">
                    <td colspan="3">
                        <div class="list-dropdown__row">
                            <div class="list-dropdown__header">E-mail</div>
                            <div class="list-dropdown__text">{{ $user->email }}</div>
                        </div>
                        <div class="list-dropdown__row">
                            <div class="list-dropdown__header">Role</div>
                            <div class="list-dropdown__text">{{ ucfirst($user->roles->pluck('name')[0]) }}</div>
                        </div>
                        <div class="list-dropdown__row">
                            <div class="list-dropdown__header">Updated</div>
                            <div class="list-dropdown__text">{{ $user->updated_at->diffForHumans() }}</div>
                        </div>
                        <i class="list-dropdown__delete fas fa-trash-alt"></i>
                        <i class="list-dropdown__edit fas fa-edit"></i>
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>

        <div class="list__bottom">
            {{ $users->appends($_GET)->links() }}
        </div>

    </div>

    @component('admin/components/delete_modal')
        @slot('title') Delete user @endslot
        @slot('route') /admin/users/delete @endslot
        @slot('list') {{ $list }} @endslot
    @endcomponent

    @component('admin/components/message')@endcomponent

@endsection