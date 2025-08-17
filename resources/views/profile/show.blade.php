@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Mon Profil</h4>
                    <div>
                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }} text-white">
                            {{ ucfirst($user->role) }}
                        </span>
                        <span class="badge bg-secondary">
                            Membre depuis {{ $user->created_at ? $user->created_at->diffForHumans() : 'récemment' }}
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 24px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ $user->name }}</h5>
                                <p class="text-muted mb-0">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}" class="mt-4">
                        @csrf
                        @method('PUT')

                        <h5 class="mb-3">Modifier les informations</h5>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                            
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">Adresse email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                            
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('car.acceuil') }}" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-arrow-left me-1"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
