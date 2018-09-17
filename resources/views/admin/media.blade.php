@extends('layouts.admin')

@section('content')

    <div class="tool-bar">
        <div class="tool-bar__left">
            <h1 class="page-header">All Media</h1>
            <button class="button button--primary" data-toggle="modal" data-target="#mediaAddModal">
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

        @component('admin/components/list', ['items' => $items, 'list_options' => $list_options])
            @slot('search') {{ $search }} @endslot
            @slot('sort_column') {{ $sort_column }} @endslot
            @slot('sort_direction') {{ $sort_direction }} @endslot
            @slot('per_page') {{ $per_page }} @endslot
            @slot('list') {{ $list }} @endslot
            @slot('route') /admin/media @endslot
            @slot('singular') media file @endslot
            @slot('plural') media files @endslot
        @endcomponent

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

                <div class="grid__item" data-popshow="mediaDetails">
                    <span class="imageInfo"
                            data-id="{{ $item->id }}"
                            data-name="{{ $item->name }}"
                            data-path="{{ $item->path . '-16-9-lg' . '.' . $item->extension}}"
                            data-updated="{{ $item->updated_at->diffForHumans() }}"
                            data-size="{{ round($item->size / 100000, 2) }} MB"
                            data-alt="{{ $item->alt }}"
                            data-title="{{ $item->title }}"
                            data-resX="{{ $item->resolution_x }}"
                            data-resY="{{ $item->resolution_y }}"
                            data-extension="{{ $item->extension }}"
                    ></span>

                    <div class="grid__img" style="background-color: {{ $item->color }};background-image: url(/{{ $item->path . '-16-9-lg' . '.' . $item->extension }})"
                         onload="$(this).css('border', '5px solid red')"></div>
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

    <!-- Upload modal -->
    <div class="modal fade" id="mediaAddModal">
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
                          id="media-upload-dropzone"></form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>



    <!-- Media details -->
    <div id="mediaDetails" class="popup popup--lg">

        <div hidden id="detailsId"></div>

        <div class="popup__overlay"></div>

        <div class="popup__main">

            <div class="media-details">

                <div class="media-details__img-container">

                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-12">
                                <img class="media-details__img" src="/img/test.jpg" alt="">
                            </div>

                        </div>

                    </div>

                </div>
                <div class="media-details__text-container">
                    <div class="container-fluid">
                        
                        <div class="row">
                            <div class="col-md-6 col-lg-4">

                                <div class="media-details__item">
                                    <div class="media-details__header">Name
                                        <span class="media-details__edit"><i class="fas fa-pencil-alt"></i> Edit</span>
                                        <i class="media-details__check fas fa-check" data-column="name"></i>
                                        <i class="media-details__error fas fa-times"></i>
                                    </div>
                                    <div id="mediaName" class="media-details__text">test123</div>
                                    <input id="mediaNameInput" placeholder="Name..." class="media-details__input" type="text">
                                </div>

                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="media-details__item">
                                    <div class="media-details__header">Title
                                        <span class="media-details__edit"><i class="fas fa-pencil-alt"></i> Edit</span>
                                        <i class="media-details__check fas fa-check" data-column="title"></i>
                                        <i class="media-details__error fas fa-times"></i>
                                    </div>
                                    <div id="mediaTitle" class="media-details__text">Image of a guy.</div>
                                    <input id="mediaTitleInput" placeholder="Title..." class="media-details__input" type="text">
                                </div>


                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="media-details__item">
                                    <div class="media-details__header">Alt attribute
                                        <span class="media-details__edit"><i class="fas fa-pencil-alt"></i> Edit</span>
                                        <i class="media-details__check fas fa-check" data-column="alt"></i>
                                        <i class="media-details__error fas fa-times"></i>
                                    </div>
                                    <div id="mediaAlt" class="media-details__text">An image of a guy.</div>
                                    <input id="mediaAltInput" placeholder="Alt..." class="media-details__input" type="text">
                                </div>



                            </div>


                            <div class="col-md-6 col-lg-4">
                                <div class="media-details__item">
                                    <div class="media-details__header">Extension</div>
                                    <div id="mediaExtension" class="media-details__text">.png</div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="media-details__item">
                                    <div class="media-details__header">Resolution</div>
                                    <div id="mediaResolution" class="media-details__text">1280 x 720</div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="media-details__item">
                                    <div class="media-details__header">Size</div>
                                    <div id="mediaSize" class="media-details__text">1280 x 720</div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="media-details__item media-details__item--end">
                                    <div class="media-details__header">File path</div>
                                    <div id="mediaPath" class="media-details__text">
                                        http://localhost:8000/admin/media?list=0
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="media-details__item media-details__item--end">
                                    <button data-popshow="deletePopup" class="media-details__delete"><i class="fas fa-trash-alt"></i> Delete media file</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div data-pophide="mediaDetails" class="popup__close-icon fas fa-times"></div>

        </div>

    </div>

    <!-- Popup delete -->
    @component('admin/components/delete_modal')
        @slot('title') Delete media file @endslot
        @slot('route') /admin/media/delete @endslot
        @slot('list') {{ $list }} @endslot
    @endcomponent

    @component('admin/components/message')@endcomponent

@endsection