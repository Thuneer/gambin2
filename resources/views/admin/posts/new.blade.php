@extends('layouts.admin')

@section('content')

    <div class="tool-bar">
        <div class="tool-bar__left">
            <h1 class="page-header">Add new article</h1>
        </div>
    </div>

    <div class="form">

        <div class="form__body">
            <form id="form" action="/admin/articles/new" method="POST">

                @csrf

                <div class="form__left">
                    
                    <!-- Title -->
                    <div class="form__group">
                        <label class="form__label" for="">Title <span class="form__required">*</span></label>
                        <input value="{{ old('title') }}" name="title" class="form__input" type="text" required
                               placeholder="Title here...">
                        @if ($errors->has('title'))
                            <div class="form__error">
                                <strong>{{ $errors->first('title') }}</strong>
                            </div>
                        @endif
                    </div>
                    <!-- Title - END -->

                    <!-- Description -->
                    <div class="form__group">
                        <label class="form__label" for="">Description</label>
                        <textarea placeholder="Description here..." rows="5" name="ingress"></textarea>
                        @if ($errors->has('ingress'))
                            <div class="form__error">
                                <strong>{{ $errors->first('ingress') }}</strong>
                            </div>
                        @endif
                    </div>
                    <!-- Description - END -->

                    <!-- Content -->
                    <div class="form__group form__group--summernote">
                        <label class="form__label" for="">Content</label>
                        <textarea name="body" id="summernote"></textarea>
                        @if ($errors->has('body'))
                            <div class="form__error">
                                <strong>{{ $errors->first('body') }}</strong>
                            </div>
                        @endif
                    </div>
                    <!-- Content - END -->

                    <div class="form__bottom d-none d-lg-block">
                        <button onclick="$('#submitBtn').click();" type="submit" class="button button--primary">Add new
                            article
                        </button>
                        <button class="post-preview button button--secondary">Preview</button>
                    </div>
                    <button style="display: none" id="submitBtn"></button>

                </div>
                <div class="form__right">

                    <!-- Status -->
                    @component('admin.components.forms.post_status')
                        @slot('status') draft @endslot
                    @endcomponent

                    <!-- Image Preview -->
                    @component('admin.components.image_preview', ['item' => ['images' => []]])
                        @slot('title') Post image @endslot
                        @slot('type') card @endslot
                        @slot('id') imagePicker @endslot
                    @endcomponent

                    <!-- Tags -->
                    @component('admin.components.forms.post_tags', ['tags' => $tags, 'post' => ['tags' => []]])@endcomponent

                </div>

                <div class="form__bottom d-block d-lg-none">
                    <button onclick="$('#submitBtn').click();" type="submit" class="button button--primary">Add new
                        article
                    </button>
                    <button class="post-preview button button--secondary">Preview</button>
                </div>

            </form>
        </div>

    </div>

    <!-- Image Picker -->
    @component('admin.components.image_picker')@endcomponent

    <!-- Message -->
    @component('admin.components.message')@endcomponent

@endsection