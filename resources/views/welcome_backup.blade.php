@extends('layouts.app')

@section('content')
<style>
    .hero-section {
        position: relative;
        height: 80vh;
        color: white;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('{{ asset('assets/v1.webp') }}') no-repeat center center/cover;
        filter: brightness(0.5);
        z-index: -1;
    }

    .booking-panel {
        background: rgba(17, 24, 39, 0.8);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        margin-top: 2rem;
        max-width: 800px;
        width: 100%;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .booking-panel .nav-tabs {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .booking-panel .nav-tabs .nav-link {
        background: transparent;
        border: none;
        color: #d1d5db;
        font-weight: 600;
        padding: 0.75rem 1.25rem;
        border-radius: 0.5rem 0.5rem 0 0;
        transition: all 0.3s ease;
    }

    .booking-panel .nav-tabs .nav-link.active {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }
    
    .booking-panel .tab-content {
        padding-top: 1.5rem;
    }

    .booking-panel .form-control {
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        border-radius: 0.5rem;
    }
    .booking-panel .form-control::placeholder {
        color: #9ca3af;
    }
    .booking-panel .form-control:focus {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: #4f46e5;
        box-shadow: none;
        color: white;
    }

    .booking-panel .form-label {
        color: #d1d5db;
        font-weight: 500;
        margin-bottom: 0.5rem;
        text-align: left;
        display: block;
    }

    .booking-panel .btn-primary {
        background-color: #4f46e5;
        border-color: #4f46e5;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        width: 100%;
        transition: background-color 0.3s ease;
    }
    .booking-panel .btn-primary:hover {
        background-color: #4338ca;
    }

    .transfer-panel {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 200px;
    }
</style>

<div class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="display-4 fw-bold">Location & Transfert Privé</h1>
                <p class="lead mb-4">Le véhicule parfait pour chaque étape de votre voyage.</p>
                
                <div class="booking-panel mx-auto">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="bookingTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="rental-tab" data-bs-toggle="tab" data-bs-target="#rental-panel" type="button" role="tab" aria-controls="rental-panel" aria-selected="true">
                                <i class="fas fa-car me-2"></i>Location
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="transfer-tab" data-bs-toggle="tab" data-bs-target="#transfer-panel" type="button" role="tab" aria-controls="transfer-panel" aria-selected="false">
                                <i class="fas fa-map-marked-alt me-2"></i>Transfert
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="bookingTabContent">
                        <!-- Rental Panel -->
                        <div class="tab-pane fade show active" id="rental-panel" role="tabpanel" aria-labelledby="rental-tab">
                            <form action="{{ route('car.search') }}" method="GET">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="location" class="form-label">Lieu</label>
                                        <input type="text" class="form-control" id="location" name="location" placeholder="Ville, aéroport, etc.">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="start_date" class="form-label">Début</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="end_date" class="form-label">Fin</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">Rechercher</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Transfer Panel -->
                        <div class="tab-pane fade" id="transfer-panel" role="tabpanel" aria-labelledby="transfer-tab">
                            <div class="transfer-panel text-center">
                                <p class="lead">Besoin d'un chauffeur pour vos déplacements ?</p>
                                <p>Réservez un transfert privé avec nos chauffeurs professionnels pour un trajet en toute sérénité.</p>
                                <a href="{{ route('transfers.book') }}" class="btn btn-primary mt-3" style="max-width: 300px;">Réserver un Transfert</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-4">Nos Véhicules Populaires</h2>
    <div class="row">
        @if(isset($cars) && $cars->count() > 0)
            @foreach($cars as $car)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset($car->images) }}" class="card-img-top" alt="{{ $car->brand }} {{ $car->model }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $car->brand }} {{ $car->model }}</h5>
                            <p class="card-text"><small class="text-muted">Année: {{ $car->year }}</small></p>
                            <a href="{{ route('cars.detail', $car->id) }}" class="btn btn-sm btn-outline-primary">Voir les détails</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <p class="text-center text-muted">Aucun véhicule populaire à afficher pour le moment.</p>
            </div>
        @endif
    </div>
</div>
@endsection
        border-radius: 0.5rem 0.5rem 0 0;
        transition: all 0.3s ease;
    }

    .booking-panel .nav-tabs .nav-link.active {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }
    
    .booking-panel .tab-content {
        padding-top: 1.5rem;
    }

    .booking-panel .form-control {
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        border-radius: 0.5rem;
    }
    .booking-panel .form-control::placeholder {
        color: #9ca3af;
    }
    .booking-panel .form-control:focus {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: #4f46e5;
        box-shadow: none;
        color: white;
    }

    .booking-panel .form-label {
        color: #d1d5db;
        font-weight: 500;
        margin-bottom: 0.5rem;
        text-align: left;
        display: block;
    }

    .booking-panel .btn-primary {
        background-color: #4f46e5;
        border-color: #4f46e5;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        width: 100%;
        transition: background-color 0.3s ease;
    }
    .booking-panel .btn-primary:hover {
        background-color: #4338ca;
    }

    .transfer-panel {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 200px;
    }
</style>

<div class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="display-4 fw-bold">Location & Transfert Privé</h1>
                <p class="lead mb-4">Le véhicule parfait pour chaque étape de votre voyage.</p>
                
                <div class="booking-panel mx-auto">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="bookingTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="rental-tab" data-bs-toggle="tab" data-bs-target="#rental-panel" type="button" role="tab" aria-controls="rental-panel" aria-selected="true">
                                <i class="fas fa-car me-2"></i>Location
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="transfer-tab" data-bs-toggle="tab" data-bs-target="#transfer-panel" type="button" role="tab" aria-controls="transfer-panel" aria-selected="false">
                                <i class="fas fa-map-marked-alt me-2"></i>Transfert
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="bookingTabContent">
                        <!-- Rental Panel -->
                        <div class="tab-pane fade show active" id="rental-panel" role="tabpanel" aria-labelledby="rental-tab">
                            <form action="{{ route('car.search') }}" method="GET">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="location" class="form-label">Lieu</label>
                                        <input type="text" class="form-control" id="location" name="location" placeholder="Ville, aéroport, etc.">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="start_date" class="form-label">Début</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="end_date" class="form-label">Fin</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">Rechercher</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Transfer Panel -->
                        <div class="tab-pane fade" id="transfer-panel" role="tabpanel" aria-labelledby="transfer-tab">
                            <div class="transfer-panel text-center">
                                <p class="lead">Besoin d'un chauffeur pour vos déplacements ?</p>
                                <p>Réservez un transfert privé avec nos chauffeurs professionnels pour un trajet en toute sérénité.</p>
                                <a href="{{ route('transfers.book') }}" class="btn btn-primary mt-3" style="max-width: 300px;">Réserver un Transfert</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-4">Nos Véhicules Populaires</h2>
    <div class="row">
        @foreach($cars as $car)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset($car->images) }}" class="card-img-top" alt="{{ $car->brand }} {{ $car->model }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $car->brand }} {{ $car->model }}</h5>
                        <p class="card-text"><small class="text-muted">Année: {{ $car->year }}</small></p>
                        <a href="{{ route('cars.detail', $car->id) }}" class="btn btn-sm btn-outline-primary">Voir les détails</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('content')
<style>
    .hero-section {
        position: relative;
        height: 80vh;
        color: white;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('{{ asset('assets/v1.webp') }}') no-repeat center center/cover;
        filter: brightness(0.5);
        z-index: -1;
    }

    .booking-panel {
        background: rgba(17, 24, 39, 0.8);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        margin-top: 2rem;
        max-width: 800px;
        width: 100%;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .booking-panel .nav-tabs {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .booking-panel .nav-tabs .nav-link {
        background: transparent;
        border: none;
        color: #d1d5db;
        font-weight: 600;
        padding: 0.75rem 1.25rem;
        border-radius: 0.5rem 0.5rem 0 0;
        transition: all 0.3s ease;
    }

    .booking-panel .nav-tabs .nav-link.active {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }
    
    .booking-panel .tab-content {
        padding-top: 1.5rem;
    }

    .booking-panel .form-control {
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        border-radius: 0.5rem;
    }
    .booking-panel .form-control::placeholder {
        color: #9ca3af;
    }
    .booking-panel .form-control:focus {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: #4f46e5;
        box-shadow: none;
        color: white;
    }

    .booking-panel .form-label {
        color: #d1d5db;
        font-weight: 500;
        margin-bottom: 0.5rem;
        text-align: left;
        display: block;
    }

    .booking-panel .btn-primary {
        background-color: #4f46e5;
        border-color: #4f46e5;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        width: 100%;
        transition: background-color 0.3s ease;
    }
    .booking-panel .btn-primary:hover {
        background-color: #4338ca;
    }

    .transfer-panel {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 200px;
    }
</style>

<div class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="display-4 fw-bold">Location & Transfert Privé</h1>
                <p class="lead mb-4">Le véhicule parfait pour chaque étape de votre voyage.</p>
                
                <div class="booking-panel mx-auto">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="bookingTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="rental-tab" data-bs-toggle="tab" data-bs-target="#rental-panel" type="button" role="tab" aria-controls="rental-panel" aria-selected="true">
                                <i class="fas fa-car me-2"></i>Location
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="transfer-tab" data-bs-toggle="tab" data-bs-target="#transfer-panel" type="button" role="tab" aria-controls="transfer-panel" aria-selected="false">
                                <i class="fas fa-map-marked-alt me-2"></i>Transfert
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="bookingTabContent">
                        <!-- Rental Panel -->
                        <div class="tab-pane fade show active" id="rental-panel" role="tabpanel" aria-labelledby="rental-tab">
                            <form action="{{ route('car.search') }}" method="GET">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="location" class="form-label">Lieu</label>
                                        <input type="text" class="form-control" id="location" name="location" placeholder="Ville, aéroport, etc.">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="start_date" class="form-label">Début</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="end_date" class="form-label">Fin</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">Rechercher</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Transfer Panel -->
                        <div class="tab-pane fade" id="transfer-panel" role="tabpanel" aria-labelledby="transfer-tab">
                            <div class="transfer-panel text-center">
                                <p class="lead">Besoin d'un chauffeur pour vos déplacements ?</p>
                                <p>Réservez un transfert privé avec nos chauffeurs professionnels pour un trajet en toute sérénité.</p>
                                <a href="{{ route('transfers.book') }}" class="btn btn-primary mt-3" style="max-width: 300px;">Réserver un Transfert</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-4">Nos Véhicules Populaires</h2>
    <div class="row">
        @foreach($cars as $car)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset($car->images) }}" class="card-img-top" alt="{{ $car->brand }} {{ $car->model }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $car->brand }} {{ $car->model }}</h5>
                        <p class="card-text"><small class="text-muted">Année: {{ $car->year }}</small></p>
                        <a href="{{ route('cars.detail', $car->id) }}" class="btn btn-sm btn-outline-primary">Voir les détails</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('content')
<style>
    .hero-section {
        position: relative;
        height: 80vh;
        color: white;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('{{ asset('assets/v1.webp') }}') no-repeat center center/cover;
        filter: brightness(0.5);
        z-index: -1;
    }

    .booking-panel {
        background: rgba(17, 24, 39, 0.8);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        margin-top: 2rem;
        max-width: 800px;
        width: 100%;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .booking-panel .nav-tabs {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .booking-panel .nav-tabs .nav-link {
        background: transparent;
        border: none;
        color: #d1d5db;
        font-weight: 600;
        padding: 0.75rem 1.25rem;
        border-radius: 0.5rem 0.5rem 0 0;
        transition: all 0.3s ease;
    }

    .booking-panel .nav-tabs .nav-link.active {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }
    
    .booking-panel .tab-content {
        padding-top: 1.5rem;
    }

    .booking-panel .form-control {
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        border-radius: 0.5rem;
    }
    .booking-panel .form-control::placeholder {
        color: #9ca3af;
    }
    .booking-panel .form-control:focus {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: #4f46e5;
        box-shadow: none;
        color: white;
    }

    .booking-panel .form-label {
        color: #d1d5db;
        font-weight: 500;
        margin-bottom: 0.5rem;
        text-align: left;
        display: block;
    }

    .booking-panel .btn-primary {
        background-color: #4f46e5;
        border-color: #4f46e5;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        width: 100%;
        transition: background-color 0.3s ease;
    }
    .booking-panel .btn-primary:hover {
        background-color: #4338ca;
    }

    .transfer-panel {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 200px;
    }
</style>

<div class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="display-4 fw-bold">Location & Transfert Privé</h1>
                <p class="lead mb-4">Le véhicule parfait pour chaque étape de votre voyage.</p>
                
                <div class="booking-panel mx-auto">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="bookingTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="rental-tab" data-bs-toggle="tab" data-bs-target="#rental-panel" type="button" role="tab" aria-controls="rental-panel" aria-selected="true">
                                <i class="fas fa-car me-2"></i>Location
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="transfer-tab" data-bs-toggle="tab" data-bs-target="#transfer-panel" type="button" role="tab" aria-controls="transfer-panel" aria-selected="false">
                                <i class="fas fa-map-marked-alt me-2"></i>Transfert
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="bookingTabContent">
                        <!-- Rental Panel -->
                        <div class="tab-pane fade show active" id="rental-panel" role="tabpanel" aria-labelledby="rental-tab">
                            <form action="{{ route('car.search') }}" method="GET">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="location" class="form-label">Lieu</label>
                                        <input type="text" class="form-control" id="location" name="location" placeholder="Ville, aéroport, etc.">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="start_date" class="form-label">Début</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="end_date" class="form-label">Fin</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">Rechercher</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Transfer Panel -->
                        <div class="tab-pane fade" id="transfer-panel" role="tabpanel" aria-labelledby="transfer-tab">
                            <div class="transfer-panel text-center">
                                <p class="lead">Besoin d'un chauffeur pour vos déplacements ?</p>
                                <p>Réservez un transfert privé avec nos chauffeurs professionnels pour un trajet en toute sérénité.</p>
                                <a href="{{ route('transfers.book') }}" class="btn btn-primary mt-3" style="max-width: 300px;">Réserver un Transfert</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-4">Nos Véhicules Populaires</h2>
    <div class="row">
        @foreach($cars as $car)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset($car->images) }}" class="card-img-top" alt="{{ $car->brand }} {{ $car->model }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $car->brand }} {{ $car->model }}</h5>
                        <p class="card-text"><small class="text-muted">Année: {{ $car->year }}</small></p>
                        <a href="{{ route('cars.detail', $car->id) }}" class="btn btn-sm btn-outline-primary">Voir les détails</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('content')
<style>
    .hero-section {
        position: relative;
        height: 80vh;
        color: white;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('{{ asset('assets/v1.webp') }}') no-repeat center center/cover;
        filter: brightness(0.5);
        z-index: -1;
    }

    .booking-panel {
        background: rgba(17, 24, 39, 0.8);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        margin-top: 2rem;
        max-width: 800px;
        width: 100%;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .booking-panel .nav-tabs {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .booking-panel .nav-tabs .nav-link {
        background: transparent;
        border: none;
        color: #d1d5db;
        font-weight: 600;
        padding: 0.75rem 1.25rem;
        border-radius: 0.5rem 0.5rem 0 0;
        transition: all 0.3s ease;
    }

    .booking-panel .nav-tabs .nav-link.active {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }
    
    .booking-panel .tab-content {
        padding-top: 1.5rem;
    }

    .booking-panel .form-control {
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        border-radius: 0.5rem;
    }
    .booking-panel .form-control::placeholder {
        color: #9ca3af;
    }
    .booking-panel .form-control:focus {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: #4f46e5;
        box-shadow: none;
        color: white;
    }

    .booking-panel .form-label {
        color: #d1d5db;
        font-weight: 500;
        margin-bottom: 0.5rem;
        text-align: left;
        display: block;
    }

    .booking-panel .btn-primary {
        background-color: #4f46e5;
        border-color: #4f46e5;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        width: 100%;
        transition: background-color 0.3s ease;
    }
    .booking-panel .btn-primary:hover {
        background-color: #4338ca;
    }

    .transfer-panel {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 200px;
    }
</style>

<div class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="display-4 fw-bold">Location & Transfert Privé</h1>
                <p class="lead mb-4">Le véhicule parfait pour chaque étape de votre voyage.</p>
                
                <div class="booking-panel mx-auto">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="bookingTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="rental-tab" data-bs-toggle="tab" data-bs-target="#rental-panel" type="button" role="tab" aria-controls="rental-panel" aria-selected="true">
                                <i class="fas fa-car me-2"></i>Location
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="transfer-tab" data-bs-toggle="tab" data-bs-target="#transfer-panel" type="button" role="tab" aria-controls="transfer-panel" aria-selected="false">
                                <i class="fas fa-map-marked-alt me-2"></i>Transfert
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="bookingTabContent">
                        <!-- Rental Panel -->
                        <div class="tab-pane fade show active" id="rental-panel" role="tabpanel" aria-labelledby="rental-tab">
                            <form action="{{ route('car.search') }}" method="GET">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="location" class="form-label">Lieu</label>
                                        <input type="text" class="form-control" id="location" name="location" placeholder="Ville, aéroport, etc.">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="start_date" class="form-label">Début</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="end_date" class="form-label">Fin</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">Rechercher</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Transfer Panel -->
                        <div class="tab-pane fade" id="transfer-panel" role="tabpanel" aria-labelledby="transfer-tab">
                            <div class="transfer-panel text-center">
                                <p class="lead">Besoin d'un chauffeur pour vos déplacements ?</p>
                                <p>Réservez un transfert privé avec nos chauffeurs professionnels pour un trajet en toute sérénité.</p>
                                <a href="{{ route('transfers.book') }}" class="btn btn-primary mt-3" style="max-width: 300px;">Réserver un Transfert</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-4">Nos Véhicules Populaires</h2>
    <div class="row">
        @foreach($cars as $car)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset($car->images) }}" class="card-img-top" alt="{{ $car->brand }} {{ $car->model }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $car->brand }} {{ $car->model }}</h5>
                        <p class="card-text"><small class="text-muted">Année: {{ $car->year }}</small></p>
                        <a href="{{ route('cars.detail', $car->id) }}" class="btn btn-sm btn-outline-primary">Voir les détails</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('content')
<style>
    .hero-section {
        position: relative;
        height: 80vh;
        color: white;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('{{ asset('assets/v1.webp') }}') no-repeat center center/cover;
        filter: brightness(0.5);
        z-index: -1;
    }

    .booking-panel {
        background: rgba(17, 24, 39, 0.8);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        margin-top: 2rem;
        max-width: 800px;
        width: 100%;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .booking-panel .nav-tabs {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .booking-panel .nav-tabs .nav-link {
        background: transparent;
        border: none;
        color: #d1d5db;
        font-weight: 600;
        padding: 0.75rem 1.25rem;
        border-radius: 0.5rem 0.5rem 0 0;
        transition: all 0.3s ease;
    }

    .booking-panel .nav-tabs .nav-link.active {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }
    
    .booking-panel .tab-content {
        padding-top: 1.5rem;
    }

    .booking-panel .form-control {
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        border-radius: 0.5rem;
    }
    .booking-panel .form-control::placeholder {
        color: #9ca3af;
    }
    .booking-panel .form-control:focus {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: #4f46e5;
        box-shadow: none;
        color: white;
    }

    .booking-panel .form-label {
        color: #d1d5db;
        font-weight: 500;
        margin-bottom: 0.5rem;
        text-align: left;
        display: block;
    }

    .booking-panel .btn-primary {
        background-color: #4f46e5;
        border-color: #4f46e5;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        width: 100%;
        transition: background-color 0.3s ease;
    }
    .booking-panel .btn-primary:hover {
        background-color: #4338ca;
    }

    .transfer-panel {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 200px;
    }
</style>

<div class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="display-4 fw-bold">Location & Transfert Privé</h1>
                <p class="lead mb-4">Le véhicule parfait pour chaque étape de votre voyage.</p>
                
                <div class="booking-panel mx-auto">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="bookingTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="rental-tab" data-bs-toggle="tab" data-bs-target="#rental-panel" type="button" role="tab" aria-controls="rental-panel" aria-selected="true">
                                <i class="fas fa-car me-2"></i>Location
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="transfer-tab" data-bs-toggle="tab" data-bs-target="#transfer-panel" type="button" role="tab" aria-controls="transfer-panel" aria-selected="false">
                                <i class="fas fa-map-marked-alt me-2"></i>Transfert
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="bookingTabContent">
                        <!-- Rental Panel -->
                        <div class="tab-pane fade show active" id="rental-panel" role="tabpanel" aria-labelledby="rental-tab">
                            <form action="{{ route('car.search') }}" method="GET">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="location" class="form-label">Lieu</label>
                                        <input type="text" class="form-control" id="location" name="location" placeholder="Ville, aéroport, etc.">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="start_date" class="form-label">Début</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="end_date" class="form-label">Fin</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">Rechercher</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Transfer Panel -->
                        <div class="tab-pane fade" id="transfer-panel" role="tabpanel" aria-labelledby="transfer-tab">
                            <div class="transfer-panel text-center">
                                <p class="lead">Besoin d'un chauffeur pour vos déplacements ?</p>
                                <p>Réservez un transfert privé avec nos chauffeurs professionnels pour un trajet en toute sérénité.</p>
                                <a href="{{ route('transfers.book') }}" class="btn btn-primary mt-3" style="max-width: 300px;">Réserver un Transfert</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-4">Nos Véhicules Populaires</h2>
    <div class="row">
        @foreach($cars as $car)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset($car->images) }}" class="card-img-top" alt="{{ $car->brand }} {{ $car->model }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $car->brand }} {{ $car->model }}</h5>
                        <p class="card-text"><small class="text-muted">Année: {{ $car->year }}</small></p>
                        <a href="{{ route('cars.detail', $car->id) }}" class="btn btn-sm btn-outline-primary">Voir les détails</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('content')
<style>
    .hero-section {
        position: relative;
        height: 80vh;
        color: white;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('{{ asset('assets/v1.webp') }}') no-repeat center center/cover;
        filter: brightness(0.5);
        z-index: -1;
    }

    .booking-panel {
        background: rgba(17, 24, 39, 0.8);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        margin-top: 2rem;
        max-width: 800px;
        width: 100%;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .booking-panel .nav-tabs {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .booking-panel .nav-tabs .nav-link {
        background: transparent;
        border: none;
        color: #d1d5db;
        font-weight: 600;
        padding: 0.75rem 1.25rem;
        border-radius: 0.5rem 0.5rem 0 0;
        transition: all 0.3s ease;
    }

    .booking-panel .nav-tabs .nav-link.active {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }
    
    .booking-panel .tab-content {
        padding-top: 1.5rem;
    }

    .booking-panel .form-control {
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        border-radius: 0.5rem;
    }
    .booking-panel .form-control::placeholder {
        color: #9ca3af;
    }
    .booking-panel .form-control:focus {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: #4f46e5;
        box-shadow: none;
        color: white;
    }

    .booking-panel .form-label {
        color: #d1d5db;
        font-weight: 500;
        margin-bottom: 0.5rem;
        text-align: left;
        display: block;
    }

    .booking-panel .btn-primary {
        background-color: #4f46e5;
        border-color: #4f46e5;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        width: 100%;
        transition: background-color 0.3s ease;
    }
    .booking-panel .btn-primary:hover {
        background-color: #4338ca;
    }

    .transfer-panel {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 200px;
    }
</style>

<div class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="display-4 fw-bold">Location & Transfert Privé</h1>
                <p class="lead mb-4">Le véhicule parfait pour chaque étape de votre voyage.</p>
                
                <div class="booking-panel mx-auto">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="bookingTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="rental-tab" data-bs-toggle="tab" data-bs-target="#rental-panel" type="button" role="tab" aria-controls="rental-panel" aria-selected="true">
                                <i class="fas fa-car me-2"></i>Location
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="transfer-tab" data-bs-toggle="tab" data-bs-target="#transfer-panel" type="button" role="tab" aria-controls="transfer-panel" aria-selected="false">
                                <i class="fas fa-map-marked-alt me-2"></i>Transfert
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="bookingTabContent">
                        <!-- Rental Panel -->
                        <div class="tab-pane fade show active" id="rental-panel" role="tabpanel" aria-labelledby="rental-tab">
                            <form action="{{ route('car.search') }}" method="GET">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="location" class="form-label">Lieu</label>
                                        <input type="text" class="form-control" id="location" name="location" placeholder="Ville, aéroport, etc.">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="start_date" class="form-label">Début</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="end_date" class="form-label">Fin</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">Rechercher</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Transfer Panel -->
                        <div class="tab-pane fade" id="transfer-panel" role="tabpanel" aria-labelledby="transfer-tab">
                            <div class="transfer-panel text-center">
                                <p class="lead">Besoin d'un chauffeur pour vos déplacements ?</p>
                                <p>Réservez un transfert privé avec nos chauffeurs professionnels pour un trajet en toute sérénité.</p>
                                <a href="{{ route('transfers.book') }}" class="btn btn-primary mt-3" style="max-width: 300px;">Réserver un Transfert</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-4">Nos Véhicules Populaires</h2>
    <div class="row">
        @foreach($cars as $car)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset($car->images) }}" class="card-img-top" alt="{{ $car->brand }} {{ $car->model }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $car->brand }} {{ $car->model }}</h5>
                        <p class="card-text"><small class="text-muted">Année: {{ $car->year }}</small></p>
                        <a href="{{ route('cars.detail', $car->id) }}" class="btn btn-sm btn-outline-primary">Voir les détails</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

        position: relative;
        height: 80vh;
        color: white;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('{{ asset('assets/v1.webp') }}') no-repeat center center/cover;
        filter: brightness(0.5);
        z-index: -1;
    }

    .booking-panel {
        background: rgba(17, 24, 39, 0.8);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        margin-top: 2rem;
        max-width: 800px;
        width: 100%;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .booking-panel .nav-tabs {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .booking-panel .nav-tabs .nav-link {
        background: transparent;
        border: none;
        color: #d1d5db;
        font-weight: 600;
        padding: 0.75rem 1.25rem;
        border-radius: 0.5rem 0.5rem 0 0;
        transition: all 0.3s ease;
    }

    .booking-panel .nav-tabs .nav-link.active {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }
    
    .booking-panel .tab-content {
        padding-top: 1.5rem;
    }

    .booking-panel .form-control {
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        border-radius: 0.5rem;
    }
    .booking-panel .form-control::placeholder {
        color: #9ca3af;
    }
    .booking-panel .form-control:focus {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: #4f46e5;
        box-shadow: none;
        color: white;
    }

    .booking-panel .form-label {
        color: #d1d5db;
        font-weight: 500;
        margin-bottom: 0.5rem;
        text-align: left;
        display: block;
    }

    .booking-panel .btn-primary {
        background-color: #4f46e5;
        border-color: #4f46e5;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        width: 100%;
        transition: background-color 0.3s ease;
    }
    .booking-panel .btn-primary:hover {
        background-color: #4338ca;
    }

    .transfer-panel {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 200px;
    }
</style>

<div class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="display-4 fw-bold">Location & Transfert Privé</h1>
                <p class="lead mb-4">Le véhicule parfait pour chaque étape de votre voyage.</p>
                
                <div class="booking-panel mx-auto">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="bookingTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="rental-tab" data-bs-toggle="tab" data-bs-target="#rental-panel" type="button" role="tab" aria-controls="rental-panel" aria-selected="true">
                                <i class="fas fa-car me-2"></i>Location
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="transfer-tab" data-bs-toggle="tab" data-bs-target="#transfer-panel" type="button" role="tab" aria-controls="transfer-panel" aria-selected="false">
                                <i class="fas fa-map-marked-alt me-2"></i>Transfert
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="bookingTabContent">
                        <!-- Rental Panel -->
                        <div class="tab-pane fade show active" id="rental-panel" role="tabpanel" aria-labelledby="rental-tab">
                            <form action="{{ route('car.search') }}" method="GET">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="location" class="form-label">Lieu</label>
                                        <input type="text" class="form-control" id="location" name="location" placeholder="Ville, aéroport, etc.">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="start_date" class="form-label">Début</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="end_date" class="form-label">Fin</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">Rechercher</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Transfer Panel -->
                        <div class="tab-pane fade" id="transfer-panel" role="tabpanel" aria-labelledby="transfer-tab">
                            <div class="transfer-panel text-center">
                                <p class="lead">Besoin d'un chauffeur pour vos déplacements ?</p>
                                <p>Réservez un transfert privé avec nos chauffeurs professionnels pour un trajet en toute sérénité.</p>
                                <a href="{{ route('transfers.book') }}" class="btn btn-primary mt-3" style="max-width: 300px;">Réserver un Transfert</a>
                            </div>
                        </div>
                    </div>
                </div>
</section>
<section class="testimony-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Ce que disent nos clients</h2>
            <p class="lead text-muted">Des milliers de clients satisfaits à travers le monde.</p>
        </div>
        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="testimonial-card">
                        <img src="{{ asset('assets/v19.jpg') }}" alt="User 1">
                        <p class="testimonial-text fst-italic mt-3">"Service incroyable ! La location a été simple et rapide. La voiture était en parfait état. Je recommande vivement."</p>
                        <h5 class="testimonial-author mt-3 mb-0">Jean Dupont</h5>
                        <small class="text-muted">Client régulier</small>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="testimonial-card">
                        <img src="{{ asset('assets/v20.jpg') }}" alt="User 2">
                        <p class="testimonial-text fst-italic mt-3">"Une expérience sans faille du début à la fin. Le personnel était amical et serviable. Je louerai à nouveau avec eux."</p>
                        <h5 class="testimonial-author mt-3 mb-0">Marie Curie</h5>
                        <small class="text-muted">Voyageuse d'affaires</small>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="testimonial-card">
                        <img src="{{ asset('assets/v23.jpg') }}" alt="User 3">
                        <p class="testimonial-text fst-italic mt-3">"Excellent choix de véhicules et des prix très compétitifs. Le processus de réservation en ligne est un jeu d'enfant."</p>
                        <h5 class="testimonial-author mt-3 mb-0">Pierre Martin</h5>
                        <small class="text-muted">Famille en vacances</small>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>
<section class="newsletter-section text-white text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="fw-bold">Ne manquez aucune offre !</h2>
                <p class="lead my-4">Abonnez-vous à notre newsletter pour recevoir les dernières nouvelles et offres spéciales directement dans votre boîte de réception.</p>
                <form action="#" method="post" class="newsletter-form-modern mx-auto">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Votre adresse e-mail" required style="height: 46px;">
                        <button type="submit" class="btn btn-primary px-4 py-2 ms-2" style="border-radius: 30px; white-space: nowrap;">
    <i class="fas fa-bell me-2"></i>S'abonner
</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@include('_footer')