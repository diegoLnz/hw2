@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modal.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/nasaLibrary.css')  }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/doLogout.js') }}"></script>
    <script src="{{ asset('js/modal.js') }}"></script>
    <script src="{{ asset('js/savedNasaVideos.js') }}"></script>
@endpush

@section('title', 'Nasa video library')

@section('content')

    <header>
        @include('components.navbar')
    </header>

    @include('components.modal')

    <div id="video-container">

    </div>

@endsection