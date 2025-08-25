@extends('dashboard.layouts.app')

@php
$statusClasses = [
    'pending' => 'bg-warning-soft text-warning',
    'confirmed' => 'bg-info-soft text-info',
    'assigned' => 'bg-primary-soft text-primary',
    'on_the_way' => 'bg-primary-soft text-primary',
    'completed' => 'bg-success-soft text-success',
    'cancelled' => 'bg-danger-soft text-danger',
    'no_show' => 'bg-secondary-soft text-secondary',
];
@endphp

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-12">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Gestion des Transferts</h1>
                <a href="{{ route('dashboard.transfers.create') }}" class="btn btn-primary d-flex align-items-center">
                    <i class="fas fa-plus-circle me-2"></i>
                    <span>Créer un Transfert</span>
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Liste des transferts</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Client</th>
                                    <th>Chauffeur</th>
                                    <th>Voiture</th>
                                    <th>Date de Prise en Charge</th>
                                    <th>Lieu de Prise en Charge</th>
                                    <th>Lieu de Dépose</th>
                                    <th class="text-center">Statut</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transfers as $transfer)
                                    <tr>
                                        <td>{{ $transfer->id }}</td>
                                        <td>{{ $transfer->user->name ?? 'N/A' }}</td>
                                        <td>{{ $transfer->driver->name ?? 'Non assigné' }}</td>
                                        <td>{{ $transfer->car->brand ?? 'N/A' }} {{ $transfer->car->model ?? '' }}</td>
                                        <td>{{ $transfer->pickup_datetime ? $transfer->pickup_datetime->format('d/m/Y H:i') : 'N/A' }}</td>
                                        <td>{{ $transfer->pickup_latitude }}, {{ $transfer->pickup_longitude }}</td>
                                        <td>{{ $transfer->dropoff_latitude }}, {{ $transfer->dropoff_longitude }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $statusClasses[$transfer->status] ?? 'bg-secondary-soft text-secondary' }}">
                                                {{ $transfer->status_label ?? $transfer->status }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('dashboard.transfers.edit', $transfer) }}" class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="tooltip" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('dashboard.transfers.destroy', $transfer) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce transfert ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Supprimer">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <p class="text-muted mb-0">Aucun transfert trouvé.</p>
                                            <a href="{{ route('dashboard.transfers.create') }}" class="btn btn-primary btn-sm mt-2">Créer un transfert</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($transfers->hasPages())
                        <div class="card-footer bg-white py-3">
                            {{ $transfers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
    .bg-secondary-soft { background-color: rgba(108, 117, 125, 0.1); }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    .btn-outline-warning {
        color: #ffc107;
        border-color: #ffc107;
    }
    .btn-outline-warning:hover {
        color: #000;
        background-color: #ffc107;
        border-color: #ffc107;
    }
    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
    }
    .btn-outline-danger:hover {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }
</style>
@endsection
