@extends('layouts.app')

@push('styles')
<style>
    .search-results-page {
        background-color: #121212;
        color: #e0e0e0;
    }
    .filter-sidebar {
        background: #1a1a1a;
        padding: 1.5rem;
        border-radius: 0.8rem;
        border: 1px solid #333;
        box-shadow: 0 10px 30px rgba(0,0,0,0.25);
        backdrop-filter: blur(6px);
    }
    .filter-title {
        font-weight: 700;
        margin-bottom: 1.2rem;
        color: #ffffff;
    }
    .filter-sidebar .form-label { color: #cfcfcf; }
    .filter-sidebar .form-control {
        background: #222;
        color: #fff;
        border: 1px solid #444;
        border-radius: 0.6rem;
    }
    .filter-sidebar .form-control::placeholder { color: #9aa0a6; }
    .filter-sidebar .form-control:focus {
        border-color: #3d5afe;
        box-shadow: 0 0 0 0.2rem rgba(61,90,254,0.25);
        background: #222;
        color: #fff;
    }
    .filter-sidebar .form-range { accent-color: #3d5afe; }
    .filter-sidebar .btn.btn-primary {
        background-color: #3d5afe;
        border: none;
        font-weight: 600;
    }
    .filter-sidebar .btn.btn-primary:hover { background-color: #2c49c9; }
    .car-card {
        background: #1a1a1a;
        border: 1px solid #333;
        border-radius: 0.8rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .car-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(0,0,0,0.4);
        border-color: #3d5afe;
    }
    .car-card-img {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        height: 200px;
        object-fit: cover;
    }
    .car-card-body {
        padding: 1.5rem;
    }
    .car-card-title {
        font-weight: 700;
        font-size: 1.2rem;
        color: #ffffff;
    }
    .car-specs {
        display: flex;
        gap: 1rem;
        color: #bbbbbb;
        margin: 1rem 0;
    }
    .car-spec-item i {
        margin-right: 0.5rem;
    }
    .car-price {
        font-weight: 600;
        font-size: 1.2rem;
        color: #00bcd4;
    }
    .btn.btn-primary { background-color: #3d5afe; border: none; }
    .btn.btn-primary:hover { background-color: #2c49c9; }

    /* Page Header */
    .page-header { margin-bottom: 1.5rem; }
    .page-title {
        font-size: 2rem;
        font-weight: 800;
        background: linear-gradient(90deg, #3d5afe, #00bcd4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin: 0;
    }
    .subtitle { color: #9aa0a6; margin-top: 0.25rem; }

    /* Results summary + chips */
    .results-summary { display:flex; align-items:center; justify-content:space-between; gap:1rem; background:#1a1a1a; border:1px solid #333; border-radius:1rem; padding:0.9rem 1.1rem; margin-bottom:1.25rem; }
    .active-chips { display:flex; flex-wrap:wrap; gap:0.5rem; }
    .chip { display:inline-flex; align-items:center; gap:0.4rem; padding:0.35rem 0.6rem; background:#222; border:1px solid #333; color:#e0e0e0; border-radius:999px; font-size:0.85rem; }
    .chip i { color:#3d5afe; }
    .btn-clear { display:inline-flex; align-items:center; gap:0.5rem; padding:0.5rem 0.85rem; background:transparent; border:1px solid #444; border-radius:0.6rem; color:#e0e0e0; text-decoration:none; }
    .btn-clear:hover { background:#2a2a2a; color:#fff; }

    /* Skeleton loader for images */
    .car-card-img.skeleton {
        background: linear-gradient(90deg, #1a1a1a 25%, #222 37%, #1a1a1a 63%);
        background-size: 400% 100%;
        animation: shimmer 1.4s ease infinite;
    }
    @keyframes shimmer {
        0% { background-position: 100% 0; }
        100% { background-position: -100% 0; }
    }

    /* Pagination */
    .pagination .page-link { background:#1a1a1a; border-color:#333; color:#e0e0e0; }
    .pagination .page-item.active .page-link { background:#3d5afe; border-color:#3d5afe; color:#fff; }
    .pagination .page-link:hover { background:#2a2a2a; border-color:#444; color:#fff; }

    /* Empty state */
    .alert-dark { background:#1a1a1a; border:1px solid #333; color:#cfcfcf; }
</style>
@endpush

@section('content')
<div class="search-results-page py-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">{{ __('resultat') ?? 'Résultats de recherche' }}</h1>
            <p class="subtitle">{{ __('messages.discover_our_fleet') ?? 'Découvrez notre flotte de véhicules modernes' }}</p>
        </div>

        <div class="results-summary">
            <div class="active-chips">
                @if(request()->filled('location_id'))
                    @php
                        $selectedLocation = $locations->firstWhere('id', request('location_id'));
                    @endphp
                    @if($selectedLocation)
                        <a class="chip" href="{{ route('car.search', request()->except('location_id')) }}" title="{{ __('messages.remove') ?? 'Retirer' }}">
                            <i class="fas fa-map-marker-alt"></i> {{ $selectedLocation->name }} <i class="fas fa-times"></i>
                        </a>
                    @endif
                @endif
                @if(request()->filled('brand'))
                    <a class="chip" href="{{ route('car.search', request()->except('brand')) }}" title="{{ __('messages.remove') ?? 'Retirer' }}">
                        <i class="fas fa-car"></i> {{ request('brand') }} <i class="fas fa-times"></i>
                    </a>
                @endif
                @if(request()->filled('max_price'))
                    <a class="chip" href="{{ route('car.search', request()->except('max_price')) }}" title="{{ __('messages.remove') ?? 'Retirer' }}">
                        <i class="fas fa-tag"></i> ≤ {{ request('max_price') }} <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
            <div class="d-flex align-items-center gap-2">
                
                <a href="{{ route('car.search') }}" class="btn-clear"><i class="fas fa-times"></i> {{ __('supprimer') ?? 'Effacer les filtres' }}</a>
            </div>
        </div>
        <div class="row">
            <!-- Filter Sidebar -->
            <div class="col-lg-3">
                <aside class="filter-sidebar">
                    <h4 class="filter-title">{{ __('messages.filters') }}</h4>
                    <form action="{{ route('car.search') }}" method="GET">
                        <div class="mb-3">
                            <label for="filter-location" class="form-label">{{ __('Lieu') }}</label>
                            <select class="form-control" id="filter-location" name="location_id">
                                <option value="">{{ __('Tous les lieux') }}</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="filter-brand" class="form-label">{{ __('messages.brand') }}</label>
                            <input type="text" class="form-control" id="filter-brand" name="brand" placeholder="{{ __('messages.brand_placeholder') }}" value="{{ request('brand') }}">
                        </div>
                        <div class="mb-3">
                            <label for="filter-price" class="form-label">{{ __('messages.price_range') }}</label>
                            <input type="range" class="form-range" min="0" max="500" id="filter-price" name="max_price" value="{{ request('max_price', 500) }}">
                        </div>
                        <div class="mb-3">
                            <label for="start-date" class="form-label">{{ __('messages.start_date') }}</label>
                            <input type="text" class="form-control" id="start-date" name="start-date" placeholder="dd/mm/yyyy" value="{{ request('start-date') }}">
                        </div>
                        <div class="mb-3">
                            <label for="end-date" class="form-label">{{ __('messages.end_date') }}</label>
                            <input type="text" class="form-control" id="end-date" name="end-date" placeholder="dd/mm/yyyy" value="{{ request('end-date') }}">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">{{ __('messages.apply_filters') }}</button>
                    </form>
                </aside>
            </div>

            <!-- Search Results -->
            <div class="col-lg-9">
                @if($cars->isEmpty())
                    <div class="alert alert-dark">
                        <p>{{ __('messages.no_cars_found') }}</p>
                    </div>
                @else
                    <div class="row">
                        @foreach($cars as $car)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card car-card">
                                    @php
                                        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="400" height="300"><rect width="100%" height="100%" fill="#1a1a1a"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#9aa0a6" font-size="18" font-family="Inter,Arial">Vehicle Image</text></svg>';
                                        $placeholder = 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($svg);

                                        $imgSrc = null;
                                        if (!empty($car->imageUrl)) {
                                            $url = trim($car->imageUrl);
                                            $allowed = \Illuminate\Support\Str::startsWith($url, ['http://', 'https://', '/storage', 'storage/', '/images', '/uploads']);
                                            $imgSrc = $allowed ? $url : null;
                                        }
                                        if (!$imgSrc) {
                                            $imagesRaw = $car->images ?? null;
                                            $images = is_array($imagesRaw) ? $imagesRaw : (empty($imagesRaw) ? [] : json_decode($imagesRaw, true));
                                            if (!is_array($images)) { $images = []; }
                                            $firstImage = $images[0] ?? null;
                                            if ($firstImage) {
                                                $imgSrc = asset('storage/' . ltrim($firstImage, '/'));
                                            } elseif (is_string($imagesRaw) && trim($imagesRaw) !== '') {
                                                $path = trim($imagesRaw);
                                                $imgSrc = \Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/']) ? $path : asset('storage/' . ltrim($path, '/'));
                                            }
                                        }
                                        if (!$imgSrc) { $imgSrc = $placeholder; }
                                    @endphp
                                    <img src="{{ $imgSrc }}" loading="lazy" class="card-img-top car-card-img skeleton" alt="{{ $car->brand }} {{ $car->model }}" onload="this.classList.remove('skeleton')" onerror="this.onerror=null; this.src='{{ $placeholder }}'">
                                    <div class="card-body car-card-body">
                                        <h5 class="card-title car-card-title">{{ $car->brand }} {{ $car->model }}</h5>
                                        <div class="car-specs">
                                            <span class="car-spec-item"><i class="fas fa-calendar-alt"></i> {{ $car->year }}</span>
                                            <span class="car-spec-item"><i class="fas fa-check-circle"></i> {{ $car->availability ? __('messages.available') : __('messages.unavailable') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                                <p class="car-price mb-0"><strong>{{ number_format(App\Helpers\CurrencyHelper::convert($car->price_per_day), 2, ',', ' ') }} {{ session('currency', 'TND') }}</strong> / {{ __('messages.day') }}</p>
                                            <a href="{{ route('cars.detail', ['car' => $car, 'location_id' => request('location_id')]) }}" class="btn btn-primary">{{ __('messages.details') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $cars->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
