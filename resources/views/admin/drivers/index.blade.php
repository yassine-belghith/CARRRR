@extends('dashboard.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Gestion des Chauffeurs</h1>
                <a href="{{ route('dashboard.drivers.create') }}" class="btn btn-primary">Ajouter un Chauffeur</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Liste des chauffeurs</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>N° de Permis</th>
                                    <th>Téléphone</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($drivers as $driver)
                                    <tr>
                                        <td>{{ $driver->user->name }}</td>
                                        <td>{{ $driver->user->email }}</td>
                                        <td>{{ $driver->license_number }}</td>
                                        <td>{{ $driver->phone }}</td>
                                        <td>
                                            <span class="badge {{ $driver->status == 'available' ? 'bg-dark text-white' : ($driver->status == 'on_mission' ? 'badge-warning' : 'badge-danger') }}">
                                                {{ ucfirst(str_replace('_', ' ', $driver->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('dashboard.drivers.edit', $driver) }}" class="btn btn-sm btn-warning">Modifier</a>
                                            <form action="{{ route('dashboard.drivers.destroy', $driver) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce chauffeur ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Aucun chauffeur trouvé.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $drivers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
