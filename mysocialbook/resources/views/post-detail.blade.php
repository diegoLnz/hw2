@extends('layouts.app')

@push('token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modal.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/post-detail.css')  }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/doLogout.js') }}"></script>
    <script src="{{ asset('js/modal.js') }}"></script>
    <script src="{{ asset('js/post-detail.js') }}" defer></script>
@endpush

@section('title', "Post")

@section('content')

    <header>

        @include('components.navbar')

    </header>

    <input type="hidden" id="hidden-post-id" value="{{ $postInfo->id }}">
    <input type="hidden" id="current-user-id" value="{{ $currentUser->id }}">
    <input id="user-id" type="hidden" value="{{ $postInfo->user_id }}">

    @include('components.modal')
    
    <div class="main">
        <div id="post-container">
    
        </div>
    </div>

@endsection