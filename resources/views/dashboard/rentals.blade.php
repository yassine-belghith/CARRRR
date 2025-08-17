
@include('../../_header')
<section class="dashboard d-flex">
    <div class="tables w-25 h-100 text-bg-success py-5 d-flex flex-column">
        <a href="{{ route('dashboard.users') }}" class="d-flex align-items-center justify-content-around border mb-3 item">
            <span class="d-inline-block text-center mx-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                </svg>
            </span>
            <span class="d-inline-block w-100 fs-3 fw-light">Utilisateurs</span>
        </a>
        <a href="{{ route('dashboard.cars') }}" class="d-flex align-items-center justify-content-around border mb-3 item">
            <span class="d-inline-block text-center mx-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-car-front-fill" viewBox="0 0 16 16">
                    <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679q.05.242.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.8.8 0 0 0 .381-.404l.792-1.848ZM3 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2m10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM2.906 5.189a.51.51 0 0 0 .497.731c.91-.073 3.35-.17 4.597-.17s3.688.097 4.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 11.691 3H4.309a.5.5 0 0 0-.447.276L2.906 5.19Z"/>
                </svg>
            </span>
            <span class="d-inline-block w-100 fs-3 fw-light">Voitures</span>
        </a>
        <a href="{{ route('dashboard.rentals.index') }}" class="d-flex align-items-center justify-content-around border mb-3 bg-light text-dark">
            <span class="d-inline-block text-center mx-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                    <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                </svg>
            </span>
            <span class="d-inline-block w-100 fs-3 fw-light">Gestion des Locations</span>
        </a>
        <a href="{{ route('page.createCar') }}" class="d-flex align-items-center justify-content-around border mb-3 item">
            <span class="d-inline-block text-center mx-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
            </span>
            <span class="d-inline-block w-100 fs-3 fw-light">Créer une voiture</span>
        </a>
    </div>
    <div class="w-75 h-100 d-flex flex-column details">
        <div class="p-4">
            <h2 class="mb-4">Gestion des Locations</h2>
            <div class="table-responsive bg-white rounded shadow-sm">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center">#ID</th>
                            <th scope="col">Client</th>
                            <th scope="col">Véhicule</th>
                            <th scope="col" class="text-center">Date de début</th>
                            <th scope="col" class="text-center">Date de fin</th>
                            <th scope="col" class="text-center">Statut</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                @foreach ($rentals as $rental)
                            <tr>
                            <td class="text-center">{{ $rental->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="ms-3">
                                        <p class="fw-bold mb-0">{{ $rental->user->name }}</p>
                                        <small class="text-muted">{{ $rental->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="fw-bold mb-0">{{ $rental->car->brand }} {{ $rental->car->model }}</p>
                                        <small class="text-muted">{{ $rental->car->license_plate }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark">
                                    {{ \Carbon\Carbon::parse($rental->rental_date)->format('d/m/Y') }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark">
                                    {{ \Carbon\Carbon::parse($rental->return_date)->format('d/m/Y') }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($rental->status == '1')
                                    <span class="badge bg-warning text-dark">En attente</span>
                                @elseif($rental->status == '2')
                                    <span class="badge bg-success">En cours</span>
                                @elseif($rental->status == '3')
                                    <span class="badge bg-secondary">Terminée</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    @if($rental->status == '1')
                                        <form method="POST" action="{{ route('rental.status', ['status' => '2', 'id' => $rental->id]) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success" title="Approuver la location">
                                                <i class="fas fa-check"></i> Valider
                                            </button>
                                        </form>
                                    @elseif($rental->status == '2')
                                        <form method="POST" action="{{ route('rental.status', ['status' => '3', 'id' => $rental->id]) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-primary" title="Terminer la location">
                                                <i class="fas fa-flag-checkered"></i> Clôturer
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form method="POST" action="{{ route('rental.delete', $rental->id) }}" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Supprimer la location">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                @endforeach
                    </tbody>
                </table>
            </div>
            @if($rentals->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <p class="h5 text-muted">Aucune location trouvée</p>
                </div>
            @endif
        </div>
    </div>
</section>
@include('../../_footer')

@push('styles')
<style>
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.4em 0.8em;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
</style>
@endpush