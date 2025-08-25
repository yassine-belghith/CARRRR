@extends('layouts.app')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
            body, html {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        background-color: #121212;
        color: #e0e0e0;
        min-height: 100vh;
    }

    /* Page Layout */
            .products {
        padding: 4rem 0;
        background-color: #121212;
        min-height: 100vh;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 2.5rem;
        color: #fff;
        background: linear-gradient(90deg, #3d5afe, #00bcd4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    /* Filters */
            .filtre-container {
        background: rgba(30, 30, 30, 0.8);
        backdrop-filter: blur(15px);
        padding: 1.8rem;
        border-radius: 1.2rem;
        border: 1px solid #333;
        box-shadow: 0 10px 30px rgba(243, 240, 240, 0.3);
    }
    
    .filtre h5 {
        font-size: 1.4rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 1.8rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .filter-section h6 {
        font-size: 1rem;
        font-weight: 600;
        color: #e0e0e0;
        margin-bottom: 1.2rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #333;
    }
    
    .form-check-label {
        font-size: 0.95rem;
        color: #e0e0e0;
        cursor: pointer;
    }
    
    .form-check-input {
        background-color: #222;
        border-color: #444;
    }
    
    .form-check-input:checked {
        background-color: #3d5afe;
        border-color: #3d5afe;
    }

    /* Search Box */
    .search-container .form-control {
        border-radius: 999px 0 0 999px;
        border: 1px solid #444;
        padding: 0.8rem 1.5rem;
        background: #222;
        color: #fff;
        font-size: 0.95rem;
    }
    
    .search-container .form-control:focus {
        border-color: #3d5afe;
        box-shadow: 0 0 0 0.2rem rgba(154, 158, 180, 0.25);
    }
    
    .search-container .btn {
        border-radius: 0 999px 999px 0;
        background: #3d5afe;
        border: none;
        padding: 0 1.5rem;
        transition: all 0.3s ease;
    }
    
    .search-container .btn:hover {
        background: #2c49c9;
    }
    
    .search-container .btn i {
        color: white;
        font-size: 1.1rem;
    }

    /* Results Summary */
    .results-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        background: #1a1a1a;
        border: 1px solid #333;
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 6px 20px rgba(0,0,0,0.25);
    }
    .results-summary .page-title {
        margin: 0 0 0.25rem 0;
    }
    .search-hint {
        margin: 0;
        color: #9aa0a6;
        font-size: 0.95rem;
    }
    .active-chips { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.5rem; }
    .chip {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 0.6rem;
        background: #222;
        border: 1px solid #333;
        color: #e0e0e0;
        border-radius: 999px;
        font-size: 0.85rem;
    }
    .chip i { color: #3d5afe; }
    .btn-clear {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.55rem 0.9rem;
        background: transparent;
        border: 1px solid #444;
        color: #e0e0e0;
        border-radius: 0.75rem;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .btn-clear:hover { background: #2a2a2a; border-color: #555; color: #fff; }

    /* Car Cards */
            .all-products .item {
        display: flex;
        flex-wrap: wrap;
        background-color: #1a1a1a;
        border-radius: 1.2rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid #333;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }
    
    .all-products .item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.4);
        border-color: #3d5afe;
    }

    .car-image {
        flex: 0 0 220px;
        margin-right: 2rem;
        border-radius: 1rem;
        overflow: hidden;
        border: 1px solid #444;
    }
    
    .car-image img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .all-products .item:hover .car-image img {
        transform: scale(1.03);
    }

    .item-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .car-brand {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        color: #fff;
    }

    .car-details {
        font-size: 0.95rem;
        color: #bbb;
    }
    
    .detail-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.7rem;
    }
    
    .detail-item i {
        width: 24px;
        text-align: center;
        margin-right: 0.8rem;
        color: #3d5afe;
        font-size: 1.1rem;
    }
    
    .price {
        color: #00bcd4 !important;
        font-weight: 600;
    }

    /* View Details Button */
    .btn-voir-plus {
        display: inline-flex;
        align-items: center;
        margin-top: 1.2rem;
        font-weight: 600;
        color: #3d5afe;
        text-decoration: none;
        transition: all 0.3s ease;
        padding: 0.5rem 0;
        width: fit-content;
    }
    
    .btn-voir-plus:hover {
        color: #00bcd4;
        transform: translateX(5px);
    }
    
    .btn-voir-plus i {
        margin-left: 0.5rem;
        transition: transform 0.3s ease;
    }
    
    .btn-voir-plus:hover i {
        transform: translateX(3px);
    }

    /* Pagination */
    .pagination-container {
        margin-top: 3rem;
    }
    
    .pagination .page-link {
        background: rgba(30, 30, 30, 0.8);
        border: 1px solid #444;
        color: #e0e0e0;
        margin: 0 0.3rem;
        border-radius: 8px !important;
        min-width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .pagination .page-item.active .page-link {
        background: #3d5afe;
        border-color: #3d5afe;
    }
    
    .pagination .page-link:hover {
        background: #3d5afe;
        border-color: #3d5afe;
        color: #fff;
    }
    
    /* No Results */
    .no-results {
        background: rgba(30, 30, 30, 0.8);
        border-radius: 1.2rem;
        padding: 3rem 2rem;
        text-align: center;
        border: 1px  ;
        box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
    }
    
    .no-results i {
        font-size: 3rem;
        color: #3d5afe;
        margin-bottom: 1.5rem;
    }
    
    .no-results h4 {
        color: #fff;
        margin-bottom: 1rem;
    }
    
    .no-results p {
        color: #aaa;
        margin-bottom: 0;
    }
</style>
@endpush

@section('content')
<section class="products">
    <div class="container">
        @if(isset($search) && !empty($search))
            <div class="results-summary">
                <div>
                    <h1 class="page-title">{{ __('messages.search_results_for') }} : <span style="color:#007aff">"{{ $search }}"</span></h1>
                    <p class="search-hint">{{ method_exists($cars, 'total') ? $cars->total() : count($cars) }} {{ __('messages.results') ?? 'results' }}</p>
                    <div class="active-chips">
                        @if(request()->filled('location'))
                            <span class="chip"><i class="fas fa-map-marker-alt"></i> {{ request('location') }}</span>
                        @endif
                        @if(request()->filled('start_date'))
                            <span class="chip"><i class="far fa-calendar"></i> {{ request('start_date') }}</span>
                        @endif
                        @if(request()->filled('end_date'))
                            <span class="chip"><i class="far fa-calendar-check"></i> {{ request('end_date') }}</span>
                        @endif
                    </div>
                </div>
                <a href="{{ url('/cars') }}" class="btn-clear"><i class="fas fa-times"></i> {{ __('messages.clear_filters') ?? 'Clear filters' }}</a>
            </div>
        @else
            <h1 class="page-title">{{ __('messages.our_vehicles') }}</h1>
        @endif

        <form action="{{ route('car.search') }}" method="GET">
            <div class="row g-4">
                <!-- Filters -->
                <div class="col-lg-3">
                    <div class="filtre-container">
                        <div class="filtre">
                            <div class="mb-4">
                                <h5><i class="fas fa-filter me-2" style="color:#007aff"></i>{{ __('messages.filters') }}</h5>

                                <!-- Vehicle Type -->
                                <div class="filter-section">
                                    <h6>{{ __('messages.vehicle_type') }} :</h6>
                                    @foreach(['compact','sedan','berline','pickup','suv'] as $type)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="type[]" id="{{ $type }}Checkbox" value="{{ $type }}" {{ in_array($type, request('type', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ $type }}Checkbox">{{ ucfirst($type) }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Dates -->
                            <div class="filter-section mb-4">
                                <h6>{{ __('messages.availability_date') }} :</h6>
                                <div class="mb-2">
                                    <label for="start_date" class="form-label small">{{ __('messages.start_date') }}</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                                </div>
                                <div>
                                    <label for="end_date" class="form-label small">{{ __('messages.end_date') }}</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                                </div>
                            </div>

                            <!-- Capacity -->
                            <div class="filter-section mb-4">
                                <h6>{{ __('messages.capacity') }} :</h6>
                                @foreach(['2'=>'2 personnes','4'=>'4 personnes','5'=>'5 personnes'] as $cap => $label)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="capacity[]" id="persons{{ $cap }}Checkbox" value="{{ $cap }}" {{ in_array($cap, request('capacity', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="persons{{ $cap }}Checkbox">{{ $label }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-primary w-100" style="background:linear-gradient(90deg, #3d5afe, #00bcd4);border:none;border-radius:999px;padding:0.8rem;font-weight:600;letter-spacing:0.5px;transition:all 0.3s ease;">
                                {{ __('messages.apply_filters') }}
                                <i class="fas fa-filter ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Cars List -->
                <div class="col-lg-9">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Search bar -->
                    <div class="search-container mb-3">
                        <div class="input-group">
                            <input type="text" id="search" name="location" class="form-control" placeholder="{{ __('messages.search_vehicles') }}..." value="{{ $search ?? '' }}">
                            <button class="btn" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Cars -->
                    <div class="all-products">
                        @forelse ($cars as $car)
                            <div class="item">
                                <div class="car-image">
                                    @php
                                        $imgSrc = null;
                                        if (!empty($car->imageUrl)) {
                                            $imgSrc = $car->imageUrl;
                                        } else {
                                            $imagesRaw = $car->images ?? null;
                                            $images = is_array($imagesRaw) ? $imagesRaw : (empty($imagesRaw) ? [] : json_decode($imagesRaw, true));
                                            if (!is_array($images)) { $images = []; }
                                            $firstImage = $images[0] ?? null;
                                            if ($firstImage) {
                                                $imgSrc = asset('storage/' . $firstImage);
                                            }
                                        }
                                        if (!$imgSrc) {
                                            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="220" height="160"><rect width="100%" height="100%" fill="#1a1a1a"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#9aa0a6" font-size="16" font-family="Inter,Arial">Vehicle Image</text></svg>';
                                            $imgSrc = 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($svg);
                                        }
                                    @endphp
                                    <img src="{{ $imgSrc }}" alt="{{ $car->brand }} {{ $car->model }}" class="img-fluid" />
                                </div>
                                <div class="item-content">
                                    <div>
                                        <h5 class="car-brand">{{ $car->brand }} {{ $car->model }}</h5>
                                        <div class="car-details">
                                            <div class="detail-item">
                                                <i class="fas fa-car me-2"></i>
                                                <span>{{ __('messages.type') }}: {{ $car->type ?? 'Standard' }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <i class="fas fa-users me-2"></i>
                                                <span>{{ __('messages.seats') }}: {{ $car->seats ?? 4 }} {{ __('messages.people') }}</span>
                                            </div>
                                                                                        <div class="detail-item price">
                                                <i class="fas fa-tag me-2"></i>
                                                <span>{{ __('messages.from') }} <strong>{{ number_format(App\Helpers\CurrencyHelper::convert($car->price_per_day), 2) }} {{ session('currency', 'TND') }}</strong> /{{ __('messages.day') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('cars.detail', $car) }}" class="btn-voir-plus">
                                        {{ __('messages.view_details') }} <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="no-results text-center py-5">
                                <i class="fas fa-car-crash fa-3x mb-3"></i>
                                @if(isset($search) && !empty($search))
                                    <h4>{{ __('messages.no_vehicles_found_for') }} "{{ $search }}"</h4>
                                    <p class="lead text-white-50">{{ __('messages.discover_our_fleet') }}</p>
                                @else
                                    <h4>{{ __('messages.no_vehicles_available') }}</h4>
                                    <p class="text-muted">{{ __('messages.try_again_later') }}</p>
                                @endif
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-container mt-4">
                        {{ $cars->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
