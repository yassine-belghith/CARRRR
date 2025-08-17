@extends('dashboard.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Gestion des Véhicules</h4>
        <a href="{{ route('dashboard.cars.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Ajouter un véhicule
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Marque</th>
                            <th>Modèle</th>
                            <th>Année</th>
                            <th>Disponibilité</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cars as $car)
                            <tr>
                                <td>{{ $car->brand }}</td>
                                <td>{{ $car->model }}</td>
                                <td>{{ $car->year }}</td>
                                <td>
                                    <span class="badge {{ $car->availability ? 'bg-success' : 'bg-danger' }}">
                                        {{ $car->availability ? 'Disponible' : 'Non disponible' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('dashboard.cars.edit', $car) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Aucun véhicule trouvé</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $cars->links() }}
        </div>
    </div>
</div>
@endsection
