@extends('layouts.app')

@push('styles')
<style>
    .search-results-page {
        background-color: #f8f9fa;
    }
    .filter-sidebar {
        background: #fff;
        padding: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .filter-title {
        font-weight: 600;
        margin-bottom: 1.5rem;
    }
    .car-card {
        background: #fff;
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .car-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
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
        font-weight: 600;
        font-size: 1.2rem;
    }
    .car-specs {
        display: flex;
        gap: 1rem;
        color: #6c757d;
        margin: 1rem 0;
    }
    .car-spec-item i {
        margin-right: 0.5rem;
    }
    .car-price {
        font-weight: 600;
        font-size: 1.3rem;
    }
</style>
@endpush

@section('content')
<div class="search-results-page py-5">
    <div class="container">
        <div class="row">
            <!-- Filter Sidebar -->
            <div class="col-lg-3">
                <aside class="filter-sidebar">
                    <h4 class="filter-title">{{ __('messages.filters') }}</h4>
                    <form action="{{ route('car.search') }}" method="GET">
                        <div class="mb-3">
                            <label for="filter-brand" class="form-label">{{ __('messages.brand') }}</label>
                            <input type="text" class="form-control" id="filter-brand" name="brand" placeholder="{{ __('messages.brand_placeholder') }}" value="{{ request('brand') }}">
                        </div>
                        <div class="mb-3">
                            <label for="filter-price" class="form-label">{{ __('messages.price_range') }}</label>
                            <input type="range" class="form-range" min="0" max="500" id="filter-price" name="max_price" value="{{ request('max_price', 500) }}">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">{{ __('messages.apply_filters') }}</button>
                    </form>
                </aside>
            </div>

            <!-- Search Results -->
            <div class="col-lg-9">
                @if($cars->isEmpty())
                    <div class="alert alert-info">
                        <p>{{ __('messages.no_cars_found') }}</p>
                    </div>
                @else
                    <div class="row">
                        @foreach($cars as $car)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card car-card">
                                    <img src="{{ $car->imageUrl ?? 'https://via.placeholder.com/400x300' }}" class="card-img-top car-card-img" alt="{{ $car->brand }} {{ $car->model }}">
                                    <div class="card-body car-card-body">
                                        <h5 class="card-title car-card-title">{{ $car->brand }} {{ $car->model }}</h5>
                                        <div class="car-specs">
                                            <span class="car-spec-item"><i class="fas fa-calendar-alt"></i> {{ $car->year }}</span>
                                            <span class="car-spec-item"><i class="fas fa-check-circle"></i> {{ $car->availability ? __('messages.available') : __('messages.unavailable') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="car-price mb-0"><strong>{{ number_format(App\Helpers\CurrencyHelper::convert($car->price_per_day), 2, ',', ' ') }} {{ session('currency', 'TND') }}</strong> / {{ __('messages.day') }}</p>
                                            <a href="{{ route('cars.detail', $car) }}" class="btn btn-primary">{{ __('messages.details') }}</a>
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
