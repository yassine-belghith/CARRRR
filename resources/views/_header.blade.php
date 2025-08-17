<!DOCTYPE html>
<html ang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}" />
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/user.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/cars.css') }}" />
    <link rel="stylesheet" href="@vite('resources/css/app.css')" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Car Rental Management</title>
</head>
<body>
<style>
    :root {
        --primary: #4f46e5;
        --primary-light: #818cf8;
        --primary-dark: #4338ca;
        --secondary: #7c3aed;
        --accent: #ec4899;
        --dark: #111827;
        --darker: #0f172a;
        --light: #f8fafc;
        --lighter: #f1f5f9;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 8px 30px rgba(0, 0, 0, 0.12);
        --shadow-lg: 0 10px 50px rgba(0, 0, 0, 0.15);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --border-radius: 0.5rem;
    }

    /* Base Styles */
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        color: #2d3748;
        line-height: 1.6;
    }

    /* Navbar Styles */
    .navbar {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: var(--shadow);
        padding: 0.5rem 0;
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1040;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        transition: var(--transition);
    }

    .navbar.scrolled {
        padding: 0.4rem 0;
        box-shadow: var(--shadow-md);
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        font-weight: 700;
        color: var(--darker) !important;
        font-size: 1.5rem;
        letter-spacing: -0.5px;
    }

    .navbar-brand img {
        height: 40px;
        width: auto;
        margin-right: 12px;
        transition: var(--transition);
    }

    .nav-link {
        font-weight: 500;
        padding: 0.6rem 1rem !important;
        margin: 0 0.15rem;
        color: var(--gray-600) !important;
        position: relative;
        transition: var(--transition);
        border-radius: var(--border-radius);
        font-size: 0.95rem;
    }

    .nav-link i {
        width: 20px;
        text-align: center;
        margin-right: 6px;
    }

    .nav-link:before {
        content: '';
        position: absolute;
        width: 0;
        height: 3px;
        bottom: 0;
        left: 50%;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        transition: var(--transition);
        transform: translateX(-50%);
        border-radius: 3px;
    }

    .nav-link:hover,
    .nav-link.active {
        color: var(--primary) !important;
        background: rgba(79, 70, 229, 0.05);
    }

    .nav-link:hover:before,
    .nav-link.active:before {
        width: 70%;
    }

    .navbar-toggler {
        border: none;
        padding: 0.5rem;
        border-radius: var(--border-radius);
        transition: var(--transition);
    }

    .navbar-toggler:hover {
        background: var(--gray-100);
    }

    .navbar-toggler:focus {
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        outline: none;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2879, 70, 229, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        width: 1.5em;
        height: 1.5em;
    }

    /* Badge */
    .badge {
        padding: 0.35em 0.65em;
        font-weight: 600;
        border-radius: 50rem;
    }

    /* Buttons */
    .btn {
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
        font-weight: 500;
        transition: var(--transition);
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-1px);
    }

    /* Responsive Adjustments */
    @media (max-width: 991.98px) {
        .navbar-collapse {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 1rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            margin: 0.5rem -0.5rem 0;
            border: 1px solid rgba(0, 0, 0, 0.05);
            max-height: 80vh;
            overflow-y: auto;
        }

        .nav-link {
            margin: 0.2rem 0;
            padding: 0.8rem 1rem !important;
            border-radius: 0.4rem;
        }

        .nav-link:before {
            display: none;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--gray-100);
            transform: translateX(4px);
        }
    }

    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideIn {
        from { transform: translateY(-100%); }
        to { transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.4s ease-out forwards;
    }
    
    /* Scroll behavior for navbar */
    .navbar {
        animation: slideIn 0.4s ease-out;
    }
    
    /* Add scroll effect */
    document.addEventListener('DOMContentLoaded', function () {
        const navbar = document.querySelector('.koyeb-navbar');
        if (navbar) {
            window.addEventListener('scroll', function () {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        }
    });

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Add smooth scrolling to all links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Navbar scroll effect
        const navbar = document.querySelector('.koyeb-navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                navbar.style.backdropFilter = 'blur(10px)';
            } else {
                navbar.style.boxShadow = 'none';
                navbar.style.background = 'transparent';
                navbar.style.backdropFilter = 'none';
            }
        });
    });

</style>

<style>
    /* Navbar animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .nav-link, .navbar-brand, .btn {
        transition: all 0.3s ease-in-out;
        position: relative;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: var(--primary);
        transition: width 0.3s ease-in-out;
    }

    .nav-link:hover::after {
        width: 100%;
    }

    .nav-link:hover {
        transform: translateY(-2px);
    }

    .navbar-brand:hover {
        transform: scale(1.05);
    }

    .btn-outline-primary:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* Navbar items animation */
    .navbar-nav .nav-item {
        animation: fadeInDown 0.5s ease-out forwards;
        opacity: 0;
    }

    .navbar-nav .nav-item:nth-child(1) { animation-delay: 0.1s; }
    .navbar-nav .nav-item:nth-child(2) { animation-delay: 0.2s; }
    .navbar-nav .nav-item:nth-child(3) { animation-delay: 0.3s; }
    .navbar-nav .nav-item:nth-child(4) { animation-delay: 0.4s; }
    .navbar-nav .nav-item:nth-child(5) { animation-delay: 0.5s; }
    .navbar-nav .nav-item:nth-child(6) { animation-delay: 0.6s; }
</style>

<nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-custom koyeb-navbar">
  <div class="container">
      <a class="navbar-brand" href="{{ route('car.acceuil') }}">
          <img src="{{ asset('assets/rentlogo.png') }}" alt="Logo" class="d-inline-block align-top" style="height:60px; width:auto;">
          <span class="d-none d-md-inline">CarRental</span>
      </a>
      
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      
      <!-- Empty divs removed for cleaner code -->
      <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
              <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('car.acceuil') ? 'active' : '' }}" href="{{ route('car.acceuil') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Accueil">
                      <i class="fas fa-home"></i> Accueil
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('car.cars') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Voir nos véhicules">
                      <i class="fas fa-car"></i> Nos voitures
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('contact.form') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Nous contacter">
                      <i class="fas fa-envelope"></i> Contact
                  </a>
              </li>
              
              <!-- Onglets pour un utilisateur connecté -->
              @auth
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('users.rentals') ? 'active' : '' }}" href="{{ route('users.rentals' , ['user' => Auth::user()->id ]) }}">
                          <i class="fas fa-calendar-alt me-2"></i> Mes Locations
                      </a>
                  </li>
                  <li class="nav-item">
                      <form method="POST" action="{{ route('logout') }}" class="d-inline">
                          @csrf
                          <button type="submit" class="btn btn-outline-primary ms-2">
                              <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                          </button>
                      </form>
                  </li>
              @endauth
              
              <!-- Onglets pour un administrateur -->
              @if(Auth::user() && Auth::user()->role === 'admin')
                  <li class="nav-item">
                      <a href="{{ route('dashboard.index') }}" class="btn btn-outline-primary ms-2">
                          <i class="fas fa-tachometer-alt me-2"></i> Tableau de bord
                      </a>
                  </li>
              @endif
   
              <!-- Onglets pour un utilisa  teur non connecté -->
              @guest
                  <li class="nav-item">
                      <a class="nav-link fs-5 text-white fw-light mx-3" href="{{ route('login') }}">Connexion</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link fs-5 text-white fw-light mx-3" href="{{ route('page.register') }}">Inscription</a>
                  </li>
              @endguest
          </ul>
      </div>
  </div>
</nav>