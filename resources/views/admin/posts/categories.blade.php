@extends('layouts.admin')

@section('content')

    <div class="tool-bar">
        <div class="tool-bar__left">
            <h1 class="page-header">Add new category</h1>
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
                @slot('route') {{ '/admin/articles/categories' }} @endslot
                @slot('list') {{ $list }} @endslot
                @slot('placeholder') Search for page... @endslot
            @endcomponent

            <button class="search-mobile__toggle">
                <i class="fas fa-search"></i>
            </button>

            <form class="search-mobile">
                <input class="search-mobile__input" type="text" placeholder="Search for page...">
                <button class="search-mobile__btn"><i class="fas fa-search"></i></button>
            </form>

        </div>

    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="form">

                    <div class="form__body">
                        <form id="form" action="/admin/pages/new" method="POST">

                            @csrf


                                <div class="form__left">
                                    <!-- Title -->
                                    <div class="form__group">
                                        <label class="form__label" for="">Name <span class="form__required">*</span></label>
                                        <input id="page-title" value="{{ old('title') }}" name="name" class="form__input" type="text"
                                               required
                                               placeholder="Name here...">
                                        @if ($errors->has('name'))
                                            <div class="form__error">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Title - END -->

                                    <div class="form__bottom">
                                        <button onclick="$('#submitBtn').click();" type="submit" class="button button--primary">Add new
                                            category
                                        </button>

                                    </div>

                                </div>


                        </form>
                    </div>

                </div>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-6">
                @component('admin/components/list', ['items' => $items, 'list_options' => $list_options])
                    @slot('search') {{ $search }} @endslot
                    @slot('sort_column') {{ $sort_column }} @endslot
                    @slot('sort_direction') {{ $sort_direction }} @endslot
                    @slot('per_page') {{ $per_page }} @endslot
                    @slot('list') {{ $list }} @endslot
                    @slot('route') /admin/articles/categories @endslot
                    @slot('singular') category @endslot
                    @slot('plural') categories @endslot
                @endcomponent
            </div>
        </div>
    </div>

    @component('admin/components/delete_modal')
        @slot('title') Delete category @endslot
        @slot('route') /admin/articles/categories @endslot
        @slot('list') {{ $list }} @endslot
    @endcomponent

    @component('admin/components/message')@endcomponent

@endsection