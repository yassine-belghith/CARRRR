@extends('dashboard.layouts.app')

@section('title', 'Gestion des Véhicules')

@push('styles')
<style>
    :root {
        --sidebar-width: 260px;
        --header-height: 70px;
        --card-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }
    
    /* Base responsive settings */
    * {
        box-sizing: border-box;
    }
    
    html {
        -webkit-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
        text-size-adjust: 100%;
        height: 100%;
    }
    
    body {
        min-height: 100%;
        display: flex;
        flex-direction: column;
        -webkit-text-size-adjust: none;
        background-color: #f5f7fa;
    }
    
    /* Card styles */
    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        margin-bottom: 1.5rem;
        overflow: hidden;
        width: 100%;
        background-color: #fff;
    }
    
    .card-body {
        padding: 0;
        width: 100%;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    /* Table styles */
    .table {
        margin-bottom: 0;
        width: 100%;
    }
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        border-top: none;
        padding: 1rem 1.25rem;
        background-color: #f8f9fa;
        white-space: nowrap;
        color: #4b5563;
        border-bottom: 2px solid #e5e7eb;
    }
    
    .table > :not(caption) > * > * {
        padding: 1rem 1.25rem;
        vertical-align: middle;
    }
    
    .table td {
        border-color: #f0f2f5;
        color: #4b5563;
    }
    
    .table tr:not(:last-child) {
        border-bottom: 1px solid #f0f2f5;
    }
    
    /* Button styles */
    .btn {
        border-radius: 0.5rem;
        font-weight: 500;
        transition: var(--transition);
    }
    
    .btn-sm {
        padding: 0.35rem 0.75rem;
        font-size: 0.75rem;
        white-space: nowrap;
    }
    
    .btn-outline-danger {
        color: #ef4444;
        border-color: #ef4444;
    }
    
    .btn-outline-danger:hover {
        background-color: #ef4444;
        color: white;
    }
    
    .btn-outline-success {
        color: #10b981;
        border-color: #10b981;
    }
    
    .btn-outline-success:hover {
        background-color: #10b981;
        color: white;
    }
    
    /* Badge styles */
    .badge {
        font-weight: 500;
        padding: 0.4em 0.8em;
        font-size: 0.75em;
        border-radius: 0.375rem;
        text-transform: capitalize;
    }
    
    .bg-primary {
        background-color: #4f46e5 !important;
    }
    
    .bg-secondary {
        background-color: #6b7280 !important;
    }
    
    /* Page header styles */
    .page-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 0;
        line-height: 1.3;
    }
    
    .breadcrumb {
        margin-bottom: 0;
        padding: 0.5rem 0;
        background: none;
    }
    
    .breadcrumb-item {
        font-size: 0.875rem;
    }
    
    .breadcrumb-item a {
        color: #6b7280;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .breadcrumb-item a:hover {
        color: #4f46e5;
    }
    
    .breadcrumb-item.active {
        color: #4f46e5;
        font-weight: 500;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        color: #9ca3af;
    }
    
    /* Responsive adjustments */
    @media (max-width: 1199.98px) {
        .container-fluid {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
    }
    
    @media (max-width: 991.98px) {
        .page-title {
            font-size: 1.35rem;
        }
        
        .table-responsive {
            border-radius: 0.5rem;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            -ms-overflow-style: -ms-autohiding-scrollbar;
            margin: 0 -1rem;
            width: calc(100% + 2rem);
        }
        
        .table {
            min-width: 900px;
        }
    }
    
    @media (max-width: 767.98px) {
        .page-title {
            font-size: 1.25rem;
            margin-bottom: 0.5rem !important;
        }
        
        .breadcrumb {
            padding: 0.25rem 0;
        }
        
        .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.8125rem;
        }
    }
    
    @media (max-width: 575.98px) {
        .page-title {
            font-size: 1.1rem;
        }
        
        .breadcrumb-item {
            font-size: 0.8rem;
        }
        
        .btn {
            padding: 0.3rem 0.6rem;
            font-size: 0.75rem;
        }
        
        .badge {
            padding: 0.3em 0.6em;
            font-size: 0.7em;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0 px-sm-3 py-3" style="min-width: 320px;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <div>
            <h1 class="page-title mb-2 mb-md-0">Gestion des véhicules</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Tableau de bord</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Véhicules</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('dashboard.cars.page.create') }}" class="btn btn-primary mt-3 mt-md-0">
            <i class="fas fa-plus me-2"></i>Ajouter un véhicule
        </a>
    </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Total</h6>
                                <h3 class="mb-0">{{ $cars->count() }}</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="fas fa-car text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Disponibles</h6>
                                <h3 class="mb-0">{{ $cars->where('availability', 1)->count() }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">En location</h6>
                                <h3 class="mb-0">{{ $cars->where('availability', 0)->count() }}</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="fas fa-road text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Marques</h6>
                                <h3 class="mb-0">{{ $cars->unique('brand')->count() }}</h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="fas fa-tags text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cars Table -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Véhicule</th>
                                <th>Modèle</th>
                                <th class="text-center">Année</th>
                                <th class="text-center">Plaque</th>
                                <th class="text-center">Statut</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cars as $car)
                                <tr>
                                    <td class="text-muted">#{{ $car->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-car text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0">{{ $car->brand }}</h6>
                                                <small class="text-muted">{{ $car->color ?? 'Non spécifiée' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $car->model }}</td>
                                    <td class="text-center">{{ $car->year }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark font-monospace">{{ $car->registration_number }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($car->availability == 1)
                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                <i class="fas fa-check-circle me-1"></i> Disponible
                                            </span>
                                        @else
                                            <span class="badge bg-warning bg-opacity-10 text-warning">
                                                <i class="fas fa-road me-1"></i> En location
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('cars.detail', $car->id) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Voir détails">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <a href="{{ route('dashboard.cars.edit', $car->id) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Modifier">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <a href="{{ route('dashboard.cars.maintenances.index', $car) }}" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="Carnet d'entretien">
                                                <i class="fas fa-book"></i>
                                            </a>
                                            <form action="{{ route('dashboard.cars.delete', $car->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Supprimer">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-car-side text-muted mb-2" style="font-size: 2rem;"></i>
                                            <p class="text-muted mb-0">Aucun véhicule enregistré</p>
                                            <a href="{{ route('dashboard.cars.page.create') }}" class="btn btn-sm btn-primary mt-2">
                                                <i class="fas fa-plus me-1"></i> Ajouter un véhicule
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($cars->hasPages())
                    <div class="card-footer bg-white border-top-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Affichage de <span class="fw-semibold">{{ $cars->firstItem() }}</span> à <span class="fw-semibold">{{ $cars->lastItem() }}</span> sur <span class="fw-semibold">{{ $cars->total() }}</span> véhicules
                            </div>
                            <nav>
                                {{ $cars->links('pagination::bootstrap-5') }}
                            </nav>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Confirm before deleting
        document.querySelectorAll('.delete-car').forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endpush

@endsection