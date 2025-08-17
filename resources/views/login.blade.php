@extends('layouts.app')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
<style>
    body, .login-page {
        font-family: 'Inter', sans-serif;
        background-color: #121212;
        color: #e0e0e0;
    }

    * {
        transition: all 0.3s ease-in-out;
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .login-page {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem;
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    }

    main.py-4 {
        padding: 0 !important;
        width: 100%;
    }

    .login-container {
        width: 100%;
        max-width: 420px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    .login-card {
        background: rgba(30, 30, 30, 0.8);
        border-radius: 1.5rem;
        padding: 2.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        border: 1px solid #333;
        max-width: 420px;
        width: 100%;
        position: relative;
        z-index: 2;
    }

    .login-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .login-title {
        color: #fff;
        font-size: 2.25rem;
        font-weight: 800;
        margin-bottom: 0.75rem;
        background: linear-gradient(90deg, #3d5afe, #00bcd4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .login-subtitle {
        color: rgba(255, 255, 255, 0.7);
        font-size: 1rem;
        font-weight: 400;
    }

    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }

    .form-label {
        display: block;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .input-group {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.7);
        font-size: 1.1rem;
    }

    .form-control {
        width: 100%;
        padding: 0.9rem 1rem 0.9rem 3rem;
        background: #222;
        border: 1px solid #444;
        border-radius: 0.75rem;
        color: #fff;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .form-control:focus {
        outline: none;
        border-color: #3d5afe;
        box-shadow: 0 0 0 0.2rem rgba(61, 90, 254, 0.25);
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    .forgot-password {
        display: block;
        text-align: right;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.85rem;
        text-decoration: none;
        margin-top: 0.5rem;
        transition: color 0.3s ease;
    }

    .forgot-password:hover {
        color: #fff;
        text-decoration: underline;
    }

    .btn-login {
        width: 100%;
        padding: 1rem;
        background: #3d5afe;
        color: #fff;
        border: none;
        border-radius: 0.75rem;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1.5rem;
        box-shadow: 0 10px 20px rgba(61, 90, 254, 0.3);
    }

    .btn-login:hover {
        background: #2c49c9;
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(61, 90, 254, 0.4);
    }

    .divider {
        display: flex;
        align-items: center;
        margin: 2rem 0;
        color: #666;
        font-size: 0.85rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #444;
        margin: 0 1rem;
    }

    .social-login {
        text-align: center;
    }

    .social-buttons {
        display: flex;
        gap: 1rem;
        margin: 2rem 0;
    }

    .social-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.8rem;
        border: 1px solid #444;
        border-radius: 0.75rem;
        background: #222;
        color: #fff;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .social-btn:hover {
        background: #2a2a2a;
        transform: translateY(-2px);
        border-color: #555;
    }

    .signup-link {
        text-align: center;
        margin-top: 2rem;
        color: #aaa;
        font-size: 0.95rem;
    }

    .signup-link a {
        color: #3d5afe;
        font-weight: 600;
        text-decoration: none;
        margin-left: 0.5rem;
        transition: color 0.3s ease;
    }

    .signup-link a:hover {
       color: #00bcd4;
        text-decoration: none;
    }

    .error-message {
        color: #ff6b6b;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: block;
    }
    </style>
@endpush

@section('content')
<div class="login-page">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1 class="login-title">CAR RENT</h1>
                <p class="login-subtitle">Connectez-vous pour accéder à votre compte</p>
            </div>
            
            <form method="POST" action="{{ route('login.perform') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="email">Adresse Email</label>
                    <div class="input-group">
                        <i class="input-icon fas fa-envelope"></i>
                        <input type="email" id="email" name="email" class="form-control" 
                               placeholder="Entrez votre email" value="{{ old('email') }}" required autofocus>
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="password">Mot de passe</label>
                        <a href="#" class="forgot-password">Mot de passe oublié ?</a>
                    </div>
                    <div class="input-group">
                        <i class="input-icon fas fa-lock"></i>
                        <input type="password" id="password" name="password" class="form-control" 
                               placeholder="Entrez votre mot de passe" required>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" class="btn-login">
                    Se connecter
                </button>
            </form>
            
            <div class="divider">ou continuer avec</div>
            
            <div class="social-login">
                <div class="social-buttons">
                    <button type="button" class="social-btn" title="Se connecter avec Google">
                        <i class="fab fa-google"></i>
                    </button>
                    <button type="button" class="social-btn" title="Se connecter avec Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button type="button" class="social-btn" title="Se connecter avec Apple">
                        <i class="fab fa-apple"></i>
                    </button>
                </div>
            </div>
            
            <p class="signup-link">
                Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a>
            </p>
        </div>
    </div>
</div>
@endsection