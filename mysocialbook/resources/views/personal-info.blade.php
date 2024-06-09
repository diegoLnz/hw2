@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modal.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/user.css')  }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/doLogout.js') }}"></script>
    <script src="{{ asset('js/modal.js') }}"></script>
    <script src="{{ asset('js/userPosts.js') }}" defer></script>
@endpush

@section('title', $userInfo->name." (@".$userInfo->username.")")

@section('content')

    <header>

        @include('components.navbar')

    </header>

    @include('components.modal')

    <div class="main">
        <div id="user-info">
            <div id="user-desc">
                <input id="user-id" type="hidden" value="{{ $userInfo->id }}">
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
            <img id="profile-image" src="images/generic_user.png" alt="Immagine profilo">
        </div>

        <div class="threads-list-div">
            <span id="threads-label">Threads</span>
            <div id="post-container">

            </div>
        </div>
    </div>

@endsection