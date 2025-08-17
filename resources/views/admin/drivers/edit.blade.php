@extends('dashboard.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="h3 mb-4 text-gray-800">Modifier le Chauffeur</h1>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Détails du chauffeur : {{ $driver->user->name }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.drivers.update', $driver) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="license_number">Numéro de permis</label>
                            <input type="text" class="form-control @error('license_number') is-invalid @enderror" id="license_number" name="license_number" value="{{ old('license_number', $driver->license_number) }}" required>
                            @error('license_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="license_issue_date">Date d'émission du permis</label>
                                    <input type="date" class="form-control @error('license_issue_date') is-invalid @enderror" id="license_issue_date" name="license_issue_date" value="{{ old('license_issue_date', $driver->license_issue_date->format('Y-m-d')) }}" required>
                                    @error('license_issue_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="license_expiry_date">Date d'expiration du permis</label>
                                    <input type="date" class="form-control @error('license_expiry_date') is-invalid @enderror" id="license_expiry_date" name="license_expiry_date" value="{{ old('license_expiry_date', $driver->license_expiry_date->format('Y-m-d')) }}" required>
                                    @error('license_expiry_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone">Téléphone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $driver->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Statut</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="available" {{ old('status', $driver->status) == 'available' ? 'selected' : '' }}>Disponible</option>
                                <option value="on_mission" {{ old('status', $driver->status) == 'on_mission' ? 'selected' : '' }}>En mission</option>
                                <option value="unavailable" {{ old('status', $driver->status) == 'unavailable' ? 'selected' : '' }}>Indisponible</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        <a href="{{ route('dashboard.drivers.index') }}" class="btn btn-secondary">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
