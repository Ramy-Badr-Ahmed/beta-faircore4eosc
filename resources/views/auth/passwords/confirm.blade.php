@extends('layouts.single-column-page')

<x-beta.navigation-bar :isLoginActive="true"
                       :mtime="(new DateTime('Europe/Berlin'))->setTimeStamp(File::lastModified(base_path('resources/views/auth/passwords/confirm.blade.php')))->format('d/M/y @H:i')" />

@section('headline', 'FC4EOSC — RSAC — Beta')

@section('main')
<div class="centered-content">
    <div style="text-align: center">
        <p style="margin-bottom: 20px">
            Please confirm your password before proceeding!
        </p>
    </div>
</div>

<div class="container">
    <div style="margin-top:50px;" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-yellow bodyShadow-forms fadeIn" >
            <div class="panel-heading headerCard">
                <div class="panel-title" style="letter-spacing: 2px; font-weight: bold">{{ __('Confirm Password') }}</div>
            </div>
            <div style="padding-top:30px" class="panel-body" >

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <label for="email"></label>
                        <input type="email" class="form-control" id="email" name="email" value="{{Auth::user()->email}}" readonly>
                    </div>

                    <div style="margin-bottom: 25px" class="input-group @error('password') has-error @enderror">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <label for="password"></label>
                        <input id="password" type="password" class="form-control " name="password"
                               placeholder="Password" required autocomplete="current-password">
                        @error('password')
                            <span class="glyphicon glyphicon-remove form-control-feedback " aria-hidden="true"></span>
                        @enderror
                    </div>

                    @error('password')
                        <span class="invalid-feedback help-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <div class="row mb-0">
                        <div class="col-md-8 col-md-push-4">
                            <button type="submit" class="btn btn-primary -btn -btn-effect-deposit" style="margin-right: 5px">
                                {{ __('Confirm') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
