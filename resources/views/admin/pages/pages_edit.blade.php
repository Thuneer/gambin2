@extends('layouts.admin')

@section('content')

    <div class="tool-bar">
        <div class="tool-bar__left">
            <h1 class="page-header">Edit page</h1>
        </div>
    </div>

    <div class="form">

        <div class="form__body">
            <form id="form" action="/admin/pages/{{ $page->id }}/edit" method="POST">

                @csrf

                <div class="form__left">

                    <input id="page-id" type="hidden" value="{{ $page->id }}" name="id">

                    <!-- Title -->
                    <div class="form__group">
                        <label class="form__label" for="">Title <span class="form__required">*</span></label>
                        <input id="page-title" value="{{ $page->title }}" name="title" class="form__input" type="text"
                               required
                               placeholder="Title here...">
                        @if ($errors->has('title'))
                            <div class="form__error">
                                <strong>{{ $errors->first('title') }}</strong>
                            </div>
                        @endif
                    </div>
                    <!-- Title - END -->

                    <!-- Url -->
                    <div class="form__group">
                        <label class="form__label" for="">Permalink <span class="form__required">*</span></label>
                        <div class="permalink">
                            {{ URL::to('/') }}/<span class="permalink__url">{{ $page->permalink }}</span> <input placeholder="example/users"
                                                                                           class="permalink__input"
                                                                                           type="text" name="permalink" value="{{ $page->permalink_short }}">
                            <button id="permalink-edit" class="permalink__btn"><i class="fas fa-pencil-alt"></i>
                            </button>
                            <button id="permalink-add" class="permalink__btn permalink__btn--success"><i
                                        class="fas fa-check"></i></button>
                            <button id="permalink-remove" class="permalink__btn permalink__btn--error"><i
                                        class="fas fa-times"></i></button>
                        </div>

                        @if ($errors->has('permalink'))
                            <div class="form__error">
                                <strong>{{ $errors->first('permalink') }}</strong>
                            </div>
                        @endif
                    </div>
                    <!-- Title - END -->

                    <!-- Content -->
                    <div class="form__group form__group--summernote" @if($page->type == 1) style="display: none" @endif>
                        <label class="form__label" for="">Content</label>
                        <textarea name="summernote_body" id="summernote">{{ $page->type == 0 ? $page->body : '' }}</textarea>
                        @if ($errors->has('body'))
                            <div class="form__error">
                                <strong>{{ $errors->first('body') }}</strong>
                            </div>
                        @endif
                        <input type="hidden" name="pb_body" id="pb-content" value="{{ $page->type == 1 ? $page->body : '' }}">
                    </div>
                    <!-- Content - END -->


                    <div id="pagebuilder-container" class="form__group" @if($page->type == 1) style="display: block" @endif>
                        <label class="form__label" for="">Content</label>
                        <div class="form__builder">
                            <button data-popshow="page-builder-popup" class="button button--builder"><i
                                        class="fas fa-gavel"></i> Enter news builder
                            </button>
                        </div>

                    </div>


                    <div class="form__bottom d-none d-lg-block">
                        <button onclick="$('#submitBtn').click();" type="submit" class="button button--primary">Save page
                        </button>

                    </div>
                    <button style="display: none" id="submitBtn"></button>

                </div>
                <div class="form__right">

                    <div class="form__group form__group--card">
                        <label class="form__label" for="">Type</label>
                        <div>
                            <input name="type" id="regular" type="radio" value="0" {{ $page->type == 0 ? 'checked' : '' }}>
                            <label for="regular">Regular</label>
                        </div>
                        <div>
                            <input name="type" id="pagebuilder" type="radio" value="1" {{ $page->type == 1 ? 'checked' : '' }}>
                            <label for="pagebuilder">News builder</label>
                        </div>


                    </div>

                    <div class="form__group form__group--card">
                        <label class="form__label" for="">Options</label>
                        <div class="form__mini-group">
                            <label class="form__label form__label-mini" for="">Parent</label>
                            <div>
                                <select name="parent" id="parent-select">
                                    <option value="">No parent</option>
                                    @foreach($pages as $loopPage)
                                        {{ renderPageParentNodes($loopPage, $page) }}
                                    @endforeach
                                </select>
                            </div>

                            @if ($errors->has('parent'))
                                <div class="form__error">
                                    <strong>{{ $errors->first('parent') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="form__mini-group">
                            <label class="form__label form__label-mini" for="">Template</label>
                            <div>
                                <select name="template" id="">
                                    <option value="-1">No parent</option>
                                    @foreach($templates as $template)
                                        <option @if($page->template == $template) selected @endif value="{{ $template }}">{{ $template }}</option>
                                    @endforeach

                                </select>


                            </div>
                        </div>


                    </div>

                </div>

                <div class="form__bottom d-block d-lg-none">
                    <button onclick="$('#submitBtn').click();" type="submit" class="button button--primary">Save page
                    </button>
                </div>

            </form>
        </div>

    </div>

    <!-- Page builder -->
    @component('admin.pages.pb')@endcomponent

    <!-- Message -->
    @component('admin.components.message')@endcomponent

@endsection