@extends('layouts.admin')

@section('content')


    <div class="tool-bar">
        <div class="tool-bar__left">
            <h1 class="page-header">Add new user</h1>
        </div>
    </div>

    <div class="form">

        <div class="form__body">
            <form id="form" action="/admin/users/new" method="POST">

                @csrf

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">

                            <!-- First Name -->
                            <div class="form__group">
                                <label class="form__label" for="">First name <span
                                            class="form__required">*</span></label>
                                <input value="{{ old('first-name') }}" name="first-name" class="form__input" type="text"
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
                                <input value="{{ old('last-name') }}" name="last-name" class="form__input" type="text"
                                       placeholder="Last name here...">
                            </div>
                            <!-- Last Name - END -->

                            <!-- Email-->
                            <div class="form__group">
                                <label class="form__label" for="">E-mail <span class="form__required">*</span></label>
                                <input value="{{ old('email') }}" name="email" class="form__input" type="email"
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

                                @php $p = Auth::user()->roles[0]->permissions; @endphp

                                <label class="checkcontainer @if(!$p->contains('name', 'create standard users')) checkcontainer-disabled @endif">Standard
                                    <input @if(!$p->contains('name', 'create standard users')) disabled @endif
                                            @if($p->contains('name', 'create standard users')) checked="checked" @endif type="radio" name="role" value="1">
                                    <span class="radiobtn"></span>
                                </label>
                                <label class="checkcontainer @if(!$p->contains('name', 'create editors')) checkcontainer-disabled @endif">Editor
                                    <input @if(!$p->contains('name', 'create editors')) disabled @endif
                                            @if(!$p->contains('name', 'create standard users') && $p->contains('name', 'create editors')) checked="checked" @endif type="radio" name="role" value="2">
                                    <span class="radiobtn"></span>
                                </label>
                                <label class="checkcontainer @if(!$p->contains('name', 'create administrators')) checkcontainer-disabled @endif">Administrator
                                    <input @if(!$p->contains('name', 'create administrators')) disabled @endif
                                    @if($p->contains('name', 'create administrators') && !$p->contains('name', 'create standard users') && !$p->contains('name', 'create editors')) checked="checked" @endif type="radio" name="role" value="3">
                                    <span class="radiobtn"></span>
                                </label>
                                <label class="checkcontainer @if(!$p->contains('name', 'create super admins')) checkcontainer-disabled @endif">Super admin
                                    <input @if(!$p->contains('name', 'create super admins')) disabled @endif
                                    @if($p->contains('name', 'create super admins') && !$p->contains('name', 'create standard users') && !$p->contains('name', 'create editors') && !$p->contains('name', 'create administrators')) checked="checked" @endif type="radio" name="role" value="4">
                                    <span class="radiobtn"></span>
                                </label>
                            </div>
                            <!-- Role - END -->

                            <!-- Image Preview -->
                            @component('admin.components.image_preview', ['item' => ['images' => []]])
                                @slot('title') Avatar @endslot
                                @slot('type') regular @endslot
                        @endcomponent

                        <!-- Password -->
                            <div class="form__group">
                                <label class="form__label" for="">Password <span class="form__required">*</span></label>
                                <input name="password" class="form__input" type="password"
                                       placeholder="Password here..."
                                       required
                                       minlength="8">
                            </div>
                            <!-- Password - END -->

                            <!-- Password Confirm -->
                            <div class="form__group">
                                <label class="form__label" for="">Confirm password <span class="form__required">*</span></label>
                                <input name="password_confirmation" class="form__input" type="password"
                                       placeholder="Confirm password here..." required minlength="8">
                                @if ($errors->has('password'))
                                    <div class="form__error">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <!-- Password Confirm - END -->

                            <button style="display: none" id="submitBtn"></button>

                        </div>
                    </div>
                </div>

            </form>
        </div>

        <div class="form__bottom">
            <button onclick="$('#submitBtn').click();" type="submit" class="button button--primary">Add new user
            </button>
        </div>

    </div>

    @component('admin.components.image_picker')@endcomponent

    @component('admin.components.message')@endcomponent

@endsection
