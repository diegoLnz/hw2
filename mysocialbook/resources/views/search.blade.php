@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/doLogout.js') }}"></script>
    <script src="{{ asset('js/modal.js') }}"></script>
    <script src="{{ asset('js/search.js') }}"></script>
@endpush

@section('title', 'Search')

@section('content')

    <header>

        @include('components.navbar')

    </header>

    @include('components.modal')

    <div id="main">

        <input type="hidden" id="hidden-username" value="{{ Session::get('user') }}">

        <input type="text" name="search-input" id="search-input" placeholder="Cerca utenti">

        <div id="users-list-div">
        </div>

    </div>

@endsection