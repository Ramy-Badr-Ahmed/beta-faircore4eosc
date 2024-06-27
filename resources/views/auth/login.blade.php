@extends('layouts.single-column-page')

<x-beta.navigation-bar :isLoginActive="true"
                       :mtime="(new DateTime('Europe/Berlin'))->setTimeStamp(File::lastModified(base_path('resources/views/auth/login.blade.php')))->format('d/M/y @H:i')" />

@section('headline', 'FC4EOSC — WP6.2 — Beta')

@section('main')

    <div class="centered-content">
        <div style="text-align: center">
            <p style="margin-bottom: 20px">
                For organisational matters, please log in first.
            </p>
        </div>
    </div>

    <div class="container">
        <div style="margin-top:50px;" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-yellow bodyShadow-forms fadeIn">
                <div class="panel-heading headerCard">
                    <div class="panel-title" style="letter-spacing: 2px; font-weight: bold">{{ __('User Login') }}</div>
                </div>
                <div style="padding-top:30px" class="panel-body" >

                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div style="margin-bottom: 25px" class="input-group @error('email') has-error @enderror">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <label for="email"></label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                                   required autocomplete="email" placeholder="Email Address">
                            @error('email')
                                <span class="glyphicon glyphicon-remove form-control-feedback " aria-hidden="true"></span>
                            @enderror
                        </div>

                        @error('email')
                            <span class="invalid-feedback help-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <div style="margin-bottom: 25px" class="input-group @error('password') has-error @enderror">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <label for="password"></label>
                            <input id="password" type="password" class="form-control" name="password" required placeholder="Password"
                                   autocomplete="current-password">
                            @error('password')
                                <span class="glyphicon glyphicon-remove form-control-feedback " aria-hidden="true"></span>
                            @enderror
                        </div>

                        @error('password')
                            <span class="invalid-feedback help-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="row mb-3" style="margin-bottom: 20px">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0" style="margin-bottom: 20px">
                            <div class="col-md-8 col-md-push-4">
                                <button type="submit" class="btn btn-primary -btn -btn-effect-deposit" style="margin-right: 5px">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div style="border-top: 1px solid#888; padding-top:15px; font-size:90%" >
                                    <span> Don't have an account?<span class="glyphicon glyphicon-edit" style="margin-left: 6px; margin-right: 4px; font-size: 12px"></span>
                                        <a href="{{route('register')}}">Register Here</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
