@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modal.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/nasaVideoDetail.css')  }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/doLogout.js') }}"></script>
    <script src="{{ asset('js/modal.js') }}"></script>
    <script src="{{ asset('js/nasaVideoDetail.js') }}"></script>
@endpush

@section('title', 'Nasa video')

@section('content')

    <header>
        @include('components.navbar')
    </header>

    @include('components.modal')

    <div class="video-container">
        <video controls muted>
            <source src="{{ $url }}" type="video/mp4">
        </video>
        <div id="btn-container">
            <button type="button" id="save-btn">
                @if (!$isLiked)
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-bookmark" viewBox="0 0 16 16">
                    <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                </svg>
                @else
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-bookmark-fill" viewBox="0 0 16 16">
                    <path d="M2 2v13.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2"/>
                </svg>
                @endif
            </button>
        </div>
    </div>

@endsection