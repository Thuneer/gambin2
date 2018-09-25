@extends('layouts.admin')

@section('content')

    <div class="tool-bar">
        <div class="tool-bar__left">
            <h1 class="page-header">Edit "{{ $post->title }}"</h1>
        </div>
    </div>

    <div class="form">

        <div class="form__body">
            <form id="form" action="/admin/articles/{{ $post->id }}/edit" method="POST">

                @csrf

                <div class="form__left">

                    <!-- Title -->
                    <div class="form__group">
                        <label class="form__label" for="">Title <span class="form__required">*</span></label>
                        <input value="{{ $post->title }}" name="title" class="form__input" type="text" required
                               placeholder="Title here...">
                        @if ($errors->has('title'))
                            <div class="form__error">
                                <strong>{{ $errors->first('title') }}</strong>
                            </div>
                        @endif
                    </div>
                    <!-- Title - END -->


                    <!-- Slug -->
                    <div class="form__group">
                        <label class="form__label" for="">Slug</label>
                        <input value="{{ $post->slug }}" name="slug" class="form__input" type="text"
                               placeholder="Title here...">
                        @if ($errors->has('slug'))
                            <div class="form__error">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </div>
                        @endif
                    </div>
                    <!-- Slug - END -->

                    <!-- Description -->
                    <div class="form__group">
                        <label class="form__label" for="">Short content</label>
                        <textarea placeholder="Description here..." rows="5" name="ingress" >{{ $post->ingress }}</textarea>
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
                        <textarea name="body" id="summernote">{{ $post->body }}</textarea>
                        @if ($errors->has('body'))
                            <div class="form__error">
                                <strong>{{ $errors->first('body') }}</strong>
                            </div>
                        @endif
                    </div>
                    <!-- Content - END -->

                    <div class="form__bottom d-none d-lg-block">
                        <button @if(!canEditArticles(Auth::user(), $post)) disabled @endif onclick="$('#submitBtn').click();" type="submit" class="button button--primary">Save article
                        </button>
                        <button @if(!canEditArticles(Auth::user(), $post)) disabled @endif class="post-preview button button--secondary">Preview</button>
                        @if(!canEditArticles(Auth::user(), $post)) You do not have permission to edit other users' articles. @endif
                    </div>
                    <button style="display: none" id="submitBtn"></button>

                </div>
                <div class="form__right">

                    <!-- Status -->
                @component('admin.components.forms.post_status')
                    @slot('status') {{ $post->status }} @endslot
                @endcomponent

                <!-- Image Preview -->
                    @component('admin.components.image_preview', ['item' => $post])
                        @slot('title') Post image @endslot
                        @slot('type') card @endslot
                            @slot('id') imagePicker @endslot
                    @endcomponent


                <!-- Tags -->
                    @component('admin.components.forms.post_tags', ['tags' => $tags, 'post' => $post])@endcomponent

                </div>

                <div class="form__bottom d-block d-lg-none">
                    <button @if(!canEditArticles(Auth::user(), $post)) disabled @endif onclick="$('#submitBtn').click();" type="submit" class="button button--primary">Save article
                    </button>
                    <button @if(!canEditArticles(Auth::user(), $post)) disabled @endif class="post-preview button button--secondary">Preview</button>
                    @if(!canEditArticles(Auth::user(), $post)) You do not have permission to edit other users' articles. @endif
                </div>

            </form>
        </div>

    </div>

    <!-- Image Picker -->
    @component('admin.components.image_picker')@endcomponent

    <!-- Message -->
    @component('admin.components.message')@endcomponent

@endsection