@extends('dashboard.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body text-center">
                    <!-- Avatar Display -->
                    <div class="d-flex justify-content-center mb-4">
                        @if(Auth::user()->avatar)
                            <div class="user-avatar" style="width: 120px; height: 120px; border-radius: 50%; background-size: cover; background-position: center; background-image: url('{{ asset('storage/' . Auth::user()->avatar) }}'); border: 4px solid #f8f9fa; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);"></div>
                        @else
                            <div class="user-avatar d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; border-radius: 50%; background-color: #3490dc; color: white; font-size: 48px; font-weight: bold; border: 4px solid #f8f9fa; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <span class="badge bg-dark fs-5 mb-3 p-3 rounded-pill text-black bg-opacity-10">
                        <i class="fas fa-user me-2 text-black"></i> Profil
                    </span>
                    
                    @if(strtolower(Auth::user()->role ?? '') === 'admin')
                        <span class="badge bg-dark fs-6 mb-3 ms-2 p-2 rounded-pill">
                            <i class="fas fa-shield-alt me-1"></i> ADMIN
                        </span>
                    @endif
                    
                    <h4 class="fw-bold mb-4 text-black">Informations du compte</h4>
                    
                    <div class="card mb-4">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-user me-2 text-primary"></i> <b>Nom :</b></span>
                                <span>{{ Auth::user()->name }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-envelope me-2 text-primary"></i> <b>Email :</b></span>
                                <span>{{ Auth::user()->email }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-user-tag me-2 text-primary"></i> <b>Rôle :</b></span>
                                <span class="badge bg-primary">{{ Auth::user()->role ?? 'Utilisateur' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-calendar-alt me-2 text-primary"></i> <b>Date d'inscription :</b></span>
                                <span>{{ Auth::user()->created_at ? Auth::user()->created_at->format('d/m/Y') : '-' }}</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('dashboard.index') }}" class="btn btn-outline-dark">
                            <i class="fas fa-arrow-left me-2"></i> Retour au tableau de bord
                        </a>
                        <a href="{{ route('preferences.show') }}" class="btn btn-primary">
                            <i class="fas fa-cog me-2"></i> Modifier le profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
