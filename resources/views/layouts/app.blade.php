<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body {
            background-color: #121212;
            color: #e0e0e0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .top-bar {
            background-color: #111;
            height: 8px;
        }

        .koyeb-navbar {
            background-color: transparent;
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
            padding: 1rem 2rem; /* Adjusted padding for sticky nav */
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1020;
            transition: padding 0.3s ease; /* Smooth transition */
        }

        .koyeb-navbar.scrolled {
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .koyeb-navbar .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #fff !important;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .koyeb-navbar .navbar-brand i {
            font-size: 1.8rem;
            color: #fff;
            margin-right: 0.5rem;
        }

        .nav-center {
            background-color: transparent;
            border-radius: 12px;
            padding: 0.5rem;
        }

        .nav-center .nav-link {
            color: #e0e0e0;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .nav-center .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .nav-right .login-link {
            color: #e0e0e0;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        .nav-right .login-link:hover {
            color: #fff;
        }

        .nav-right .signup-btn {
            background-color: #222;
            color: #fff;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .nav-right .signup-btn:hover {
            background-color: #000;
            color: #fff;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    @stack('styles')
    <style>
        /* Fix for hero section overlay blocking form interaction */
        .hero-section::before {
            pointer-events: none !important;
        }
        .booking-panel {
            pointer-events: auto !important;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Navigation -->
        <div class="top-bar"></div>
        <nav class="koyeb-navbar">
            <!-- Left: Brand -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-layer-group"></i> <!-- Placeholder for Koyeb-style logo -->
                <span>{{ __('messages.app_name') }}</span>
            </a>

            <!-- Center: Main Navigation -->
            <div class="nav-center d-none d-lg-flex">
                <ul class="navbar-nav flex-row">
                    <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
                    <li class="nav-item">
    @php
        $carsRoute = (Auth::check() && Auth::user()->role === 'admin') ? 'dashboard.cars.index' : 'car.cars';
        $isActivePattern = (Auth::check() && Auth::user()->role === 'admin') ? 'dashboard/cars*' : 'cars';
    @endphp
    <a class="nav-link {{ request()->is($isActivePattern) ? 'active' : '' }}" href="{{ route($carsRoute) }}">{{ __('messages.cars') }}</a>
</li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ route('contact.form') }}">{{ __('messages.contact') }}</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('transfers.book') ? 'active' : '' }}" href="{{ route('transfers.book') }}">{{ __('messages.transfers') }}</a></li>
                </ul>
            </div>

            <!-- Right: Auth Links -->
            <div class="nav-right">
                <!-- Language Dropdown -->
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-globe"></i> {{ strtoupper(session('locale', app()->getLocale())) }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                        <li><a class="dropdown-item" href="{{ route('language.switch', 'fr') }}">FR</a></li>
                        <li><a class="dropdown-item" href="{{ route('language.switch', 'en') }}">EN</a></li>
                        <li><a class="dropdown-item" href="{{ route('language.switch', 'ja') }}">JA</a></li>
                        <li><a class="dropdown-item" href="{{ route('language.switch', 'es') }}">ES</a></li>
                    </ul>
                </div>

                <!-- Currency Dropdown -->
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="currencyDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-money-bill-wave"></i> {{ session('currency', 'TND') }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="currencyDropdown">
                        <li><a class="dropdown-item" href="{{ route('currency.switch', 'TND') }}">TND</a></li>
                        <li><a class="dropdown-item" href="{{ route('currency.switch', 'EUR') }}">EUR</a></li>
                                                <li><a class="dropdown-item" href="{{ route('currency.switch', 'USD') }}">USD</a></li>
                    </ul>
                </div>

                @guest
                    @if (!Route::is('login'))
                        <a class="signup-btn" href="{{ route('login') }}" >{{ __('messages.login') }}</a>
                    @endif
                    @if (!Route::is('register'))
                        <a class="signup-btn" href="{{ route('register') }}">{{ __('messages.register') }}</a>
                    @endif
                @else
                    <div class="dropdown">
                        <a id="navbarDropdown" class="login-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            @if(Auth::user()->role === 'admin')
                                <li><a class="dropdown-item" href="{{ route('dashboard.index') }}">{{ __('messages.dashboard') }}</a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">{{ __('messages.my_profile') }}</a></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('messages.logout') }}
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </nav>

        <!-- Main Content -->
        <main class="py-4">
            @if(session('success'))
                <div class="container">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            @yield('content')
        </main>

        <!-- Toast Container -->
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="toast-container" class="toast-container">
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto">Notification</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css'])

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>

    <x-chatbot />

    @vite(['resources/js/app.js'])
    <script>
        (function() {
            const nav = document.querySelector('.koyeb-navbar');
            function onScroll() {
                if (!nav) return;
                if (window.scrollY > 20) {
                    nav.classList.add('scrolled');
                } else {
                    nav.classList.remove('scrolled');
                }
            }
            window.addEventListener('scroll', onScroll, { passive: true });
            window.addEventListener('load', onScroll);
            onScroll();
        })();
    </script>
    @stack('scripts')
</body>
</html>
