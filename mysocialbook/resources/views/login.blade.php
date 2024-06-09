@extends('layout.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('title', 'Login')

@section('content')

    <section class="login-section">
        
        <form id="login-form" action="login" method="POST"> 
            
            <div class="login-form-div">
                <div class="access-label">Accedi con il tuo account MySocialBook</div>

                <div class="inputs">
                    <input type="text" class="login-input" id="username" name="username" placeholder="Nome utente o e-mail">
                    <input type="password" class="login-input" id="password" name="password" placeholder="Password">
                    <input type="submit" class="login-submit-btn" value="Accedi">
                </div>

                {{ $error = Request::get('error') }}
                @if($error != null)

                    @if(strtolower($error) == "invalid_credentials")

                        <p class='login-error'>Username o password errati!</p>

                    @elseif(strtolower($error) == "generic_error")

                        <p class='login-error'>Errore nel server</p>

                    @endif

                @endif
                
                <a class="forgot-pass" href="#">Password dimenticata?</a>
                
                <div class="separer"><span>o</span></div>

                <div class="register-redirect-box" onclick="window.location.href = 'Register.php'">
                    <span>Registrati a MySocialBook</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="arrow-register" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                </div>
            </div>

        </form>

    </section>

@endsection