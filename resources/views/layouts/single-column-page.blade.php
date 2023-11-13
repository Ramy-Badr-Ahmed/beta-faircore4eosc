@extends('layouts.app')

@section('content')

    <header>
        @yield('header-banner')
    </header>

    <div class="align-right">
        <a href="https://faircore4eosc.eu/" target="_blank" rel="noopener noreferrer" style="margin-top:10px; margin-right: 45px;">
            <img src="{{url('/images/fairLogo.svg')}}" width="300px" height="40px" alt="fair-logo" title="FAIRCORE4EOSC">
        </a>
    </div>

    <div class="centered-content" style="margin-left: 50px; margin-top: 35px">
        <x-session.beta.landing-messages />
    </div>

    <div class="main-title">
        <h1>@yield('headline')</h1>
        @if(! request()->routeIs(['lw-meta-form', 'feedback', 'uc', 'tree-view', 'on-the-fly-view', 'lw-mass-view', 'privacy', 'imprint']))
            <div class="text-center">
                <a href="https://faircore4eosc.eu/eosc-core-components/eosc-research-software-apis-and-connectors-rsac" target="_blank" rel="noopener noreferrer"
                   style="margin-top:10px; margin-bottom: 20px;">
                    <img src="{{url('/images/rsac.svg')}}" width="400px" height="50px" alt="rsac-logo" title="rsac">
                </a>
            </div>
        @endif
    </div>

    <div class="subtitle">
        @yield('subtitle')
    </div>

    <div class="@yield('container-class')">

        <main class="col-12 col-md-12 py-md-3 pl-md-5 bd-content" role="main">

            @yield('main')

            @if(request()->header('isDBAlive'))
                @include('includes.general.footer')
            @endif

        </main>

    </div>

@endsection
