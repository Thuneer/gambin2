@extends('layouts.admin')

@section('content')

    <div class="tool-bar">
        <div class="tool-bar__left">
            <h1 class="page-header">Edit "{{ $item->name }}"</h1>
        </div>
    </div>

    <div class="form">

        <div class="form__body">
            <form id="form" action="/admin/media/{{ $item->id }}/edit" method="POST">
                @csrf

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">

                            <!-- Name -->
                            <div class="form__group">
                                <label class="form__label" for="">Name <span
                                            class="form__required">*</span></label>
                                <input value="{{ $item->name }}" name="name" class="form__input" type="text"
                                       placeholder="Name here..." required>
                                @if ($errors->has('name'))
                                    <div class="form__error">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <!-- First Name - END -->

                            <!-- Last Name -->
                            <div class="form__group">
                                <label class="form__label" for="">Alt attribute</label>
                                <input value="{{ $item->alt }}" name="alt" class="form__input" type="text"
                                       placeholder="Alt attribute here...">
                            </div>
                            <!-- Last Name - END -->




                        </div>
                    </div>
                </div>

                <button style="display: none" id="submitBtn"></button>

            </form>
        </div>

        <div class="form__bottom">

            <button onclick="$('#submitBtn').click();" type="submit" class="form__btn button button--primary"
                    @if(!canEditMedia(Auth::user())) disabled @endif>
                Save
                media file
            </button>

            @if(!canEditMedia(Auth::user()))
                You are not allowed to edit media files.
            @endif

        </div>

    </div>


    @component('admin.components.message')@endcomponent

@endsection
