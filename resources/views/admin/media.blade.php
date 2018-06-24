@extends('layouts.admin')

@section('content')

    <div class="tool-bar">
        <div class="tool-bar__left">
            <h1 class="page-header">All Media</h1>
            <button class="button button--primary" data-toggle="modal" data-target="#mediaAdd">
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

                <i onclick="$('#list-value').val('0'); $('.view-type').submit();"
                   class="view-type__icon view-type__icon--grid icon @if($list == '0') view-type__active @endif fas fa-th"></i>
                <i onclick="$('#list-value').val('1'); $('.view-type').submit();"
                   class="view-type__icon view-type__icon--list @if($list == '1') view-type__active @endif fas fa-th-list"></i>
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
                        <label for="bulkCheckbox"></label>
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
                            <input class="list__checkbox" id="styled-checkbox-{{ $item->id }}" type="checkbox">
                            <label for="styled-checkbox-{{ $item->id }}"></label>
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

                            <a href="/admin/media/{{ $item->id }}/edit" class="list__edit">Edit</a>

                            @if(!canDeleteMedia(Auth::user()))
                                <span data-toggle="tooltip" title="You do not have permission to delete media files."> @endif

                                    <button @if (!canDeleteMedia(Auth::user())) disabled
                                            @endif class="list__delete" data-toggle="modal" data-target="#deleteModal">Delete</button>

                                    @if(!canDeleteMedia(Auth::user()))</span>@endif

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

                <div class="grid__item" data-popshow="test1">

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
    <div id="test1" class="popup">

        <div class="popup__overlay"></div>

        <div class="popup__body">

            <div class="popup__header">
                <h3>Media details</h3>
            </div>
            <div class="media-details">

                <div class="container-fluid">

                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <img class="media-details__img" src="/img/test.jpg" alt="">
                        </div>
                        <div class="col-md-4">
                           <div class="media-details__container">
                               <div class="media-details__item">
                                   <div class="media-details__header">Name</div>
                                   <div class="media-details__text">test123</div>
                               </div>
                               <div class="media-details__item">
                                   <div class="media-details__header">Extension</div>
                                   <div class="media-details__text">.png</div>
                               </div>
                               <div class="media-details__item">
                                   <div class="media-details__header">Size</div>
                                   <div class="media-details__text">2 MB</div>
                               </div>
                               <div class="media-details__item">
                                   <div class="media-details__header">Resolution</div>
                                   <div class="media-details__text">1280 x 720</div>
                               </div>

                               <div class="media-details__item">
                                   <div class="media-details__header">Alt attribute</div>
                                   <div class="media-details__text">An image of a guy.</div>
                               </div>

                               <div class="media-details__item">
                                   <div class="media-details__header">File path</div>
                                   <div class="media-details__text">http://localhost:8000/admin/media?list=0</div>
                               </div>
                           </div>
                        </div>
                    </div>

                </div>

            </div>
            <div data-pophide="test1" class="popup__close-icon fas fa-times"></div>

        </div>

    </div>

    @component('admin/components/message')@endcomponent

@endsection