@extends('layouts.single-column-page')

<x-beta.navigation-bar :mtime="(new DateTime('Europe/Berlin'))->setTimeStamp(File::lastModified(base_path('resources/views/pages/general/imprint.blade.php')))->format('d/M/y @H:i')" />

@section('headline', 'Imprint')

@section('main')

    <p>
    </p>
    <p>
    </p>
    <p>
    </p>

@endsection
