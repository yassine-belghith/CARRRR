@extends('dashboard.layouts.app')

@section('title', 'Ajouter une voiture')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold">Ajouter une voiture</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="text-decoration-none">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard.cars.index') }}" class="text-decoration-none">Voitures</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ajouter</li>
            </ol>
        </nav>
    </div>
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form method="POST" action="{{ route('dashboard.cars.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="brand" class="form-label fw-semibold">Marque</label>
                                            <input type="text" class="form-control form-control-lg" id="brand" name="brand" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="model" class="form-label fw-semibold">Modèle</label>
                                            <input type="text" class="form-control form-control-lg" id="model" name="model" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="year" class="form-label fw-semibold">Année</label>
                                            <input type="number" class="form-control form-control-lg" id="year" name="year" min="1900" max="{{ date('Y') + 1 }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="registration_number" class="form-label fw-semibold">Immatriculation</label>
                                            <input type="text" class="form-control form-control-lg" id="registration_number" name="registration_number" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="availability" class="form-label fw-semibold">Disponibilité</label>
                                            <select class="form-select form-select-lg" id="availability" name="availability" required>
                                                <option value="1">Disponible</option>
                                                <option value="0">Non disponible</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="price_per_day" class="form-label fw-semibold">Prix par jour</label>
                                            <input type="number" class="form-control form-control-lg" id="price_per_day" name="price_per_day" min="0" step="0.01" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="description" class="form-label fw-semibold">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-4">
                                            <label for="images" class="form-label fw-semibold">Images</label>
                                            <input type="file" class="form-control form-control-lg" id="images" name="images[]" multiple accept="image/*">
                                            <div class="form-text">Sélectionnez une ou plusieurs images</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="{{ route('dashboard.cars.index') }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-arrow-left me-2"></i>Retour
                                            </a>
                                            <button type="submit" class="btn btn-primary px-4">
                                                <i class="fas fa-save me-2"></i>Enregistrer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</div>

@endsection