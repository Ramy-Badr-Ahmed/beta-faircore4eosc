@extends('layouts.single-column-page')

<x-beta.navigation-bar :isLoginActive="true"
                       :mtime="(new DateTime('Europe/Berlin'))->setTimeStamp(File::lastModified(base_path('resources/views/auth/passwords/email.blade.php')))->format('d/M/y @H:i')" />

@section('headline', 'LZI — WP6.2 — Beta')

@section('main')

    <div class="centered-content">
        <div style="text-align: center">
            <p style="margin-bottom: 20px">
                You can reset your password below via your registered email address.
            </p>
        </div>
    </div>

    <div class="container">
        <div style="margin-top:50px; margin-bottom: 50px" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-yellow bodyShadow-forms fadeIn" >
                <div class="panel-heading headerCard">
                    <div class="panel-title" style="letter-spacing: 2px; font-weight: bold">{{ __('Reset Password') }}</div>
                </div>
                <div style="padding-top:30px" class="panel-body" >

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div style="margin-bottom: 25px" class="input-group @error('email') has-error @enderror" >
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <label for="email"></label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                                   placeholder="Email Address" required autocomplete="email" @if(!$errors->has('email')) autofocus @endif >

                            @error('email')
                                <span class="glyphicon glyphicon-remove form-control-feedback " aria-hidden="true"></span>
                            @enderror
                        </div>

                        @error('email')
                            <span class="invalid-feedback help-block" role="alert" style="margin-bottom: 30px">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="row mb-0" style="margin-bottom: 20px">
                            <div class="col-md-6 col-md-push-4">
                                <button type="submit" class="btn btn-primary -btn -btn-effect">
                                    {{ __('Send Password Reset Link') }}
                                </button>
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
