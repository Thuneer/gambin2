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

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">

                            <!-- First Name -->
                            <div class="form__group">
                                <label class="form__label" for="">First name <span
                                            class="form__required">*</span></label>
                                <input value="{{ $user->first_name }}" name="first-name" class="form__input" type="text"
                                       placeholder="First name here..." required>
                                @if ($errors->has('first-name'))
                                    <div class="form__error">
                                        <strong>{{ $errors->first('first-name') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <!-- First Name - END -->

                            <!-- Last Name -->
                            <div class="form__group">
                                <label class="form__label" for="">Last name</label>
                                <input value="{{ $user->last_name }}" name="last-name" class="form__input" type="text"
                                       placeholder="Last name here...">
                            </div>
                            <!-- Last Name - END -->

                            <!-- Email-->
                            <div class="form__group">
                                <label class="form__label" for="">E-mail <span class="form__required">*</span></label>
                                <input value="{{ $user->email }}" name="email" class="form__input" type="email"
                                       placeholder="E-mail here..." required>
                                @if ($errors->has('email'))
                                    <div class="form__error">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <!-- Email - END -->

                            <!-- Role -->

                            <div class="form__group">
                                <label class="form__label" for="role">Role</label>
                                @php
                                    $auth_user = Auth::user();
                                    $auth_user_role = $auth_user->roles[0];
                                    $user_role_name = $user->roles[0]->name;

                                @endphp

                                <label class=" @if(canEditUserRole($auth_user, $user, 'edit standard users')) checkcontainer @else checkcontainer checkcontainer-disabled @endif">Standard
                                    <input @if(canEditUserRole($auth_user, $user, 'edit standard users')) @else disabled @endif @if($user->roles[0]->name == 'standard user') checked="checked" @endif
                                           type="radio" name="role" value="1">
                                    <span class="radiobtn"></span>
                                </label>
                                <label class="checkcontainer @if(canEditUserRole($auth_user, $user, 'edit editors')) checkcontainer @else checkcontainer checkcontainer-disabled @endif">Editor
                                    <input @if(canEditUserRole($auth_user, $user, 'edit editors')) @else disabled @endif @if($user->roles[0]->name == 'editor') checked="checked" @endif
                                           type="radio" name="role" value="2">
                                    <span class="radiobtn"></span>
                                </label>
                                <label class="checkcontainer @if(canEditUserRole($auth_user, $user, 'edit administrators')) checkcontainer @else checkcontainer checkcontainer-disabled @endif">Administrator
                                    <input @if(canEditUserRole($auth_user, $user, 'edit administrators')) @else disabled @endif @if($user->roles[0]->name == 'administrator') checked="checked" @endif
                                           type="radio" name="role" value="3">
                                    <span class="radiobtn"></span>
                                </label>
                                <label class="checkcontainer @if(canEditUserRole($auth_user, $user, 'edit super admins')) checkcontainer @else checkcontainer checkcontainer-disabled @endif">Super
                                    admin
                                    <input @if(canEditUserRole($auth_user, $user, 'edit super admins')) @else disabled @endif @if($user->roles[0]->name == 'super admin') checked="checked" @endif
                                           type="radio" name="role" value="4">
                                    <span class="radiobtn"></span>
                                </label>
                                <label class="checkcontainer @if($auth_user_role->name == 'owner' && $auth_user->id == $user->id) checkcontainer @else checkcontainer checkcontainer-disabled @endif">Owner
                                    <input @if($auth_user_role->name == 'owner' && $auth_user->id == $user->id) @else disabled @endif @if($user->roles[0]->name == 'owner') checked="checked" @endif
                                    type="radio" name="role" value="5">
                                    <span class="radiobtn"></span>
                                </label>
                            </div>

                            <!-- Role - END -->

                            <!-- Image Preview -->
                            @component('admin.components.image_preview', ['item' => $user])
                                @slot('title') Avatar @endslot
                                @slot('type') regular @endslot
                                @slot('id') imagePicker @endslot
                        @endcomponent

                        <!-- Password -->
                            <div class="form__group">
                                <label class="form__label" for="">Password <span class="form__required">*</span></label>
                                <input name="password" class="form__input" type="password"
                                       placeholder="Password here...">
                            </div>
                            <!-- Password - END -->

                            <!-- Password Confirm -->
                            <div class="form__group">
                                <label class="form__label" for="">Confirm password <span class="form__required">*</span></label>
                                <input name="password_confirmation" class="form__input" type="password"
                                       placeholder="Confirm password here...">
                                @if ($errors->has('password'))
                                    <div class="form__error">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <!-- Password Confirm - END -->

                        </div>
                    </div>
                </div>

                <button style="display: none" id="submitBtn"></button>

            </form>
        </div>

        <div class="form__bottom">
            <button onclick="$('#submitBtn').click();" type="submit" class="form__btn button button--primary"
                    @if(!canEditUser($user_role_name, $auth_user_role) && (Auth::user()->id != $user->id)) disabled @endif>
                Save user
            </button>

            @if(!canEditUser($user_role_name, $auth_user_role) && (Auth::user()->id != $user->id))
                You are not allowed to edit <b>{{ ucfirst($user->roles[0]->name) }}s</b>.
            @endif

        </div>

    </div>

    @component('admin.components.image_picker')@endcomponent

    @component('admin.components.message')@endcomponent

@endsection
