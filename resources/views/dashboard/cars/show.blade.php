@extends('dashboard.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Détails du Véhicule</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard.cars.index') }}">Véhicules</a></li>
                <li class="breadcrumb-item active" aria-current="page">Détails</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 fw-bold">{{ $car->brand }} {{ $car->model }} ({{ $car->year }})</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <h6 class="text-gray-700 fw-medium">Informations de base</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0">
                                <strong>Marque:</strong> {{ $car->brand }}
                            </li>
                            <li class="list-group-item px-0">
                                <strong>Modèle:</strong> {{ $car->model }}
                            </li>
                            <li class="list-group-item px-0">
                                <strong>Année:</strong> {{ $car->year }}
                            </li>
                            <li class="list-group-item px-0">
                                <strong>Plaque d'immatriculation:</strong> {{ $car->license_plate }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <h6 class="text-gray-700 fw-medium">Statut</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0">
                                <strong>Disponibilité:</strong>
                                <span class="badge bg-{{ $car->is_available ? 'success' : 'danger' }}">
                                    {{ $car->is_available ? 'Disponible' : 'Non disponible' }}
                                </span>
                            </li>
                            <li class="list-group-item px-0">
                                <strong>Nombre de locations:</strong> {{ $car->rentals->count() }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                <a href="{{ route('dashboard.cars.index') }}" class="btn btn-light border-2 border-gray-300 text-gray-700 fw-medium px-4 py-2 rounded-3">
                    <i class="fas fa-arrow-left me-2"></i> Retour
                </a>
                <div>
                    <a href="{{ route('dashboard.cars.edit', $car) }}" class="btn btn-primary bg-primary border-0 px-4 py-2 rounded-3 fw-medium">
                        <i class="fas fa-edit me-2"></i> Modifier
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
