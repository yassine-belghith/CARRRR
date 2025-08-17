@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="h4 mb-0">Désabonnement des emails</h1>
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-{{ session('status') }}" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    @if(isset($success) && $success)
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ $message ?? 'Votre désabonnement a été enregistré avec succès.' }}
                        </div>
                        
                        <p class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Vous ne recevrez plus d'emails de notre part à l'adresse <strong>{{ $email }}</strong>.
                        </p>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ $message ?? 'Une erreur est survenue lors de votre désabonnement.' }}
                        </div>
                        
                        <p class="mb-0">
                            Si vous souhaitez vous désabonner, veuillez nous contacter à 
                            <a href="mailto:{{ config('mail.admin_email', 'contact@example.com') }}">
                                {{ config('mail.admin_email', 'contact@example.com') }}
                            </a>
                        </p>
                    @endif

                    <hr>
                    
                    <div class="text-center mt-4">
                        <a href="{{ url('/') }}" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i> Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
