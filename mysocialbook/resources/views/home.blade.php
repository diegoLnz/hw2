@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/index.js') }}"></script>
    <script src="{{ asset('js/postGeneration.js') }}" defer></script>
    <script src="{{ asset('js/callNasa.js') }}" defer></script>
@endpush

@section('title', 'Home')

@section('content')

    <header>

        @include('components.navbar')

    </header>

    <div class="content d-none" id="nasa-post-container">

    </div>

    @include('components.modal')

    @include('components.postcontainer')

@endsection