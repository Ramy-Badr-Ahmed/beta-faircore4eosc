<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="google" content="notranslate">
    <meta http-equiv="Content-Language" content="en">

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'DSub') }}</title>

    <link rel="icon" href="{{ asset('images/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?{{ config('app.release') }}" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" >
</head>

<body>

    @if(!request()->header('isDBAlive'))
        <div class="alert alert-warning centered-content" style="margin: 150px auto; width: 35%; text-align: center; font-size: 16px; padding: 12px; letter-spacing: 1px; font-weight: bolder; border-radius: 12px">
            Temporarily Out of Service. Please Visit us later!
        </div>
        @php return @endphp
    @endif

    <div id="app" data-release="{{ config('app.release') }}">
        @yield('content')
    </div>

    @yield('modals')

    <script src="{{ asset('js/app.js') }}?{{ config('app.release') }}"></script>

    @yield('script')

    @stack('scripts')

</body>

</html>
