@extends('layouts.barebones')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-7">
                <div class="admin-login">
                    <div class="admin-login__header">Admin login</div>

                    <div class="admin-form__container">

                        <form method="POST" action="/admin/login">
                            @csrf

                            <div class="form-group">
                                <label for="email" class="">E-mail address</label>


                                <input id="email" type="email"
                                       class="admin-login__input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                       value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="password" class="">{{ __('Password') }}</label>


                                <input id="password" type="password"
                                       class="admin-login__input form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="">

                                <button type="submit" class="admin-login__btn btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
