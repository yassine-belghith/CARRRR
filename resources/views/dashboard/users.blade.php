@extends('dashboard.layouts.app')

@section('title', 'Gestion des Utilisateurs')

@push('styles')
<style>
    :root {
        --sidebar-width: 260px;
        --header-height: 70px;
        --card-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }
    
    /* Base responsive settings */
    * {
        box-sizing: border-box;
    }
    
    html {
        -webkit-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
        text-size-adjust: 100%;
        height: 100%;
    }
    
    body {
        min-height: 100%;
        display: flex;
        flex-direction: column;
        -webkit-text-size-adjust: none;
        background-color: #f5f7fa;
    }
    
    /* Card styles */
    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        margin-bottom: 1.5rem;
        overflow: hidden;
        width: 100%;
        background-color: #fff;
    }
    
    .card-body {
        padding: 0;
        width: 100%;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    /* Table styles */
    .table {
        margin-bottom: 0;
        width: 100%;
    }
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        border-top: none;
        padding: 1rem 1.25rem;
        background-color: #f8f9fa;
        white-space: nowrap;
        color: #4b5563;
        border-bottom: 2px solid #e5e7eb;
    }
    
    .table > :not(caption) > * > * {
        padding: 1rem 1.25rem;
        vertical-align: middle;
        white-space: nowrap;
    }
    
    .table td {
        border-color: #f0f2f5;
        color: #4b5563;
    }
    
    .table tr:not(:last-child) {
        border-bottom: 1px solid #f0f2f5;
    }
    
    /* Button styles */
    .btn {
        border-radius: 0.5rem;
        font-weight: 500;
        transition: var(--transition);
    }
    
    .btn-sm {
        padding: 0.35rem 0.75rem;
        font-size: 0.75rem;
        white-space: nowrap;
    }
    
    .btn-outline-danger {
        color: #ef4444;
        border-color: #ef4444;
    }
    
    .btn-outline-danger:hover {
        background-color: #ef4444;
        color: white;
    }
    
    .btn-outline-success {
        color: #10b981;
        border-color: #10b981;
    }
    
    .btn-outline-success:hover {
        background-color: #10b981;
        color: white;
    }
    
    /* Badge styles */
    .badge {
        font-weight: 500;
        padding: 0.4em 0.8em;
        font-size: 0.75em;
        border-radius: 0.375rem;
        text-transform: capitalize;
    }
    
    .bg-primary {
        background-color: #4f46e5 !important;
    }
    
    .bg-secondary {
        background-color: #6b7280 !important;
    }
    
    /* Page header styles */
    .page-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 0;
        line-height: 1.3;
    }
    
    .breadcrumb {
        margin-bottom: 0;
        padding: 0.5rem 0;
        background: none;
    }
    
    .breadcrumb-item {
        font-size: 0.875rem;
    }
    
    .breadcrumb-item a {
        color: #6b7280;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .breadcrumb-item a:hover {
        color: #4f46e5;
    }
    
    .breadcrumb-item.active {
        color: #4f46e5;
        font-weight: 500;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        color: #9ca3af;
    }
    
    /* Responsive adjustments */
    @media (max-width: 1199.98px) {
        .container-fluid {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
    }
    
    @media (max-width: 991.98px) {
        .page-title {
            font-size: 1.35rem;
        }
        
        .table-responsive {
            border-radius: 0.5rem;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            -ms-overflow-style: -ms-autohiding-scrollbar;
            margin: 0 -1rem;
            width: calc(100% + 2rem);
        }
        
        .table {
            min-width: 900px;
        }
    }
    
    @media (max-width: 767.98px) {
        .page-title {
            font-size: 1.25rem;
            margin-bottom: 0.5rem !important;
        }
        
        .breadcrumb {
            padding: 0.25rem 0;
        }
        
        .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.8125rem;
        }
    }
    
    @media (max-width: 575.98px) {
        .page-title {
            font-size: 1.1rem;
        }
        
        .breadcrumb-item {
            font-size: 0.8rem;
        }
        
        .btn {
            padding: 0.3rem 0.6rem;
            font-size: 0.75rem;
        }
        
        .badge {
            padding: 0.3em 0.6em;
            font-size: 0.7em;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0 px-sm-3 py-3" style="min-width: 320px;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <h1 class="page-title mb-2 mb-md-0">Gestion des Utilisateurs</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item active" aria-current="page">Utilisateurs</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center">ID</th>
                            <th scope="col">Nom d'utilisateur</th>
                            <th scope="col">Email</th>
                            <th scope="col" class="text-center">Rôle</th>
                            <th scope="col" class="text-center">Chauffeur</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <th scope="row" class="text-center">{{ $user->id }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $user->role === 'admin' ? 'primary' : 'secondary' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($user->is_driver)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i> Oui
                                        </span>
                                    @else
                                        <span class="badge bg-light text-dark">Non</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        @if ($user->role === 'admin')
                                            <form action="{{ route('dashboard.users.removeAdmin', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Retirer les droits d\'administrateur à cet utilisateur ?')">
                                                    <i class="fas fa-user-minus"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('dashboard.users.makeAdmin', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-success"
                                                    onclick="return confirm('Donner les droits d\'administrateur à cet utilisateur ?')">
                                                    <i class="fas fa-user-shield"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if($user->is_driver)
                                            <form action="{{ route('dashboard.users.removeDriver', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-warning"
                                                    onclick="return confirm('Retirer le statut de chauffeur à cet utilisateur ?')">
                                                    <i class="fas fa-user-times"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('dashboard.users.makeDriver', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-info"
                                                    onclick="return confirm('Définir cet utilisateur comme chauffeur ?')">
                                                    <i class="fas fa-taxi"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Aucun utilisateur trouvé</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if ($users->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Handle sidebar toggle
        const menuToggle = document.getElementById('menu-toggle');
        const wrapper = document.getElementById('wrapper');
        
        function updateSidebarState() {
            const isToggled = wrapper.classList.contains('toggled');
            localStorage.setItem('sidebarToggled', isToggled);
            
            // Update content margin when sidebar state changes
            const content = document.querySelector('.container-fluid');
            if (content) {
                content.style.transition = 'margin 0.3s ease';
                content.style.marginLeft = isToggled ? '0' : '';
            }
        }
        
        if (menuToggle && wrapper) {
            menuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                wrapper.classList.toggle('toggled');
                updateSidebarState();
            });
            
            // Apply saved sidebar state
            if (localStorage.getItem('sidebarToggled') === 'true') {
                wrapper.classList.add('toggled');
                updateSidebarState();
            }
        }
        
        // Handle window resize
        function handleResize() {
            if (window.innerWidth < 992) {
                wrapper.classList.add('toggled');
            } else if (localStorage.getItem('sidebarToggled') !== 'true') {
                wrapper.classList.remove('toggled');
            }
            updateSidebarState();
        }
        
        // Initial check
        handleResize();
        
        // Add resize listener
        window.addEventListener('resize', handleResize);
    });
</script>
@endpush

@endsection