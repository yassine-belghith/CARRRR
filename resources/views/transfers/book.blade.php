@extends('layouts.app')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    body, .welcome-page {
        font-family: 'Inter', sans-serif;
        background-color: #121212;
        color: #e0e0e0;
    }
    .hero-main {
        position: relative;
        min-height: 100vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        overflow: hidden;
        padding: 2rem 0;
    }
    .spline-background {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        z-index: 1;
    }
    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 900px;
        width: 100%;
        padding: 1rem;
    }
    .hero-content h1 {
        font-size: 4rem;
        font-weight: 900;
        line-height: 1.2;
        background: linear-gradient(90deg, #3d5afe, #00bcd4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1rem;
    }
    .hero-content p {
        font-size: 1.25rem;
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 2rem;
    }
    .transfer-form-body {
        background-color: rgba(0, 0, 0, 0.4);
        padding: 2.5rem;
        border-radius: 1rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }
    .form-label {
        font-weight: 600;
        color: #fff;
        text-align: left;
        display: block;
    }
    .form-control, .form-select {
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        border: 1px solid #444;
        background-color: #222;
        color: #fff;
        width: 100%;
    }
    .form-control:focus, .form-select:focus {
        border-color: #3d5afe;
        box-shadow: 0 0 0 0.2rem rgba(61, 90, 254, 0.25);
        background-color: #222;
    }
    input[type=number].form-control {
        color: #fff;
    }
    .btn-primary {
        background-color: #3d5afe;
        border: none;
        font-weight: 600;
        padding: 0.9rem;
        border-radius: 0.5rem;
        box-shadow: 0 10px 20px rgba(61, 90, 254, 0.3);
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #2c49c9;
        transform: translateY(-2px);
    }
    #map {
        height: 350px;
        width: 100%;
        border-radius: 1rem;
        margin-bottom: 1.5rem;
        border: 1px solid #444;
    }
    .location-controls {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .location-controls .btn {
        flex: 1;
        border-radius: 0.5rem;
        padding: 0.75rem;
        font-weight: 600;
    }
    .btn-outline-primary {
        border-color: #3d5afe;
        color: #3d5afe;
    }
    .btn-outline-primary:hover {
        background-color: #3d5afe;
        color: #fff;
    }
    .btn-outline-secondary {
        border-color: #ccc;
        color: #ccc;
    }
    .btn-outline-secondary:hover {
        background-color: #ccc;
        color:rgb(255, 255, 255);
    }
    .location-display {
        display: flex;
        justify-content: space-between;
        background-color: rgba(0,0,0,0.3);
        padding: 0.8rem 1rem;
        border-radius: 0.8rem;
        margin-bottom: 2rem;
        font-size: 0.9rem;
        color: #e0e0e0;
    }
    .leaflet-popup-content-wrapper, .leaflet-popup-tip {
        background: #2a2a2a;
        color: #fff;
        box-shadow: 0 3px 14px rgba(0,0,0,0.4);
    }
</style>
@endpush

@section('content')
<div class="welcome-page">
    <section class="hero-main">
        <div class="spline-background">
            <spline-viewer url="https://prod.spline.design/LM0LrWOAlS428xr8/scene.splinecode"></spline-viewer>
        </div>
        <div class="hero-content">
            <h1>{{ __('messages.transfers_title') }}</h1>
            <p class="subtitle">{{ __('messages.transfers_subtitle') }}</p>
            <div class="transfer-form-body">
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
                    <div class="row g-3">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <label for="pickup_datetime" class="form-label">{{ __('messages.transfers_pickup_datetime') }}</label>
                            <input type="datetime-local" name="pickup_datetime" id="pickup_datetime" class="form-control @error('pickup_datetime') is-invalid @enderror" value="{{ old('pickup_datetime') }}" required>
                            @error('pickup_datetime')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="passenger_count" class="form-label">{{ __('messages.transfers_passengers') }}</label>
                            <input type="number" name="passenger_count" id="passenger_count" class="form-control @error('passenger_count') is-invalid @enderror" value="{{ old('passenger_count', 1) }}" required min="1">
                            @error('passenger_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="luggage_count" class="form-label">{{ __('messages.transfers_luggage') }}</label>
                            <input type="number" name="luggage_count" id="luggage_count" class="form-control @error('luggage_count') is-invalid @enderror" value="{{ old('luggage_count', 0) }}" required min="0">
                            @error('luggage_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100">{{ __('messages.transfers_request_transfer') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script type="module" src="https://unpkg.com/@splinetool/viewer/build/spline-viewer.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
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
        const map = L.map('map').setView([36.8065, 10.1815], 13);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 19
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
                if (pickupMarker) pickupMarker.setLatLng(e.latlng); else pickupMarker = L.marker(e.latlng, {draggable: true}).addTo(map);
                pickupMarker.bindPopup(`<b>${window.translations.pickupPopup}</b>`).openPopup();
                pickupLatInput.value = lat; pickupLngInput.value = lng;
                pickupCoordsP.textContent = `${window.translations.pickupLabel} ${lat.toFixed(5)}, ${lng.toFixed(5)}`;
                pickupMarker.on('dragend', function(event) {
                    const pos = event.target.getLatLng();
                    pickupLatInput.value = pos.lat; pickupLngInput.value = pos.lng;
                    pickupCoordsP.textContent = `${window.translations.pickupLabel} ${pos.lat.toFixed(5)}, ${pos.lng.toFixed(5)}`;
                });
            } else if (currentSelection === 'dropoff') {
                if (dropoffMarker) dropoffMarker.setLatLng(e.latlng); else dropoffMarker = L.marker(e.latlng, {draggable: true}).addTo(map);
                dropoffMarker.bindPopup(`<b>${window.translations.dropoffPopup}</b>`).openPopup();
                dropoffLatInput.value = lat; dropoffLngInput.value = lng;
                dropoffCoordsP.textContent = `${window.translations.dropoffLabel} ${lat.toFixed(5)}, ${lng.toFixed(5)}`;
                dropoffMarker.on('dragend', function(event) {
                    const pos = event.target.getLatLng();
                    dropoffLatInput.value = pos.lat; dropoffLngInput.value = pos.lng;
                    dropoffCoordsP.textContent = `${window.translations.dropoffLabel} ${pos.lat.toFixed(5)}, ${pos.lng.toFixed(5)}`;
                });
            }
            document.getElementById('map').style.cursor = '';
            currentSelection = null;
        });
    });
</script>
@endpush