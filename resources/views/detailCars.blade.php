@extends('layouts.app')

@push('styles')
<style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "Helvetica Neue", sans-serif;
        background-color: #f5f5f7;
        color: #1d1d1f;
    }

    .detail-section {
        padding: 2rem 1rem;
        max-width: 1200px;
        margin: auto;
    }

    .car-card {
        background: white;
        border-radius: 22px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        overflow: hidden;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        padding: 2rem;
    }

    .car-card img {
        border-radius: 16px;
        object-fit: cover;
        width: 100%;
        height: auto;
    }

    .car-info h2 {
        font-size: 1.8rem;
        font-weight: 600;
        text-align: center;
        padding: 0.8rem;
        border-radius: 12px;
        background: #1d1d1f;
        color: white;
        margin-bottom: 1rem;
    }

    .car-info p {
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 0.6rem;
    }

    .reservation-panel {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .reservation-panel h3 {
        text-align: center;
        font-size: 1.3rem;
        font-weight: 500;
        background: #1d1d1f;
        color: white;
        padding: 0.7rem;
        border-radius: 12px;
        margin-bottom: 0.5rem;
    }

    .reservations ul {
        padding-left: 1.2rem;
    }

    .btn-ios {
        display: inline-block;
        background: #007aff;
        color: white;
        border: none;
        padding: 0.8rem 1.5rem;
        border-radius: 12px;
        font-weight: 500;
        text-align: center;
        transition: background 0.3s ease;
        cursor: pointer;
    }

    .btn-ios:hover {
        background: #0063cc;
    }

    .form-control {
        border-radius: 12px;
        padding: 0.7rem;
        border: 1px solid #d2d2d7;
    }

    .alert {
        border-radius: 12px;
        padding: 0.8rem 1rem;
        font-size: 0.9rem;
    }

    @media(max-width: 900px) {
        .car-card {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<section class="detail-section">
    <div class="car-card">
        <div class="car-info">
            <img src="{{ asset($car->images) }}" alt="voiture"/>
            <h2>{{ $car->model }}</h2>
            <p><strong>Designation:</strong> {{ $car->brand }}</p>
            <p><strong>Model:</strong> {{ $car->model }}</p>
            <p><strong>Actuellement Disponible:</strong> {{ $car->availability == 1 ? 'Oui' : 'Non' }}</p>
            <p><strong>Année d'apparution:</strong> {{ $car->year }}</p>
            <p><strong>Description:</strong> {{ $car->description }}</p>
        </div>

        <div class="reservation-panel">
            <h3>Planifier une réservation</h3>

            <div id='calendar'></div>

            @if(Auth::check() && Auth::user()->role === 'admin')
                <div class="text-center">
                    <p class="fs-6">Connecté en tant qu'administrateur</p>
                    <a href="{{ route('dashboard.rentals.create') }}" class="btn-ios">
                        <i class="fas fa-plus-circle me-2"></i> Créer une location
                    </a>
                </div>
            @else
                <form method="POST" action="{{ route('rental.user.store', $car) }}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="pickupDate">Date de prise en charge :</label>
                        <input type="date" id="pickupDate" class="form-control" name="start_date" />
                    </div>
                    <div class="mt-3">
                        <label for="returnDate">Date de retour :</label>
                        <input type="date" id="returnDate" class="form-control" name="end_date" />
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" value="1" id="needs_driver_detail" name="needs_driver">
                        <label class="form-check-label" for="needs_driver_detail">J’ai besoin d’un chauffeur</label>
                    </div>
                    <div id="license_wrap_detail" class="mt-3" style="display:none;">
                        <label for="driver_license_detail" class="form-label">Importer une photo de votre permis (jpg, png, pdf)</label>
                        <input type="file" id="driver_license_detail" class="form-control" name="driver_license" accept=".jpg,.jpeg,.png,.pdf" />
                        <div class="form-text">Requis si vous ne demandez pas un chauffeur.</div>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger mt-3">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->reservationErrors->any())
                        <div class="alert alert-danger mt-3">
                            <ul>
                                @foreach ($errors->reservationErrors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <button type="submit" class="btn-ios mt-3 w-100">Réserver cette voiture</button>
                </form>
            @endif
        </div>
    </div>
</section>
@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM content loaded, initializing calendar...');
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: {
                url: '/cars/{{ $car->id }}/reservations',
                failure: function(error) {
                    console.error('Error fetching events:', error);
                }
            },
            eventColor: '#ff0000',
            eventDidMount: function(info) {
                console.log('Event mounted:', info.event.title, info.event.start, info.event.end);
            },
            datesSet: function(dateInfo) {
                console.log('Calendar dates set.');
                console.log('Current events:', calendar.getEvents());
            }
        });
        calendar.render();
        console.log('Calendar rendered.');

        // Toggle license upload when chauffeur is NOT needed
        var needsDriverDetail = document.getElementById('needs_driver_detail');
        var licenseWrapDetail = document.getElementById('license_wrap_detail');
        function updateLicenseDetailVisibility() {
            if (!needsDriverDetail || !licenseWrapDetail) return;
            licenseWrapDetail.style.display = needsDriverDetail.checked ? 'none' : 'block';
        }
        if (needsDriverDetail) {
            needsDriverDetail.addEventListener('change', updateLicenseDetailVisibility);
            updateLicenseDetailVisibility();
        }
    });
</script>
@endpush

@endsection


