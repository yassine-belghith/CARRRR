@extends('layouts.app')

@push('styles')
<style>
    .car-detail-page { background-color: #121212; color: #e0e0e0; }
    .card-dark { background: #1a1a1a; border: 1px solid #333; border-radius: 0.8rem; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
    .card-dark .card-header { background: transparent; border-bottom: 1px solid #2a2a2a; color: #fff; }
    .card-dark .list-group-item { background: transparent; color: #cfcfcf; border-color: #2a2a2a; }
    .badge-availability { padding: 0.4rem 0.6rem; border-radius: 0.5rem; font-weight: 600; }
    .badge-availability.available { background: rgba(76,175,80,.15); color: #4caf50; border: 1px solid rgba(76,175,80,.35); }
    .badge-availability.unavailable { background: rgba(244,67,54,.15); color: #f44336; border: 1px solid rgba(244,67,54,.35); }
    .price-tag { font-weight: 700; font-size: 1.2rem; color: #00bcd4; }
    .btn.btn-primary { background-color: #3d5afe; border: none; }
    .btn.btn-primary:hover { background-color: #2c49c9; }
    .btn.btn-secondary { background-color: #2a2a2a; border: 1px solid #444; color: #e0e0e0; }
    .btn.btn-secondary:hover { background-color: #333; color: #fff; }
    .form-control { background: #222; color: #fff; border: 1px solid #444; border-radius: 0.6rem; }
    .form-control:focus { border-color: #3d5afe; box-shadow: 0 0 0 0.2rem rgba(61,90,254,0.25); background: #222; color: #fff; }
    .lead { color: #cfcfcf; }
    /* Skeleton for image */
    .skeleton { background: linear-gradient(90deg, #1a1a1a 25%, #222 37%, #1a1a1a 63%); background-size: 400% 100%; animation: shimmer 1.4s ease infinite; }
    @keyframes shimmer { 0% { background-position: 100% 0; } 100% { background-position: -100% 0; } }
</style>
@endpush

@section('content')
<div class="car-detail-page py-5">
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-dark">
                <div class="card-header">
                    <h1 class="h3 m-0" style="font-weight:800;background:linear-gradient(90deg,#3d5afe,#00bcd4);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">{{ $car->brand }} {{ $car->model }}</h1>
                </div>
                <div class="card-body">
                    @php
                        $imagesRaw = $car->images;
                        $images = is_array($imagesRaw) ? $imagesRaw : (empty($imagesRaw) ? [] : json_decode($imagesRaw, true));
                        if (!is_array($images)) { $images = []; }
                        $firstImage = $images[0] ?? null;
                        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="800" height="500"><rect width="100%" height="100%" fill="#1a1a1a"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#9aa0a6" font-size="32" font-family="Inter,Arial">Vehicle Image</text></svg>';
                        $placeholder = 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($svg);

                        $imgSrc = null;
                        if (is_string($firstImage) && preg_match('/\.(jpe?g|png|webp|gif)$/i', $firstImage)) {
                            $imgSrc = asset('storage/' . ltrim($firstImage, '/'));
                        } elseif (is_string($imagesRaw) && preg_match('/\.(jpe?g|png|webp|gif)$/i', $imagesRaw)) {
                            $path = trim($imagesRaw);
                            $imgSrc = \Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/']) ? $path : asset('storage/' . ltrim($path, '/'));
                        }
                        if (!$imgSrc) { $imgSrc = $placeholder; }
                    @endphp
                    <img src="{{ $imgSrc }}" loading="lazy" class="img-fluid rounded mb-4 skeleton" alt="{{ $car->brand }} {{ $car->model }}" onload="this.classList.remove('skeleton')">
                    <p class="lead">{{ $car->description }}</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between"><span>{{ __('messages.year') }}</span><span>{{ $car->year }}</span></li>
                        <li class="list-group-item d-flex justify-content-between"><span>{{ __('messages.registration_number') }}</span><span>{{ $car->registration_number }}</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"><span>{{ __('messages.availability') }}</span>
                            @if($car->availability)
                                <span class="badge-availability available">{{ __('messages.available') }}</span>
                            @else
                                <span class="badge-availability unavailable">{{ __('messages.not_available') }}</span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between"><span>{{ __('messages.price_per_day') }}</span>
                            <span class="price-tag">{{ number_format(App\Helpers\CurrencyHelper::convert($car->price_per_day), 2, ',', ' ') }} {{ session('currency', 'TND') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-dark">
                <div class="card-header">
                    <h2 class="h5 m-0">{{ __('messages.book_this_vehicle') }}</h2>
                </div>
                <div class="card-body">
                    @auth
                        <form action="{{ route('rental.user.store', $car) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="location_id" value="{{ request('location_id') }}">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">{{ __('messages.start_date') }}</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">{{ __('messages.end_date') }}</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="location_id" class="form-label">{{ __('Lieu de prise en charge') }}</label>
                                <select class="form-control" id="location_id" name="location_id" required>
                                    <option value="">{{ __('Sélectionner un lieu') }}</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="1" id="needs_driver" name="needs_driver">
                                <label class="form-check-label" for="needs_driver">
                                    {{ ('J’ai besoin d’un chauffeur') }}
                                </label>
                            </div>
                            <div id="license_wrap" class="mb-3" style="display:none;">
                                <label for="driver_license" class="form-label">{{ ('Importer une photo de votre permis (jpg, png, pdf)') }}</label>
                                <input type="file" class="form-control" id="driver_license" name="driver_license" accept=".jpg,.jpeg,.png,.pdf">
                                <div class="form-text">Requis si vous ne demandez pas un chauffeur.</div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">{{ __('messages.book_now') }}</button>
                        </form>
                    @else
                        <p class="mb-3 text-white">{{ __('messages.login_to_book') }}</p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('login') }}" class="btn btn-primary flex-fill">{{ __('messages.login') }}</a>
                            <a href="{{ route('register') }}" class="btn btn-secondary flex-fill">{{ __('messages.register') }}</a>
                        </div>
                    @endauth
                </div>
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

        // Toggle license input when needs_driver is checked/unchecked
        var needsDriver = document.getElementById('needs_driver');
        var licenseWrap = document.getElementById('license_wrap');
        function updateLicenseVisibility() {
            if (!needsDriver) return;
            licenseWrap.style.display = needsDriver.checked ? 'none' : 'block';
        }
        if (needsDriver) {
            needsDriver.addEventListener('change', updateLicenseVisibility);
            updateLicenseVisibility();
        }
    });
</script>
@endpush
