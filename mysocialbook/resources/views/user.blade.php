@extends('layouts.app')

@push('token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modal.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/user.css')  }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/doLogout.js') }}"></script>
    <script src="{{ asset('js/modal.js') }}"></script>
    <script src="{{ asset('js/follow.js') }}"></script>
    <script src="{{ asset('js/userPosts.js') }}" defer></script>
@endpush

@section('title', $userInfo->name." (@".$userInfo->username.")")

@section('content')

    <header>

        @include('components.navbar')

    </header>

    <input type="hidden" id="hidden-user" value="{{ Session::get('user') }}">
    <input type="hidden" id="hidden-user-to-follow" value="{{ $userInfo->username }}">

    @include('components.modal')

    <div class="main">
        <div id="user-info">
            <div id="user-desc">
                <input id="user-id" type="hidden" value="{{ $userInfo->id }}">
                <input id="current-user-id" type="hidden" value="{{ $currentUser->id }}">
                <span id="username">
                    {{ $userInfo->name }}
                </span>
                <span id="user-name">
                    {{ $userInfo->username }}
                </span>
                <a href="#" id="num-followers">
                    Followers: {{ $userInfo->followersNum }}
                </a>
            </div>
            <img id="profile-image" src="{{ isset($userExt->image) ? asset('storage/'.$userExt->image->file_path) : '' }}" class="{{ isset($userExt->image) ? '' : 'covered'}}"alt="Immagine profilo">
        </div>

        <div class="follow-div">
            @if ($userInfo->alreadyFollowed) 
                <button id="follow-btn" class="custom-btn already-follows" type="button">Segui già</button>
            @else
                <button id="follow-btn" class="custom-btn" type="button">Segui</button>
            @endif
        </div>

        <div class="threads-list-div">
            <span id="threads-label">Threads</span>
            <div id="post-container">

            </div>
        </div>
    </div>

@endsection