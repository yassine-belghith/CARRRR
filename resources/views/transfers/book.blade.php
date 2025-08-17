@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        .transfer-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 85vh;
            padding: 3rem 1rem;
            background-color: #f5f5f7;
        }
        .transfer-card {
            width: 100%;
            max-width: 800px;
            background: #ffffff;
            padding: 3rem;
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .transfer-card h1 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #1c1c1e;
            text-align: center;
        }
        .transfer-card p.subtitle {
            color: #8a8a8e;
            margin-bottom: 2.5rem;
            text-align: center;
        }
        #map {
            height: 400px;
            width: 100%;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
            border: 1px solid #e5e5e7;
        }
        .location-controls {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .location-controls .btn {
            flex: 1;
        }
        .location-display {
            display: flex;
            justify-content: space-between;
            background-color: #f5f5f7;
            padding: 0.8rem 1rem;
            border-radius: 0.8rem;
            margin-bottom: 2rem;
            font-size: 0.9rem;
            color: #3a3a3c;
        }
        .form-control, .form-select {
            background-color: #f5f5f7;
            border: 1px solid #e5e5e7;
            border-radius: 0.8rem;
            padding: 0.9rem 1rem;
            font-size: 1rem;
            transition: all 0.2s ease-in-out;
        }
        .form-control:focus, .form-select:focus {
            background-color: #ffffff;
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.2);
        }
        .btn-submit {
            width: 100%;
            padding: 0.9rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 0.8rem;
            background-color: #007bff;
            border: none;
            color: white;
            transition: background-color 0.2s ease;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
    </style>
@endpush

@section('content')
<div class="transfer-container">
    <div class="transfer-card">
        <h1>{{ __('messages.transfers_title') }}</h1>
        <p class="subtitle">{{ __('messages.transfers_subtitle') }}</p>

        <div id="map"></div>

        <div class="location-controls">
            <button type="button" id="set-pickup" class="btn btn-outline-primary">{{ __('messages.transfers_set_pickup') }}</button>
            <button type="button" id="set-dropoff" class="btn btn-outline-secondary">{{ __('messages.transfers_set_dropoff') }}</button>
        </div>

        <div class="location-display">
            <span id="pickup-coords">{{ __('messages.transfers_pickup_location_status') }}</span>
            <span id="dropoff-coords">{{ __('messages.transfers_dropoff_location_status') }}</span>
        </div>

        <form action="{{ route('transfers.store') }}" method="POST">
            @csrf
            <input type="hidden" name="pickup_latitude" id="pickup_latitude">
            <input type="hidden" name="pickup_longitude" id="pickup_longitude">
            <input type="hidden" name="dropoff_latitude" id="dropoff_latitude">
            <input type="hidden" name="dropoff_longitude" id="dropoff_longitude">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="car_id" class="form-label">{{ __('messages.transfers_vehicle') }}</label>
                    <select name="car_id" id="car_id" class="form-select @error('car_id') is-invalid @enderror" required>
                        <option selected disabled>{{ __('messages.transfers_select_vehicle') }}</option>
                        @foreach($cars as $car)
                            <option value="{{ $car->id }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>
                                {{ $car->brand }} {{ $car->model }}
                            </option>
                        @endforeach
                    </select>
                    @error('car_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="pickup_datetime" class="form-label">{{ __('messages.transfers_pickup_datetime') }}</label>
                    <input type="datetime-local" name="pickup_datetime" id="pickup_datetime" class="form-control @error('pickup_datetime') is-invalid @enderror" value="{{ old('pickup_datetime') }}" required>
                    @error('pickup_datetime')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="passenger_count" class="form-label">{{ __('messages.transfers_passengers') }}</label>
                    <input type="number" name="passenger_count" id="passenger_count" class="form-control @error('passenger_count') is-invalid @enderror" value="{{ old('passenger_count', 1) }}" required min="1">
                    @error('passenger_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-4">
                    <label for="luggage_count" class="form-label">{{ __('messages.transfers_luggage') }}</label>
                    <input type="number" name="luggage_count" id="luggage_count" class="form-control @error('luggage_count') is-invalid @enderror" value="{{ old('luggage_count', 0) }}" required min="0">
                    @error('luggage_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-submit">{{ __('messages.transfers_request_transfer') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.translations = {
        pickupPopup: "{{ __('messages.transfers_pickup_location_popup') }}",
        dropoffPopup: "{{ __('messages.transfers_dropoff_location_popup') }}",
        pickupLabel: "{{ __('messages.transfers_pickup_location_label') }}",
        dropoffLabel: "{{ __('messages.transfers_dropoff_location_label') }}"
    };
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const map = L.map('map').setView([36.8065, 10.1815], 13); // Centered on Tunis
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        const pickupLatInput = document.getElementById('pickup_latitude');
        const pickupLngInput = document.getElementById('pickup_longitude');
        const dropoffLatInput = document.getElementById('dropoff_latitude');
        const dropoffLngInput = document.getElementById('dropoff_longitude');
        const pickupCoordsP = document.getElementById('pickup-coords');
        const dropoffCoordsP = document.getElementById('dropoff-coords');

        let currentSelection = null;
        let pickupMarker = null;
        let dropoffMarker = null;

        document.getElementById('set-pickup').addEventListener('click', () => {
            currentSelection = 'pickup';
            document.getElementById('map').style.cursor = 'crosshair';
        });

        document.getElementById('set-dropoff').addEventListener('click', () => {
            currentSelection = 'dropoff';
            document.getElementById('map').style.cursor = 'crosshair';
        });

        map.on('click', function(e) {
            if (!currentSelection) return;

            const { lat, lng } = e.latlng;

            if (currentSelection === 'pickup') {
                if (pickupMarker) {
                    pickupMarker.setLatLng(e.latlng);
                } else {
                    pickupMarker = L.marker(e.latlng, {draggable: true}).addTo(map);
                }
                pickupMarker.bindPopup(`<b>${window.translations.pickupPopup}</b>`).openPopup();

                pickupLatInput.value = lat;
                pickupLngInput.value = lng;
                pickupCoordsP.textContent = `${window.translations.pickupLabel} ${lat.toFixed(5)}, ${lng.toFixed(5)}`;

                pickupMarker.on('dragend', function(event) {
                    const marker = event.target;
                    const position = marker.getLatLng();
                    pickupLatInput.value = position.lat;
                    pickupLngInput.value = position.lng;
                    pickupCoordsP.textContent = `${window.translations.pickupLabel} ${position.lat.toFixed(5)}, ${position.lng.toFixed(5)}`;
                });

            } else if (currentSelection === 'dropoff') {
                if (dropoffMarker) {
                    dropoffMarker.setLatLng(e.latlng);
                } else {
                    dropoffMarker = L.marker(e.latlng, {draggable: true}).addTo(map);
                }
                dropoffMarker.bindPopup(`<b>${window.translations.dropoffPopup}</b>`).openPopup();

                dropoffLatInput.value = lat;
                dropoffLngInput.value = lng;
                dropoffCoordsP.textContent = `${window.translations.dropoffLabel} ${lat.toFixed(5)}, ${lng.toFixed(5)}`;

                dropoffMarker.on('dragend', function(event) {
                    const marker = event.target;
                    const position = marker.getLatLng();
                    dropoffLatInput.value = position.lat;
                    dropoffLngInput.value = position.lng;
                    dropoffCoordsP.textContent = `${window.translations.dropoffLabel} ${position.lat.toFixed(5)}, ${position.lng.toFixed(5)}`;
                });
            }
            
            document.getElementById('map').style.cursor = '';
            currentSelection = null;
        });
    });
</script>
@endpush