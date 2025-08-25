@extends('dashboard.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Détails de la Location #{{ $rental->id }}</h4>
                    <div class="float-right">
                        <a href="{{ route('dashboard.rentals.edit', $rental->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <a href="{{ route('dashboard.rentals.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Informations Client</h5>
                            <hr>
                            <p><strong>Nom:</strong> {{ $rental->user->name }}</p>
                            <p><strong>Email:</strong> {{ $rental->user->email }}</p>
                            <p><strong>Téléphone:</strong> {{ $rental->user->phone ?? 'Non renseigné' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Détails du Véhicule</h5>
                            <hr>
                            <p><strong>Marque/Modèle:</strong> {{ $rental->car->brand }} {{ $rental->car->model }}</p>
                            <p><strong>Immatriculation:</strong> {{ $rental->car->license_plate }}</p>
                            <p><strong>Prix journalier:</strong> {{ number_format($rental->car->price_per_day, 2, ',', ' ') }} €</p>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Détails de la Location</h5>
                            <hr>
                            <p><strong>Date de début:</strong> {{ optional($rental->start_date)->format('d/m/Y') }}</p>
                            <p><strong>Date de fin:</strong> {{ optional($rental->end_date)->format('d/m/Y') }}</p>
                            <p><strong>Lieu de départ:</strong> {{ $rental->location->name ?? 'Non spécifié' }}</p>
                            <p><strong>Nombre de jours:</strong> {{ $rental->start_date ? $rental->start_date->diffInDays($rental->end_date) + 1 : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Paiement</h5>
                            <hr>
                            <p><strong>Prix total:</strong> {{ number_format($rental->total_price, 2, ',', ' ') }} €</p>
                            <p>
                                <strong>Statut:</strong>
                                @switch($rental->status)
                                    @case('pending')
                                        <span class="badge bg-warning">En attente</span>
                                        @break
                                    @case('approved')
                                        <span class="badge bg-primary">Confirmée</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-success">Terminée</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger">Annulée</span>
                                        @break
                                @endswitch
                            </p>
                        </div>
                    </div>

                    @if($rental->notes)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Notes</h5>
                                <hr>
                                <p>{{ $rental->notes }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Actions</h5>
                            <hr>
                            <div class="btn-group" role="group">
                                @if($rental->status === 'pending')
                                    <form action="{{ route('dashboard.rentals.status', ['rental' => $rental->id, 'status' => 'approved']) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check"></i> Confirmer la location
                                        </button>
                                    </form>
                                @endif

                                @if($rental->status === 'approved')
                                    <form action="{{ route('dashboard.rentals.status', ['rental' => $rental->id, 'status' => 'completed']) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-info">
                                            <i class="fas fa-flag-checkered"></i> Marquer comme terminée
                                        </button>
                                    </form>
                                @endif

                                @if(in_array($rental->status, ['pending', 'approved']))
                                    <form action="{{ route('dashboard.rentals.status', ['rental' => $rental->id, 'status' => 'cancelled']) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-times"></i> Annuler la location
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('dashboard.rentals.destroy', $rental->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette location ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
