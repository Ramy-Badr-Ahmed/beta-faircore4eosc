@extends('layouts.single-column-page')

<x-beta.navigation-bar :isHomeActive="true"
    :mtime="(new DateTime('Europe/Berlin'))->setTimeStamp(File::lastModified(base_path('resources/views/landing.blade.php')))->format('d/M/y @H:i')" />

@section('headline', 'FC4EOSC — RSAC — Beta')

@section('main')
    <div class="centered-content" style="margin-top: 10px">
        <div style="text-align: center">
            <p style="margin-bottom: 20px">
                Welcome to the beta version for the four <b><a href="https://faircore4eosc.eu" target='_blank' rel='noopener noreferrer'>FairCore4EOSC Project</a></b> Pillars <b>(Archive, Reference, Describe & Cite)</b>.
            </p>
            <p style="margin-bottom: 20px">
                You are welcome to test the current version.
            </p>
            @if(Auth::guest())
                <a href="{{route('login')}}" target='_self' rel='noopener noreferrer'>
                    <button class="lib-button lib-khaki lib-hover-shadow">Get Started</button>
                </a>
            @endif

            @if(Auth::check())
                @if(!Auth::user()->email_verified_at)
                    <p style="margin-bottom: 20px; margin-top: 40px; font-weight: bold">
                        Your account is pending verification. <a href="{{route('verification.notice')}}" target='_self' rel='noopener noreferrer'>Verification Link</a>
                    </p>
                @endif
                <div class="container" style="margin-top: 50px">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a style="margin-right:40px;color: white" id ="AR-btn" class="btn btn-info -btn -btn-effect" href="{{route('tree-view')}}" target='_self' rel='noopener noreferrer'>Archive — Reference</a>
                            <a style="color: white" id ="DC-btn" class="btn btn-info -btn -btn-effect" href="{{route('lw-meta-form')}}" target='_self' rel='noopener noreferrer'>Describe — Cite</a>
                        </div>
                    </div>
                </div>
            @endif
            @if(Auth::check() && Auth::user()->email_verified_at)
                <p style="margin-bottom: 20px; margin-top: 50px">
                    We're looking forward for your feedback!
                </p>
                <a href="{{route('feedback')}}" target='_self' rel='noopener noreferrer'>
                    <button class="lib-button lib-khaki lib-hover-shadow">Submit Feedback</button>
                </a>
            @endif
        </div>
    </div>

    <div class="container" style="margin-top: 80px">
        <div class="row text-center">
            <div class="col-md-12">
                <p style="font-weight: bold">Powered by</p>
            </div>
        </div>
        <div class="row" style="margin-top: 20px">
            <div class="col-md-12 text-center">
                <a href="https://laravel.com/" target="_blank" rel="noopener noreferrer" style="margin-right: 45px;">
                    <img src="{{url('/images/ll.svg')}}" width="60px" height="60px" alt="laravel-logo" title="Laravel">
                </a>
                <a href="https://laravel-livewire.com/" target="_blank" rel="noopener noreferrer" style="margin-right: 45px;">
                    <img src="{{url('/images/lw.svg')}}" width="65px" height="65px" alt="lw-logo" title="Livewire">
                </a>
                <a href="https://roadrunner.dev/" target="_blank" rel="noopener noreferrer" style="margin-right: 45px;">
                    <img src="{{url('/images/rr.svg')}}" width="70px" height="70px" alt="rr-logo"  title="RoadRunner">
                </a>
                <a href="https://letsencrypt.org/" target="_blank" rel="noopener noreferrer" style="margin-right: 45px;">
                    <img src="{{url('/images/le.svg')}}" width="65px" height="65px" alt="le-logo" title="LetsEncrypt">
                </a>
                <a href="https://nodejs.org/" target="_blank" rel="noopener noreferrer" style="margin-right: 45px;">
                    <img src="{{url('/images/njl.svg')}}" width="80px" height="65px" alt="nodejs-logo" title="Node.js">
                </a>
                <a href="https://mariadb.com/" target="_blank" rel="noopener noreferrer" style="margin-right: 45px;">
                    <img src="{{url('/images/mdb.svg')}}" width="65px" height="60px" alt="mariadb-logo" title="MariaDB">
                </a>
                <a href="https://galeracluster.com/" target="_blank" rel="noopener noreferrer" style="margin-right: 45px;">
                    <img src="{{url('/images/GL.svg')}}" width="60px" height="55px" alt="mariadb-logo" title="GaleraCluster">
                </a>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 80px">
        <div class="row text-center">
            <div class="col-md-12">
                <p style="font-weight: bold">Hosted by</p>
            </div>
        </div>
        <div class="row" style="margin-top: 20px">
            <div class="col-md-12 text-center">
                <a href="https://www.bw-cloud.org/" target="_blank" rel="noopener noreferrer" style="margin:auto;">
                    <img src="{{url('/images/bwcl.svg')}}" width="80px" height="70px" alt="bwcl-logo" title="bwcloud">
                </a>
            </div>
        </div>
    </div>
@endsection

