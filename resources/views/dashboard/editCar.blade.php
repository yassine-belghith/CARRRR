@extends('dashboard.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Modifier le véhicule</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard.cars.index') }}">Véhicules</a></li>
                <li class="breadcrumb-item active" aria-current="page">Modifier</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 fw-bold">Détails du véhicule</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.cars.update', $car) }}">
                @csrf
                @method('PUT')
                
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="brand" class="form-label fw-medium text-gray-700">Marque <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg border-2 border-gray-200 rounded-3 py-2 px-3 focus:border-primary focus:shadow-none" 
                                   id="brand" name="brand" value="{{ $car->brand }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="model" class="form-label fw-medium text-gray-700">Modèle <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg border-2 border-gray-200 rounded-3 py-2 px-3 focus:border-primary focus:shadow-none" 
                                   id="model" name="model" value="{{ $car->model }}" required>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="year" class="form-label fw-medium text-gray-700">Année <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg border-2 border-gray-200 rounded-3 py-2 px-3 focus:border-primary focus:shadow-none" 
                                   id="year" name="year" value="{{ $car->year }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="registration_number" class="form-label fw-medium text-gray-700">Plaque d'immatriculation <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg border-2 border-gray-200 rounded-3 py-2 px-3 focus:border-primary focus:shadow-none" 
                                   id="registration_number" name="registration_number" value="{{ $car->registration_number }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="availability" class="form-label fw-medium text-gray-700">Disponibilité <span class="text-danger">*</span></label>
                            <select class=  "form-select form-select-lg border-2 border-gray-200 rounded-3 py-2 px-3 focus:border-primary focus:shadow-none" 
                                    id="availability" name="availability" required>
                                <option value="1" {{ $car->availability == 1 ? 'selected' : '' }}>Disponible</option>
                                <option value="0" {{ $car->availability == 0 ? 'selected' : '' }}>Non disponible</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="images" class="form-label fw-medium text-gray-700">Images</label>
                            <input type="text" class="form-control form-control-lg border-2 border-gray-200 rounded-3 py-2 px-3 focus:border-primary focus:shadow-none"
                                   id="images" name="images" value="{{ is_array($car->images) ? implode(', ', $car->images) : $car->images }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="color" class="form-label fw-medium text-gray-700">Couleur</label>
                            <input type="text" class="form-control form-control-lg border-2 border-gray-200 rounded-3 py-2 px-3 focus:border-primary focus:shadow-none"
                                   id="color" name="color" value="{{ is_array($car->color) ? implode(', ', $car->color) : $car->color }}">
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="description" class="form-label fw-medium text-gray-700">Description</label>
                    <textarea class="form-control border-2 border-gray-200 rounded-3 py-2 px-3 focus:border-primary focus:shadow-none"
                              id="description" name="description" rows="4">{{ is_array($car->description) ? implode(', ', $car->description) : $car->description }}</textarea>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                    <a href="{{ route('dashboard.cars.index') }}" class="btn btn-light border-2 border-gray-300 text-gray-700 fw-medium px-4 py-2 rounded-3">
                        <i class="fas fa-arrow-left me-2"></i> Annuler
                    </a>
                    <button type="submit" class="btn btn-primary bg-primary border-0 px-4 py-2 rounded-3 fw-medium">
                        <i class="fas fa-save me-2"></i> Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.15);
        border-color: #4f46e5;
    }
    .btn-primary {
        background-color: #4f46e5;
        border-color: #4f46e5;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #4338ca;
        border-color: #4338ca;
        transform: translateY(-1px);
    }
    .btn-light {
        transition: all 0.3s ease;
    }
    .btn-light:hover {
        background-color: #f3f4f6;
        transform: translateY(-1px);
    }
    .form-label {
        margin-bottom: 0.5rem;
    }
</style>
@endpush