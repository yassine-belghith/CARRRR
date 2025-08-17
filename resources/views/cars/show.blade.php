@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="h3">{{ $car->brand }} {{ $car->model }}</h1>
                </div>
                <div class="card-body">
                    @if($car->images && !empty($car->images[0]))
                        <img src="{{ asset('storage/' . $car->images[0]) }}" class="img-fluid rounded mb-4" alt="{{ $car->brand }} {{ $car->model }}">
                    @endif
                    <p class="lead">{{ $car->description }}</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>{{ __('messages.year') }}:</strong> {{ $car->year }}</li>
                        <li class="list-group-item"><strong>{{ __('messages.registration_number') }}:</strong> {{ $car->registration_number }}</li>
                        <li class="list-group-item"><strong>{{ __('messages.availability') }}:</strong> 
                            @if($car->availability)
                                <span class="badge bg-success">{{ __('messages.available') }}</span>
                            @else
                                <span class="badge bg-danger">{{ __('messages.not_available') }}</span>
                            @endif
                        </li>
                        <li class="list-group-item"><strong>{{ __('messages.price_per_day') }}:</strong> {{ number_format(App\Helpers\CurrencyHelper::convert($car->price_per_day), 2) }} {{ session('currency', 'TND') }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="h4">{{ __('messages.book_this_vehicle') }}</h2>
                </div>
                <div class="card-body">
                    @auth
                        <form action="{{ route('rental.user.store', $car) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="start_date" class="form-label">{{ __('messages.start_date') }}</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">{{ __('messages.end_date') }}</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">{{ __('messages.book_now') }}</button>
                        </form>
                    @else
                        <p>{{ __('messages.login_to_book') }}</p>
                        <a href="{{ route('login') }}" class="btn btn-primary">{{ __('messages.login') }}</a>
                        <a href="{{ route('register') }}" class="btn btn-secondary">{{ __('messages.register') }}</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toastEl = document.querySelector('.toast');
        if (toastEl) {
            var toast = new bootstrap.Toast(toastEl);
            var toastBody = toastEl.querySelector('.toast-body');

            @if(session('success'))
                toastBody.textContent = '{{ session('success') }}';
                toast.show();
            @endif

            @if(session('error'))
                toastBody.textContent = '{{ session('error') }}';
                toast.show();
            @endif
        }
    });
</script>
@endpush
