@extends('layouts.dashboard')

@section('title', 'Carnet d\'entretien pour ' . $car->brand . ' ' . $car->model)

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Carnet d'entretien pour {{ $car->brand }} {{ $car->model }}</h3>
        <div class="card-tools">
            <a href="{{ route('dashboard.cars.maintenances.create', $car) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Ajouter un entretien
            </a>
        </div>
    </div>
    <div class="card-body">
        @if ($maintenances->isEmpty())
            <div class="alert alert-info">
                Aucun entretien n'a été enregistré pour ce véhicule.
            </div>
        @else
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Coût</th>
                        <th>Prestataire</th>
                        <th>Kilométrage</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($maintenances as $maintenance)
                        <tr>
                            <td>{{ $maintenance->maintenance_date->format('d/m/Y') }}</td>
                            <td>{{ $maintenance->type }}</td>
                            <td>{{ Str::limit($maintenance->description, 50) }}</td>
                            <td>{{ number_format($maintenance->cost, 2, ',', ' ') }} €</td>
                            <td>{{ $maintenance->service_provider ?? 'N/A' }}</td>
                            <td>{{ $maintenance->mileage ? number_format($maintenance->mileage, 0, ',', ' ') . ' km' : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('dashboard.cars.maintenances.edit', [$car, $maintenance]) }}" class="btn btn-sm btn-warning">Modifier</a>
                                <form action="{{ route('dashboard.cars.maintenances.destroy', [$car, $maintenance]) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <div class="card-footer">
        {{ $maintenances->links() }}
    </div>
</div>
@endsection
