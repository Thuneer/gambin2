@extends('layouts.barebones')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-6">
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

                            <div class="form-group">

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"
                                               name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                    </label>
                                </div>

                            </div>

                            <div class="">

                                <button type="submit" class="admin-login__btn btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>

                            @foreach ($errors->all() as $message) {
                            <p>{{ $message }}</p>
                            @endforeach


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
