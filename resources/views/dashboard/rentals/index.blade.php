@extends('dashboard.layouts.app')

@section('title', 'Gestion des Locations')

@push('styles')
<style>
    .status-badge {
        font-size: 0.8rem;
        font-weight: 500;
        padding: 0.35rem 0.65rem;
        border-radius: 50rem;
    }
    
    .btn-action {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        margin: 0 2px;
        border-radius: 50% !important;
    }
    
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
    
    .table td {
        vertical-align: middle;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Gestion des Locations</h1>
        <a href="{{ route('dashboard.rentals.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvelle Location
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Client</th>
                            <th>Véhicule</th>
                            <th>Période</th>
                            <th class="text-end">Prix Total</th>
                            <th>Statut</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rentals as $rental)
                            <tr>
                                <td class="fw-semibold">#{{ $rental->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-2">
                                            <div class="avatar-sm">
                                                <div class="avatar-title bg-light text-primary rounded-circle">
                                                    {{ substr($rental->user->name, 0, 1) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $rental->user->name }}</h6>
                                            <small class="text-muted">{{ $rental->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-2">
                                            <div class="avatar-sm">
                                                <div class="avatar-title bg-light text-dark rounded">
                                                    <i class="fas fa-car"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $rental->car->brand }} {{ $rental->car->model }}</h6>
                                            <small class="text-muted">{{ $rental->car->registration_number }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium">
                                            <i class="far fa-calendar-alt me-1"></i>
                                            {{ \Carbon\Carbon::parse($rental->start_date)->format('d/m/Y') }} - 
                                            {{ \Carbon\Carbon::parse($rental->end_date)->format('d/m/Y') }}
                                        </span>
                                        <small class="text-muted">
                                            {{ $rental->days_count }} jour{{ $rental->days_count > 1 ? 's' : '' }}
                                        </small>
                                    </div>
                                </td>
                                <td class="text-end fw-semibold">
                                    {{ number_format($rental->total_price, 2, ',', ' ') }} €
                                </td>
                                <td>
                                    @switch($rental->status)
                                        @case('pending')
                                            <span class="status-badge bg-warning bg-opacity-10 text-warning">
                                                <i class="fas fa-clock me-1"></i> En attente
                                            </span>
                                            @break
                                        @case('approved')
                                            <span class="status-badge bg-primary bg-opacity-10 text-primary">
                                                <i class="fas fa-check-circle me-1"></i> Confirmée
                                            </span>
                                            @break
                                        @case('completed')
                                            <span class="status-badge bg-success bg-opacity-10 text-success">
                                                <i class="fas fa-check-double me-1"></i> Terminée
                                            </span>
                                            @break
                                        @case('cancelled')
                                            <span class="status-badge bg-danger bg-opacity-10 text-danger">
                                                <i class="fas fa-times-circle me-1"></i> Annulée
                                            </span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('dashboard.rentals.show', $rental->id) }}" 
                                           class="btn btn-sm btn-action btn-outline-info" 
                                           data-bs-toggle="tooltip" 
                                           title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($rental->status === 'pending')
                                            <form action="{{ route('dashboard.rentals.status', ['rental' => $rental->id, 'status' => 'approved']) }}" 
                                                  method="POST" 
                                                  class="ms-1 d-inline"
                                                  data-bs-toggle="tooltip"
                                                  title="Approuver la location">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-action btn-outline-success">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('dashboard.rentals.destroy', $rental->id) }}" 
                                                  method="POST" 
                                                  class="ms-1 d-inline" 
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette location ?')"
                                                  data-bs-toggle="tooltip"
                                                  title="Supprimer">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-action btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="avatar-lg mb-3">
                                            <div class="avatar-title bg-light text-secondary rounded-circle">
                                                <i class="fas fa-calendar-times fa-2x"></i>
                                            </div>
                                        </div>
                                        <h5 class="text-muted mb-1">Aucune location trouvée</h5>
                                        <p class="text-muted mb-0">Commencez par créer une nouvelle location</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($rentals->hasPages())
                <div class="card-footer border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Affichage de <b>{{ $rentals->firstItem() }}</b> à <b>{{ $rentals->lastItem() }}</b> 
                            sur <b>{{ $rentals->total() }}</b> locations
                        </div>
                        <div>
                            {{ $rentals->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Enable tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
@endsection
