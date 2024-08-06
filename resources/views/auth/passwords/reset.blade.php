@extends('layouts.single-column-page')

<x-beta.navigation-bar :isLoginActive="true"
                       :mtime="(new DateTime('Europe/Berlin'))->setTimeStamp(File::lastModified(base_path('resources/views/auth/passwords/reset.blade.php')))->format('d/M/y @H:i')" />

@section('headline', 'FC4EOSC — RSAC — Beta')

@section('main')
    <div class="centered-content">
        <div style="text-align: center">
            <p style="margin-bottom: 20px">
                You can reset your password now
            </p>
        </div>
    </div>

    <div style="margin-top:50px" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-yellow bodyShadow-forms fadeIn">
            <div class="panel-heading headerCard">
                <div class="panel-title" style="letter-spacing: 2px; font-weight: bold">{{ __('Reset Password') }}</div>
            </div>
            <div class="panel-body" >

                <form method="POST" action="{{ route('password.update') }}" class="form-horizontal" role="form">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group @error('email') has-error has-feedback @enderror" style="margin-bottom: 20px">
                        <label for="email" class="col-md-3 control-label">{{ __('Email Address') }}</label>
                        <div class="col-md-9">
                            <input id="email" type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}"
                                   required autocomplete="email">

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
                            <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">

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

                    <div class="form-group" style="margin-bottom: 40px">
                        <label for="password-confirm" class="col-md-3 control-label">{{ __('Confirm Password') }}</label>
                        <div class="col-md-9">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn btn-primary -btn -btn-effect">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
