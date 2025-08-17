<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Tableau de bord - Location de Voitures')</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3.0 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6.4.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}" />
    
        <style>
        /* Global Design System */
        :root {
            --primary: #4e73df;
            --primary-hover: #2e59d9;
            --secondary: #858796;
            --success: #1cc88a;
            --info: #36b9cc;
            --warning: #f6c23e;
            --danger: #e74a3b;
            --light: #f8f9fc;
            --dark: #5a5c69;
            --dark-blue: #1a223e;
            --white: #fff;
            --gray-100: #f8f9fc;
            --gray-200: #eaecf4;
            --gray-300: #dddfeb;
            --gray-400: #d1d3e2;
            --gray-500: #b7b9cc;
            --gray-600: #858796;
            --gray-700: #6e707e;
            --gray-800: #5a5c69;
            --gray-900: #3a3b45;
            --font-family-sans-serif: 'Inter', sans-serif;
            --shadow-soft: 0 .15rem 1.75rem 0 rgba(58, 59, 69, .15) !important;
            --shadow-layered: 0 0 1px 0 rgba(58, 59, 69, 0.1), 0 2px 4px 0 rgba(58, 59, 69, 0.1);
            --border-color: #e3e6f0;
        }
        body {
            font-family: var(--font-family-sans-serif);
            background-color: var(--light);
            color: var(--gray-800);
            font-size: 0.9rem;
        }

        /* Layout */
        #wrapper {
            display: flex;
        }

        #page-content-wrapper {
            width: 100%;
            padding: 1.5rem;
            margin-left: 250px;
            transition: margin-left 0.3s ease-in-out;
        }

        /* Sidebar */
        #sidebar-wrapper {
            min-height: 100vh;
            width: 250px;
            background: var(--dark-blue);
            position: fixed;
            z-index: 1040;
            transition: margin-left 0.3s ease-in-out;
        }

        .sidebar-heading {
            padding: 1.5rem;
            text-align: center;
            color: var(--white);
            font-size: 1.1rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .list-group-item {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            padding: 0.75rem 1.5rem;
            margin: 0.1rem 0.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .list-group-item i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
            color: rgba(255, 255, 255, 0.3);
        }

        .list-group-item:hover, .list-group-item.active {
            background: var(--primary);
            color: var(--white);
        }

        .list-group-item:hover i, .list-group-item.active i {
            color: var(--white);
        }

        /* Top Navbar */
        .navbar {
            background-color: var(--white);
            box-shadow: var(--shadow-soft);
            border-radius: 0.5rem;
            position: sticky;
            top: 1.5rem; /* Aligns with page-content-wrapper padding */
            z-index: 1020;
        }

        main.container-fluid {
            padding-top: 1rem; /* Add space below the sticky navbar */
        }

        /* Page Content & Components */
        .card {
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            box-shadow: var(--shadow-soft);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background-color: var(--white);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.25rem;
            font-weight: 600;
            color: var(--primary);
        }

        .btn {
            border-radius: 0.35rem;
            font-weight: 600;
        }

        /* Responsive Toggling */
        @media (max-width: 992px) {
            #sidebar-wrapper {
                margin-left: -250px;
            }
            #wrapper.toggled #sidebar-wrapper {
                margin-left: 0;
            }
            #page-content-wrapper {
                margin-left: 0 !important;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-light">
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-heading">
                <img src="{{ asset('assets/rentlogo.png') }}" alt="Logo" style="max-width: 120px; height: auto;">
            </div>
            <div class="list-group list-group-flush mt-3">
                <a href="{{ route('dashboard.index') }}" class="list-group-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Tableau de bord
                </a>
                <a href="{{ route('dashboard.users.index') }}" class="list-group-item {{ request()->is('dashboard/users*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Utilisateurs
                </a>
                <a href="{{ route('dashboard.cars.index') }}" class="list-group-item {{ request()->is('dashboard/cars*') ? 'active' : '' }}">
                    <i class="fas fa-car"></i> Véhicules
                </a>
                <a href="{{ route('dashboard.rentals.index') }}" class="list-group-item {{ request()->is('dashboard/rentals*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i> Locations
                </a>
                <a href="{{ route('dashboard.transfers.index') }}" class="list-group-item {{ request()->is('dashboard/transfers*') ? 'active' : '' }}">
                    <i class="fas fa-exchange-alt"></i> Transferts
                </a>
                <a href="{{ route('dashboard.contact.messages.index') }}" class="list-group-item {{ request()->is('dashboard/contact-messages*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> Messages
                </a>
                <div class="position-absolute bottom-0 w-100 mb-3">
                    <a href="{{ url('/') }}" class="list-group-item">
                        <i class="fas fa-home"></i> Retour au site
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="list-group-item text-danger border-0 bg-transparent w-100 text-start">
                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content Wrapper -->
        <div id="page-content-wrapper">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4">
                <div class="container-fluid">
                    <button class="btn btn-primary d-lg-none" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                    
                    <div class="collapse navbar-collapse">
                        <!-- Breadcrumbs could go here if needed -->
                    </div>

                    @include('_user_dropdown')
                </div>
            </nav>
            <!-- /#top-navbar -->

            <!-- Main Content -->
            <main class="container-fluid">
                @yield('content')
            </main>
            <!-- /#main-content -->
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->

    
    <!-- Bootstrap 5.3.0 Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    @stack('scripts')
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
        
        // Initialize tooltips and popovers
        document.addEventListener('DOMContentLoaded', function() {
            // Tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Popovers
            const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            popoverTriggerList.map(function(popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });
            
            // Handle active states for sidebar items
            const currentLocation = location.href;
            const menuItems = document.querySelectorAll('.nav-link');
            
            menuItems.forEach(item => {
                if (item.href === currentLocation) {
                    item.classList.add('active');
                    const parent = item.parentElement;
                    
                    // If it's a dropdown item, also mark the parent as active
                    if (parent.classList.contains('dropdown-item')) {
                        const dropdown = parent.closest('.dropdown');
                        if (dropdown) {
                            const dropdownToggle = dropdown.querySelector('.dropdown-toggle');
                            if (dropdownToggle) {
                                dropdownToggle.classList.add('active');
                            }
                        }
                    }
                }
            });
        });
    </script>
    
    <script>
        // Sidebar Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar-wrapper');
            const toggleBtn = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            if (!toggleBtn) return;
            
            // Toggle sidebar on button click
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                sidebar.classList.toggle('show');
                
                // Toggle overlay
                if (sidebarOverlay) {
                    sidebarOverlay.classList.toggle('active');
                }
                
                // Toggle body class for mobile
                document.body.classList.toggle('sidebar-open');
                
                // Toggle icon between bars and times
                const icon = toggleBtn.querySelector('i');
                if (sidebar.classList.contains('show')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 991.98 && 
                    !sidebar.contains(e.target) &&
                    e.target !== toggleBtn && 
                    !toggleBtn.contains(e.target) &&
                    !e.target.classList.contains('dropdown-toggle')) {
                    
                    sidebar.classList.remove('show');
                    if (sidebarOverlay) {
                        sidebarOverlay.classList.remove('active');
                    }
                    document.body.classList.remove('sidebar-open');
                    
                    const icon = toggleBtn.querySelector('i');
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
            
            // Handle window resize
            function handleResize() {
                if (window.innerWidth > 991.98) {
                    // Desktop view
                    sidebar.classList.add('show');
                    if (sidebarOverlay) {
                        sidebarOverlay.classList.remove('active');
                    }
                    document.body.classList.remove('sidebar-open');
                    
                    const icon = toggleBtn.querySelector('i');
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                } else {
                    // Mobile view
                    sidebar.classList.remove('show');
                    if (sidebarOverlay) {
                        sidebarOverlay.classList.remove('active');
                    }
                    document.body.classList.remove('sidebar-open');
                }
            }
            
            // Initial check
            handleResize();
            window.addEventListener('resize', handleResize);
        });
        // Handle active states for sidebar items
        document.addEventListener('DOMContentLoaded', function() {
            const currentLocation = location.href;
            const menuItems = document.querySelectorAll('.nav-link');
            
            menuItems.forEach(item => {
                if (item.href === currentLocation) {
                    item.classList.add('active');
                    const parent = item.parentElement;
                    
                    // If it's a dropdown item, also mark the parent as active
                    if (parent.classList.contains('dropdown-item')) {
                        const dropdown = parent.closest('.dropdown');
                        if (dropdown) {
                            const dropdownToggle = dropdown.querySelector('.dropdown-toggle');
                            if (dropdownToggle) {
                                dropdownToggle.classList.add('active');
                            }
                        }
                    }
                }
            });
        });
        });
    </script>
</body>
</html>
