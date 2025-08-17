@extends('dashboard.layouts.app')

@section('title', 'Tableau de bord')

@php
$breadcrumbs = [
    '' => route('dashboard.index')
];
@endphp

@section('content')
<div class="container-fluid px-4">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"></h1>
        <div class="d-none d-sm-inline-block">

        </div>
    </div>
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Users Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-primary shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="row no-gutters align-items-center flex-grow-1">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Utilisateurs</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.users.index') }}" class="btn btn-sm btn-primary mt-3">Gérer</a>
                </div>
            </div>
        </div>

        <!-- Cars Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-success shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="row no-gutters align-items-center flex-grow-1">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Véhicules</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCars }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-car fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.cars.index') }}" class="btn btn-sm btn-success mt-3">Voir la flotte</a>
                </div>
            </div>
        </div>

        <!-- Rentals Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-info shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="row no-gutters align-items-center flex-grow-1">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Locations</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRentals }}</div>
                            <div class="mt-1">
                                <span class="text-warning small">{{ $pendingRentals }} en attente</span><br>
                                <span class="text-success small">{{ $confirmedRentals }} confirmées</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.rentals.index') }}" class="btn btn-sm btn-info mt-3">Voir les locations</a>
                </div>
            </div>
        </div>

        <!-- Transfers Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-warning shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="row no-gutters align-items-center flex-grow-1">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Transferts</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTransfers }}</div>
                            <div class="mt-1">
                                <span class="text-warning small">{{ $pendingTransfers }} en attente</span><br>
                                <span class="text-success small">{{ $confirmedTransfers }} confirmés</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.transfers.index') }}" class="btn btn-sm btn-warning mt-3">Voir les transferts</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="m-0 font-weight-bold text-gray-800">
                        <i class="fas fa-bolt text-warning me-2"></i>Actions rapides
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Add User -->
                        <div class="col-lg-4 col-md-6">
                            <a href="#" class="card action-card h-100 border-0 text-decoration-none">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                                            <i class="fas fa-user-plus fa-2x"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-1 fw-bold text-dark">Nouvel utilisateur</h5>
                                            <p class="text-muted mb-0 small">Ajoutez un nouvel utilisateur au système</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top-0 text-primary fw-bold py-2">
                                    <span>Commencer <i class="fas fa-arrow-right ms-1"></i></span>
                                </div>
                            </a>
                        </div>

                        <!-- Add Car -->
                        <div class="col-lg-4 col-md-6">
                            <a href="#" class="card action-card h-100 border-0 text-decoration-none">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-success bg-opacity-10 text-success rounded-3 p-3 me-3">
                                            <i class="fas fa-car-side fa-2x"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-1 fw-bold text-dark">Nouveau véhicule</h5>
                                            <p class="text-muted mb-0 small">Ajoutez un nouveau véhicule à la flotte</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top-0 text-success fw-bold py-2">
                                    <span>Commencer <i class="fas fa-arrow-right ms-1"></i></span>
                                </div>
                            </a>
                        </div>

                        <!-- New Rental -->
                        <div class="col-lg-4 col-md-6">
                            <a href="#" class="card action-card h-100 border-0 text-decoration-none">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-info bg-opacity-10 text-info rounded-3 p-3 me-3">
                                            <i class="fas fa-calendar-plus fa-2x"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-1 fw-bold text-dark">Nouvelle location</h5>
                                            <p class="text-muted mb-0 small">Créez une nouvelle réservation</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top-0 text-info fw-bold py-2">
                                    <span>Commencer <i class="fas fa-arrow-right ms-1"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 font-weight-bold text-gray-800">
                        <i class="fas fa-history text-primary me-2"></i>Activité récente
                    </h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">
                        Voir tout <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <!-- Activity Item 1 -->
                        <div class="list-group-item border-0 py-3 px-4 hover-bg-light">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar bg-primary bg-opacity-10 text-primary rounded-circle p-2">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold">Nouvelle connexion</h6>
                                        <small class="text-muted">{{ now()->subMinutes(5)->format('H:i') }}</small>
                                    </div>
                                    <p class="mb-0 text-muted small">Vous vous êtes connecté avec succès à votre compte.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Item 2 -->
                        <div class="list-group-item border-0 py-3 px-4 hover-bg-light">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar bg-success bg-opacity-10 text-success rounded-circle p-2">
                                        <i class="fas fa-car"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold">Nouveau véhicule ajouté</h6>
                                        <small class="text-muted">{{ now()->subHours(2)->format('d/m H:i') }}</small>
                                    </div>
                                    <p class="mb-0 text-muted small">Toyota RAV4 2023 a été ajouté à la flotte.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Item 3 -->
                        <div class="list-group-item border-0 py-3 px-4 hover-bg-light">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar bg-info bg-opacity-10 text-info rounded-circle p-2">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold">Nouvelle réservation</h6>
                                        <small class="text-muted">{{ now()->subDays(1)->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <p class="mb-0 text-muted small">Réservation #{{ rand(1000, 9999) }} a été créée avec succès.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Item 4 -->
                        <div class="list-group-item border-0 py-3 px-4 hover-bg-light">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar bg-warning bg-opacity-10 text-warning rounded-circle p-2">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold">Alerte de maintenance</h6>
                                        <small class="text-muted">{{ now()->subDays(2)->format('d/m/Y') }}</small>
                                    </div>
                                    <p class="mb-0 text-muted small">Le véhicule #{{ rand(100, 999) }} nécessite une révision.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3 text-center">
                    <a href="#" class="text-primary text-decoration-none fw-bold">
                        Voir plus d'activités <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-color: #4A90E2;
        --success-color: #50E3C2;
        --info-color: #57BEE2;
        --warning-color: #F5A623;
        --light-gray: #f7f9fc;
        --medium-gray: #e3e6f0;
        --dark-gray: #5a5c69;
        --text-color: #333;
        --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        --card-hover-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-hover-shadow);
    }

    .card .card-body {
        padding: 1.5rem;
    }

    .border-left-primary {
        border-left: 4px solid var(--primary-color) !important;
    }

    .text-primary {
        color: var(--primary-color) !important;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .border-left-success {
        border-left: 4px solid var(--success-color) !important;
    }

    .text-success {
        color: var(--success-color) !important;
    }

    .btn-success {
        background-color: var(--success-color);
        border-color: var(--success-color);
    }

    .border-left-info {
        border-left: 4px solid var(--info-color) !important;
    }

    .text-info {
        color: var(--info-color) !important;
    }

    .btn-info {
        background-color: var(--info-color);
        border-color: var(--info-color);
    }

    .border-left-warning {
        border-left: 4px solid var(--warning-color) !important;
    }

    .text-warning {
        color: var(--warning-color) !important;
    }

    .btn-warning {
        background-color: var(--warning-color);
        border-color: var(--warning-color);
    }

    .text-gray-800 {
        color: var(--dark-gray) !important;
    }

    .text-xs {
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }

    .h5 {
        font-weight: 700;
    }

    .action-card {
        border: 1px solid var(--medium-gray);
    }

    .action-card:hover .card-footer {
        background-color: var(--light-gray);
    }

    .icon-shape {
        width: 3.5rem;
        height: 3.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
</style>
@endsection
                