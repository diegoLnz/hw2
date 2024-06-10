@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/register.js') }}"></script>
@endpush

@section('title', 'Registrati')

@section('content')

    <section class="register-section">
        
        <form id="register-form" action="register" method="POST"> 
            @csrf
            <div class="register-box">

                <div class="register-box-header">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo image" onclick="window.location.href='home'">
                </div>

                <div class="register-box-content">
                    <span>Iscriviti per vedere le foto dei tuoi amici.</span>

                    <div class="register-box-content-inputs">

                        <input type="email" name="email" id="email" placeholder="Indirizzo e-mail">
                        <span id="email-feedback" class="input-feedback"></span>
                        <input type="text" name="name" id="name" placeholder="Nome e cognome">
                        <input type="text" name="username" id="username" placeholder="Nome utente">
                        <span id="username-feedback" class="input-feedback"></span>

                        <div class="password-container">
                            <input type="password" name="password" id="password" placeholder="Password">
                            <div id="pwd-div" class="password-toggle">Mostra</div>
                        </div>
                        <span id="password-feedback" class="input-feedback"></span>

                        <div class="password-container">
                            <input type="password" name="password-confirm" id="password-confirm" placeholder="Conferma password">
                            <div id="pwd-confirm-div" class="password-toggle">Mostra</div>
                        </div>
                        <span id="password-confirm-feedback" class="input-feedback"></span>

                    </div>

                    <div class="register-submit-box">
                        <input type="submit" class="register-submit-btn" value="Iscriviti">
                    </div>

                    <div class="login-redirect">
                        <span>Hai già un account?</span>
                        <a href="login">Accedi</a>
                    </div>
                </div>

            </div>

        </form>

    </section>

@endsection