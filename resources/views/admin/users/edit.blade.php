@extends('layouts.admin')

@section('content')


    <div class="tool-bar">
        <div class="tool-bar__left">
            <h1 class="page-header">Edit "{{ $user->first_name }} {{ $user->last_name }}"</h1>
        </div>
    </div>

    <div class="form">

        <div class="form__body">
            <form id="form" action="/admin/users/{{ $user->id }}/edit" method="POST">
                @csrf

                <div class="form__group">
                    <label for="">First name <span class="form__required">*</span></label>
                    <input value="{{ $user->first_name }}" name="first-name" class="form__input" type="text"
                           placeholder="First name here..." required>
                    @if ($errors->has('first-name'))
                        <div class="form__error">
                            <strong>{{ $errors->first('first-name') }}</strong>
                        </div>
                    @endif
                </div>
                <div class="form__group">
                    <label for="">Last name</label>
                    <input value="{{ $user->last_name }}" name="last-name" class="form__input" type="text"
                           placeholder="Last name here...">
                </div>
                <div class="form__group">
                    <label for="">E-mail <span class="form__required">*</span></label>
                    <input value="{{ $user->email }}" name="email" class="form__input" type="email"
                           placeholder="E-mail here..." required>
                    @if ($errors->has('email'))
                        <div class="form__error">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif

                </div>

                @if(Auth::user()->id != $user->id)
                <div class="form__group">
                    <label for="role">Role</label>
                    <select id="role" name="role">
                        @foreach($roles as $role)
                            <option @if($role->id == $user->role_id) selected @endif value="{{ $role->id }}"> {{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="form__group">
                    <label for="">Avatar</label>
                    <div class="image-picker-preview" data-toggle="modal" data-target=".bd-example-modal-lg">
                        <i class="image-picker-preview__add fas fa-plus"></i>
                        <i class="image-picker-preview__remove fas fa-times"></i>
                        <input id="image-picker-id" type="hidden" name="image" @if(count($user->images) > 0)data-path="{{ $user->images[0]->path_thumbnail }}" data-id="{{ $user->images[0]->id }}" @endif>
                    </div>
                    @if ($errors->has('image'))
                        <div class="form__error">
                            <strong>{{ $errors->first('image') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="form__group">
                    <label for="">Password <span class="form__required">*</span></label>
                    <input name="password" class="form__input" type="password" placeholder="Password here...">
                </div>

                <div class="form__group">
                    <label for="">Confirm password <span class="form__required">*</span></label>
                    <input name="password_confirmation" class="form__input" type="password"
                           placeholder="Confirm password here...">
                    @if ($errors->has('password'))
                        <div class="form__error">
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                    @endif
                </div>


                <button style="display: none" id="submitBtn"></button>

            </form>
        </div>

        <div class="form__bottom">
            <button onclick="$('#submitBtn').click();" type="submit" class="form__btn">Save user</button>
        </div>


    </div>

    <div class="image-picker">
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Choose image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="image-picker__tabs">
                            <div class="image-picker__tab image-picker__tab--active" data-tab="1">Media
                                library
                            </div>
                            <div class="image-picker__tab" data-tab="2">Upload images</div>

                        </div>

                        <div class="image-picker__library">

                            <div class="image-picker__search">
                                <input placeholder="Search for image name..."
                                       class="image-picker__input" type="text">
                                <i class="image-picker__search-icon fas fa-search"></i>
                                <i class="image-picker__loading-icon fas fa-spinner"></i>
                                <i class="image-picker__close-icon fas fa-times"></i>
                            </div>

                            <p class="image-picker__selected">No image selected.</p>

                            <div class="image-picker__images">

                            </div>

                        </div>


                        <div class="image-picker__upload">
                            <form action="/file-upload"
                                  class="dropzone"
                                  id="imagePickerDropzone"></form>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                        </button>
                        <button type="button" class="image-picker__select btn btn-success" disabled
                                data-dismiss="modal">Choose
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @component('admin/components/message')@endcomponent

@endsection
