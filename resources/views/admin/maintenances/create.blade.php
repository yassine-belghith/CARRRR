@extends('layouts.dashboard')

@section('title', 'Ajouter un entretien pour ' . $car->brand . ' ' . $car->model)

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Ajouter un entretien pour {{ $car->brand }} {{ $car->model }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('dashboard.cars.maintenances.store', $car) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="maintenance_date">Date de l'entretien</label>
                <input type="date" class="form-control @error('maintenance_date') is-invalid @enderror" id="maintenance_date" name="maintenance_date" value="{{ old('maintenance_date', date('Y-m-d')) }}" required>
                @error('maintenance_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="type">Type d'entretien</label>
                <input type="text" class="form-control @error('type') is-invalid @enderror" id="type" name="type" value="{{ old('type') }}" placeholder="Ex: Vidange, Changement des pneus" required>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cost">Coût (€)</label>
                        <input type="number" step="0.01" class="form-control @error('cost') is-invalid @enderror" id="cost" name="cost" value="{{ old('cost') }}" placeholder="150.50">
                        @error('cost')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mileage">Kilométrage</label>
                        <input type="number" class="form-control @error('mileage') is-invalid @enderror" id="mileage" name="mileage" value="{{ old('mileage') }}" placeholder="80000">
                        @error('mileage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="service_provider">Prestataire</label>
                <input type="text" class="form-control @error('service_provider') is-invalid @enderror" id="service_provider" name="service_provider" value="{{ old('service_provider') }}" placeholder="Ex: Garage du Centre">
                @error('service_provider')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('dashboard.cars.maintenances.index', $car) }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection
