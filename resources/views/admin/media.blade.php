@extends('layouts.admin')

@section('content')

    <div class="tool-bar">
        <div class="tool-bar__left">
            <h1 class="page-header">All Media</h1>
            <button class="tool-bar-add__btn" data-toggle="modal" data-target="#mediaAdd">
                <i class="tool-bar-add__icon fas fa-plus"></i>
                Add media
            </button>
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
                @slot('route') {{ '/admin/media' }} @endslot
                @slot('list') {{ $list }} @endslot
                @slot('placeholder') Search for media... @endslot
            @endcomponent


            <form method="GET" class="view-type">
                <input name="list" id="list-value" type="hidden">

                <i onclick="$('#list-value').val('1'); $('.view-type').submit();"
                   class="view-type__icon view-type__icon--list @if($list == '1') view-type__active @endif fas fa-th-list"></i>
                <i onclick="$('#list-value').val('0'); $('.view-type').submit();"
                   class="view-type__icon view-type__icon--grid icon @if($list == '0') view-type__active @endif fas fa-th"></i>
                <i class="view-type__icon view-type__icon--search ion-md-search"></i>

            </form>

            <button class="search-mobile__toggle">
                <i class="fas fa-search"></i>
            </button>

            <form class="search-mobile">
                <input class="search-mobile__input" type="text" placeholder="Search for media...">
                <button class="search-mobile__btn"><i class="fas fa-search"></i></button>
            </form>

        </div>

    </div>

    @if($list == '1')

        <div class="list">

            <div class="list__top">

                <div class="dropdown bulk-actions">
                    <button class="bulk-actions__btn btn dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Bulk actions
                    </button>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <button disabled id="deleteBulkBtn" class="dropdown-item" href="#" data-toggle="modal"
                           data-target="#deleteModal">Delete selected</button>
                    </div>

                </div>

                @if($search)
                    <div class="list__search-text">Searching for <b>{{ $search }}</b></div>
                    <a class="list__clear-search" href="/admin/media">Clear search</a> @endif

                @component('admin/components/amount', ['items' => $items])
                    @slot('single') media file @endslot
                    @slot('plural') media files @endslot
                @endcomponent
            </div>

            <table class="table">
                <thead>
                <tr>

                    <td class="list__td list__primary" style="width: 50px">
                        <input id="bulkCheckbox" type="checkbox">
                    </td>

                    @component('admin/components/list_th')
                        @slot('title') Name @endslot
                        @slot('value') name @endslot
                        @slot('sort_type') {{ $sort_type }} @endslot
                        @slot('sort_value') {{ $sort_value }} @endslot
                        @slot('per_page') {{ $per_page }} @endslot
                        @slot('search') {{ $search }} @endslot
                        @slot('route') /admin/media @endslot
                        @slot('list') {{ $list }} @endslot
                        @slot('type') primary @endslot
                    @endcomponent

                    @component('admin/components/list_th')
                        @slot('title') Extension @endslot
                        @slot('value') extension @endslot
                        @slot('sort_type') {{ $sort_type }} @endslot
                        @slot('sort_value') {{ $sort_value }} @endslot
                        @slot('per_page') {{ $per_page }} @endslot
                        @slot('search') {{ $search }} @endslot
                        @slot('route') /admin/media @endslot
                        @slot('list') {{ $list }} @endslot
                        @slot('type') normal @endslot
                    @endcomponent

                    @component('admin/components/list_th')
                        @slot('title') Size @endslot
                        @slot('value') size @endslot
                        @slot('sort_type') {{ $sort_type }} @endslot
                        @slot('sort_value') {{ $sort_value }} @endslot
                        @slot('per_page') {{ $per_page }} @endslot
                        @slot('search') {{ $search }} @endslot
                        @slot('route') /admin/media @endslot
                        @slot('list') {{ $list }} @endslot
                        @slot('type') normal @endslot
                    @endcomponent

                    <th class="list__th" scope="col">Attached</th>
                    <th class="list__th" scope="col">Actions</th>

                </tr>
                </thead>
                <tbody>

                @if(count($items) === 0)
                    <tr id="none-found">
                        <td colspan="3" class="list__column">
                            No media found.
                        </td>
                    </tr>
                @endif

                @foreach ($items as $item)
                    <tr class="list__column">

                        <input class="list-id" type="hidden" value="{{ $item->id }}">
                        <input class="list-name" type="hidden" value="{{ $item->name }}">

                        <td class="list__td list__primary">
                            <input class="list__checkbox" type="checkbox">
                        </td>

                        <td class="list__td list__primary">
                            <a class="list__link" href="/">
                                <span class="list__img" style="background-color: {{ $item->color }}; background-image: url('/{{ $item->path_thumbnail }}')"></span>

                                {{ $item->name }}

                            </a>
                            <i class="list-dropdown__icon fas fa-eye"></i>
                        </td>

                        <td class="list__td">{{ $item->extension }}</td>

                        <td class="list__td">{{ round($item->size / 100000, 2) }} MB</td>
                        <td class="list__td">Yes</td>

                        <td class="list__td">

                            <button class="list__edit">Edit</button>
                            @component('admin/components/list_delete_btn', ['item' => $item])
                                @slot('type') media @endslot
                                @slot('min_role') 3 @endslot
                            @endcomponent

                        </td>

                    </tr>

                    <tr class="list-dropdown list-dropdown__hidden">
                        <td colspan="3">
                            <div class="list-dropdown__row">
                                <div class="list-dropdown__header">Extension</div>
                                <div class="list-dropdown__text">{{ $item->extension }}</div>
                            </div>
                            <div class="list-dropdown__row">
                                <div class="list-dropdown__header">Size</div>
                                <div class="list-dropdown__text">{{ round($item->size / 100000, 2) }} MB</div>
                            </div>
                            <i class="list-dropdown__delete fas fa-trash-alt"></i>
                            <i class="list-dropdown__edit fas fa-edit"></i>
                        </td>
                    </tr>

                @endforeach

                </tbody>
            </table>

            <div class="list__bottom">
                {{ $items->appends($_GET)->links() }}
            </div>

        </div>
    @elseif($list == '0')

        <div class="grid__top">
            @if($search)
                <div class="list__search-text">Searching for <b>{{ $search }}</b></div>
                <a class="list__clear-search" href="/admin/media">Clear search</a> @endif
        </div>

        <div class="grid">

            @if(count($items) === 0)
                <div id="none-found">No media found.</div>
            @endif

            @foreach($items as $item)

                <div class="grid__item" data-toggle="modal" data-target="#mediaDetails">

                    <div data-info='{
                    "name": "{{ $item->name }}",
                    "path": "{{ $item->path_medium }}",
                    "updated": "{{ $item->updated_at->diffForHumans() }}",
                    "size": "{{ round($item->size / 100000, 2) }} MB",
                    "extension": "{{ $item->extension }}" }'></div>

                    <div class="grid__img" style="background-color: {{ $item->color }};background-image: url(/{{ $item->path_thumbnail }})" onload="$(this).css('border', '5px solid red')"></div>
                    <div class="grid__details">
                        f
                    </div>
                </div>

            @endforeach

        </div>

        <div class="grid__bottom">
            {{ $items->appends($_GET)->links() }}
        </div>
    @endif

    @component('admin/components/delete_modal')
        @slot('title') Delete media @endslot
        @slot('route') /admin/media/delete @endslot
        @slot('list') {{ $list }} @endslot
    @endcomponent

    <!-- Upload modal -->
    <div class="modal fade" id="mediaAdd">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Upload media files (.png, .jpg or .mp4)</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="/admin/media" method="POST"
                          class="dropzone"
                          id="my-awesome-dropzone"></form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>


    <!-- Media details -->
    <div class="media-details modal fade" id="mediaDetails">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Media details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="media-details__img"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="media-details__row">
                                            <div class="media-details__header">Name</div>
                                            <div id="mediaName">Name and stuff</div>
                                        </div>
                                        <div class="media-details__row">
                                            <div class="media-details__header">Size</div>
                                            <div id="mediaSize">Name and stuff</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="media-details__row">
                                            <div class="media-details__header">Extension</div>
                                            <div id="mediaExtension">Name and stuff</div>
                                        </div>
                                        <div class="media-details__row">
                                            <div class="media-details__header">Updated</div>
                                            <div id="mediaUpdated">Name and stuff</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    @component('admin/components/message')@endcomponent

@endsection