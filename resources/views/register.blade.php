@include('_header')
<style>
    
    
    .logo-container {
        position: relative;
        width: 250px;
        height: 250px;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .logo-border {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: conic-gradient(from 0deg, #28a745, #20c997, #17a2b8, #007bff, #6f42c1, #28a745);
        background-size: 200% 200%;
        animation: rotate 3s linear infinite, borderPulse 4s ease-in-out infinite;
    }
    .logo-img {
        position: relative;
        z-index: 2;
        width: 90%;
        height: 90%;
        object-fit: contain;
        border-radius: 50%;
        background: white;
        padding: 10px;
    }
   
    
    @keyframes rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    @keyframes borderPulse {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
</style>

<section class="register-page">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-4 text-center">
                <div class="logo-container">
                    <div class="logo-border"></div>
                    <img src="{{ asset('assets/rent.png') }}" alt="Logo" class="logo-img">
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-center">
        <form class="w-100 my-5 px-5 py-3 form" method="POST" action="{{ route('user.register') }}">
          @csrf
            <div class="mb-3">
                <label for="exampleInputName" class="form-label">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="exampleInputName" name="name">
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Adresse E-mail</label>
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
              <input type="password" class="form-control" id="exampleInputPassword1" name="password">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword2" class="form-label">Confirmer Mot de passe</label>
                <input type="password" class="form-control" id="exampleInputPassword2" name="password_confirmation">
            </div>
            @if($error)
                <div class="mb-3 alert alert-danger">
                    @if($nameError)
                        <span class="mb-2 d-inline-block">{{ $nameError }}</span>
                    @endif
                    @if($emailError)
                        <span class="mb-2 d-inline-block">{{ $emailError }}</span>
                    @endif
                    @if($passwordError)
                        <span class="mb-2 d-inline-block">{{ $passwordError }}</span>
                    @endif
                </div>
            @endif
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="terms" required>
                <label class="form-check-label" for="exampleCheck1">J'accepte les termes et conditions</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">S'inscrire</button>

            <div style="display: flex; align-items: center; text-align: center; margin: 1.5rem 0; color: #6c757d;">
                <hr style="flex-grow: 1; background-color: #6c757d;">
                <span style="padding: 0 1rem;">ou</span>
                <hr style="flex-grow: 1; background-color: #6c757d;">
            </div>

            <a href="{{ route('auth.google') }}" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center" style="gap: 0.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                    <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.25C3.216 7.62 4.966 9.333 8 9.333c1.337 0 2.52-.576 3.337-1.543H8V6.558h7.545z"/>
                </svg>
                S'inscrire avec Google
            </a>

            <p class="mt-3 text-center">Vous avez déjà un compte ? <a href="{{ route('login') }}">Connectez-vous</a></p>
                </form>
                </div>
            </div>
        </div>
    </div>
<script>
  // Enforce black background once DOM is ready (final safeguard)
  document.addEventListener('DOMContentLoaded', function() {
    document.documentElement.style.setProperty('background-color', '#000', 'important');
    document.documentElement.style.setProperty('background-image', 'none', 'important');
    document.body.style.setProperty('background-color', '#000', 'important');
    document.body.style.setProperty('background-image', 'none', 'important');
    const app = document.getElementById('app');
    if (app) { app.style.setProperty('background-color', '#000', 'important'); app.style.setProperty('background-image', 'none', 'important'); }
  });
  </script>
</section>
@include('_footer')