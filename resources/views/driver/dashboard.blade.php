@extends('layouts.app')

@section('title', 'Tableau de bord Chauffeur')

@push('styles')
<style>
    /* Modern dark theme for driver dashboard */
    .driver-dashboard { background: #0b0b12; color: #e5e7eb; min-height: 100vh; }
    .driver-dashboard .page-title { color: #f3f4f6; font-weight: 700; letter-spacing: .3px; }

    /* Cards */
    .driver-dashboard .card { background: #111827; border: 1px solid #1f2937; color: #e5e7eb; }
    .driver-dashboard .card-header { background: transparent; border-bottom: 1px solid #1f2937; color: #cbd5e1; }

    /* KPI cards */
    .stat-card { border-left: 4px solid transparent; transition: box-shadow .18s ease, transform .18s ease; }
    .stat-card.border-left-warning { border-image: linear-gradient(180deg, #a78bfa, #7c3aed) 1; }
    .stat-card.border-left-info { border-image: linear-gradient(180deg, #22d3ee, #3b82f6) 1; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 22px rgba(0,0,0,.28); }
    .stat-card .card-body { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .stat-card .kpi-label { color: #9ca3af; font-size: .85rem; text-transform: uppercase; letter-spacing: .6px; }
    .stat-card .kpi-value { color: #f9fafb; font-size: 1.5rem; font-weight: 700; }
    .stat-card i { font-size: 2.25rem; opacity: .4; color: #a78bfa; }

    /* Tabs */
    .driver-dashboard .nav-tabs { border-bottom: 1px solid #1f2937; }
    .driver-dashboard .nav-tabs .nav-link { color: #a1a1aa; background: transparent; border: none; border-bottom: 2px solid transparent; }
    .driver-dashboard .nav-tabs .nav-link:hover { color: #e5e7eb; }
    .driver-dashboard .nav-tabs .nav-link.active { color: #c4b5fd; border-color: #7c3aed; }

    /* Tables */
    .driver-dashboard table thead { background: #0f172a; color: #cbd5e1; }
    .driver-dashboard .table-hover tbody tr:hover { background: rgba(124, 58, 237, 0.08); }
    .driver-dashboard td, .driver-dashboard th { border-color: #1f2937 !important; }

    /* Badges */
    .driver-dashboard .badge.bg-success { background-color: #16a34a !important; }
    .driver-dashboard .badge.bg-warning { background-color: #f59e0b !important; color: #111827 !important; }
    .driver-dashboard .badge.bg-danger { background-color: #ef4444 !important; }
    .driver-dashboard .badge.text-dark { color: #0b0b12 !important; }

    /* Buttons */
    .driver-dashboard .btn-outline-info { color: #93c5fd; border-color: #3b82f6; }
    .driver-dashboard .btn-outline-info:hover { background: #3b82f6; color: #0b0b12; }
    .driver-dashboard .btn-outline-success { color: #86efac; border-color: #22c55e; }
    .driver-dashboard .btn-outline-success:hover { background: #22c55e; color: #0b0b12; }
    .driver-dashboard .btn-outline-danger { color: #fca5a5; border-color: #ef4444; }
    .driver-dashboard .btn-outline-danger:hover { background: #ef4444; color: #0b0b12; }

    /* Utilities */
    .muted { color: #9ca3af; }
    
    /* Item cards */
    .item-grid { display: grid; grid-template-columns: repeat(1, minmax(0, 1fr)); gap: 14px; }
    @media (min-width: 768px) { .item-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (min-width: 1200px) { .item-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
    .item-card { background: #0f172a; border: 1px solid #1f2937; border-radius: .75rem; overflow: hidden; transition: transform .16s ease, box-shadow .16s ease; }
    .item-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.35); }
    .item-card .item-header { display:flex; justify-content:space-between; align-items:center; padding: .75rem 1rem; border-bottom: 1px solid #1f2937; background: linear-gradient(180deg, rgba(124,58,237,.08), rgba(17,24,39,0)); }
    .item-card .item-body { padding: .9rem 1rem; }
    .item-meta { display:flex; flex-wrap:wrap; gap:10px 16px; }
    .item-meta .meta { display:flex; align-items:center; gap:8px; color:#cbd5e1; }
    .status-dot { width:8px; height:8px; border-radius:50%; display:inline-block; margin-right:6px; }
    .dot-warning { background:#f59e0b; }
    .dot-success { background:#16a34a; }
    .dot-danger { background:#ef4444; }
    .muted-sm { color:#9ca3af; font-size:.85rem; }
</style>
@endpush

@section('content')
<div class="driver-dashboard py-4">
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 page-title">Tableau de bord chauffeur</h1>
        </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

        <!-- KPI Cards -->
        <div class="row mb-4">
            <div class="col-md-6 mb-4">
                <div class="card stat-card border-left-warning shadow-sm h-100 py-2 px-3">
                    <div class="card-body">
                        <div>
                            <div class="kpi-label mb-1">Transferts en attente</div>
                            <div class="kpi-value">{{ $pendingTransfersCount }}</div>
                        </div>
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card stat-card border-left-info shadow-sm h-100 py-2 px-3">
                    <div class="card-body">
                        <div>
                            <div class="kpi-label mb-1">Locations à venir</div>
                            <div class="kpi-value">{{ $upcomingRentalsCount }}</div>
                        </div>
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>
        </div>

    <!-- Tabbed Interface -->
    <div class="card shadow-sm mb-4">
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
                    <div class="item-grid">
                        @forelse ($transfers as $transfer)
                            <div class="item-card">
                                <div class="item-header">
                                    <div>
                                        <div class="muted-sm">Date & Heure</div>
                                        <div class="fw-semibold">{{ $transfer->pickup_datetime ? $transfer->pickup_datetime->format('d/m/Y H:i') : 'N/A' }}</div>
                                    </div>
                                    <div class="text-end">
                                        <div class="muted-sm">Statuts</div>
                                        <div>
                                            <span class="badge bg-{{ $transfer->status == 'confirmed' ? 'success' : 'warning' }} text-dark me-1">{{ ucfirst($transfer->status) }}</span>
                                            <span class="badge bg-{{ $transfer->driver_confirmation_status == 'confirmed' ? 'success' : ($transfer->driver_confirmation_status == 'declined' ? 'danger' : 'warning') }}">{{ ucfirst($transfer->driver_confirmation_status) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-body">
                                    <div class="item-meta mb-3">
                                        <div class="meta"><i class="fas fa-user"></i><span>{{ optional($transfer->user)->name ?? 'N/A' }}</span></div>
                                        <div class="meta"><i class="fas fa-location-dot"></i>
                                            <span>
                                                {{ $transfer->pickupDestination?->name ?? ( (!is_null($transfer->pickup_latitude) && !is_null($transfer->pickup_longitude)) ? ($transfer->pickup_latitude . ', ' . $transfer->pickup_longitude) : 'N/A') }}
                                            </span>
                                            <i class="fas fa-arrow-right mx-1"></i>
                                            <span>
                                                {{ $transfer->dropoffDestination?->name ?? ( (!is_null($transfer->dropoff_latitude) && !is_null($transfer->dropoff_longitude)) ? ($transfer->dropoff_latitude . ', ' . $transfer->dropoff_longitude) : 'N/A') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('driver.transfers.show', $transfer) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye me-1"></i> Détails</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="card bg-transparent border-0">
                                <div class="card-body text-center text-muted">Vous n'avez aucun transfert assigné pour le moment.</div>
                            </div>
                        @endforelse
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $transfers->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>

                <!-- Rentals Tab -->
                <div class="tab-pane fade" id="rentals" role="tabpanel" aria-labelledby="rentals-tab">
                    <h4 class="mb-3">Locations Assignées</h4>
                    <div class="item-grid">
                        @forelse ($rentals as $rental)
                            <div class="item-card">
                                <div class="item-header">
                                    <div>
                                        <div class="muted-sm">Période</div>
                                        <div class="fw-semibold">{{ $rental->rental_date->format('d/m/Y') }} → {{ $rental->return_date->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="text-end">
                                        <div class="muted-sm">Statut</div>
                                        <div>
                                            <span class="badge bg-{{ $rental->status == 'approved' ? 'success' : 'warning' }}">{{ ucfirst($rental->status) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-body">
                                    <div class="item-meta mb-3">
                                        <div class="meta"><i class="fas fa-user"></i><span>{{ $rental->user->name }}</span></div>
                                        <div class="meta"><i class="fas fa-car-side"></i><span>{{ $rental->car->brand }} {{ $rental->car->model }}</span></div>
                                        @if($rental->location)
                                        <div class="meta"><i class="fas fa-map-marker-alt"></i><span>{{ $rental->location->name }}</span></div>
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('driver.rentals.show', $rental) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye me-1"></i> Détails</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="card bg-transparent border-0">
                                <div class="card-body text-center text-muted">Vous n'avez aucune location assignée pour le moment.</div>
                            </div>
                        @endforelse
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $rentals->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
