@extends('dashboard.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-12">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Gestion des Destinations</h1>
                <a href="{{ route('dashboard.destinations.create') }}" class="btn btn-primary d-flex align-items-center">
                    <i class="fas fa-plus-circle me-2"></i>
                    <span>Ajouter une Destination</span>
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Liste des destinations</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="dataTable" width="100%" cellspacing="0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Adresse</th>
                                    <th>Ville</th>
                                    <th>Pays</th>
                                    <th class="text-center">Statut</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($destinations as $destination)
                                    <tr>
                                        <td>{{ $destination->name }}</td>
                                        <td>{{ $destination->address }}</td>
                                        <td>{{ $destination->city }}</td>
                                        <td>{{ $destination->country }}</td>
                                        <td class="text-center">
                                            @if($destination->is_active)
                                                <span class="badge bg-success-soft text-success">Actif</span>
                                            @else
                                                <span class="badge bg-danger-soft text-danger">Inactif</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('dashboard.destinations.edit', $destination) }}" class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="tooltip" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('dashboard.destinations.destroy', $destination) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette destination ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Supprimer">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <p class="mb-0 text-muted">Aucune destination trouvée.</p>
                                            <a href="{{ route('dashboard.destinations.create') }}" class="btn btn-primary mt-2">Ajouter votre première destination</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($destinations->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $destinations->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-success-soft {
        background-color: rgba(25, 135, 84, 0.1);
    }
    .bg-danger-soft {
        background-color: rgba(220, 53, 69, 0.1);
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    .btn-outline-warning {
        color: #ffc107;
        border-color: #ffc107;
    }
    .btn-outline-warning:hover {
        color: #000;
        background-color: #ffc107;
        border-color: #ffc107;
    }
    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
    }
    .btn-outline-danger:hover {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }
</style>
@endsection
