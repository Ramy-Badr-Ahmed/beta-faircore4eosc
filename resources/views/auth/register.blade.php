@extends('layouts.single-column-page')

<x-beta.navigation-bar :isRegisterActive="true"
                       :mtime="(new DateTime('Europe/Berlin'))->setTimeStamp(File::lastModified(base_path('resources/views/auth/register.blade.php')))->format('d/M/y @H:i')" />

@section('headline', 'LZI — WP6.2 — Beta')

@section('main')
    <div class="centered-content">
        <div style="text-align: center">
            <p style="margin-bottom: 20px">
                For organisational matters, please register as a new user.
            </p>
        </div>
    </div>

    <div style="margin-top:50px; margin-bottom: 100px" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-yellow bodyShadow-forms fadeIn">
            <div class="panel-heading headerCard">
                <div class="panel-title" style="letter-spacing: 2px; font-weight: bold">{{ __('Create a New Account') }}</div>
            </div>
            <div class="panel-body" >
                <form method="POST" action="{{ route('register') }}" class="form-horizontal" role="form">
                    @csrf

                    <div class="form-group @error('name') has-error has-feedback @enderror" style="margin-bottom: 20px">
                        <label for="name" class="col-md-3 control-label">{{ __('Name') }}</label>
                        <div class="col-md-9">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" @if(!$errors->has('name')) autofocus @endif>

                            @error('name')
                                <span class="glyphicon glyphicon-remove form-control-feedback " aria-hidden="true"></span>
                            @enderror

                            @error('name')
                                <span class="invalid-feedback help-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group @error('email') has-error has-feedback @enderror" style="margin-bottom: 20px">
                        <label for="email" class="col-md-3 control-label">{{ __('Email Address') }}</label>
                        <div class="col-md-9">
                            <input id="email" type="email" class="form-control " name="email" value="{{ old('email') }}" required autocomplete="email">
                            <span style="color: #6c757d">Please use a valid email address</span>

                            @error('email')
                                <span class="glyphicon glyphicon-remove form-control-feedback " aria-hidden="true"></span>
                            @enderror

                            @error('email')
                                <span class="invalid-feedback help-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group @error('password') has-error has-feedback @enderror" style="margin-bottom: 20px">
                        <label for="password" class="col-md-3 control-label">{{ __('Password') }}</label>
                        <div class="col-md-9">
                            <input id="password" type="password" class="form-control " name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="glyphicon glyphicon-remove form-control-feedback " aria-hidden="true"></span>
                            @enderror

                            @error('password')
                                <span class="invalid-feedback help-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 30px">
                        <label for="password-confirm" class="col-md-3 control-label">{{ __('Confirm Password') }}</label>
                        <div class="col-md-9">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-9">
                            <button type="submit" class="btn btn-primary -btn -btn-effect-deposit">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-11">
                            <div class="col-md-offset-1" style="border-top: 1px solid#888; padding-top:15px; font-size:90%" >
                                <span>
                                    Have an account?<span class="glyphicon glyphicon-log-in" style="margin-left: 6px; margin-right: 4px; font-size: 12px"></span>
                                    <a href="{{route('login')}}">Sign In Here</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
