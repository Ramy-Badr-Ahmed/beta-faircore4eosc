@extends('layouts.single-column-page')

<x-beta.navigation-bar :mtime="(new DateTime('Europe/Berlin'))->setTimeStamp(File::lastModified(base_path('resources/views/pages/general/privacy.blade.php')))->format('d/M/y @H:i')" />

@section('headline', 'Data Privacy Policy')

@section('subtitle')

    <h4>Privacy</h4>
    <br>

@endsection

@section('main')

@endsection
