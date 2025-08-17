@extends('layouts.app')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    body, .welcome-page {
        font-family: 'Inter', sans-serif;
        background-color: #121212;
        color: #e0e0e0;
    }

    * {
        transition: all 0.3s ease-in-out;
    }

    .hero-main {
        position: relative;
        height: 100vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        overflow: hidden;
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
        padding: 1rem;
        animation: fadeIn 1.5s ease;
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

    .booking-form-body {
        background-color: rgba(0, 0, 0, 0.4);
        padding: 2.5rem;
        border-radius: 1rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }

    .form-label {
        font-weight: 600;
        color: #fff;
    }

    .form-control,
    .form-select {
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        border: 1px solid #444;
        background-color: #222;
        color: #fff;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #3d5afe;
        box-shadow: 0 0 0 0.2rem rgba(61, 90, 254, 0.25);
    }

    .input-group-text {
        background-color: transparent;
        border: none;
        color: #aaa;
    }

    .btn-primary {
        background-color: #3d5afe;
        border: none;
        font-weight: 600;
        padding: 0.75rem;
        border-radius: 0.5rem;
        box-shadow: 0 10px 20px rgba(61, 90, 254, 0.3);
    }

    .btn-primary:hover {
        background-color: #2c49c9;
        transform: translateY(-2px);
    }

    .hero-buttons .btn {
        font-size: 1rem;
        font-weight: 600;
        padding: 0.9rem 2rem;
        border-radius: 50px;
        margin: 0.5rem;
    }

    .btn-outline-secondary {
        border: 1px solid #ccc;
        color: #ccc;
        background: transparent;
    }

    .btn-outline-secondary:hover {
        background-color: #fff;
        color: #3d5afe;
    }

    .section {
        padding: 6rem 0;
    }

    .section-title {
        text-align: center;
        font-size: 2.75rem;
        font-weight: 700;
        position: relative;
        margin-bottom: 4rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: #3d5afe;
        border-radius: 2px;
    }

    .how-it-works-card {
        background: #1e1e1e;
        border-radius: 1.5rem;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        transition: transform 0.3s;
        border: 1px solid #333;
    }

    .how-it-works-card:hover {
        transform: translateY(-10px);
    }

    .how-it-works-card .icon {
        font-size: 2.5rem;
        color: #3d5afe;
        margin-bottom: 1rem;
    }

    .cta-section {
        padding: 5rem 0;
        text-align: center;
    }

    .cta-section h2 {
        font-size: 2.75rem;
        font-weight: 700;
        position: relative;
    }

    .cta-section h2::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: #3d5afe;
    }

    .cta-section p {
        max-width: 600px;
        margin: 1rem auto 2rem;
        color: #b0b0b0;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="welcome-page">
    <!-- Hero Section -->
    <section class="hero-main">
        <div class="spline-background">
            <spline-viewer url="https://prod.spline.design/LM0LrWOAlS428xr8/scene.splinecode"></spline-viewer>
        </div>
        <div class="hero-content">
            <h1>{{ __('messages.welcome_hero_title') }}</h1>
            <p>{{ __('messages.welcome_hero_subtitle') }}</p>
            <div class="booking-form-body">
                <form action="{{ route('car.search') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label for="destination" class="form-label">{{ __('messages.pickup_location_label') }}</label>
                            <select id="destination" name="location" class="form-select">
                                <option value="" disabled selected>{{ __('messages.select_location_placeholder') }}</option>
                                @foreach($destinations as $type => $locations)
                                    <optgroup label="{{ $type }}">
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <label for="start-date" class="form-label">{{ __('messages.start_date_label') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input type="date" id="start-date" name="start_date" class="form-control" placeholder="{{ __('dd/mm/yyyy') }}">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <label for="start_time" class="form-label">{{ __('heure ') }}</label>
                            <select id="start_time" name="start_time" class="form-select">
                                @for ($i = 0; $i < 24; $i++)
                                    <option value="{{ sprintf('%02d', $i) }}:00">{{ sprintf('%02d', $i) }}:00</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <label for="end-date" class="form-label">{{ __('messages.end_date_label') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input type="date" id="end-date" name="end_date" class="form-control" placeholder="{{ __('dd/mm/yyyy') }}">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <label for="end_time" class="form-label">{{ __('heure') }}</label>
                            <select id="end_time" name="end_time" class="form-select">
                                @for ($i = 0; $i < 24; $i++)
                                    <option value="{{ sprintf('%02d', $i) }}:00">{{ sprintf('%02d', $i) }}:00</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary w-100">{{ __('messages.search_button') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Réservation Facile en 3 Étapes</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="how-it-works-card">
                        <div class="icon"><i class="fas fa-search"></i></div>
                        <h3>Rechercher</h3>
                        <p>Trouvez la voiture ou le transfert parfait pour vos besoins parmi notre flotte variée.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="how-it-works-card">
                        <div class="icon"><i class="fas fa-calendar-check"></i></div>
                        <h3>Sélectionner & Réserver</h3>
                        <p>Choisissez vos dates, confirmez vos informations et réservez en toute sécurité en quelques minutes.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="how-it-works-card">
                        <div class="icon"><i class="fas fa-car"></i></div>
                        <h3>Conduire</h3>
                        <p>Récupérez votre voiture ou rencontrez votre chauffeur et profitez d'un voyage agréable et sans tracas.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured vehicles section removed -->

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Prêt à Commencer Votre Aventure ?</h2>
            <p>Créez un compte pour gérer vos réservations, ou explorez notre gamme complète de véhicules pour trouver votre voiture idéale dès aujourd'hui.</p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn btn-primary">Créer un Compte</a>
                <a href="{{ route('car.cars') }}" class="btn btn-outline-secondary">Explorer Notre Flotte</a>
            </div>
        </div>
    </section>
</div>
@endsection


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startDateInput = document.getElementById('start-date');
        const endDateInput = document.getElementById('end-date');

        const fpStart = flatpickr(startDateInput, {
            locale: 'fr',
            dateFormat: 'd/m/Y',
            minDate: 'today',
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates[0]) {
                    fpEnd.set('minDate', selectedDates[0]);
                }
            }
        });

        const fpEnd = flatpickr(endDateInput, {
            locale: 'fr',
            dateFormat: 'd/m/Y',
            minDate: startDateInput.value || 'today',
        });
    </script>
    <script type="module" src="https://unpkg.com/@splinetool/viewer/build/spline-viewer.js"></script>
@endpush