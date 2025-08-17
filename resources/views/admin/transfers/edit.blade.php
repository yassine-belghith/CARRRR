@extends('dashboard.layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Modifier le Transfert #{{ $transfer->reference_number }}</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Détails du Transfert</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.transfers.update', $transfer) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="user_id">Client</label>
                            <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $transfer->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="driver_id">Chauffeur</label>
                            <select name="driver_id" id="driver_id" class="form-control @error('driver_id') is-invalid @enderror">
                                <option value="">Non assigné</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}" {{ old('driver_id', $transfer->driver_id) == $driver->id ? 'selected' : '' }}>{{ $driver->name }}</option>
                                @endforeach
                            </select>
                            @error('driver_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="car_id">Voiture</label>
                            <select name="car_id" id="car_id" class="form-control @error('car_id') is-invalid @enderror">
                                <option value="">Non assignée</option>
                                @foreach($cars as $car)
                                    <option value="{{ $car->id }}" {{ old('car_id', $transfer->car_id) == $car->id ? 'selected' : '' }}>{{ $car->brand }} {{ $car->model }}</option>
                                @endforeach
                            </select>
                            @error('car_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pickup_datetime">Date et Heure de Prise en Charge</label>
                            <input type="datetime-local" name="pickup_datetime" id="pickup_datetime" class="form-control @error('pickup_datetime') is-invalid @enderror" value="{{ old('pickup_datetime', $transfer->pickup_datetime->format('Y-m-d\TH:i')) }}" required>
                            @error('pickup_datetime')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pickup_location_id">Lieu de Prise en Charge</label>
                            <select name="pickup_location_id" id="pickup_location_id" class="form-control @error('pickup_location_id') is-invalid @enderror" required>
                                @foreach($destinations as $destination)
                                    <option value="{{ $destination->id }}" {{ old('pickup_location_id', $transfer->pickup_location_id) == $destination->id ? 'selected' : '' }}>{{ $destination->name }}</option>
                                @endforeach
                            </select>
                            @error('pickup_location_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dropoff_location_id">Lieu de Dépose</label>
                            <select name="dropoff_location_id" id="dropoff_location_id" class="form-control @error('dropoff_location_id') is-invalid @enderror" required>
                                @foreach($destinations as $destination)
                                    <option value="{{ $destination->id }}" {{ old('dropoff_location_id', $transfer->dropoff_location_id) == $destination->id ? 'selected' : '' }}>{{ $destination->name }}</option>
                                @endforeach
                            </select>
                            @error('dropoff_location_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <hr>
                <h6 class="text-muted">Détails du Vol (Optionnel)</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="airline">Compagnie Aérienne</label>
                            <input type="text" name="airline" id="airline" class="form-control @error('airline') is-invalid @enderror" value="{{ old('airline', $transfer->airline) }}">
                            @error('airline')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="flight_number">Numéro de Vol</label>
                            <input type="text" name="flight_number" id="flight_number" class="form-control @error('flight_number') is-invalid @enderror" value="{{ old('flight_number', $transfer->flight_number) }}">
                            @error('flight_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <hr>
                <h6 class="text-muted">Détails des Passagers, Prix et Statut</h6>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="passenger_count">Passagers</label>
                            <input type="number" name="passenger_count" id="passenger_count" class="form-control @error('passenger_count') is-invalid @enderror" value="{{ old('passenger_count', $transfer->passenger_count) }}" required min="1">
                            @error('passenger_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="luggage_count">Bagages</label>
                            <input type="number" name="luggage_count" id="luggage_count" class="form-control @error('luggage_count') is-invalid @enderror" value="{{ old('luggage_count', $transfer->luggage_count) }}" required min="0">
                            @error('luggage_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="price">Prix</label>
                            <div class="input-group">
                                <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $transfer->price) }}" required step="0.01" min="0">
                                <div class="input-group-append"><span class="input-group-text">EUR</span></div>
                                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Statut</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                @foreach(['pending', 'confirmed', 'assigned', 'on_the_way', 'completed', 'cancelled', 'no_show'] as $status)
                                    <option value="{{ $status }}" {{ old('status', $transfer->status) == $status ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                                @endforeach
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="special_instructions">Instructions Spéciales</label>
                    <textarea name="special_instructions" id="special_instructions" rows="3" class="form-control @error('special_instructions') is-invalid @enderror">{{ old('special_instructions', $transfer->special_instructions) }}</textarea>
                    @error('special_instructions')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('dashboard.transfers.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection
