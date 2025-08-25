@extends('layouts.app')

@section('title', 'Détails de la Location #' . $rental->id)

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Location #{{ $rental->id }}</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h5 class="text-muted">Client</h5>
                    <p class="mb-1"><strong>Nom:</strong> {{ $rental->user->name }}</p>
                    <p class="mb-0"><strong>Email:</strong> {{ $rental->user->email }}</p>
                </div>
                <div class="col-md-6">
                    <h5 class="text-muted">Véhicule</h5>
                    <p class="mb-1"><strong>Modèle:</strong> {{ $rental->car->brand }} {{ $rental->car->model }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Début:</strong> {{ $rental->rental_date->format('d/m/Y') }}</p>
                    <p class="mb-0"><strong>Fin:</strong> {{ $rental->return_date->format('d/m/Y') }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Statut:</strong> <span class="badge bg-{{ $rental->status == 'approved' ? 'success' : 'warning' }}">{{ ucfirst($rental->status) }}</span></p>
                    <p class="mb-0"><strong>Prix total:</strong> {{ number_format($rental->total_price ?? 0, 2, ',', ' ') }} €</p>
                </div>
            </div>

            @if($rental->location)
            <div class="row mb-3">
                <div class="col-md-12">
                    <h5 class="text-muted">Agence</h5>
                    <p class="mb-1"><strong>Nom:</strong> {{ $rental->location->name }}</p>
                    <p class="mb-0"><strong>Adresse:</strong> {{ $rental->location->address }}, {{ $rental->location->city }} {{ $rental->location->postal_code }}, {{ $rental->location->country }}</p>
                </div>
            </div>
            @endif

            @if($rental->notes)
                <div class="mb-3">
                    <h5 class="text-muted">Notes</h5>
                    <p>{{ $rental->notes }}</p>
                </div>
            @endif

            <a href="{{ route('driver.dashboard') }}" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</div>
@endsection


