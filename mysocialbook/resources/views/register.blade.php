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
        
        <form id="register-form" action="register" method="POST" enctype="multipart/form-data"> 
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

                        <!-- Image upload -->
                        <p id="label-for-profile">Foto profilo:</p>
                        <div class="image-upload-div">
                            <button type="button" id="upload-button" class="upload-btn d-block">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                    <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z"/>
                                </svg>
                            </button>

                            <input type="file" id="file-input" name="file" accept="image/jpeg, image/png" class="d-none">
                            <img id="image-preview" class="d-none" alt="Anteprima immagine">
                            
                            <button type="button" id="remove-image-button" class="d-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    @error('error')
                        <p class='error-message'>{{ $message }}</p>
                    @enderror 

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