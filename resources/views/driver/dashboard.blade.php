@extends('layouts.app')

@section('title', 'Tableau de bord Chauffeur')

@push('styles')
<style>
    .stat-card {
        border-left: 5px solid var(--bs-primary);
        transition: all 0.3s ease-in-out;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .stat-card .card-body {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .stat-card i {
        font-size: 3rem;
        opacity: 0.3;
    }
    .nav-tabs .nav-link {
        color: var(--bs-secondary);
    }
    .nav-tabs .nav-link.active {
        color: var(--bs-primary);
        border-color: var(--bs-primary);
        border-bottom-width: 3px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tableau de bord</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-6 mb-4">
            <div class="card stat-card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Transferts en Attente de Confirmation</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingTransfersCount }}</div>
                    <i class="fas fa-hourglass-half text-gray-300"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card stat-card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Locations à Venir</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $upcomingRentalsCount }}</div>
                    <i class="fas fa-calendar-alt text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabbed Interface -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="transfers-tab" data-bs-toggle="tab" data-bs-target="#transfers" type="button" role="tab" aria-controls="transfers" aria-selected="true">Mes Transferts</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="rentals-tab" data-bs-toggle="tab" data-bs-target="#rentals" type="button" role="tab" aria-controls="rentals" aria-selected="false">Mes Locations</button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <!-- Transfers Tab -->
                <div class="tab-pane fade show active" id="transfers" role="tabpanel" aria-labelledby="transfers-tab">
                    <h4 class="mb-3">Transferts Assignés</h4>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date et Heure</th>
                                    <th>Client</th>
                                    <th>Lieux</th>
                                    <th>Statut</th>
                                    <th>Confirmation</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transfers as $transfer)
                                    <tr>
                                        <td>{{ $transfer->pickup_datetime ? $transfer->pickup_datetime->format('d/m/Y H:i') : 'N/A' }}</td>
                                        <td>{{ $transfer->customer_name }}</td>
                                        <td>{{ $transfer->pickup_location }} <i class="fas fa-arrow-right mx-1"></i> {{ $transfer->dropoff_location }}</td>
                                        <td>
                                            <span class="badge bg-{{ $transfer->status == 'confirmed' ? 'success' : 'warning' }} text-dark">{{ ucfirst($transfer->status) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $transfer->driver_confirmation_status == 'confirmed' ? 'success' : ($transfer->driver_confirmation_status == 'declined' ? 'danger' : 'warning') }}">{{ ucfirst($transfer->driver_confirmation_status) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('driver.transfers.show', $transfer) }}" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="Voir Détails"><i class="fas fa-eye"></i></a>
                                            @if ($transfer->driver_confirmation_status == 'pending')
                                                <form action="{{ route('driver.transfers.confirm', $transfer) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" title="Confirmer"><i class="fas fa-check"></i></button>
                                                </form>
                                                <form action="{{ route('driver.transfers.decline', $transfer) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Refuser"><i class="fas fa-times"></i></button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">Vous n'avez aucun transfert assigné pour le moment.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $transfers->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>

                <!-- Rentals Tab -->
                <div class="tab-pane fade" id="rentals" role="tabpanel" aria-labelledby="rentals-tab">
                    <h4 class="mb-3">Locations Assignées</h4>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Début</th>
                                    <th>Fin</th>
                                    <th>Client</th>
                                    <th>Voiture</th>
                                    <th>Statut</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rentals as $rental)
                                    <tr>
                                        <td>{{ $rental->rental_date->format('d/m/Y') }}</td>
                                        <td>{{ $rental->return_date->format('d/m/Y') }}</td>
                                        <td>{{ $rental->user->name }}</td>
                                        <td>{{ $rental->car->brand }} {{ $rental->car->model }}</td>
                                        <td>
                                            <span class="badge bg-{{ $rental->status == 'approved' ? 'success' : 'warning' }}">{{ ucfirst($rental->status) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('dashboard.rentals.show', $rental) }}" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="Voir Détails"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">Vous n'avez aucune location assignée pour le moment.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $rentals->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
