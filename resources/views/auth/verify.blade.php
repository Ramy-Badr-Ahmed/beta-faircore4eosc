@extends('layouts.single-column-page')

<x-beta.navigation-bar :isLoginActive="true"
                       :mtime="(new DateTime('Europe/Berlin'))->setTimeStamp(File::lastModified(base_path('resources/views/auth/verify.blade.php')))->format('d/M/y @H:i')" />

@section('headline', 'FC4EOSC — WP6.2 — Beta')

@section('main')

    <div class="centered-content" style="margin-top: 20px">
        <div style="text-align: center; letter-spacing: 1px;">
            <p style="margin-bottom: 20px">
                Account Verification Pending
            </p>
        </div>
    </div>

    <div class="container">
        <div style="margin-top:50px;" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-yellow bodyShadow-forms fadeIn" >
                <div class="panel-heading headerCard">
                    <div class="panel-title" style="letter-spacing: 2px; font-weight: bold">{{ __('Verify Your Email Address') }}</div>
                </div>
                <div style="padding-top:30px" class="panel-body" >

                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    <div style="margin-bottom: 35px;letter-spacing: 1px;">
                        {{ __("We've emailed you with a verification link") }},
                        {{ __('If you did not receive the email') }}
                    </div>

                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <div class="row mb-0" style="margin-bottom: 20px">
                            <div class="col-md-6 col-md-push-3">
                                <button type="submit" class="btn btn-primary -btn -btn-effect">{{ __('click here to request another') }}</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div style="border-top: 1px solid#888; padding-top:15px; font-size:90%" >
                                    <span>
                                        Already Verified?<span class="glyphicon glyphicon-home" style="margin-left: 6px; margin-right: 4px; font-size: 12px"></span>
                                        <a href="{{route('home')}}">Home</a>
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
