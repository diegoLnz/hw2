@extends('layouts.app')

@push('token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modal.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/likedPosts.css')  }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/doLogout.js') }}"></script>
    <script src="{{ asset('js/modal.js') }}"></script>
    <script src="{{ asset('js/likedPosts.js') }}" defer></script>
@endpush

@section('title', 'Mi Piace')

@section('content')

    <header>

        @include('components.navbar')

    </header>

    @include('components.modal')

    <div class="threads-list-div">
        <input id="user-id" type="hidden" value="{{ $userInfo->id }}">
        <span id="threads-label">Mi Piace</span>
        <div id="post-container">

        </div>
    </div>

@endsection