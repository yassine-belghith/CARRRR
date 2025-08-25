    @extends('layouts.app')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
<style>
    body, .register-page {
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

    .register-page {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem;
        background: #000 !important;
    }

    main.py-4 {
        padding: 0 !important;
        width: 100%;
    }

    .register-container {
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    .register-card {
        background: rgba(30, 30, 30, 0.8);
        border-radius: 1.5rem;
        padding: 2.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        border: 1px solid #333;
        width: 100%;
        position: relative;
        z-index: 2;
    }

    .register-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .register-title {
        color: #fff;
        font-size: 2.25rem;
        font-weight: 800;
        margin-bottom: 0.75rem;
        background: linear-gradient(90deg, #3d5afe, #00bcd4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .register-subtitle {
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

    .btn-register {
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

    .btn-register:hover {
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

    .login-link {
        text-align: center;
        margin-top: 2rem;
        color: #aaa;
        font-size: 0.95rem;
    }

    .login-link a {
        color: #3d5afe;
        font-weight: 600;
        text-decoration: none;
        margin-left: 0.5rem;
        transition: color 0.3s ease;
    }
    

    .login-link a:hover {
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
<div class="register-page">
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <h1 class="register-title">CAR RENT</h1>
                <p class="register-subtitle">Créez votre compte pour commencer</p>
            </div>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="name">Nom complet</label>
                    <div class="input-group">
                        <i class="input-icon fas fa-user"></i>
                        <input type="text" id="name" name="name" class="form-control" 
                               placeholder="Entrez votre nom complet" value="{{ old('name') }}" required autofocus>
                    </div>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="email">Adresse Email</label>
                    <div class="input-group">
                        <i class="input-icon fas fa-envelope"></i>
                        <input type="email" id="email" name="email" class="form-control" 
                               placeholder="Entrez votre email" value="{{ old('email') }}" required>
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="password">Mot de passe</label>
                    <div class="input-group">
                        <i class="input-icon fas fa-lock"></i>
                        <input type="password" id="password" name="password" class="form-control" 
                               placeholder="Créez un mot de passe" required>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="password-confirm">Confirmer le mot de passe</label>
                    <div class="input-group">
                        <i class="input-icon fas fa-lock"></i>
                        <input type="password" id="password-confirm" name="password_confirmation" class="form-control" 
                               placeholder="Confirmez votre mot de passe" required>
                    </div>
                </div>
                
                <button type="submit" class="btn-register">
                    S'inscrire
                </button>
            </form>
            
            <p class="login-link">
                Vous avez déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
            </p>
        </div>
    </div>
</div>
@endsection
